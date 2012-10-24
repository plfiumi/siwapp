<div id="supplier-data" class="global-data block">
  <h3><?php echo __('Supplier info') ?></h3>
  <ul>
    <li>
      <span class="_75"><?php echo render_tag($invoiceForm['supplier_name'])?></span>
      <span class="_25"><?php echo render_tag($invoiceForm['supplier_identification'])?></span>
    </li>
    <li>
      <span class="_50"><?php echo render_tag($invoiceForm['contact_person'])?></span>
      <span class="_50"><?php echo render_tag($invoiceForm['supplier_email'])?></span>
    </li>
    <li>
      <span class="_50"><?php echo render_tag($invoiceForm['supplier_phone'])?></span>
      <span class="_50"><?php echo render_tag($invoiceForm['supplier_fax'])?></span>
    </li>
    <li>
      <span class="_75"><?php echo render_tag($invoiceForm['invoicing_address'])?></span>
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
      $('#".$invoiceForm['shipping_address']->renderId()."').val(item[5]);
      $('#".$invoiceForm['supplier_phone']->renderId()."').val(item[6]);
      $('#".$invoiceForm['supplier_fax']->renderId()."').val(item[7]);
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
