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

  <?php
  echo $supplierForm->renderHiddenFields();
  ?>
  <div id="supplier-data" class="global-data block">
  <h3><?php echo __('Supplier info') ?></h3>
  <ul>
    <li>
      <span class="_50">
        <?php echo render_tag($supplierForm['name'])?>
        <?php echo $supplierForm['name_slug']->renderError()?>
      </span>
      <span class="_25">
        <?php echo render_tag($supplierForm['business_name'])?>
      </span>
      <span class="_25">
         <?php echo render_tag($supplierForm['identification'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($supplierForm['phone'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($supplierForm['fax'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($supplierForm['mobile'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($supplierForm['email'])?>
      </span>
      <span class="_50">
        <?php echo render_tag($supplierForm['website'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($supplierForm['contact_person'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($supplierForm['contact_person_phone'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($supplierForm['contact_person_email'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($supplierForm['invoicing_address'])?>
      </span>
      <span class="_50">
        <?php echo render_tag($supplierForm['invoicing_city'])?>
      </span>
    </li>
    <li>
      <span class="_25">
        <?php echo render_tag($supplierForm['invoicing_postalcode'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($supplierForm['invoicing_state'])?>
      </span>
        <span class="_25">
        <?php echo render_tag($supplierForm['invoicing_country'])?>
      </span>
    </li>
    <li>
       <span class="_50 ">
         <?php echo render_tag($supplierForm['comments'])?>
       </span>
    </li>
  </ul>
</div>
<div id="supplier-administrative-data" class="global-data block">
    <h3><?php echo __('Administrative details') ?></h3>
    <ul>
    <li>
      <span class="_50">
        <label class="light" for="<? echo $supplierForm['tax_condition_id']->renderId()?>"><?php echo __('Tax condition') ?></label>
        <?php echo render_tag($supplierForm['tax_condition_id'])  ?>
      </span>
      <span class="_50">
        <!--<label for="<? //echo $supplierForm['series_id']->renderId()?>"><?php echo __('Invoicing series') ?></label>
        <?php //echo render_tag($supplierForm['series_id'])  ?>-->
      </span>
    </li>
    <li>
      <span class="_50">
        <label class="light" for="<? echo $supplierForm['payment_type_id']->renderId()?>"><?php echo __('Payment type') ?></label>
        <?php echo render_tag($supplierForm['payment_type_id'])  ?>
      </span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($supplierForm['financial_entity'])  ?>
      </span>
      <span class="_50">
        <?php echo render_tag($supplierForm['financial_entity_office']) ?>
      </span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($supplierForm['financial_entity_account']) ?>
      </span>
    </li>
  </ul>
</div>
<div id="supplier-data" class="global-data block">  
  <h3><?php echo __('Online Access') ?></h3>
  <ul>
    <li>
      <span class="_50">
        <?php echo render_tag($supplierForm['login'])?>
      </span>
      <span class="_50">
        <?php echo render_tag($supplierForm['password'])?>
      </span>
    </li>
  </ul> 
</div>
<div id="supplier-data" class="global-data block">  
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
echo javascript_tag(" $('#supplier-data input[type=text], #supplier-data textarea').SiwappFormTips();"); // See invoice.js
echo javascript_tag(" $('#supplier-administrative-data input[type=text], #supplier-administrative-data textarea').SiwappFormTips();"); // See invoice.js
?>
