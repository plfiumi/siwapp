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
      <span class="_50">
        <?php echo render_tag($customerForm['name'])?>
        <?php echo $customerForm['name_slug']->renderError()?>
      </span>
      <span class="_25">
        <?php echo render_tag($customerForm['business_name'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($customerForm['identification'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($customerForm['phone'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($customerForm['fax'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($customerForm['mobile'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($customerForm['email'])?>
      </span>
      <span class="_50">
        <?php echo render_tag($customerForm['website'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($customerForm['contact_person'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($customerForm['contact_person_phone'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($customerForm['contact_person_email'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($customerForm['invoicing_address'])?>
      </span>
      <span class="_50">
        <?php echo render_tag($customerForm['invoicing_city'])?>
      </span>
    </li>
    <li>
      <span class="_25">
        <?php echo render_tag($customerForm['invoicing_postalcode'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($customerForm['invoicing_state'])?>
      </span>
        <span class="_25">
        <?php echo render_tag($customerForm['invoicing_country'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($customerForm['shipping_address'])?>
      </span>
      <span class="_50">
        <?php echo render_tag($customerForm['shipping_city'])?>
      </span>
    </li>
    <li>
      <span class="_25">
        <?php echo render_tag($customerForm['shipping_postalcode'])?>
      </span>
      <span class="_25">
        <?php echo render_tag($customerForm['shipping_state'])?>
      </span>
        <span class="_25">
        <?php echo render_tag($customerForm['shipping_country'])?>
      </span>
    </li>
    <li>
       <span class="_50 ">
         <?php echo render_tag($customerForm['shipping_company_data'])?>
       </span>
    </li>
    <li>
       <span class="_50 ">
         <?php echo render_tag($customerForm['comments'])?>
       </span>
    </li>
  </ul>
</div>
<div id="customer-administrative-data" class="global-data block">
    <h3><?php echo __('Administrative details') ?></h3>
    <ul>
    <li>
      <span class="_50">
        <label class="light" for="<? echo $customerForm['tax_condition_id']->renderId()?>"><?php echo __('Tax condition') ?></label>
        <?php echo render_tag($customerForm['tax_condition_id'])  ?>
        </span>
      <span class="_50">
        <label class="light" for="<? echo $customerForm['series_id']->renderId()?>"><?php echo __('Invoicing series') ?></label>
        <?php echo render_tag($customerForm['series_id'])  ?>
        </span>
    </li>
    <li>
      <span class="_50">
        <label class="light" for="<? echo $customerForm['discount']->renderId()?>"><?php echo __('Discount Percentage') ?></label>
        <?php echo render_tag($customerForm['discount'])  ?>
        </span>
      <span class="_50">
        <label class="light" for="<? echo $customerForm['payment_type_id']->renderId()?>"><?php echo __('Payment type') ?></label>
        <?php echo render_tag($customerForm['payment_type_id'])  ?>
        </span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($customerForm['financial_entity'])  ?>
        </span>
      <span class="_50">
        <?php echo render_tag($customerForm['financial_entity_office']) ?></span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($customerForm['financial_entity_control_digit'])  ?>
        </span>
      <span class="_50">
        <?php echo render_tag($customerForm['financial_entity_account']) ?></span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($customerForm['financial_entity_bic'])  ?>
        </span>
      <span class="_50">
        <?php echo render_tag($customerForm['financial_entity_iban']) ?></span>
    </li>
  </ul>
</div>
  <?php include_partial('common/tagsDataBlock', array('invoice' => $customer, 'invoiceForm' => $customerForm)) ?>
  <div id="saving-options" class="block">
    <?php
echo javascript_tag("
  var validateDC = function(){
      var cd = $('#".$customerForm['financial_entity_control_digit']->renderId()."');
      var entity = $('#".$customerForm['financial_entity']->renderId()."');
      var office = $('#".$customerForm['financial_entity_office']->renderId()."');
      var account = $('#".$customerForm['financial_entity_account']->renderId()."');

      if (entity.val() == '' || office.val() == '' || cd.val() == '' || account.val() == '')
          return;

      correctcd = calcularDC(entity.val(), office.val(), account.val())
          if (correctcd != cd.val()){
                alert('". __('Wrong Control Digit')."');
              }
          else {
            $('#".$customerForm['financial_entity_iban']->renderId()."').val(calcIBANforSpain(entity.val(), office.val(), cd.val(), account.val()));
          }
    }
    var cd = $('#".$customerForm['financial_entity_control_digit']->renderId()."');
    var entity = $('#".$customerForm['financial_entity']->renderId()."');
    var office = $('#".$customerForm['financial_entity_office']->renderId()."');
    var account = $('#".$customerForm['financial_entity_account']->renderId()."');
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
  echo javascript_tag(" $('#customer-data input[type=text], #customer-data textarea').SiwappFormTips();"); // See invoice.js
  echo javascript_tag(" $('#customer-administrative-data input[type=text], #customer-administrative-data textarea').SiwappFormTips();"); // See invoice.js
?>
