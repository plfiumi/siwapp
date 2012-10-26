<?php use_helper('JavascriptBase') ?>

<?php include_partial('configuration/navigation') ?>

<div id="settings-wrapper" class="content">
  <form action="<?php echo url_for('@categories') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php echo $form['_csrf_token']?>
    
        <?php include_partial('submit') ?>
    
    <?php include_partial('common/globalErrors', array('form' => $form));?>
    <fieldset class="left categories taxseries">
      <h3><?php echo __('Product Categories') ?></h3>
      <div id="product_categories">
        <ul class="head">
          <a href="#" class="xit"></a>
          <li class="name"><strong><?php echo __('Name')?></strong></li>
        </ul>
        <?php foreach ($form['product_categories'] as $category): ?>
        <?php echo $category ?>
        <?php endforeach ?>
      </div>
      <div class="clear"></div>
      <small>
        <a id="addNewCategory" href="#" class="to:product_categories"><?php echo __('Add a new category') ?></a>
      </small>
    </fieldset>
    <?php include_partial('submit') ?>
  </form>
</div>
