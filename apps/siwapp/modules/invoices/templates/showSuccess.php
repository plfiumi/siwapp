<?php use_helper('Text') ?>

<div id="invoice-container" class="content">

  <h2><?php echo __("Invoice") . ' ' . $invoice ?></h2>
  <div id="saving-options">
    <?php echo gButton_to_function(__('Print'), "Tools.popup(siwapp_urls.printHtml + '?ids[]=".$invoice->getId()."')", 'class=action print') ?>
    <?php echo gButton_to_function(__('PDF'), "window.location=siwapp_urls.printPdf + '?ids[]=".$invoice->getId()."'", 'class=action pdf') ?>
    <?php echo gButton_to(__('Send'), 'invoices/send?id=' .$invoice->getId(), 'class=action send') ?>
    <?php echo gButton_to(__('Edit'), 'invoices/edit?id=' .$invoice->getId(), 'class=action edit');  ?>
  </div>
  <div class="invoice show">

    <div id="customer-data" class="global-data block">
      <h3><?php echo __('Customer info') ?></h3>
      <ul>
        <li>
          <span>
            <span class="_50">
              <label><?php echo __('Name/Legal Name') ?>:</label>
              <?php echo $invoice->getCustomerName() ?>
            </span>
            <span class="_50 _last">
              <label><?php echo __('Legal Id') ?>:</label>
              <?php echo $invoice->getCustomerIdentification() ?>
            </span>
          </span>
          <span class="clear"></span>
        </li>
        <li>
          <span>
            <span class="_50">
              <label><?php echo __('Business Name') ?>:</label>
              <?php echo $invoice->getCustomerBusinessName() ?>
            </span>
            <span class="_50 _last">
              <label><?php echo __('Tax condition') ?>:</label>
              <?php echo $invoice->getCustomerTaxCondition() ?>
            </span>
          </span>
          <span class="clear"></span>
        </li>
        <li>
          <span>
            <span class="_50">
              <label><?php echo __('Phone') ?>:</label>
              <?php echo $invoice->getCustomerPhone() ?>
            </span>
            <span class="_50 _last">
              <label><?php echo __('Email') ?>:</label>
              <?php echo $invoice->getCustomerEmail() ?>
            </span>
          </span>
          <span class="clear"></span>
        </li>
        <li>
          <span>
            <span class="_50">
              <label><?php echo __('Invoicing address') ?>:</label>
<?php echo simple_format_text($invoice->getInvoicingAddress().'<br>'.$invoice->getInvoicingPostalcode().' '.$invoice->getInvoicingCity().'<br>'.$invoice->getInvoicingState().' '.$invoice->getInvoicingCountry()) ?></span>
            <span class="_50 _last">
              <label><?php echo __('Shipping address') ?>:</label>
<?php echo simple_format_text($invoice->getShippingAddress().'<br>'.$invoice->getShippingPostalcode().' '.$invoice->getShippingCity().'<br>'.$invoice->getShippingState().' '.$invoice->getShippingCountry()) ?>
            </span>
          </span>
          <span class="clear"></span>
        </li>
      </ul>
    </div><!-- div#customer-data -->

    <div id="payment-data" class="block">
      <h3><?php echo __('Payment details') ?></h3>
      <p><label><?php echo __('Issued at') ?>:</label> <?php echo $invoice->getIssueDate() ?> <label><?php echo __('will become overdue at') ?>:</label> <?php echo $invoice->getDueDate() ?></p>

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
              <?php include_partial('invoices/invoiceRowShow', array('item' => $item, 'currency' => $currency)); ?>
            <?php endforeach ?>

          <?php endif ?>
        </tbody>
        <tfoot id="global_calculations">
          <?php foreach ($invoice->getBasesDetails() as $name => $amount): ?>
          <tr>
            <td colspan="4" class="noborder"></td>
            <td><?php echo __('Base')." ".$name ?></td>
            <td id="td_subtotal" class="right">
              <?php echo format_currency($amount, $currency) ?>
            </td>
          </tr>
          <?php endforeach ?>
          <?php foreach ($invoice->getTaxDetails() as $name => $amount): ?>
          <tr>
            <td colspan="4" class="noborder"></td>
            <td><?php echo __('Total')." ".$name ?></td>
            <td class="right"><?php echo format_currency($amount,$currency)?></td>
          </tr>
          <?php endforeach ?>
          <tr>
            <td><?php echo __('Discount') ?></td>
            <td id="td_global_discount" class="right">
              <?php echo format_currency($invoice->getDiscountAmount(), $currency) ?>
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

    <div id="other_info-data">
      <div class="block">
        <h3><?php echo __('Buy order number') ?></h3>
        <div class="textarea">
          <?php echo $invoice->getBuyOrderNumber() ?>
        </div>
      </div>

      <div class="block">
        <h3><?php echo __('Delivery note number') ?></h3>
        <div class="textarea">
          <?php echo $invoice->getDeliveryNoteNumber() ?>
        </div>
      </div>
    </div>
    
    <div id="shipping_company-data" class="block">
      <h3><?php echo __('Shipping Company Data') ?></h3>
      <div class="textarea">
        <?php echo $invoice->getShippingCompanyData(); ?>
      </div>
    </div>
    
    <div id="terms-data">
    
      <?php if (strlen($invoice->getTerms())): ?>
        <div class="block">
          <h3><?php echo __('Terms & Conditions') ?></h3>
          <div class="textarea">
            <?php echo $invoice->getTerms() ?>
          </div>
        </div>
      <?php endif ?>

      <?php if (strlen($invoice->getNotes())): ?>
        <div class="block">
          <h3><?php echo __('Notes') ?></h3>
          <div class="textarea">
            <?php echo $invoice->getNotes() ?>
          </div>
        </div>
      <?php endif ?>

    </div>

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
    <?php echo gButton_to_function(__('Print'), "Tools.popup(siwapp_urls.printHtml + '?ids[]=".$invoice->getId()."')", 'class=action print') ?>
    <?php echo gButton_to_function(__('PDF'), "window.location=siwapp_urls.printPdf + '?ids[]=".$invoice->getId()."'", 'class=action pdf') ?>
    <?php echo gButton_to(__('Send'), 'invoices/send?id=' .$invoice->getId(), 'class=action send') ?>
    <?php echo gButton_to(__('Edit'), 'invoices/edit?id=' .$invoice->getId(), 'class=action edit');  ?>
  </div>

</div>
