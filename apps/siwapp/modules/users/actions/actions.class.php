<?php

/**
 * UserObjects actions.
 *
 * @package    siwapp
 * @subpackage invoices
 * @author     Siwapp Team
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class UsersActions extends sfActions
{
  public function preExecute()
  {
    $this->currency = $this->getUser()->getAttribute('currency');
    $this->culture  = $this->getUser()->getCulture();
  }
  
  private function getProfile(sfWebRequest $request)
  {
    $this->forward404Unless($UserObject = Doctrine::getTable('Profile')->find($request->getParameter('id')),
      sprintf('Object Profile does not exist with id %s', $request->getParameter('id')));
      
    return $UserObject;
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $namespace  = $request->getParameter('searchNamespace');
    $search     = $this->getUser()->getAttribute('search', null, $namespace);
    $sort       = $this->getUser()->getAttribute('sort', array('first_name', 'asc'), $namespace);
    $page       = $this->getUser()->getAttribute('page', 1, $namespace);
    $maxResults = $this->getUser()->getPaginationMaxResults();
    
    $q = UserQuery::create()->search($search)
        ->orderBy("$sort[0] $sort[1], last_name $sort[1]");

    $this->pager = new sfDoctrinePager('UserObject', $maxResults);
    $this->pager->setQuery($q);
    $this->pager->setPage($page);
    $this->pager->init();
   
    $this->getUser()->setAttribute('page', $request->getParameter('page'));
    
    $this->sort = $sort;
  }

  public function executeNew(sfWebRequest $request)
  {
    $i18n = $this->getContext()->getI18N();
    $UserObject = new Profile();
    
    $this->UserObjectForm = new ProfileForm($UserObject, array('culture'=>$this->culture));
    $this->title       = $i18n->__('New User');
    $this->action      = 'create';
    $this->setTemplate('edit');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->UserObjectForm = new ProfileForm(null, array('culture' => $this->culture));
    $this->title = $this->getContext()->getI18N()->__('New User');
    $this->action = 'create';

    $this->processForm($request, $this->UserObjectForm);
    $this->setTemplate('edit');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $UserObject = $this->getProfile($request);
    $superadmin = $UserObject->getUser()->getIsSuperAdmin();
    $username = $UserObject->getUser()->getUserName();
    $this->UserObjectForm = new ProfileForm($UserObject, array('culture'=>$this->culture, 'superadmin'=> $superadmin, 'username' => $username));
    $i18n = $this->getContext()->getI18N();
    $this->title = $i18n->__('Edit User');
    $this->action = 'update';
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $UserObject_params = $request->getParameter('config');
    $request->setParameter('id', $UserObject_params['id']);
    $this->forward404Unless($request->isMethod('post'));
    $UserObject = $this->getProfile($request);
    $username = $UserObject->getUser()->getUserName();
    
    $this->UserObjectForm = new ProfileForm($UserObject, array('culture'=>$this->culture, 'username' => $username));
    $this->processForm($request, $this->UserObjectForm);
    
    $i18n = $this->getContext()->getI18N();
    $this->title = $i18n->__('Edit User');
    $this->action = 'update';
    
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $UserObject = $this->getProfile($request);
    if(!$UserObject->delete())
    {
      $this->getUser()->error($this->getContext()->getI18N()
                              ->__('The User could not be deleted. '
                                   .'Probably because an associated invoice exists')
                              );
    }

    $this->redirect('users/index');
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $i18n = $this->getContext()->getI18N();
    
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $template = 'The User was %s successfully %s.';
      $message  = $form->getObject()->isNew() ? 'created' : 'updated';
      $suffix   = null;
      $method   = 'info';

      $UserObject = $form->save();
      
      $this->getUser()->$method($i18n->__(sprintf($template, $message, $suffix)));
      $this->redirect('users/edit?id='.$UserObject->id);
    }
    else
    {
      $this->getUser()->error($i18n->__('The User has not been saved due to some errors.'));
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

    //TO REVIEW MCY the use of a pseudo conditionals switch looks really suspect

    if($form->isValid() || $this->getContext()->getConfiguration()->getEnvironment() == 'test')
    {
      $n = 0;
      foreach($request->getParameter('ids', array()) as $id)
      {
        if($UserObject = Doctrine::getTable('Profile')->find($id))
        {
          switch($request->getParameter('batch_action'))
          {
            case 'delete':
              $user = $UserObject->getUser(); 
              if ($UserObject->delete() && $user->delete()) $n++;
              break;
          }
        }
      }
      switch($request->getParameter('batch_action'))
      {
        case 'delete':
          $this->getUser()->info(sprintf($i18n->__('%d Users were successfully deleted.'), $n));
          break;
      }
    }

    $this->redirect('users');
  }

}
