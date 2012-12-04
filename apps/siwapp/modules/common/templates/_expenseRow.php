<?php 
use_helper('jQuery', 'Number', 'JavascriptBase');
$currency = $sf_user->getAttribute('currency');
?>
<tr id="tr_invoice_item_<?php echo $rowId?>">
  <td class="description">
    <?php if(!$sf_user->has_module('products')):?>
    <?php echo jq_link_to_function('',
      "$('#tr_invoice_item_".$rowId." input.remove').val(1);$('#tr_invoice_item_$rowId').hide();$(document).trigger('GlobalUpdateEvent');",
      array('class' => 'remove-item xit')
    ) ?>
    <?php endif; ?>
    <?php echo $invoiceItemForm->renderHiddenFields();?>
    <?php echo $invoiceItemForm['description']->render(array(), ESC_RAW) ?>
  </td>
  <td class="right ucost"><?php 
    if ($invoiceItemForm['expense_type_id']->hasError()):
      echo $invoiceItemForm['expense_type_id']->render(array('class'=>'error'), ESC_RAW);
    else:
      echo $invoiceItemForm['expense_type_id']->render(array(), ESC_RAW);
    endif;
    echo javascript_tag("$('#".$invoiceItemForm['expense_type_id']->renderId()."').val($('#expense_default_expense_type').val())");
    ?></td>
  <td class="right quantity"><?php 
    if ($invoiceItemForm['unitary_cost']->hasError()):
      echo $invoiceItemForm['unitary_cost']->render(array('class'=>'error'), ESC_RAW);
    else:
      echo $invoiceItemForm['unitary_cost']->render(array(), ESC_RAW);
    endif;
  ?></td>
  <td class="right quantity"><?php 
    if ($invoiceItemForm['quantity']->hasError()):
      echo $invoiceItemForm['quantity']->render(array('class'=>'error'), ESC_RAW);
    else:
      echo $invoiceItemForm['quantity']->render(array(), ESC_RAW);
    endif;
  ?></td>
  <td class="right taxes_td">
    <span id="<?php echo $rowId?>_taxes" class="taglist taxes">
      <?php $err = $invoiceItemForm['taxes_list']->hasError() ? 'error' : '';
        $item_taxes = $invoiceItemForm['taxes_list']->getValue() ? 
          $invoiceItemForm['taxes_list']->getValue() : array();
        $totalTaxesValue = Doctrine::getTable('Tax')->getTotalTaxesValue($item_taxes);
        echo jq_javascript_tag("
        window.new_item_tax_index = $('".$rowId."_taxes').find('span[id^=tax_".$rowId."]').size()+1;
        ");
        echo jq_link_to_remote(__("Add"), array(
        'update'=>$rowId.'_taxes',
        'url'=>'common/ajaxAddExpenseItemTax',
        'position'=>'bottom',
        'method'=>'post',
        'with'=>"{item_tax_index: new_item_tax_index++, invoice_item_key: '$rowId'}"
        ));
        foreach($item_taxes as $taxId):
        include_partial('common/taxExpenseSpan',array('taxKey'=>$taxId,'rowId'=>$rowId,'err'=>$err));
        endforeach?>

      <?php
        // if item has no taxes, and there are "default" taxes defined, we add them
        if(isset($isNew) && !count($item_taxes))
        {
          $default_taxes = Doctrine::getTable('Tax')->createQuery()->
            AndWhere('active = ? ', true)->
            AndWhere('is_default = ? ', true)->
            AndWhere('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))->
execute();
          foreach($default_taxes as $taxx)
          {
            echo javascript_tag(
                   jq_remote_function(
                     array(
                       'update'=> $rowId.'_taxes',
                       'url'  => 'common/ajaxAddExpenseItemTax',
                       'position' => 'bottom',
                       'method'   => 'post',
                       'with'     => "{
                                        item_tax_index:   new_item_tax_index++, 
                                        invoice_item_key: '$rowId',
                                        selected_tax:     '".$taxx->id."'
                                      }"
                       )
                     )
                   );
          }
        }
      ?>
    </span>
    
  </td>
    <td class="right price"><?php echo format_currency(Tools::getRounded(Tools::getNetAmount($invoiceItemForm['unitary_cost']->getValue(),$invoiceItemForm['quantity']->getValue(),0,$totalTaxesValue), Tools::getDecimals()), $currency) ?> </td>
</tr>
<?php
$urlAjax = url_for('common/ajaxInvoiceItemsAutocomplete');
$urlAjaxSelectProduct = url_for('products/ajaxProduct');
echo javascript_tag("
  $('#".$invoiceItemForm['description']->renderId()."')
    .autocomplete('".$urlAjax."', jQuery.extend({}, {
      dataType: 'json',
      parse:    function(data) {
        var parsed = [];
        for (key in data) {
          parsed[parsed.length] = { data: [
            data[key].description, 
            data[key].reference, 
            data[key].price,
            data[key].id
          ], value: data[key].description, result: data[key].description };
        }
        return parsed;
      },
      minChars: 2,
      matchContains: true
    }))
    .result(function(event, item) {
      $('#".$invoiceItemForm['description']->renderId()."').val(item[0]);
      $('#".$invoiceItemForm['product_autocomplete']->renderId()."').val(item[1]);
      $('#".$invoiceItemForm['unitary_cost']->renderId()."').val(item[2]);
      $('#".$invoiceItemForm['product_id']->renderId()."').val(item[3]);
      $(document).trigger('GlobalUpdateEvent');
    });
    
  //connect the selection of a product to update the row item
  $('#".$invoiceItemForm['product_autocomplete']->renderId()."')
    .autocomplete('".$urlAjaxSelectProduct."', jQuery.extend({}, {
      dataType: 'json',
      parse:    function(data) {
        var parsed = [];
        for (key in data) {
          parsed[parsed.length] = { data: [
            data[key].description,
            data[key].reference,  
            data[key].price,
            data[key].id
          ], value: data[key].description, result: data[key].description };
        }
        return parsed;
      },
      minChars: 2,
      matchContains: true
    }))
    .result(function(event, item) {
      $('#".$invoiceItemForm['description']->renderId()."').val(item[0]);
      $('#".$invoiceItemForm['product_autocomplete']->renderId()."').val(item[1]);
      $('#".$invoiceItemForm['unitary_cost']->renderId()."').val(item[2]);
      $('#".$invoiceItemForm['product_id']->renderId()."').val(item[3]);
      $(document).trigger('GlobalUpdateEvent');
    });
");

?>
