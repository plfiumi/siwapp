<?php
$form = $UserObjectForm;
use_helper('JavascriptBase', 'jQuery');
include_stylesheets_for_form($UserObjectForm);
include_javascripts_for_form($UserObjectForm);

$user = $UserObjectForm->getObject();
?>
<div id="settings-wrapper" class="content">
  <form action="<?php echo url_for("users/$action") ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="users">

  <div class="clear text-right">
  <?php echo gButton(__('Save'), 'type=submit class=btn action primary save', 'button=true') ?>
</div>
    <?php echo $form->renderHiddenFields() ?>
    
    <?php include_partial('common/globalErrors', array('form' => $form));?>

    <fieldset class="left">
      <h3><?php echo __('User Info') ?></h3>
      <ul>
        <?php
          echo $form['first_name']->renderRow(array('class' => error_class($form['first_name'])));
          echo $form['last_name']->renderRow(array('class' => error_class($form['last_name'])));
          echo $form['email']->renderRow(array('class' => error_class($form['email'])));
        ?>
      </ul>
    </fieldset>

    <fieldset class="right">
      <h3><?php echo __('Access Info:')?></h3>
      <ul>
        <?php echo $form['username']->renderRow(array('class'=>error_class($form['username'])))?>
        <?php echo $form['new_password']->renderRow(array('class'=>error_class($form['new_password'])))?>
        <?php echo $form['superadmin']->renderRow(array('class'=>error_class($form['superadmin'])))?>
      </ul>
    </fieldset>
    
    <fieldset class="left">
      <h3><?php echo __('Translate the application') ?></h3>
      <ul>
        <?php
          echo $form['language']->renderRow(array('class' => error_class($form['language'])));
        ?>
      </ul>
      <ul id="country_container"></ul>
    </fieldset>
    
    <fieldset class="left">
      <h3><?php echo __('Make it easy') ?></h3>
      <ul>
        <?php
          echo $form['nb_display_results']->renderRow(array('class' => error_class($form['nb_display_results'])));
          echo $form['search_filter']->renderRow(array('class' => error_class($form['search_filter'])));
        ?>
      </ul>
    </fieldset>
    
<div class="clear text-right">
  <?php echo gButton(__('Save'), 'type=submit class=btn action primary save', 'button=true') ?>
</div>
  </form>
</div>
