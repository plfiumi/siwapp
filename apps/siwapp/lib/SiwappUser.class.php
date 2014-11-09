<?php

class SiwappUser extends sfGuardSecurityUser
{
  public function signIn($user, $remember = false, $con = null)
  {
    try{
        parent::signIn($user, $remember, $con);
        $this->loadCompany();
        $this->loadUserSettings();
    }catch(Exception $e)
    {
        parent::signOut();
    }
  }

  public function loadCompany($companyid = 0)
  {
    $companyObject = new Company();
    if($companyid==0)
    {
        $userid= $this->getGuardUser()->getId();
        $companyObject=$companyObject->getDefaultCompany($userid);
    } else {
      //TODO: Check if user has permisions on this company.
      $companyObject=$companyObject->loadById($companyid);
    }
    if(empty($companyObject))
        throw new sfException('This user has no company assigned. Contact system administrator.');
    $this->setAttribute('company_id',''.$companyObject->getId());
    $this->setAttribute('company_name',$companyObject->getName());

    $currency = $companyObject->get('currency', 'USD');
    $currency_decimals = $companyObject->get('currency_decimals', 2);

    $this->setAttribute('currency', $currency);
    $this->setAttribute('currency_decimals', $currency_decimals);

  }

  public function loadUserSettings()
  {
    $siwapp_mandatory_modules = array_keys(
                                           sfConfig::get('app_modules_mandatory')
                                           );
    $siwapp_optional_modules = PropertyTable::get(
                                                  'siwapp_modules',
                                                  array()
                                                  );
    /* If the user is not a super admin don't show the companies and users options. */
    if(!($this->getGuardUser()->getIsSuperAdmin()) && !$this->hasGroup("professional") && !$this->hasGroup("corporate"))
    {
        $real_modules= array();
        foreach ($siwapp_mandatory_modules as $module)
        {
            if(in_array( $module, array('companies','users')))
                continue;
            $real_modules[] = $module;
        }
        $siwapp_mandatory_modules = $real_modules;
    }

    $com = Doctrine_Query::create()
        ->select('cu.company_id,c.name')
        ->from('CompanyUser cu')
        ->innerJoin('cu.Company c')
        ->where('sf_guard_user_id = ?', $this->getGuardUser()->getId())
        ->OrderBy('c.name ASC')->fetchArray();
    $available_companies= array();
    foreach($com as $company)
    {
        $available_companies[] = array(
            "id" => $company['Company']['id'],
            "name" => $company['Company']['name'],
        );
    }
    $this->setAttribute('available_companies',$available_companies);

    $this->setAttribute('siwapp_modules',
                        array_merge(
                                    $siwapp_mandatory_modules,
                                    $siwapp_optional_modules
                                    )
                        );

    $culture = $this->getLanguage();
    if($this->getCountry()) $culture .= '_'.$this->getCountry();

    $this->setCulture($culture);
  }

  /**
   * Search Parameters
   */
  public function updateSearch(sfWebRequest $request)
  {
    $changed = false;
    $ns = $request->getParameter('searchNamespace');

    // if reset, remove all search parameters from request and user
    if ($request->getParameter('reset'))
    {
      $request->getParameterHolder()->remove('search');
      $this->getAttributeHolder()->remove('search', null, $ns);

      $changed = true;
    }
    else
    {
      // check if some parameters have changed, and setting them into user
      $params = array('search', 'sort');
      foreach ($params as $param)
      {
        $value = $request->getParameter($param, null);

        if($value && $this->getAttribute($param, null, $ns) != $value)
        {
          $this->setAttribute($param, $value, $ns);
          $changed = true;
        }
      }
    }

    // If something has changed we reset page to 1
    if ($changed)
    {
      $request->setParameter('page', 1);
    }

    // if page comes as parameter insert as attribute
    if ($page = $request->getParameter('page'))
    {
      $this->setAttribute('page', $page, $ns);
    }
    if($ns == 'invoices' || $ns == 'expenses' || $ns == 'estimates')
    {
      $search = $this->getSearchSettings($this->getAttribute('search', null, $ns));
    }
    else
    {
      $search = $this->getAttribute('search', null, $ns);
    }

    // this is to put the customer name in the autocomplete field
    if(isset($search['customer_id']) && $search['customer_id'] > 0)
    {
      if($cust = Doctrine::getTable('Customer')->find($search['customer_id']))
      {
        $search['customer_name'] = $cust->getName();
      }
      else
      {
        unset($search['customer_name']);
        unset($search['customer_id']);
      }
    }

    $this->setAttribute('search', $search, $ns);
  }

