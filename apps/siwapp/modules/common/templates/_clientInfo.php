<div id="customer-data" class="global-data block">
  <h3><?php echo __('Customer info') ?></h3>
  <ul>
    <li>
      <span class="_50">
        <?php echo render_tag($invoiceForm['customer_name'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($invoiceForm['customer_business_name'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($invoiceForm['customer_identification'])?>
      </span>
    </li>
    <li>
      <span class="_25">
         <?php echo render_tag($invoiceForm['customer_phone'])?>
      </span>
      <span class="_25">
            <?php echo render_tag($invoiceForm['customer_fax'])?>
      </span>
      <span class="_25">
          <?php echo render_tag($invoiceForm['customer_mobile'])?>
      </span>
      <span class="_25">
          <?php echo render_tag($invoiceForm['customer_email'])?>
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
      <span class="_50">
        <?php echo render_tag($invoiceForm['shipping_address'])?>
      </span>
      <span class="_50">
        <?php echo render_tag($invoiceForm['shipping_city'])?>
      </span>
    </li>
    <li>
      <span class="_25">
        <?php echo render_tag($invoiceForm['shipping_postalcode'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($invoiceForm['shipping_state'])?>
      </span>
        <span class="_25">
        <?php echo render_tag($invoiceForm['shipping_country'])?>
      </span>
    </li>
    <li>
       <span class="_50 ">
         <?php echo render_tag($invoiceForm['customer_comments'])?>
       </span>
    </li>
    <li>
       <span class="_50 ">
         <?php echo render_tag($invoiceForm['customer_tax_condition'])?>
       </span>
    </li>
  </ul>
</div>
<?php
use_helper('JavascriptBase');

$urlAjax = url_for('common/ajaxCustomerAutocomplete');
echo javascript_tag("
  $('#".$invoiceForm['customer_name']->renderId()."')
    .autocomplete('".$urlAjax."', jQuery.extend({}, {
      dataType: 'json',
      parse:    function(data) {
        var parsed = [];
        for (key in data) {
          parsed[parsed.length] = { data: [ data[key].customer,
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
            data[key].shipping_address,
            data[key].shipping_city,
            data[key].shipping_state,
            data[key].shipping_postalcode,
            data[key].shipping_country,
            data[key].shipping_company_data,
            data[key].comments,
            data[key].tax_condition,
            data[key].payment_type,
            data[key].discount,
            data[key].series,
          ], value: data[key].customer, result: data[key].customer };
        }
        return parsed;
      },
      minChars: 2,
      matchContains: true
    }))
    .result(function(event, item) {
      $('#".$invoiceForm['customer_business_name']->renderId()."').val(item[1]);
      $('#".$invoiceForm['customer_identification']->renderId()."').val(item[2]);
      $('#".$invoiceForm['customer_phone']->renderId()."').val(item[3]);
      $('#".$invoiceForm['customer_fax']->renderId()."').val(item[4]);
      $('#".$invoiceForm['customer_mobile']->renderId()."').val(item[5]);
      $('#".$invoiceForm['customer_email']->renderId()."').val(item[6]);
      $('#".$invoiceForm['contact_person']->renderId()."').val(item[7]);
      $('#".$invoiceForm['contact_person_phone']->renderId()."').val(item[8]);
      $('#".$invoiceForm['contact_person_email']->renderId()."').val(item[9]);
      $('#".$invoiceForm['invoicing_address']->renderId()."').val(item[10]);
      $('#".$invoiceForm['invoicing_city']->renderId()."').val(item[11]);
      $('#".$invoiceForm['invoicing_state']->renderId()."').val(item[12]);
      $('#".$invoiceForm['invoicing_postalcode']->renderId()."').val(item[13]);
      $('#".$invoiceForm['invoicing_country']->renderId()."').val(item[14]);
      $('#".$invoiceForm['shipping_address']->renderId()."').val(item[15]);
      $('#".$invoiceForm['shipping_city']->renderId()."').val(item[16]);
      $('#".$invoiceForm['shipping_state']->renderId()."').val(item[17]);
      $('#".$invoiceForm['shipping_postalcode']->renderId()."').val(item[18]);
      $('#".$invoiceForm['shipping_country']->renderId()."').val(item[19]);
      $('#".$invoiceForm['shipping_company_data']->renderId()."').val(item[20]);
      $('#".$invoiceForm['customer_comments']->renderId()."').val(item[21]);
      $('#".$invoiceForm['customer_tax_condition']->renderId()."').val(item[22]);
      $('#".$invoiceForm['payment_type_id']->renderId()."').val(item[23]);
      $('#".$invoiceForm['discount']->renderId()."').val(item[24]);
      
      var customer_series = item[24];
      if(customer_series!=(0||''||null))
        $('#".$invoiceForm['series_id']->renderId()."').val(customer_series);
    });
");

$isnew = $invoiceForm->isNew()?'true':'false';
echo javascript_tag(" $('#customer-data input[type=text], #customer-data textarea, #recurring-data input[type=text], #recurring-data select').SiwappFormTips({is_new:$isnew});") // See invoice.js

?>
