<div id="supplier-data" class="global-data block">
  <h3><?php echo __('Supplier info') ?></h3>
  <ul>
    <li>
      <span class="_75">
        <label for="<? echo $invoiceForm['supplier_name']->renderId()?>"><?php echo __('Supplier Name') ?></label>
        <?php echo render_tag($invoiceForm['supplier_name'])?>
      </span>
      <span class="_25">
         <label for="<? echo $invoiceForm['supplier_identification']->renderId()?>"><?php echo __('Legal Id') ?></label>
        <?php echo render_tag($invoiceForm['supplier_identification'])?>
      </span>
    </li>
    <li>
      <span class="_50">
         <label for="<? echo $invoiceForm['contact_person']->renderId()?>"><?php echo __('Contact Person') ?></label>
        <?php echo render_tag($invoiceForm['contact_person'])?>
      </span>
      <span class="_50">
       <label for="<? echo $invoiceForm['supplier_email']->renderId()?>"><?php echo __('Supplier Email') ?></label>
        <?php echo render_tag($invoiceForm['supplier_email'])?>
      </span>
    </li>
    <li>
      <span class="_50">
         <label for="<? echo $invoiceForm['supplier_phone']->renderId()?>"><?php echo __('Supplier Phone') ?></label>
        <?php echo render_tag($invoiceForm['supplier_phone'])?>
      </span>
      <span class="_50">
         <label for="<? echo $invoiceForm['supplier_fax']->renderId()?>"><?php echo __('Supplier Fax') ?></label>
        <?php echo render_tag($invoiceForm['supplier_fax'])?>
      </span>
    </li>
        <li>
      <span class="_50">
        <label for="<? echo $invoiceForm['invoicing_address']->renderId()?>"><?php echo __('Invoicing Address') ?></label>
        <?php echo render_tag($invoiceForm['invoicing_address'])?>
      </span>
      <span class="_50">
        <label for="<? echo $invoiceForm['invoicing_city']->renderId()?>"><?php echo __('Invoicing City') ?></label>
        <?php echo render_tag($invoiceForm['invoicing_city'])?>
      </span>
    </li>
    <li>
      <span class="_25">
        <label for="<? echo $invoiceForm['invoicing_postalcode']->renderId()?>"><?php echo __('Invoicing Postal code') ?></label>
        <?php echo render_tag($invoiceForm['invoicing_postalcode'])?>
      </span>  
      <span class="_25">
        <label for="<? echo $invoiceForm['invoicing_state']->renderId()?>"><?php echo __('Invoicing State') ?></label>
        <?php echo render_tag($invoiceForm['invoicing_state'])?>
      </span>
        <span class="_25">
        <label for="<? echo $invoiceForm['invoicing_country']->renderId()?>"><?php echo __('Invoicing Contry') ?></label>
        <?php echo render_tag($invoiceForm['invoicing_country'])?>
      </span>
    </li>
  </ul>
</div>
<?php
use_helper('JavascriptBase');

$urlAjax = url_for('common/ajaxSupplierAutocomplete');
echo javascript_tag("
  $('#".$invoiceForm['supplier_name']->renderId()."')
    .autocomplete('".$urlAjax."', jQuery.extend({}, {
      dataType: 'json',
      parse:    function(data) {
        var parsed = [];
        for (key in data) {
          parsed[parsed.length] = { data: [ data[key].supplier, 
            data[key].supplier_identification, 
            data[key].contact_person,
            data[key].supplier_email,
            data[key].invoicing_address,
            data[key].shipping_address,
            data[key].supplier_phone,
            data[key].supplier_fax,
            data[key].expense_type,
            data[key].invoicing_city,
            data[key].invoicing_state,
            data[key].invoicing_postalcode,
            data[key].invoicing_country,
          ], value: data[key].supplier, result: data[key].supplier };
        }
        return parsed;
      },
      minChars: 2,
      matchContains: true
    }))
    .result(function(event, item) {

      $('#".$invoiceForm['supplier_identification']->renderId()."').val(item[1]);
      $('#".$invoiceForm['contact_person']->renderId()."').val(item[2]);
      $('#".$invoiceForm['supplier_email']->renderId()."').val(item[3]);
      $('#".$invoiceForm['invoicing_address']->renderId()."').val(item[4]);
      $('#".$invoiceForm['supplier_phone']->renderId()."').val(item[6]);
      $('#".$invoiceForm['supplier_fax']->renderId()."').val(item[7]);
      $('#".$invoiceForm['default_expense_type']->renderId()."').val(item[8]);
      $('#".$invoiceForm['invoicing_city']->renderId()."').val(item[9]);
      $('#".$invoiceForm['invoicing_state']->renderId()."').val(item[10]);
      $('#".$invoiceForm['invoicing_postalcode']->renderId()."').val(item[11]);
      $('#".$invoiceForm['invoicing_country']->renderId()."').val(item[12]);
      //Change al the expenses types that are not assigned
      $('#tbody_invoice_items select').each(function(idx,elem){
        if(elem.id.indexOf('expense_type_id')>0)
        {
          if(!$(elem).val())
            $(elem).val(item[8]);
        }
      });
    });
");

$isnew = $invoiceForm->isNew()?'true':'false';
echo javascript_tag(" $('#supplier-data input[type=text], #supplier-data textarea, #recurring-data input[type=text], #recurring-data select').SiwappFormTips({is_new:$isnew});") // See invoice.js

?>
