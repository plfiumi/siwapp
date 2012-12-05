<?php use_helper('Number', 'I18N', 'Date') ?>

<div id="content-wrapper" class="content">
  <h2><?php echo __('Global Situation'); ?></h2>
  <div id="situation-wrapper" class="left">
  <div class="left">
    <h3><?php echo __('Estimates'); ?></h3>
  <table class="dashboard-info">
    <tbody>
      <tr>
        <th><?php echo __('Total') ?></th>
        <th id="total" class="right"><?php echo format_currency($epending+$eapproved+$erejected, $currency)?></th>
      </tr>
      <tr>
        <td><?php echo __('Pending') ?></td>
        <td id="pending" class="right"><?php echo format_currency($epending, $currency)?></td>
      </tr>
      <tr>
        <td><?php echo __('Approved') ?><br/><small></small></td>
        <td id="approved" class="totalDue right"><?php echo format_currency($eapproved, $currency)?></td>
      </tr>
      <tr class="overdue">
        <td><?php echo __('Rejected') ?></td>
        <td id="rejected" class="right"><?php echo format_currency($erejected, $currency)?></td>
      </tr>

    </tbody>
  </table>
  </div>
  <div class="left">
  <h3><?php echo __('Invoices'); ?></h3>
  <table class="dashboard-info">
    <tbody>
      <tr>
        <th><?php echo __('Total') ?></th>
        <th id="total" class="right"><?php echo format_currency($gross, $currency)?></th>
      </tr>
      <tr>
        <td><?php echo __('Recived') ?></td>
        <td id="receipts" class="right"><?php echo format_currency($paid, $currency)?></td>
      </tr>
      <tr>
        <td><?php echo __('Due') ?><br/><small></small></td>
        <td id="due" class="totalDue right"><?php echo format_currency($due, $currency)?></td>
      </tr>
    </tbody>
  </table>
  </div>

  <div class="left">
  <h3><?php echo __('Expenses'); ?></h3>
  <table class="dashboard-info">
    <tbody>
      <tr>
        <th><?php echo __('Total') ?></th>
        <th id="total" class="right"><?php echo format_currency($expense_gross, $currency)?></th>
      </tr>
      <tr>
        <td><?php echo __('Paid') ?></td>
        <td id="receipts" class="right"><?php echo format_currency($expense_paid, $currency)?></td>
      </tr>
      <tr>
        <td><?php echo __('Due') ?><br/><small></small></td>
        <td id="due" class="totalDue right"><?php echo format_currency($expense_due, $currency)?></td>
      </tr>
    </tbody>
  </table>
  </div>
  <div class="left">
  <h3><?php echo __('Profit and Loss'); ?></h3>
  <table class="dashboard-info">
    <tbody>
      <tr>
        <th><?php echo __('Net Profit') ?></th>
        <th id="dashboard-balance-taxes" class="right"><?php echo format_currency($gross-$expense_gross,$currency);?></th>
      </tr>
      <tr>
        <td><?php echo __('Total Revenue') ?></td>
        <td id="dashboard-balance-total" class="right"><?php echo format_currency($gross,$currency);?></td>
      </tr>
      <tr>
        <td><?php echo __('Total Expenses') ?></td>
        <td id="dashboard-balance-net" class="right"><?php echo format_currency($expense_gross,$currency);?></td>
      </tr>
    </tbody>
  </table>
  </div>
  
  </div> <!-- situation-wrapper -->
