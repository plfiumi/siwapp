<?php use_helper('Text') ?>

<div id="expense-container" class="content">
  
  <h2><?php echo __("Expense") . ' ' . $expense ?></h2>

  <div class="expense show">

    <div id="customer-data" class="global-data block">
      <h3><?php echo __('Supplier info') ?></h3>
      <ul>
        <li>
          <span>
            <span class="_50">
              <label><?php echo __('Supplier') ?>:</label>
              <?php echo $expense->getSupplierName() ?>
            </span>
            <span class="_50 _last">
              <label><?php echo __('Supplier identification') ?>:</label>
              <?php echo $expense->getSupplierIdentification() ?>
            </span>
          </span>
          <span class="clear"></span>
        </li>
        <li>
          <span>
            <span class="_50">
              <label><?php echo __('Contact person') ?>:</label>
              <?php echo $expense->getContactPerson() ?>
            </span>
            <span class="_50 _last">
              <label><?php echo __('Email') ?>:</label>
              <?php echo $expense->getSupplierEmail() ?>
            </span>
          </span>
          <span class="clear"></span>
        </li>
        <li>
          <span>
            <span class="_50">
              <label><?php echo __('Invoicing address') ?>:</label>
              <?php echo simple_format_text($expense->getInvoicingAddress()) ?></span>
            <span class="_50 _last">
              <label><?php echo __('Shipping address') ?>:</label>
              <?php echo simple_format_text($expense->getShippingAddress()) ?>
            </span>
          </span>
          <span class="clear"></span>
        </li>
      </ul>
    </div><!-- div#customer-data -->

    <div id="payment-data" class="block">
      <h3><?php echo __('Payment details') ?></h3>
      <p><label><?php echo __('Issued at') ?>:</label> <?php echo $expense->getIssueDate() ?> <label><?php echo __('will become overdue at') ?>:</label> <?php echo $expense->getDueDate() ?></p>

      <table class="listing">
        <thead>
          <tr>
            <th><?php echo __('Description') ?></th>
            <th class="right" width="100"><?php echo __('Unit cost') ?></th>
            <th class="right" width="60"><?php echo __('Qty') ?></th>
            <th class="right" width="100"><?php echo __('Taxes') ?></th>
            <th class="right" width="60"><?php echo __('Discount') ?></th>
            <th class="right" width="150"><?php echo __('Price') ?></th>
          </tr>
        </thead>
        <tbody id="tbody_expense_items">
          <?php if (!count($expense->getItems())): ?>

            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>

          <?php else: ?>

            <?php foreach($expense->getItems() as $item): ?>
              <?php include_partial('expenses/expenseRowShow', array('item' => $item, 'currency' => $currency)); ?>
            <?php endforeach ?>

          <?php endif ?>
        </tbody>
        <tfoot id="global_calculations">
          <tr>
            <td colspan="4" rowspan="4" class="noborder"></td>
            <td><?php echo __('Subtotal') ?></td>
            <td id="td_subtotal" class="right">
              <?php echo format_currency($expense->getNetAmount(), $currency) ?>
            </td>
          </tr>
          <tr>
            <td><?php echo __('Taxes') ?></td>
            <td id="td_total_taxes" class="right">
              <?php echo format_currency($expense->getTaxAmount(), $currency) ?>
            </td>
          </tr>
          <tr>
            <td><?php echo __('Discount') ?></td>
            <td id="td_global_discount" class="right">
              <?php echo format_currency($expense->getDiscountAmount(), $currency) ?>
            </td>
          </tr>
          <tr class="strong">
            <td><?php echo __('Total') ?></td>
            <td id="td_total" class="right">
              <?php echo format_currency($expense->getGrossAmount(), $currency) ?>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>  <!-- div#payment-data -->

    <div id="terms-data">

      <?php if (strlen($expense->getTerms())): ?>
        <div class="block">
          <h3><?php echo __('Terms & Conditions') ?></h3>
          <div class="textarea">
            <?php echo $expense->getTerms() ?>
          </div>
        </div>
      <?php endif ?>

      <?php if (strlen($expense->getNotes())): ?>
        <div class="block">
          <h3><?php echo __('Notes') ?></h3>
          <div class="textarea">
            <?php echo $expense->getNotes() ?>
          </div>
        </div>
      <?php endif ?>

    </div>

    <?php
      $tags  = $expense->getTags();
      $ctags = count($tags);
      $i     = 0;
    ?>
    <?php if ($ctags): ?>
      <div id="tags-data" class="block">
        <h3><?php echo __('Tags') ?>:</h3>
        <p>
          <?php foreach($tags as $tag): ?>
            <?php echo $tag.($ctags == ++$i ? null : ', ') ?>
          <?php endforeach ?>
        </p>
      </div>
    <?php endif ?>

  </div>

  <div id="saving-options">
    <?php echo gButton_to_function(__('Print'), "Tools.popup(siwapp_urls.printHtml + '?ids[]=".$expense->getId()."')", 'class=action print') ?>
    <?php echo gButton_to_function(__('Save PDF'), "window.location=siwapp_urls.printPdf + '?ids[]=".$expense->getId()."'", 'class=action pdf') ?>
    <?php echo gButton_to(__('Send'), 'expenses/send?id=' .$expense->getId(), 'class=action send') ?>
    <?php echo gButton_to(__('Edit'), 'expenses/edit?id=' .$expense->getId(), 'class=action edit');  ?>
  </div>
  
</div>
