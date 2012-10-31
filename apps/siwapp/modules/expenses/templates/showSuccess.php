<?php use_helper('Text') ?>

<div id="invoice-container" class="content">
  
  <h2><?php echo __("Expense") . ' ' . $invoice ?></h2>
  <div id="saving-options">
    <?php echo gButton_to(__('Edit'), 'expenses/edit?id=' .$invoice->getId(), 'class=action edit');  ?>
    <?php echo gButton_to_function(__('Print'), "Tools.popup(siwapp_urls.printHtml + '?ids[]=".$invoice->getId()."')", 'class=action print') ?>
    <?php echo gButton_to_function(__('PDF'), "window.location=siwapp_urls.printPdf + '?ids[]=".$invoice->getId()."'", 'class=action pdf') ?>
  </div>
  <div class="invoice show">

    <div id="customer-data" class="global-data block">
      <h3><?php echo __('Supplier info') ?></h3>
      <ul>
        <li>
          <span>
            <span class="_50">
              <label><?php echo __('Supplier') ?>:</label>
              <?php echo $invoice->getSupplierName() ?>
            </span>
            <span class="_50 _last">
              <label><?php echo __('Supplier identification') ?>:</label>
              <?php echo $invoice->getSupplierIdentification() ?>
            </span>
          </span>
          <span class="clear"></span>
        </li>
        <li>
          <span>
            <span class="_50">
              <label><?php echo __('Contact person') ?>:</label>
              <?php echo $invoice->getContactPerson() ?>
            </span>
            <span class="_50 _last">
              <label><?php echo __('Email') ?>:</label>
              <?php echo $invoice->getSupplierEmail() ?>
            </span>
          </span>
          <span class="clear"></span>
        </li>
        <li>
          <span>
            <span class="_50">
              <label><?php echo __('Supplier Phone') ?>:</label>
              <?php echo $invoice->getSupplierPhone() ?>
            </span>
            <span class="_50 _last">
              <label><?php echo __('Supplier Fax') ?>:</label>
              <?php echo $invoice->getSupplierFax() ?>
            </span>
          </span>
          <span class="clear"></span>
        </li>
        <li>
          <span>
            <span class="_75 _last">
              <label><?php echo __('Invoicing address') ?>:</label>
              <?php echo simple_format_text($invoice->getInvoicingAddress()) ?></span>
          </span>
          <span class="clear"></span>
        </li>
      </ul>
    </div><!-- div#customer-data -->

    <div id="payment-data" class="block">
      <h3><?php echo __('Payment details') ?></h3>
      <p><label><?php echo __('Issued at') ?>:</label> <?php echo $invoice->getIssueDate() ?> <label></p>
      <p><label><?php echo __('Supplier reference') ?>:</label> <?php echo $invoice->getSupplierReference() ?> <label></p>

      <table class="listing">
        <thead>
          <tr>
          <th><?php echo __('Description') ?></th>
          <th class="right"><?php echo __('Expense Type') ?></th>
          <th class="right"><?php echo __('Amount') ?></th>
          <th class="right"><?php echo __('Taxes') ?></th>
          <th class="right"><?php echo __('Price') ?></th>
          </tr>
        </thead>
        <tbody id="tbody_invoice_items">
          <?php if (!count($invoice->getItems())): ?>

            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>

          <?php else: ?>

            <?php foreach($invoice->getItems() as $item): ?>
              <?php include_partial('expenses/expenseRowShow', array('item' => $item, 'currency' => $currency)); ?>
            <?php endforeach ?>

          <?php endif ?>
        </tbody>
        <tfoot id="global_calculations">
          <tr>
            <td colspan="3" rowspan="4" class="noborder"></td>
            <td><?php echo __('Subtotal') ?></td>
            <td id="td_subtotal" class="right">
              <?php echo format_currency($invoice->getNetAmount(), $currency) ?>
            </td>
          </tr>
         <?php foreach ($invoice->getTaxDetails() as $name => $amount): ?>
          <tr>
            <td><?php echo __('Total')." ".$name ?></td>
            <td class="right"><?php echo format_currency($amount,$currency)?></td>
          </tr>
          <?php endforeach ?>
          <tr>
            <td><?php echo __('Taxes Total') ?></td>
            <td id="td_total_taxes" class="right">
              <?php echo format_currency($invoice->getTaxAmount(), $currency) ?>
            </td>
          </tr>
          <tr class="strong">
            <td><?php echo __('Total') ?></td>
            <td id="td_total" class="right">
              <?php echo format_currency($invoice->getGrossAmount(), $currency) ?>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>  <!-- div#payment-data -->


    <?php
      $tags  = $invoice->getTags();
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
    <?php echo gButton_to(__('Edit'), 'expenses/edit?id=' .$invoice->getId(), 'class=action edit');  ?>
    <?php echo gButton_to_function(__('Print'), "Tools.popup(siwapp_urls.printHtml + '?ids[]=".$invoice->getId()."')", 'class=action print') ?>
    <?php echo gButton_to_function(__('PDF'), "window.location=siwapp_urls.printPdf + '?ids[]=".$invoice->getId()."'", 'class=action pdf') ?>
  </div>
  
</div>
