<?php use_helper('JavascriptBase') ?>

<div id="tags_data" class="block">
  <h3><?php echo __('Tags') ?></h3>

  <?php
    echo $invoiceForm['tags'];
    echo '&nbsp;'.gButton_to_function(__('Add'), "triggerAddButton()", 'class=action-clear addTag');
    echo $invoiceForm['tags']->renderError();

    $tagTemplate = esc_js_no_entities(get_partial('common/tagSpan', array('tag' => '#{tag}')));

    echo javascript_tag("
      function triggerAddButton(){
        if($('#invoice_tags').length>0)
        {
          $('#invoice_tags_input').trigger('ComputeTags');
        }
        else if($('#customer_tags').length>0)
        {
          $('#customer_tags_input').trigger('ComputeTags');
        }
        else
        {
          $('#expense_tags_input').trigger('ComputeTags');
        }
      }

      if($('#invoice_tags').length>0)
      {
        $('#invoice_tags').tagSelector({
          autocompletionUrl : '".url_for('common/ajaxTagsAutocomplete')."',
          tagsContainer     : 'the_tags_div',
          tagTemplate       : '$tagTemplate'
        });
      }
      else if($('#customer_tags').length>0)
      {
        $('#customer_tags').tagSelector({
          autocompletionUrl : '".url_for('common/ajaxTagsAutocomplete')."',
          tagsContainer     : 'the_tags_div',
          tagTemplate       : '$tagTemplate'
        });
      }
      else
      {
        $('#expense_tags').tagSelector({
          autocompletionUrl : '".url_for('common/ajaxTagsAutocomplete')."',
          tagsContainer     : 'the_tags_div',
          tagTemplate       : '$tagTemplate'
        });
      }
    ");

  ?>

  <div id="the_tags_div" class="taglist">
    <?php foreach($invoice->getTags() as $tag): ?>
      <?php include_partial('common/tagSpan', array('tag' => $tag)) ?>
    <?php endforeach; ?>
  </div>
</div>
