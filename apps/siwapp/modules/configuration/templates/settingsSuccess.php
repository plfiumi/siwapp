<?php use_helper('JavascriptBase') ?>

<?php include_partial('configuration/navigation') ?>

<div id="settings-wrapper" class="content">
  <form action="<?php echo url_for('@settings') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
      <?php include_partial('submit') ?>
    <?php echo $form['_csrf_token'] ?>
    <div style="display:none"> <?php echo $form['company'][0]['fiscality'] ?></div>
    <?php echo $form['company'][0]['id'] ?>

    <?php include_partial('common/globalErrors', array('form' => $form));?>

    <fieldset class="left">
      <h3><?php echo __('Company') ?></h3>
      <ul>
        <?php echo $form['company'][0]['identification']->renderRow(array('class' => 'full '.error_class($form['company'][0]['identification']))) ?>
        <?php echo $form['company'][0]['name']->renderRow(array('class' => 'full '.error_class($form['company'][0]['name']))) ?>
        <?php echo $form['company'][0]['address']->renderRow(array('class' => error_class($form['company'][0]['address']))) ?>
        <?php echo $form['company'][0]['city']->renderRow(array('class' => error_class($form['company'][0]['city']))) ?>
        <?php echo $form['company'][0]['postalcode']->renderRow(array('class' => error_class($form['company'][0]['postalcode']))) ?>
        <?php echo $form['company'][0]['state']->renderRow(array('class' => error_class($form['company'][0]['state']))) ?>
        <?php echo $form['company'][0]['country']->renderRow(array('class' => error_class($form['company'][0]['country']))) ?>
        <?php echo $form['company'][0]['phone']->renderRow(array('class' => error_class($form['company'][0]['phone']))) ?>
        <?php echo $form['company'][0]['fax']->renderRow(array('class' => error_class($form['company'][0]['fax']))) ?>
        <?php echo $form['company'][0]['email']->renderRow(array('class' => 'full '.error_class($form['company'][0]['email']))) ?>
        <?php echo $form['company'][0]['url']->renderRow(array('class' => 'full '.error_class($form['company'][0]['url']))) ?>
        <?php echo $form['company'][0]['logo']->renderRow(array('class' => error_class($form['company'][0]['logo']))) ?>
        <?php echo $form['company'][0]['currency']->renderRow(array('class' => error_class($form['company'][0]['currency']))) ?>
      </ul>
    </fieldset>

    <fieldset>
      <h3><?php echo __('Legal texts') ?></h3>
      <ul>
        <?php echo $form['company'][0]['legal_terms']->renderRow(array('class' => error_class($form['company'][0]['legal_terms']))) ?>
      </ul>
    </fieldset>
        <fieldset>
     <h3><?php echo __('Bank details') ?></h3>
    <ul>
    <li>
      <span class="_50">
        <label for="<? echo $form['company'][0]['entity']->renderId()?>"><?php echo __('Entity') ?></label>
        <?php echo render_tag($form['company'][0]['entity'])  ?>
        </span>
      <span class="_50">
        <label for="<? echo $form['company'][0]['office']->renderId()?>"><?php echo __('Office') ?></label>
        <?php echo render_tag($form['company'][0]['office']) ?></span>
    </li>
    <li>
      <span class="_50">
        <label for="<? echo $form['company'][0]['control_digit']->renderId()?>"><?php echo __('Control digit') ?></label>
        <?php echo render_tag($form['company'][0]['control_digit'])  ?>
        </span>
      <span class="_50">
        <label for="<? echo $form['company'][0]['account']->renderId()?>"><?php echo __('Account') ?></label>
        <?php echo render_tag($form['company'][0]['account']) ?></span>
      <span class="_50">
        <label for="<? echo $form['company'][0]['sufix']->renderId()?>"><?php echo __('Suffix') ?></label>
        <?php echo render_tag($form['company'][0]['sufix']) ?></span>
    </li>
    <li>
      <span class="_50">
        <label for="<? echo $form['company'][0]['bic']->renderId()?>"><?php echo __('BIC Code') ?></label>
        <?php echo render_tag($form['company'][0]['bic'])  ?>
        </span>
      <span class="_50">
        <label for="<? echo $form['company'][0]['iban']->renderId()?>"><?php echo __('IBAN') ?></label>
        <?php echo render_tag($form['company'][0]['iban']) ?></span>
    </li>
  </ul>
  </fieldset>
  <fieldset>
    <h3><?php echo __('Other info') ?></h3>
    <ul>
    <li>
      <span class="_50">
        <label for="<? echo $form['company'][0]['mercantil_registry']->renderId()?>"><?php echo __('Mercantil Registry') ?></label>
        <?php echo render_tag($form['company'][0]['mercantil_registry'])  ?>
        </span>
    </li>
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
      var cd = $('#".$form['company'][0]['control_digit']->renderId()."');
      var entity = $('#".$form['company'][0]['entity']->renderId()."');
      var office = $('#".$form['company'][0]['office']->renderId()."');
      var account = $('#".$form['company'][0]['account']->renderId()."');

      if (entity.val() == '' || office.val() == '' || cd.val() == '' || account.val() == '')
          return;

      correctcd = calcularDC(entity.val(), office.val(), account.val())
          if (correctcd != cd.val()){
                alert('". __('Wrong Control Digit')."');
              }
          else {
            $('#".$form['company'][0]['iban']->renderId()."').val(calcIBANforSpain(entity.val(), office.val(), cd.val(), account.val()));
          }
    }
    var cd = $('#".$form['company'][0]['control_digit']->renderId()."');
    var entity = $('#".$form['company'][0]['entity']->renderId()."');
    var office = $('#".$form['company'][0]['office']->renderId()."');
    var account = $('#".$form['company'][0]['account']->renderId()."');
    cd.change(validateDC);
    entity.change(validateDC);
    office.change(validateDC);
    account.change(validateDC);
");
?>

    <?php include_partial('submit') ?>
  </form>
</div>
