<div id="supplier-data" class="global-data block">
  <h3><?php echo __('Supplier info') ?></h3>
  <ul>
    <li>
      <li>
        <span class="_50">
          <?php echo render_tag($invoiceForm['supplier_name'])?>
        </span>
        <span class="_25">
          <?php echo render_tag($invoiceForm['supplier_business_name'])?>
        </span>
        <span class="_25">
           <?php echo render_tag($invoiceForm['supplier_identification'])?>
        </span>
      </li>
      <li>
        <span class="_25">
          <?php echo render_tag($invoiceForm['supplier_phone'])?>
        </span>
        <span class="_25">
          <?php echo render_tag($invoiceForm['supplier_fax'])?>
        </span>
        <span class="_25">
          <?php echo render_tag($invoiceForm['supplier_mobile'])?>
        </span>
        <span class="_25">
          <?php echo render_tag($invoiceForm['supplier_email'])?>
        </span>
      </li>
      <li>
        <span class="_50">
          <?php echo render_tag($invoiceForm['contact_person'])?>
        </span>
        <span class="_25">
          <?php echo render_tag($invoiceForm['contact_person_phone'])?>
        </span>
        <span class="_25">
          <?php echo render_tag($invoiceForm['contact_person_email'])?>
        </span>
      </li>
      <li>
        <span class="_50">
          <?php echo render_tag($invoiceForm['invoicing_address'])?>
        </span>
        <span class="_50">
          <?php echo render_tag($invoiceForm['invoicing_city'])?>
        </span>
      </li>
      <li>
        <span class="_25">
          <?php echo render_tag($invoiceForm['invoicing_postalcode'])?>
        </span>
        <span class="_25">
          <?php echo render_tag($invoiceForm['invoicing_state'])?>
        </span>
          <span class="_25">
          <?php echo render_tag($invoiceForm['invoicing_country'])?>
        </span>
      </li>
      <li>
         <span class="_50 ">
           <?php echo render_tag($invoiceForm['supplier_comments'])?>
         </span>
      </li>
      <li>
       <span class="_50 ">
         <?php echo render_tag($invoiceForm['supplier_tax_condition'])?>
       </span>
      </li>
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
            data[key].business_name,
            data[key].identification, 
            data[key].phone,
            data[key].fax,
            data[key].mobile,
            data[key].email,
            data[key].contact_person,
            data[key].contact_person_phone,
            data[key].contact_person_email,
            data[key].invoicing_address,
            data[key].invoicing_city,
            data[key].invoicing_state,
            data[key].invoicing_postalcode,
            data[key].invoicing_country,
            data[key].comments,
            data[key].tax_condition,
            data[key].payment_type,
            data[key].expense_type,
          ], value: data[key].supplier, result: data[key].supplier };
        }
        return parsed;
      },
      minChars: 2,
      matchContains: true
    }))
    .result(function(event, item) {
      $('#".$invoiceForm['supplier_business_name']->renderId()."').val(item[1]);
      $('#".$invoiceForm['supplier_identification']->renderId()."').val(item[2]);
      $('#".$invoiceForm['supplier_phone']->renderId()."').val(item[3]);
      $('#".$invoiceForm['supplier_fax']->renderId()."').val(item[4]);
      $('#".$invoiceForm['supplier_mobile']->renderId()."').val(item[5]);
      $('#".$invoiceForm['supplier_email']->renderId()."').val(item[6]);
      $('#".$invoiceForm['contact_person']->renderId()."').val(item[7]);
      $('#".$invoiceForm['contact_person_phone']->renderId()."').val(item[8]);
      $('#".$invoiceForm['contact_person_email']->renderId()."').val(item[9]);
      $('#".$invoiceForm['invoicing_address']->renderId()."').val(item[10]);
      $('#".$invoiceForm['invoicing_city']->renderId()."').val(item[11]);
      $('#".$invoiceForm['invoicing_state']->renderId()."').val(item[12]);
      $('#".$invoiceForm['invoicing_postalcode']->renderId()."').val(item[13]);
      $('#".$invoiceForm['invoicing_country']->renderId()."').val(item[14]);
      $('#".$invoiceForm['supplier_comments']->renderId()."').val(item[15]);
      $('#".$invoiceForm['supplier_tax_condition']->renderId()."').val(item[16]);
      $('#".$invoiceForm['payment_type_id']->renderId()."').val(item[17]);
      $('#".$invoiceForm['default_expense_type']->renderId()."').val(item[18]);
        
      //Change al the expenses types that are not assigned
      $('#tbody_invoice_items select').each(function(idx,elem){
        if(elem.id.indexOf('expense_type_id')>0)
        {
          if(!$(elem).val())
            $(elem).val(item[18]);
        }
      });
    });
");

$isnew = $invoiceForm->isNew()?'true':'false';
echo javascript_tag(" $('#supplier-data input[type=text], #supplier-data textarea, #recurring-data input[type=text], #recurring-data select').SiwappFormTips({is_new:$isnew});") // See invoice.js

?>
