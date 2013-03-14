<?php use_helper('jQuery', 'JavascriptBase')?>
<span id="tax_<?php echo $rowId?>_<?php echo $taxKey?>"><?php
echo jq_link_to_function('',
"$('#tax_".$rowId."_".$taxKey."').remove(); $(document).trigger('GlobalUpdateEvent');")?>
<select class="observable tax" id="item_taxes_list_<?php echo $rowId?>_<?php echo $taxKey?>" name="expense[Items][<?php echo $rowId?>][taxes_list][]">
  <?php
    $taxes = Doctrine::getTable('Tax')->createQuery()
    ->Where('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))
    ->orWhere('id = ?', $taxKey)->execute();
    foreach($taxes as $o_tax):?>
  <option value="<?php echo $o_tax->id?>" <?php echo $o_tax->id == $taxKey ? 'selected="selected"':''?>>
    <?php echo $o_tax->name?>
  </option>
  <?php endforeach?>
</select>
</span>
