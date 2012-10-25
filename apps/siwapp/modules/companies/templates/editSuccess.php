<?php
use_helper('JavascriptBase', 'jQuery');
include_stylesheets_for_form($companyForm);
include_javascripts_for_form($companyForm);

$company = $companyForm->getObject();
?>
<div id="product-container" class="content">
  
  <h2><?php echo $title ?></h2>
  <form action="<?php echo url_for("companies/$action") ?>" method="post" <?php $companyForm->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="companies">
  <?php include_partial('common/globalErrors', array('form' => $companyForm)) ?>
  <?php
    echo $companyForm->renderHiddenFields();
  ?>
  <div id="company-data" class="global-data block">
  <h3><?php echo __('Company info') ?></h3>
  <ul>
    <li>
      <span class="_75"><?php echo render_tag($companyForm['name'])?></span>
      <span class="_25"><?php echo render_tag($companyForm['identification'])?></span>
    </li>
    <li>
      <span class="_75 _last"><?php echo render_tag($companyForm['address'])?></span>
    </li>
    <li>
      <span class="_50"><?php echo render_tag($companyForm['phone'])?></span>     
      <span class="_50"><?php echo render_tag($companyForm['fax'])?></span>
    </li>
    
    <li>
      <span class="_50"><?php echo render_tag($companyForm['email'])?></span>     
      <span class="_50"><?php echo render_tag($companyForm['url'])?></span>
    </li>
    <li>
      <span class="_50"><?php echo _('Currency') ?> : <?php echo render_tag($companyForm['currency'])  ?></span>
      <span class="_50"><?php echo _('Page size') ?> : <?php echo render_tag($companyForm['pdf_size']) ?></span>
    </li>
  </ul>
</div>
  <div id="company-users-data" class="global-data block">
    <h3><?php echo __('Assigned Users') ?></h3>
    <ul>
    <li>
      <span class="_50"><?php echo render_tag($companyForm['company_user_list'])?></span>  
    </li>
  </ul>
</div>
  <div id="saving-options" class="block" style="margin-top: 20px">
    <?php
    if ($company->getId()) {
      echo gButton_to(__('Delete'), "companies/delete?id=" . $company->getId(), array(
        'class' => 'action delete',
        'post' => true,
        'confirm' => __('Are you sure?'),
        ) , 'button=false')." ";
    }
    
    echo gButton(__('Save'), 'type=submit class=action primary save', 'button=true');
    ?>
  </div>
  </form>
</div>
<?php
echo javascript_tag(" $('#company-data input[type=text], #company-data textarea').SiwappFormTips();") // See invoice.js
?>
