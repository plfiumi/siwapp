<?php

/**
 * suppliers actions.
 *
 * @package    siwapp
 * @subpackage invoices
 * @author     Siwapp Team
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class suppliersActions extends sfActions
{
  public function preExecute()
  {
    $this->currency = $this->getUser()->getAttribute('currency');
    $this->culture  = $this->getUser()->getCulture();
  }
  
  private function getSupplier(sfWebRequest $request)
  {
    $this->forward404Unless($supplier = Doctrine::getTable('Supplier')->find($request->getParameter('id')),
      sprintf('Object supplier does not exist with id %s', $request->getParameter('id')));
      
    return $supplier;
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $namespace  = $request->getParameter('searchNamespace');
    $search     = $this->getUser()->getAttribute('search', null, $namespace);
    $sort       = $this->getUser()->getAttribute('sort', array('name', 'desc'), $namespace);
    $page       = $this->getUser()->getAttribute('page', 1, $namespace);
    $maxResults = $this->getUser()->getPaginationMaxResults();
    
    $q = SupplierQuery::create()->Where('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))->search($search)->orderBy("$sort[0] $sort[1], name $sort[1]");
    $date_range = array();
    $date_range['from'] = isset($search['from']) ? $search['from'] : null;
    $date_range['to']   = isset($search['to'])   ? $search['to']   : null;
    $this->date_range = $date_range;
    // totals
    $this->gross = $q->total('gross_amount');
    $this->due   = $q->total('due_amount');

    $this->pager = new sfDoctrinePager('Supplier', $maxResults);
    $this->pager->setQuery($q);
    $this->pager->setPage($page);
    $this->pager->init();
   
    $this->getUser()->setAttribute('page', $request->getParameter('page'));
    
    $this->sort = $sort;
  }

  public function executeNew(sfWebRequest $request)
  {
    $i18n = $this->getContext()->getI18N();
    $supplier = new Supplier();
    $this->supplierForm = new SupplierForm($supplier, array('culture'=>$this->culture));
    $this->title       = $i18n->__('New Supplier');
    $this->action      = 'create';
    $this->setTemplate('edit');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->supplierForm = new SupplierForm(null, array('culture' => $this->culture));
    $this->title = $this->getContext()->getI18N()->__('New Supplier');
    $this->action = 'create';

    $this->processForm($request, $this->supplierForm);
    $this->setTemplate('edit');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $supplier = $this->getSupplier($request);

    $this->supplierForm = new SupplierForm($supplier, array('culture'=>$this->culture));
    $i18n = $this->getContext()->getI18N();
    $this->title = $i18n->__('Edit Supplier');
    $this->action = 'update';
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $supplier_params = $request->getParameter('supplier');
    $request->setParameter('id', $supplier_params['id']);
    $this->forward404Unless($request->isMethod('post'));
    $supplier = $this->getSupplier($request);
    
    $this->supplierForm = new SupplierForm($supplier, array('culture'=>$this->culture));
    $this->processForm($request, $this->supplierForm);
    
    $i18n = $this->getContext()->getI18N();
    $this->title = $i18n->__('Edit Supplier');
    $this->action = 'update';
    
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $supplier = $this->getSupplier($request);
    try
    {
      $supplier->delete();
    }
    catch(siwappIntegrityException $ex)
    {
      $this->getUser()->error($this->getContext()->getI18N()
                              ->__('The supplier could not be deleted. '
                                   .'Probably because an associated invoice exists')
                              );
    }
    
    $this->redirect('suppliers/index');
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $i18n = $this->getContext()->getI18N();
    
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $template = 'The supplier was %s successfully %s.';
      $message  = $form->getObject()->isNew() ? 'created' : 'updated';
      $suffix   = null;
      $method   = 'info';
      
      $supplier = $form->save();
      
      $this->getUser()->$method($i18n->__(sprintf($template, $message, $suffix)));
      $this->redirect('suppliers/edit?id='.$supplier->id);
    }
    else
    {
      foreach($form->getErrorSchema()->getErrors() as $k=>$v)
      {
        $this->getUser()->error(sprintf('%s: %s', $k, $v->getMessageFormat()));
      }
      $this->getUser()->error($i18n->__('The supplier has not been saved due to some errors.'));
    }
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
    
    if($form->isValid() || 
       $this->getContext()->getConfiguration()->getEnvironment() == 'test')
    {
      $n = 0;
      $e = 0;
      foreach($request->getParameter('ids', array()) as $id)
      {
        if($supplier = Doctrine::getTable('Supplier')->find($id))
        {
          switch($request->getParameter('batch_action'))
          {
            case 'delete':
              try
              {
                $supplier->delete();
                $n++;
              }
              catch (siwappIntegrityException $ex)
              {
                $e++;
              }
              break;
          }
        }
      }
      switch($request->getParameter('batch_action'))
      {
        case 'delete':
          if ($n > 0)
            $this->getUser()->info(sprintf($i18n->__('%d suppliers were successfully deleted.'), $n));
          if ($e > 0)
            $this->getUser()->warn(sprintf($i18n->__('%d suppliers could not be deleted because they have associated data.'), $e));
          break;
      }
    }
    
    $this->redirect('@suppliers');
  }
  
  
}
