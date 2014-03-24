<?php use_helper('JavascriptBase') ?>

<?php include_partial('configuration/navigation') ?>

<div id="settings-wrapper" class="content">
  <form action="<?php echo url_for('@settings') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
      <?php include_partial('submit') ?>
    <?php echo $form['_csrf_token'] ?>
    <div style="display:none"> <?php echo $form['company'][0]['fiscality'] ?></div>
    <?php echo $form['company'][0]['id'] ?>

    <?php include_partial('common/globalErrors', array('form' => $form));?>

    <fieldset id="company-data" class="left">
      <h3><?php echo __('Company') ?></h3>
      <ul>
        <li>
          <span class="_25">
            <?php echo render_tag($form['company'][0]['identification'])  ?>
          </span>
          <span class="_25">
            <?php echo render_tag($form['company'][0]['name'])  ?>
          </span>
        </li>
        <li>
          <span class="_50">
            <?php echo render_tag($form['company'][0]['address'])  ?>
          </span>
        </li>
        <li>
          <span class="_25">
            <?php echo render_tag($form['company'][0]['city'])  ?>
          </span>
          <span class="_25">
            <?php echo render_tag($form['company'][0]['postalcode'])  ?>
          </span>
        </li>
        <li>
          <span class="_25">
            <?php echo render_tag($form['company'][0]['state'])  ?>
          </span>
          <span class="_25">
            <?php echo render_tag($form['company'][0]['country'])  ?>
          </span>
        </li>
        <li>
          <span class="_25">
            <?php echo render_tag($form['company'][0]['phone'])  ?>
          </span>
          <span class="_25">
            <?php echo render_tag($form['company'][0]['fax'])  ?>
          </span>
        </li>
        <li>
          <span class="_25">
            <?php echo render_tag($form['company'][0]['email'])  ?>
          </span>
          <span class="_25">
            <?php echo render_tag($form['company'][0]['url'])  ?>
          </span>
        </li>
        <li>
          <span class="_50">
            <label for="<? echo $form['company'][0]['logo']->renderId()?>"><?php echo __('Logo') ?></label>
            <?php echo render_tag($form['company'][0]['logo'])  ?>
          </span>
        </li>
        <li>
          <span class="_50">
            <label for="<? echo $form['company'][0]['currency']->renderId()?>"><?php echo __('Currency') ?></label>
            <?php echo render_tag($form['company'][0]['currency'])  ?>
          </span>
        </li>
      </ul>
    </fieldset>
    
    <fieldset id="company-administrative-data" >
     <h3><?php echo __('Administrative details') ?></h3>
    <ul>
    <li>
      <span class="_50">
        <?php echo render_tag($form['company'][0]['financial_entity'])  ?>
        </span>
      <span class="_25">
        <?php echo render_tag($form['company'][0]['financial_entity_office']) ?></span>
    </li>
    <li>
      <span class="_25">
        <?php echo render_tag($form['company'][0]['financial_entity_control_digit'])  ?>
        </span>
      <span class="_25">
        <?php echo render_tag($form['company'][0]['financial_entity_account']) ?></span>
      <span class="_25">
        <?php echo render_tag($form['company'][0]['sufix']) ?></span>
    </li>
    <li>
      <span class="_25">
        <?php echo render_tag($form['company'][0]['financial_entity_bic'])  ?>
        </span>
      <span class="_50">
        <?php echo render_tag($form['company'][0]['financial_entity_iban']) ?>
      </span>
    </li>
    <li>
      <span class="_50">
        <?php echo render_tag($form['company'][0]['mercantil_registry'])  ?>
      </span>
  </ul>
  </fieldset>
    
  <fieldset>
      <h3><?php echo __('Legal texts') ?></h3>
      <ul>
        <label for="<? echo $form['company'][0]['invoice_legal_terms']->renderId()?>"><?php echo __('Invoice Terms & Conditions') ?></label>
        <?php echo render_tag($form['company'][0]['invoice_legal_terms'])  ?>
      </ul>
      <ul>
        <label for="<? echo $form['company'][0]['estimate_legal_terms']->renderId()?>"><?php echo __('Estimate Terms & Conditions') ?></label>
        <?php echo render_tag($form['company'][0]['estimate_legal_terms'])  ?>
      </ul>
  </fieldset>
  


    <fieldset class="left taxes taxseries">
      <h3><?php echo __('Invoicing taxes') ?></h3>
      <div id="taxes">
        <ul class="head">
          <a href="#" class="xit"></a>
          <li class="name"><strong><?php echo __('Name')?></strong></li>
          <li class="value text-right"><strong><?php echo __('Value')?></strong></li>
          <li class="active"><strong><?php echo __('Active')?></strong></li>
          <li class="is_default"><strong><?php echo __('Def.')?></strong></li>
          <li class="is_default"><strong><?php echo __('Total')?></strong></li>
        </ul>
        <?php foreach ($form['taxes'] as $tax): ?>
        <?php echo $tax?>
        <?php endforeach ?>
      </div>
      <div class="clear"></div>
      <small>
        <a id="addNewTax" href="#" class="to:taxes"><?php echo __('Add a new tax value') ?></a>
      </small>
    </fieldset>

    <fieldset class="seriess taxseries">
      <h3><?php echo __('Invoicing series') ?></h3>
      <div id="seriess">
        <ul class="head">
          <a href="#" class="xit"></a>
          <li class="name"><strong><?php echo __('Label')?></strong></li>
          <li class="value"><strong><?php echo __('Value') ?></strong></li>
          <li class="first_number"><strong><?php echo __('Initial value')?></strong></li>
        </ul>
        <?php foreach ($form['seriess'] as $s): ?>
        <?php echo $s?>
        <?php endforeach ?>
      </div>
      <div class="clear"></div>
      <small>
        <a id="addNewSeries" href="#" class="to:seriess"><?php echo __('Add a new series value') ?></a><br/>
        <?php echo __('The initial value will only be used for the first saved invoice of the series if there are no invoices assigned.') ?>
      </small>
    </fieldset>

     <fieldset class="expenses taxseries">
      <h3><?php echo __('Expenses Type') ?></h3>
      <div id="expenses">
        <ul class="head">
          <a href="#" class="xit"></a>
          <li class="name"><strong><?php echo __('Name')?></strong></li>
          <li class="active"><strong><?php echo __('Enabled')?></strong></li>
        </ul>
        <?php foreach ($form['expenses'] as $s): ?>
        <?php echo $s?>
        <?php endforeach ?>
      </div>
      <div class="clear"></div>
      <small>
        <a id="addNewExpenses" href="#" class="to:expenses"><?php echo __('Add a new expense type') ?></a><br/>
      </small>
    </fieldset>

   <fieldset class="payments taxseries right">
      <h3><?php echo __('Payments Type') ?></h3>
      <div id="payments">
        <ul class="head">
          <a href="#" class="xit"></a>
          <li class="name"><strong><?php echo __('Name')?></strong></li>
          <li class="name"><strong><?php echo __('Description')?></strong></li>
          <li class="active"><strong><?php echo __('Enabled')?></strong></li>
        </ul>
        <?php foreach ($form['payments'] as $s): ?>
        <?php echo $s?>
        <?php endforeach ?>
      </div>
      <div class="clear"></div>
      <small>
        <a id="addNewPayment" href="#" class="to:payments"><?php echo __('Add a new payment type') ?></a><br/>
      </small>
    </fieldset>

    <fieldset class="left">
      <h3><?php echo __('PDF Settings') ?></h3>
      <ul>
        <?php echo $form['company'][0]['pdf_size']->renderRow(array('class' => error_class($form['company'][0]['pdf_size']))) ?>
        <?php echo $form['company'][0]['pdf_orientation']->renderRow(array('class' => error_class($form['company'][0]['pdf_orientation']))) ?>
      </ul>
    </fieldset>
    <?php
