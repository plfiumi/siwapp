<?php
use_helper('JavascriptBase', 'jQuery');
include_stylesheets_for_form($customerForm);
include_javascripts_for_form($customerForm);

$customer = $customerForm->getObject();
?>
<div id="customer-container" class="content">

  <h2><?php echo $title ?></h2>
  <form action="<?php echo url_for("customers/$action") ?>" method="post" <?php $customerForm->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="customer">
  <?php include_partial('common/globalErrors', array('form' => $customerForm)) ?>
  <?php
    echo $customerForm['id'];
    // here draft, in case were saved as draft, the button must put 1 here
    echo $customerForm['_csrf_token'];
    echo $customerForm['company_id'];
  ?>
  <div id="saving-options" class="block right">
    <?php
    if ($customer->getId()) {
      echo gButton_to(__('Delete'), "customers/delete?id=" . $customer->getId(), array(
        'class' => 'action delete',
        'post' => true,
        'confirm' => __('Are you sure?'),
        ) , 'button=false')." ";
    }

    echo gButton(__('Save'), 'type=submit class=action primary save', 'button=true');
    ?>
  </div>
  <div id="customer-data" class="global-data block">
  <h3><?php echo __('Client info') ?></h3>
  <ul>
    <li>
      <span class="_75">
        <label for="<? echo $customerForm['name']->renderId()?>"><?php echo __('Client Name') ?></label>
        <?php echo render_tag($customerForm['name'])?>
        <?php echo $customerForm['name_slug']->renderError()?>
      </span>
      <span class="_25">
          <label for="<? echo $customerForm['identification']->renderId()?>"><?php echo __('Legal Id') ?></label>
        <?php echo render_tag($customerForm['identification'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <label for="<? echo $customerForm['contact_person']->renderId()?>"><?php echo __('Contact Person') ?></label>
        <?php echo render_tag($customerForm['contact_person'])?>
      </span>
        <span class="_50">
          <label for="<? echo $customerForm['mobile']->renderId()?>"><?php echo __('Client Mobile') ?></label>
          <?php echo render_tag($customerForm['mobile'])?>
      </span>
    </li>
    <li>
        <span class="_50">
           <label for="<? echo $customerForm['phone']->renderId()?>"><?php echo __('Client Phone') ?></label>
           <?php echo render_tag($customerForm['phone'])?>
        </span>
      <span class="_50">
        <label for="<? echo $customerForm['fax']->renderId()?>"><?php echo __('Client Fax') ?></label>
            <?php echo render_tag($customerForm['fax'])?>
      </span>
    </li>
    <li>
      <span class="_50">
          <label for="<? echo $customerForm['email']->renderId()?>"><?php echo __('Client Email') ?></label>
         <?php echo render_tag($customerForm['email'])?>
     </span>

      <span class="_50">
        <label for="<? echo $customerForm['website']->renderId()?>"><?php echo __('Website') ?></label>
        <?php echo render_tag($customerForm['website'])?>
      </span>
    </li>
        <li>
      <span class="_50">
        <label for="<? echo $customerForm['invoicing_address']->renderId()?>"><?php echo __('Invoicing Address') ?></label>
        <?php echo render_tag($customerForm['invoicing_address'])?>
      </span>
      <span class="_50">
        <label for="<? echo $customerForm['invoicing_city']->renderId()?>"><?php echo __('Invoicing City') ?></label>
        <?php echo render_tag($customerForm['invoicing_city'])?>
      </span>
    </li>
    <li>
      <span class="_25">
        <label for="<? echo $customerForm['invoicing_postalcode']->renderId()?>"><?php echo __('Invoicing Postal code') ?></label>
        <?php echo render_tag($customerForm['invoicing_postalcode'])?>
      </span>
      <span class="_25">
        <label for="<? echo $customerForm['invoicing_state']->renderId()?>"><?php echo __('Invoicing State') ?></label>
        <?php echo render_tag($customerForm['invoicing_state'])?>
      </span>
        <span class="_25">
        <label for="<? echo $customerForm['invoicing_country']->renderId()?>"><?php echo __('Invoicing Contry') ?></label>
        <?php echo render_tag($customerForm['invoicing_country'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <label for="<? echo $customerForm['shipping_address']->renderId()?>"><?php echo __('Shipping Address') ?></label>
        <?php echo render_tag($customerForm['shipping_address'])?>
      </span>
      <span class="_50">
        <label for="<? echo $customerForm['shipping_city']->renderId()?>"><?php echo __('Shipping City') ?></label>
        <?php echo render_tag($customerForm['shipping_city'])?>
      </span>
    </li>
    <li>
      <span class="_25">
        <label for="<? echo $customerForm['shipping_postalcode']->renderId()?>"><?php echo __('Shipping Postal code') ?></label>
        <?php echo render_tag($customerForm['shipping_postalcode'])?>
      </span>
      <span class="_25">
        <label for="<? echo $customerForm['shipping_state']->renderId()?>"><?php echo __('Shipping State') ?></label>
        <?php echo render_tag($customerForm['shipping_state'])?>
      </span>
        <span class="_25">
        <label for="<? echo $customerForm['shipping_country']->renderId()?>"><?php echo __('Shipping Contry') ?></label>
        <?php echo render_tag($customerForm['shipping_country'])?>
      </span>
    </li>
    <li>
       <span class="_75 ">
         <label for="<? echo $customerForm['comments']->renderId()?>"><?php echo __('Comments') ?></label>
         <?php echo render_tag($customerForm['comments'])?>
       </span>
    </li>
  </ul>
</div>
  <div id="customer-bank-data" class="global-data block">
    <h3><?php echo __('Bank details') ?></h3>
    <ul>
    <li>
      <span class="_50">
        <label for="<? echo $customerForm['discount']->renderId()?>"><?php echo __('Discount Percentage') ?></label>
        <?php echo render_tag($customerForm['discount'])  ?>
        </span>
      <span class="_50">
        <label for="<? echo $customerForm['payment_type_id']->renderId()?>"><?php echo __('Payment type') ?></label>
        <?php echo render_tag($customerForm['payment_type_id'])  ?>
        </span>
    </li>
    <li>
      <span class="_50">
        <label for="<? echo $customerForm['entity']->renderId()?>"><?php echo __('Entity') ?></label>
        <?php echo render_tag($customerForm['entity'])  ?>
        </span>
      <span class="_50">
        <label for="<? echo $customerForm['office']->renderId()?>"><?php echo __('Office') ?></label>
        <?php echo render_tag($customerForm['office']) ?></span>
    </li>
    <li>
      <span class="_50">
        <label for="<? echo $customerForm['control_digit']->renderId()?>"><?php echo __('Control digit') ?></label>
        <?php echo render_tag($customerForm['control_digit'])  ?>
        </span>
      <span class="_50">
        <label for="<? echo $customerForm['account']->renderId()?>"><?php echo __('Account') ?></label>
        <?php echo render_tag($customerForm['account']) ?></span>
    </li>
    <li>
      <span class="_50">
        <label for="<? echo $customerForm['bic']->renderId()?>"><?php echo __('BIC Code') ?></label>
        <?php echo render_tag($customerForm['bic'])  ?>
        </span>
      <span class="_50">
        <label for="<? echo $customerForm['iban']->renderId()?>"><?php echo __('IBAN') ?></label>
        <?php echo render_tag($customerForm['iban']) ?></span>
    </li>
  </ul>
</div>
  <?php include_partial('common/tagsDataBlock', array('invoice' => $customer, 'invoiceForm' => $customerForm)) ?>
  <div id="saving-options" class="block">
    <?php
echo javascript_tag("
  var validateDC = function(){
      var cd = $('#".$customerForm['control_digit']->renderId()."');
      var entity = $('#".$customerForm['entity']->renderId()."');
      var office = $('#".$customerForm['office']->renderId()."');
      var account = $('#".$customerForm['account']->renderId()."');

      if (entity.val() == '' || office.val() == '' || cd.val() == '' || account.val() == '')
          return;

      correctcd = calcularDC(entity.val(), office.val(), account.val())
          if (correctcd != cd.val()){
                alert('". __('Wrong Control Digit')."');
              }
          else {
            $('#".$customerForm['iban']->renderId()."').val(calcIBANforSpain(entity.val(), office.val(), cd.val(), account.val()));
          }
    }
    var cd = $('#".$customerForm['control_digit']->renderId()."');
    var entity = $('#".$customerForm['entity']->renderId()."');
    var office = $('#".$customerForm['office']->renderId()."');
    var account = $('#".$customerForm['account']->renderId()."');
    cd.change(validateDC);
    entity.change(validateDC);
    office.change(validateDC);
    account.change(validateDC);
");
    if ($customer->getId()) {
      echo gButton_to(__('Delete'), "customers/delete?id=" . $customer->getId(), array(
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
echo javascript_tag(" $('#customer-data input[type=text], #customer-data textarea').SiwappFormTips();") // See invoice.js
?>
