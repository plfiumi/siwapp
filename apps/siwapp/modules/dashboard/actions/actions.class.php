<?php

/**
 * dashboard actions.
 *
 * @package    siwapp
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class dashboardActions extends sfActions
{
  public function preExecute()
  {
    $this->currency = $this->getUser()->getAttribute('currency');
    $this->namespace = 'invoices';
  }
  
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $namespace = $request->getParameter('searchNamespace');
    $search = $this->getUser()->getAttribute('search', null, $namespace);
    $this->maxResults = sfConfig::get('app_dashboard_max_results');
    $company_id=sfContext::getInstance()->getUser()->getAttribute('company_id');
    
    $q = InvoiceQuery::create()->Where('company_id = ?',$company_id )->search($search)->limit($this->maxResults);

    $eqp = EstimateQuery::create()->Where('status = 2')->AndWhere('company_id = ?',$company_id )->search($search)->limit($this->maxResults);

    $eqa = EstimateQuery::create()->Where('status = 3')->AndWhere('company_id = ?',$company_id )->search($search)->limit($this->maxResults);

    $eqr = EstimateQuery::create()->Where('status = 1')->AndWhere('company_id = ?',$company_id )->search($search)->limit($this->maxResults);
    
    //Expenses total
    $this->epending  = $eqp->total('gross_amount');
    if(empty($this->epending)) 
        $this->epending = 0;
    $this->eapproved  = $eqa->total('gross_amount');
    if(empty($this->eapproved)) 
        $this->eapproved = 0;
    $this->erejected  = $eqr->total('gross_amount');
    if(empty($this->erejected)) 
        $this->erejected = 0;;
    
    // for the overdue unset the date filters, to show all the overdue
    unset($search['from'], $search['to']);
    $overdueQuery = InvoiceQuery::create()->Where('company_id = ?',$company_id )->search($search)->status(Invoice::OVERDUE);

    // totals
    $this->gross  = $q->total('gross_amount');
    $this->due    = $q->total('due_amount');
    $this->paid   = $q->total('paid_amount');
    $this->odue   = $overdueQuery->total('due_amount');
    $this->taxes  = $q->total('tax_amount');
    $this->net    = $q->total('net_amount');

    $taxes = Doctrine_Query::create()->select('t.id, t.name')
      ->from('Tax t')->Where('company_id = ?',$company_id )->execute();

    $total_taxes = array();

    foreach($taxes as $t)
    {
      if($value = $q->total_tax($t->id))
      {
        $total_taxes[$t->name] = $q->total_tax($t->id);
      }
    }
    $this->total_taxes = $total_taxes;

    // this is for the redirect of the payments forms
    $this->getUser()->setAttribute('module', $request->getParameter('module'));
    
    // link counters
    $this->recentCounter  = $q->count();
    $this->overdueCounter = $overdueQuery->count();
    $this->pendingCounter = $eqp->count();
    // recent & overdue invoices
    $this->recent         = $q->execute();
    $this->overdue        = $overdueQuery->execute();
    $this->pending         = $eqp->execute();
  }
  
}
