<?php use_helper('JavascriptBase') ?>

<?php include_partial('configuration/navigation') ?>

<div id="settings-wrapper" class="content">
  <form action="<?php echo url_for('@expenses_settings') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php echo $form['_csrf_token']?>
    
        <?php include_partial('submit') ?>
    
    <?php include_partial('common/globalErrors', array('form' => $form));?>
    
    <fieldset class="left expenses taxseries">
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
    
    <?php include_partial('submit') ?>
  </form>
</div>
