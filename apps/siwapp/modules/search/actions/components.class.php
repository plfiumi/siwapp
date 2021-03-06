<?php

class searchComponents extends sfComponents
{
  
  public function executeForm(sfWebRequest $request)
  {
    $this->getStuff($request);
    $this->form = new InvoiceSearchForm($this->search, array('culture'=>$this->getUser()->getCulture()));
  }

  public function executeExpenseForm(sfWebRequest $request)
  {
    $this->getStuff($request);
    $this->form = new ExpenseSearchForm($this->search, array('culture'=>$this->getUser()->getCulture()));
  }

  public function executeRecurringForm(sfWebRequest $request)
  {
    $this->getStuff($request);
    $this->form = new RecurringInvoiceSearchForm($this->search);
  }

  public function executeCustomerForm(sfWebRequest $request)
  {
    $this->getStuff($request);
    $this->form = new CustomerSearchForm($this->search, array('culture'=>$this->getUser()->getCulture()));
  }

  public function executeSupplierForm(sfWebRequest $request)
  {
    $this->getStuff($request);
    $this->form = new SupplierSearchForm($this->search, array('culture'=>$this->getUser()->getCulture()));
  }

  public function executeProductForm(sfWebRequest $request)
  {
    $this->getStuff($request);
    $this->form = new ProductSearchForm($this->search, array('culture'=>$this->getUser()->getCulture()));
  }

  public function executeCompanyForm(sfWebRequest $request)
  {
    $this->getStuff($request);
    $this->form = new CompanySearchForm($this->search, array('culture'=>$this->getUser()->getCulture()));
  }
  
  public function executeUserForm(sfWebRequest $request)
  {
    $this->getStuff($request);
    $this->form = new UserSearchForm($this->search, array('culture'=>$this->getUser()->getCulture()));
  }
  
  public function executeEstimateForm(sfWebRequest $request)
  {
    $this->getStuff($request);
    $this->form = new InvoiceSearchForm($this->search, array('culture'=>$this->getUser()->getCulture()));
  }
  
  private function getStuff(sfWebRequest $request)
  {
    $this->namespace     = $request->getParameter('searchNamespace');
    $this->search        = $this->getUser()->getAttribute('search', null, $this->namespace);
    $this->tags          = TagTable::getAllTagName();
    $this->selected_tags = $this->getUser()->getSelectedTags($this->search);
    
    if(isset($this->search['customer_name']))
      $this->customer_name = $this->search['customer_name'];
    else
      $this->customer_name = null;
  }
  
}
