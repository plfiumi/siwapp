<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $sf_user->getCulture()?>" lang="<?php echo $sf_user->getCulture()?>">
<head>
  <?php include_http_metas() ?>
  <?php include_metas() ?>
  <?php include_title() ?>
  <link rel="shortcut icon" href="favicon.ico" />
  <script type="text/javascript" src="<?php echo url_for('js/i18n') ?>"></script>
  <script type="text/javascript" src="<?php echo url_for('js/url?key='.$sf_request->getParameter('module')) ?>"></script>
</head>
<body class="<?php echo semantic_body_classes() ?>">
<?php echo javascript_tag("
  var userCulture = '".$sf_user->getCulture()."';
  var userCompany = '".$sf_user->getAttribute('company_id')."';
    function changeCompany(obj){
        //Convert to jQuery
            obj = $(obj);
            if(obj.val() != userCompany)
               location.href = '".url_for("@change_company")."?id='+obj.val();
}

"); ?>
<div id="hd">
  <div id="hd-top">
    <a id="hd-top-logo" href="<?php echo url_for('@homepage') ?>">
      <?php echo image_tag('logo.gif', 'alt=siwapp width=210 height=100 border=0') ?>
      <span class="version">
        <?php echo 'v. '.sfConfig::get('app_version');?>
      </span>
    </a>
    
    <ul id="hd-top-menu" class="inline content">
      <li><?php echo __('Welcome, [1]!', array('[1]' => $sf_user->getUsername())) ?> |</li>
      <!--<li><?php // echo link_to(__('Help'), '@homepage') ?> |</li>-->
      <li>
          <?php echo __('Current Company:') ?>
          <select id="session_company" name="session_company" onchange="javascript:changeCompany(this);">
          <?php foreach ($sf_user->getAttribute('available_companies') as $company): ?>
             <?php 
                $selected = $company['id'] == $sf_user->getAttribute('company_id') ? 'selected=true' : '';
                echo '<option '.$selected.' value="'.$company['id'].'">'.$company['name'].'</option>' ;
             ?>
          <?php endforeach ?>
         </select> |
      </li>
      <li><?php echo link_to(__('Settings'), 'configuration/settings', array('accesskey' => "s")) ?> |</li>
      <li><?php echo link_to('Users', '@sf_guard_user') ?> |</li>
      <li><?php echo link_to('Groups', '@sf_guard_group') ?> |</li>
      <li><?php echo link_to('Permissions', '@sf_guard_permission') ?> |</li>
      <li><?php echo link_to(__('Logout'), '@sf_guard_signout') ?></li>
    </ul>
    
    </div>

    <?php include_partial('global/notifications') ?>
  </div>
  
   <div id="hd-navbar" class="content">
   <?php 
   $mainButton  = array(__('New Invoice'), '@dashboard_new');
      $tab            = $sf_request->getParameter('tab');
      $active         = 'class="active"';
      $siwapp_modules = array();
      $modules_info   = sfConfig::get('app_modules_mandatory');
      foreach($sf_user->getAttribute('siwapp_modules') as $sm) 
      { 
        $prps = $modules_info[$sm];
        $siwapp_modules[$sm] = $prps;
        if($tab == $sm)
          $mainButton = array(__($prps['new_button_name']),'@'.$sm.'_new');
      }
    ?>
    <?php echo link_to('<span>'.$mainButton[0].'</span>', $mainButton[1], 'id=new-invoice-button'); ?>
    <ul id="hd-navbar-menu" class="negative">
      <?php foreach($siwapp_modules as $so => $opts):?>
      <li <?php if ($tab == $so) echo $active ?>>
        <?php echo link_to(__($opts['tab_name']),'@'.$so) ?>
      </li>
      <?php endforeach?>
    </ul>
  </div>
  
</div>

<div id="bd">
  <div id="bd-top">
    <?php if ($sf_params->get('searchForm')) include_component_slot('searchForm')?>
  </div>
  
  <div id="bd-content">
    <?php echo $sf_content ?>
  </div>
</div>
  
</body>
</html>