<div class="clear"></div>
  <h2><?php echo __('Recent invoices') ?></h2>
  <table class="listing">
    <thead>
      <tr>
        <th class="number"><?php echo __('Number') ?></th>
        <th><?php echo __('Customer Name') ?></th>
        <th class="date"><?php echo __('Date') ?></th>
        <th class="date"><?php echo __('Due Date') ?></th>
        <th class="status"><?php echo __('Status') ?></th>
        <th class="right due"><?php echo __('Due') ?></th>
        <th class="right total"><?php echo __('Total') ?></th>
        <th class="noborder"></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($recent as $i => $invoice): ?>
        <?php
          $id       = $invoice->getId();
          $parity   = ($i % 2) ? 'odd' : 'even';
          $closed   = ($invoice->getStatus() == Invoice::CLOSED);
        ?>
        <tr id="invoice-<?php echo $id ?>" class="<?php echo "$parity link invoice-$id" ?>">
          <td class="link number"><?php echo $invoice ?></td>
          <td class="link"><?php echo $invoice->getCustomerName() ?></td>
          <td class="link date"><?php echo format_date($invoice->getIssueDate()) ?></td>
          <td class="link date"><?php echo format_date($invoice->getDueDate()) ?></td>
          <td class="link">
            <span class="status <?php echo ($stat = $invoice->getStatusString()) ?>">
              <?php echo __($stat) ?>
            </span>
          </td>
          <td class="due right link"><?php if($invoice->getDueAmount() != 0) echo format_currency($invoice->getDueAmount(), $currency)?></td>
          <td class="right link">
            <?php if ($invoice->getDraft()): ?>
              <span class="draftAmount" title="<?php echo __('This amount is not reflected in the total') ?>"></span>
            <?php endif?>
            <?php echo format_currency($invoice->getGrossAmount(), $currency)?>
          </td>
          <td class="action payments">
            <?php echo gButton(__("Payments"), "id=load-payments-for-$id rel=payments:show type=button class=payment action-clear {$invoice->getStatus()}") ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    <?php if ($recentCounter > $maxResults): ?>
    <tfoot>
      <tr>
        <td colspan="9">
          <small>
            <?php echo link_to(__('view all  ([1] invoices)', array('[1]' => $recentCounter)), '@invoices') ?>
          </small>
        </td>
      </tr>
    </tfoot>
    <?php endif; ?>
  </table>
  
  
  <h2><?php echo __('Past due invoices') ?></h2>
  <table class="listing">
    <thead>
      <tr>
        <th class="number"><?php echo __('Number') ?></th>
        <th><?php echo __('Customer Name') ?></th>
        <th><?php echo __('Date') ?></th>
        <th><?php echo __('Due Date') ?></th>
        <th class="right due"><?php echo __('Due') ?></th>
        <th class="right total"><?php echo __('Total') ?></th>
        <th class="noborder"></th>
      </tr>
    </thead>
    <tbody>
      <?php $total = 0; ?>
      <?php foreach ($overdue as $i => $invoice): ?>
        <?php
          $id       = $invoice->getId();
          $parity   = ($i % 2) ? 'odd' : 'even';
          $closed   = ($invoice->getStatus() == Invoice::CLOSED);
        ?>
        <tr id="overdue-<?php echo $id ?>" class="<?php echo "$parity link invoice-$id " ?>">
          <td class="number"><?php echo $invoice ?></td>
          <td><?php echo $invoice->getCustomerName() ?></td>
          <td class="date"><?php echo format_date($invoice->getIssueDate()) ?></td>
          <td class="date"><?php echo format_date($invoice->getDueDate()) ?></td>
          <td class="due right"><?php echo format_currency($invoice->getDueAmount(), $currency)?></td>
          <td class="right"><?php echo format_currency($invoice->getGrossAmount(), $currency) ?></td>
          <td class="action payments">
            <?php echo gButton(__("Payments"), "id=load-payments-for-$id rel=payments:show type=button class=payment action-clear {$invoice->getStatus()}") ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  
<h2><?php echo __('Recent expenses') ?></h2>
  <table class="listing estimates">
    <thead>
      <tr>
        <th class="number"><?php echo __('Number') ?></th>
        <th><?php echo __('Supplier Name') ?></th>
        <th><?php echo __('Date') ?></th>
        <th class="right due"><?php echo __('Due') ?></th>
        <th class="right total"><?php echo __('Total') ?></th>
        <th class="noborder"></th>
      </tr>
    </thead>
    <tbody>
      <?php $total = 0; ?>
      <?php foreach ($expenses as $i => $invoice): ?>
        <?php
          $id       = $invoice->getId();
          $parity   = ($i % 2) ? 'odd' : 'even';
          $closed   = ($invoice->getStatus() == Invoice::CLOSED);
        ?>
        <tr id="overdue-<?php echo $id ?>" class="<?php echo "$parity link invoice-$id " ?>">
          <td class="number"><?php echo $invoice ?></td>
          <td><?php echo $invoice->getSupplierName() ?></td>
          <td class="date"><?php echo format_date($invoice->getIssueDate()) ?></td>
          <td class="due right"><?php echo format_currency($invoice->getDueAmount(), $currency)?></td>
          <td class="right"><?php echo format_currency($invoice->getGrossAmount(), $currency) ?></td>
          <td class="action payments">
            <?php echo gButton(__("Payments"), "id=load-payments-for-$id rel=payments:show type=button class=payment action-clear {$invoice->getStatus()}") ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  
  <h2><?php echo __('Pending Estimates') ?></h2>
  <table class="listing estimates">
    <thead>
      <tr>
        <th class="number"><?php echo __('Number') ?></th>
        <th><?php echo __('Customer Name') ?></th>
        <th><?php echo __('Date') ?></th>
        <th class="right total"><?php echo __('Total') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php $total = 0; ?>
      <?php foreach ($pending as $i => $estimate): ?>
        <?php
          $id       = $estimate->getId();
          $parity   = ($i % 2) ? 'odd' : 'even';
        ?>
        <tr customEditRow="<?php echo url_for('estimates/edit'); ?>" id="estimates-<?php echo $id ?>" class="<?php echo "$parity link estimate-$id " ?>">
          <td class="number"><?php echo $estimate ?></td>
          <td><?php echo $estimate->getCustomerName() ?></td>
          <td class="date"><?php echo format_date($estimate->getIssueDate()) ?></td>
          <td class="right"><?php echo format_currency($estimate->getGrossAmount(), $currency) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  
</div>