  /**
   * this function sets the $search array with default settings
   * if the user has default settings for the search form
   *
   * @param $search array The search array
   *
   * @return array The search array
   **/
  private function getSearchSettings($search)
  {
    if($profile = $this->getProfile())
    {
      $from = $to = null;

      if (isset($search['from']))
      {
        $from = Tools::sfDateFromArray($search['from']);
      }

      if (isset($search['to']))
      {
        $to = Tools::sfDateFromArray($search['to']);
      }

      if (!isset($search['quick_dates']) && !$from && !$to && ($searchFilter = $profile->getSearchFilter()))
      {
        $to = sfDate::getInstance();
        $from = sfDate::getInstance();

        switch ($searchFilter)
        {
          case 'last_week':
            $from->subtractWeek(1);
            break;
          case 'last_month':
            $from->subtractMonth(1);
            break;
          case 'last_year':
            $from->subtractYear(1);
            break;
          case 'last_5_years':
            $from->subtractYear(5);
            break;
          case 'this_week':
            $from->firstDayOfWeek();
            break;
          case 'this_month':
            $from->firstDayOfMonth();
            break;
          case 'this_year':
            $from->firstDayOfYear();
            break;
          case 'first_quarter':
            $from->setDay(1);
            $from->setMonth(0);
            $to->setDay(31);
            $to->setMonth(2);
            break;
          case 'second_quarter':
            $from->setDay(1);
            $from->setMonth(3);
            $to->setDay(30);
            $to->setMonth(5);
            break;
          case 'third_quarter':
            $from->setDay(1);
            $from->setMonth(6);
            $to->setDay(30);
            $to->setMonth(8);
            break;
          case 'fourth_quarter':
            $from->setDay(1);
            $from->setMonth(9);
            $to->setDay(31);
                to_mod.setMonth(11);
            break;
        }

        $search['to'] = array(
            'day'   => $to->getDay(),
            'month' => $to->format('n'),
            'year'  => $to->getYear(),
          );

        $search['from'] = array(
            'day'   => $from->format('j'),
            'month' => $from->format('n'),
            'year'  => $from->getYear(),
          );

        $search['quick_dates'] = $searchFilter;
      }
    }

    return $search;
  }

  public function getSelectedTags($search)
  {
    return ((isset($search['tags']) && strlen($search['tags'])) ? explode(',', $search['tags']) : array());
  }

  public function getPaginationMaxResults()
  {
    if (!($maxResults = $this->getProfile()->getNbDisplayResults()))
    {
      $maxResults = sfConfig::get('app_pagination_max_results', 10);
    }

    return $maxResults;
  }

  /**
   * Info Notification Helpers
   * @author Carlos Escribano <carlos@markhaus.com>
   **/
  public function info($message, $b = true)
  {
    $arr = $this->getFlash('info') ? $this->getFlash('info'):array();
    array_push($arr, $message);
    $this->setFlash('info', $arr, $b);
  }

  public function warn($message, $b = true)
  {
    $arr = $this->getFlash('warning') ? $this->getFlash('warning'):array();
    array_push($arr, $message);
    $this->setFlash('warning', $arr, $b);
  }

  public function error($message, $b = true)
  {
    $arr = $this->getFlash('error') ? $this->getFlash('error'):array();
    array_push($arr, $message);
    $this->setFlash('error', $arr, $b);
  }

  /**
   * Tag Cloud Preference
   */
  public function toggleTagCloud()
  {
    $this->setAttribute('showTags', !$this->getAttribute('showTags'));
  }

  public function isTagCloudVisible()
  {
    return $this->getAttribute('showTags', false);
  }

  public function getLanguage()
  {
    $lang = $this->getProfile()->getLanguage();

    return $lang ? $lang : 'en';
  }

  public function getCountry()
  {
    $country = $this->getProfile()->getCountry();

    return $country ? $country : null;
  }

  public function getCurrency()
  {
    return $this->getAttribute('currency');
  }

  /**
   * undocumented function
   *
   * return @void
   * author JoeZ99 <jzarate@gmail.com>
   */
  public function has_module($module_name)
  {
    return in_array($module_name, $this->getAttribute('siwapp_modules',array()));
  }
}
