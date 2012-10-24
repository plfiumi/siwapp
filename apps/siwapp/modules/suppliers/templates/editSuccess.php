<?php
use_helper('JavascriptBase', 'jQuery');
include_stylesheets_for_form($supplierForm);
include_javascripts_for_form($supplierForm);

$supplier = $supplierForm->getObject();
?>
<div id="supplier-container" class="content">
  
  <h2><?php echo $title ?></h2>
  <form action="<?php echo url_for("suppliers/$action") ?>" method="post" <?php $supplierForm->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="supplier">
  <?php include_partial('common/globalErrors', array('form' => $supplierForm)) ?>
  <?php
  echo $supplierForm->renderHiddenFields();
  ?>
  <div id="supplier-data" class="global-data block">
  <h3><?php echo __('Supplier info') ?></h3>
  <ul>
    <li>
      <span class="_75">
        <?php echo render_tag($supplierForm['name'])?>
        <?php echo $supplierForm['name_slug']->renderError()?>
      </span>
      <span class="_25"><?php echo render_tag($supplierForm['identification'])?></span>
    </li>
    <li>
      <span class="_50"><?php echo render_tag($supplierForm['contact_person'])?></span>
      <span class="_50"><?php echo render_tag($supplierForm['email'])?></span>
    </li>
    <li>
      <span class="_50"><?php echo render_tag($supplierForm['phone'])?></span>
      <span class="_50"><?php echo render_tag($supplierForm['fax'])?></span>
    </li>
    <li>
      <span class="_75"><?php echo render_tag($supplierForm['invoicing_address'])?></span>
      <span class="_25"></span>
    </li>
    <li>
      <span class="_75"><?php echo render_tag($supplierForm['comments'])?></span>
    </li>
  </ul>
</div>
<div id="expense-type-data" class="global-data block">  
  <h3><?php echo __('Expense Type') ?></h3>
  <ul>
     <li>
      <span class="_50"><?php echo render_tag($supplierForm['expense_type_id'])?></span>
    </li>
  </ul> 
</div>
  <div id="saving-options" class="block">
    <?php
    if ($supplier->getId()) {
      echo gButton_to(__('Delete'), "suppliers/delete?id=" . $supplier->getId(), array(
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
echo javascript_tag(" $('#supplier-data input[type=text], #supplier-data textarea').SiwappFormTips();") // See invoice.js
?>
