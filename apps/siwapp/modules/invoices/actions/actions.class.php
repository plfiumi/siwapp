<?php

/**
 * invoices actions.
 *
 * @package    siwapp
 * @subpackage invoices
 * @author     Siwapp Team
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class invoicesActions extends sfActions
{
  public function preExecute()
  {
    $this->currency = $this->getUser()->getAttribute('currency');
    $this->culture  = $this->getUser()->getCulture();
  }
  
  private function getInvoice(sfWebRequest $request)
  {
    $this->forward404Unless($invoice = Doctrine::getTable('Invoice')->find($request->getParameter('id')),
      sprintf('Object invoice does not exist with id %s', $request->getParameter('id')));
      
    return $invoice;
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $namespace  = $request->getParameter('searchNamespace');
    $search     = $this->getUser()->getAttribute('search', null, $namespace);
    $sort       = $this->getUser()->getAttribute('sort', array('issue_date', 'desc'), $namespace);
    $page       = $this->getUser()->getAttribute('page', 1, $namespace);
    $maxResults = $this->getUser()->getPaginationMaxResults();
    
    $q = InvoiceQuery::create()
            ->Where('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))->search($search)->orderBy("$sort[0] $sort[1], number $sort[1]");
    // totals
    $this->gross = $q->total('gross_amount');
    $this->due   = $q->total('due_amount');
    
    $this->pager = new sfDoctrinePager('Invoice', $maxResults);
    $this->pager->setQuery($q);
    $this->pager->setPage($page);
    $this->pager->init();
    
    // this is for the redirect of the payments forms
    $this->getUser()->setAttribute('module', $request->getParameter('module'));
    $this->getUser()->setAttribute('page', $request->getParameter('page'));
    
    $this->sort = $sort;
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $this->invoice = $this->getInvoice($request);
  }

  public function executeNew(sfWebRequest $request)
  {
    $i18n = $this->getContext()->getI18N();
    $invoice = new Invoice();

    $this->invoiceForm = new InvoiceForm($invoice, array('culture'=>$this->culture));
    $this->title       = $i18n->__('New Invoice');
    $this->action      = 'create';
    $this->setTemplate('edit');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->invoiceForm = new InvoiceForm(null, array('culture' => $this->culture));
    $this->title = $this->getContext()->getI18N()->__('New Invoice');
    $this->action = 'create';

    $this->processForm($request, $this->invoiceForm);
    $this->setTemplate('edit');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $invoice = $this->getInvoice($request);

    // if the invoice is closed, forward to the show action unless the referer is edit or show
    if($invoice->status == Invoice::CLOSED)
    {
      $comes_from_edit = substr_count($request->getReferer(), '/edit') > 0 ? true : false;
      $this->forwardIf(!$comes_from_edit, 'invoices', 'show');
    }
    // save the original draft state
    $this->db_draft = $invoice->draft;
    // set draft=0 by default always
    $invoice->setDraft(false);
    $this->invoiceForm = new InvoiceForm($invoice, array('culture'=>$this->culture));
    
    $i18n = $this->getContext()->getI18N();
    $this->title = $i18n->__('Edit Invoice').' '.$invoice;
    $this->action = 'update';
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $invoice_params = $request->getParameter('invoice');
    $request->setParameter('id', $invoice_params['id']);
    $this->forward404Unless($request->isMethod('post'));
    $invoice = $this->getInvoice($request);
    $this->invoiceForm = new InvoiceForm($invoice, array('culture'=>$this->culture));
    $this->processForm($request, $this->invoiceForm);
    
    $i18n = $this->getContext()->getI18N();
    $this->title = $i18n->__('Edit Invoice');
    $this->action = 'update';
    
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $invoice = $this->getInvoice($request);
    $invoice->delete();

    $this->redirect('invoices/index');
  }
  
  public function executeSend(sfWebRequest $request)
  {
    $invoice = $this->getInvoice($request);

    if($this->sendEmail($invoice))
    {
      $this->getUser()->info($this->getContext()->getI18N()->__('The invoice was successfully sent.'));
    }
    else
    {
      $this->getUser()->error($this->getContext()->getI18N()->__('The invoice could not be sent due to an error.'));
    }
    $dest = $request->getReferer() ? $request->getReferer() : 'invoices/edit?id='.$invoice->id;
    $this->redirect($dest);
  }
  
  protected function sendEmail(Invoice $invoice)
  {
    $i18n = $this->getContext()->getI18N();
    $result  = false;
    try {
      $message = new InvoiceMessage($invoice);
      if($message->getReadyState())
      {
        $result = $this->getMailer()->send($message);
        if($result)
        {
          $invoice->setSentByEmail(true);
          $invoice->save();
        }
      }
    } catch (Exception $e) {
      $message = sprintf($i18n->__('There is a problem with invoice %s'), $invoice).': '.$e->getMessage();
      $this->getUser()->error($message);
    }
    
    return $result;
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $i18n = $this->getContext()->getI18N();
    $invoice_params = $request->getParameter($form->getName());
    $form->bind($invoice_params, $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $invoice = $form->save();
      $invoice->setDraft((int) $invoice_params['draft']);
      $invoice->save();
      // update totals with saved values
      $invoice->refresh(true)->setAmounts()->save();
      
      if ($request->getParameter('send_email'))
      {
        if ($this->sendEmail($invoice))
        {
          $this->getUser()->info($i18n->__('The invoice was successfully sent.'));
        }
        else
        {
          $this->getUser()->
            warn($i18n->__('The invoice could not be sent due to an error.'));
        }
      }
      $this->getUser()->info($i18n->__('The invoice was successfully saved.'));
      $this->redirect('invoices/edit?id='.$invoice->id);
    }
    else
    {
      foreach($form->getErrorSchema()->getErrors() as $k=>$v)
      {
        $this->getUser()->error(sprintf('%s: %s', $k, $v->getMessageFormat()));
      }
      $this->getUser()->error($i18n->__('The invoice has not been saved due to some errors.'));
    }
  }
  
  /**
   * batch actions
   *
   * @return void
   **/
  public function executeExport(sfWebRequest $request)
  {
      $n = 0;
      $objPHPExcel = new sfPhpExcel();
      $objPHPExcel->setActiveSheetIndex(0);
      //Generate Headers.
      $objPHPExcel->getActiveSheet()->setTitle('VENTAS');
      $objPHPExcel->getActiveSheet()->setCellValue('A1', 'FECHA');
      $objPHPExcel->getActiveSheet()->setCellValue('B1', 'REG.');
      $objPHPExcel->getActiveSheet()->setCellValue('C1', 'CUENTA');
      $objPHPExcel->getActiveSheet()->setCellValue('D1', 'NIF');
      $objPHPExcel->getActiveSheet()->setCellValue('E1', 'NOMBRE');
      $objPHPExcel->getActiveSheet()->setCellValue('F1', 'DESCRIPCIÓN');
      $objPHPExcel->getActiveSheet()->setCellValue('G1', 'BASE');
      $objPHPExcel->getActiveSheet()->setCellValue('H1', '%IVA');
      $objPHPExcel->getActiveSheet()->setCellValue('I1', 'IMPORTE IVA');
      $objPHPExcel->getActiveSheet()->setCellValue('J1', 'BASE RETENCION');
      $objPHPExcel->getActiveSheet()->setCellValue('K1', '%IRPF');
      $objPHPExcel->getActiveSheet()->setCellValue('L1', 'TOTAL IRPF');
      $objPHPExcel->getActiveSheet()->setCellValue('M1', 'TOTAL');
      $objPHPExcel->getActiveSheet()->setCellValue('N1', 'CONTRAPARTIDA'); 
      $objPHPExcel->getActiveSheet()->setCellValue('O1', 'PAIS'); 
      $objPHPExcel->getActiveSheet()->setCellValue('P1', 'PROVINCIA'); 
      $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'PAGO AUTOMATICO'); 
      $objPHPExcel->getActiveSheet()->setCellValue('R1', 'OPERACION ARRENDAMIENTO'); 
      foreach($request->getParameter('ids', array()) as $id)
      {
        if($invoice = Doctrine::getTable('Invoice')->find($id))
        {
              foreach ($invoice->getGrupedTaxes() as $tax => $value) 
              {
                  $objPHPExcel->getActiveSheet()->setCellValue('A'. ($n+2),date('d/m/Y',strtotime($invoice->getIssueDate()))); //FECHA
                  $objPHPExcel->getActiveSheet()->setCellValue('B'. ($n+2), $invoice.''); //REGISTRO
                  $objPHPExcel->getActiveSheet()->setCellValue('C'. ($n+2), ''); //CUENTA
                  $objPHPExcel->getActiveSheet()->setCellValue('D'. ($n+2), $invoice->getCustomerIdentification()); //NIF
                  $objPHPExcel->getActiveSheet()->setCellValue('E'. ($n+2), $invoice->getCustomerName()); //NOMBR
                  $objPHPExcel->getActiveSheet()->setCellValue('F'. ($n+2), 'FACTURA'.$invoice); //DESCRIPCIÓN
                  $objPHPExcel->getActiveSheet()->setCellValue('G'. ($n+2),  $value['base']); //BASE 
                  $objPHPExcel->getActiveSheet()->setCellValue('H'. ($n+2), $value['tax_value']); //%IVA
                  $objPHPExcel->getActiveSheet()->setCellValue('I'. ($n+2), $value['tax']); //IMPORTE IVA
                  $objPHPExcel->getActiveSheet()->setCellValue('J'. ($n+2), $value['base_retencion']); //BASE RETENCION
                  $objPHPExcel->getActiveSheet()->setCellValue('K'. ($n+2), abs($value['retencion_value'])); //%IRPF
                  $objPHPExcel->getActiveSheet()->setCellValue('L'. ($n+2), abs($value['retencion'])); //TOTAL IRPF
                  $objPHPExcel->getActiveSheet()->setCellValue('M'. ($n+2), $value['total']); //TOTAL
                  $objPHPExcel->getActiveSheet()->setCellValue('N'. ($n+2), '70000000'); //CONTRAPARTIDA 
                  $objPHPExcel->getActiveSheet()->setCellValue('O'. ($n+2), $invoice->getCustomer()->getInvoicingCountry()); //PAIS
                  $objPHPExcel->getActiveSheet()->setCellValue('P'. ($n+2), $invoice->getCustomer()->getInvoicingState()); //PROVINCIA
                  $objPHPExcel->getActiveSheet()->setCellValue('Q'. ($n+2), ''); //PAGO AUTOMATICO
                  $objPHPExcel->getActiveSheet()->setCellValue('R'. ($n+2), ''); //OPERACION ARRENDAMIENTO
                  $n++;
              }
        }
      }

    $this->setLayout(false);
    $response = $this->getContext()->getResponse();
    $response->clearHttpHeaders();
    $response->setHttpHeader('Content-Type', 'application/vnd.ms-excel;charset=utf-8');
    $response->setHttpHeader('Content-Disposition:', 'attachment;filename=export.xls'); 

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    ob_start();
    $objWriter->save('php://output');
    $response->setContent(ob_get_clean());
    return sfView::NONE;
  }
  
    /**
   * Export selected invoices to remesas.
   * @author: Sergi Almacellas Abellana <sergi.almacellas@btactic.com>
   * @return void
   **/
  public function executeRemesar(sfWebRequest $request)
  {
  $i18n = $this->getContext()->getI18N();
  
    require_once('AEB19Writter.php');
      $n = 0;
      $aeb19 = new AEB19Writter(' ');
      $companyObject = new Company();
      $companyObject = $companyObject->loadById(sfContext::getInstance()->getUser()->getAttribute('company_id'));
      //Campos comunes para todas las lineas.
      $aeb19->insertarCampo('codigo_presentador', $companyObject->getIdentification().$companyObject->getSufix());
      $aeb19->insertarCampo('fecha_fichero', date('dmy'));
      $aeb19->insertarCampo('nombre_presentador', $companyObject->getName());
      $aeb19->insertarCampo('entidad_receptora', $companyObject->getEntity());
      $aeb19->insertarCampo('oficina_presentador', $companyObject->getOffice());
      
      $aeb19->insertarCampo('codigo_ordenante', $companyObject->getIdentification().$companyObject->getSufix());
      $aeb19->insertarCampo('fecha_cargo', date('dmy'));
      $aeb19->insertarCampo('nombre_ordenante', $companyObject->getName());
      $aeb19->insertarCampo('cuenta_abono_ordenante', $companyObject->getEntity().$companyObject->getOffice().$companyObject->getControlDigit().$companyObject->getAccount());
      $aeb19->guardarRegistro('ordenante');

      $aeb19->insertarCampo('ordenante_domiciliacion' , $companyObject->getIdentification().$companyObject->getSufix());

      foreach($request->getParameter('ids', array()) as $id)
      {
        if($invoice = Doctrine::getTable('Invoice')->find($id))
        {
            $customer=$invoice->getCustomer();
            //Con el codigo_referencia_domiciliacion podremos referenciar la domiciliación
            $aeb19->insertarCampo('codigo_referencia_domiciliacion', $invoice);
            //Cliente al que le domiciliamos
            $aeb19->insertarCampo('nombre_cliente_domiciliacion',$invoice->getCustomerName());
            //Cuenta del cliente en la que se domiciliará la factura
            $aeb19->insertarCampo('cuenta_adeudo_cliente',$customer->getEntity().$customer->getOffice().$customer->getControlDigit().$customer->getAccount());
            //El importe de la domiciliación (tiene que ser en céntimos de euro y con el IVA aplicado)
            $aeb19->insertarCampo('importe_domiciliacion', (int)($invoice->getGrossAmount()*100));
            //Código para asociar la devolución en caso de que ocurra
            $aeb19->insertarCampo('codigo_devolucion_domiciliacion', $invoice);
            //Código interno para saber a qué corresponde la domiciliación
            $aeb19->insertarCampo('codigo_referencia_interna', $invoice);

            //Preparamos los conceptos de la domiciliación, en un array
            //Disponemos de 80 caracteres por línea (elemento del array). Más caracteres serán cortados
            //El índice 8 y 9 contendrían el sexto registro opcional, que es distinto a los demás
            $conceptosDom = array();
            //Los dos primeros índices serán el primer registro opcional
            $conceptosDom[] = str_pad("Factura ".$invoice, 40, ' ', STR_PAD_RIGHT) . str_pad("emitida por: ".$companyObject->getName(), 40, ' ', STR_PAD_RIGHT);
            $conceptosDom[] = str_pad('emitida el ' . date('d/m/Y') . ' para: '.$invoice->getCustomerName(), 40, ' ', STR_PAD_RIGHT) . str_pad(" ES-".$customer->getIdentification(), 40, ' ', STR_PAD_RIGHT);
            $conceptosDom[] = '';
            $conceptosDom[] = '';
            $conceptosDom[] = '';
            $conceptosDom[] = '';
/*            //Los dos segundos índices serán el segundo registro opcional
            $conceptosDom[] = str_pad('titular domiciliacion', 40, ' ', STR_PAD_RIGHT);
            $conceptosDom[] = str_pad('', 40, ' ', STR_PAD_RIGHT) . 'Base imponible:' . str_pad(number_format($i, 2, ',', '.') . ' EUR', 25, ' ', STR_PAD_LEFT);
            //Los dos terceros índices serán el tercer registro opcional
            $conceptosDom[] = str_pad('', 40, ' ', STR_PAD_RIGHT).
                'IVA ' . str_pad(number_format($iva * 100, 2, ',', '.'), 2, '0', STR_PAD_LEFT) . '%:'.
                str_pad(number_format($importeIva, 2, ',', '.') . ' EUR', 29, ' ', STR_PAD_LEFT);
            $conceptosDom[] = str_pad('', 40, ' ', STR_PAD_RIGHT).
                 'Total:' . str_pad(number_format($totalFactura, 2, ',', '.') . ' EUR', 34, ' ', STR_PAD_LEFT);
*/
        
            //Añadimos la domiciliación
            $aeb19->guardarRegistro('domiciliacion', $conceptosDom);
 
 
        }
      }
      $this->setLayout(false);
      $response = $this->getContext()->getResponse();
      $response->clearHttpHeaders();
      $response->setHttpHeader('Content-Type', 'text/plain;charset=utf-8');
      $response->setHttpHeader('Content-Disposition:', 'attachment;filename=remesa.txt'); 
      $response->setContent($aeb19->construirArchivo());
   
    return sfView::NONE;
  
  }
  
  /**
   * batch actions
   *
   * @return void
   **/
  public function executeBatch(sfWebRequest $request)
  {
    $i18n = $this->getContext()->getI18N();
    $form = new sfForm();
    $form->bind(array('_csrf_token' => $request->getParameter('_csrf_token')));
    
    if($form->isValid() || $this->getContext()->getConfiguration()->getEnvironment() == 'test')
    {
      $n = 0;
      foreach($request->getParameter('ids', array()) as $id)
      {
        if($invoice = Doctrine::getTable('Invoice')->find($id))
        {
          switch($request->getParameter('batch_action'))
          {
            case 'delete':
              if ($invoice->delete()) $n++;
              break;
            case 'email':
              if ($this->sendEmail($invoice)) $n++;
              break;
          }
        }
      }
      switch($request->getParameter('batch_action'))
      {
        case 'delete':
          $this->getUser()->info(sprintf($i18n->__('%d invoices were successfully deleted.'), $n));
          break;
        case 'email':
          $this->getUser()->info(sprintf($i18n->__('%d invoices were successfully sent.'), $n));
          break;
      }
    }

    $this->redirect('@invoices');
  }
  
}