echo javascript_tag("
  var validateDC = function(){
      var cd = $('#".$form['company'][0]['financial_entity_control_digit']->renderId()."');
      var entity = $('#".$form['company'][0]['financial_entity']->renderId()."');
      var office = $('#".$form['company'][0]['financial_entity_office']->renderId()."');
      var account = $('#".$form['company'][0]['financial_entity_account']->renderId()."');

      if (entity.val() == '' || office.val() == '' || cd.val() == '' || account.val() == '')
          return;

      correctcd = calcularDC(entity.val(), office.val(), account.val())
          if (correctcd != cd.val()){
                alert('". __('Wrong Control Digit')."');
              }
          else {
            $('#".$form['company'][0]['financial_entity_iban']->renderId()."').val(calcIBANforSpain(entity.val(), office.val(), cd.val(), account.val()));
          }
    }
    var cd = $('#".$form['company'][0]['financial_entity_control_digit']->renderId()."');
    var entity = $('#".$form['company'][0]['financial_entity']->renderId()."');
    var office = $('#".$form['company'][0]['financial_entity_office']->renderId()."');
    var account = $('#".$form['company'][0]['financial_entity_account']->renderId()."');
    cd.change(validateDC);
    entity.change(validateDC);
    office.change(validateDC);
    account.change(validateDC);
");
?>

    <?php include_partial('submit') ?>
  </form>
</div>

<?php
  echo javascript_tag(" $('#company-data input[type=text], #company-data textarea').SiwappFormTips();"); // See invoice.js
  echo javascript_tag(" $('#company-administrative-data input[type=text], #company-administrative-data textarea').SiwappFormTips();"); // See invoice.js
?>