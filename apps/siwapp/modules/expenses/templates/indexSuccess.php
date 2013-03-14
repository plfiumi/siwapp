<?php
use_helper('JavascriptBase', 'Number', 'Siwapp', 'Date');

$expenses = $pager->getResults();
$csrf     = new sfForm();
?>

<div class="content">
  
  <?php if (count($expenses)): ?>
    
    <?php echo form_tag('expenses/batch', 'id=batch_form class=batch') ?>
      <?php echo $csrf['_csrf_token']->render(); ?>
      <input type="hidden" name="batch_action" id="batch_action">

      <table class="listing">
        
        <thead>
          <tr>
            <td colspan="4" class="listing-options noborder">
              <?php include_partial('batchActions')?>
            </td>
            <td class="strong noborder"><?php echo __('Total') ?></td>
            <td class="totalDue strong noborder right"><?php echo format_currency($due, $currency) ?></td>
            <td class="strong noborder right"><?php echo format_currency($gross, $currency) ?></td>
            <td colspan="1000" class="noborder"></td>
          </tr>
          <tr class="empty noborder">
            <td colspan="1000"></td>
          </tr>
          <tr>
            <th class="xs"><input id="select_all" rel="all" type="checkbox" name="select_all"></th>
            <?php
              // sort parameter => array (Name, default order)
              renderHeaders(array(
                'number'        => array('Number', 'desc'),
                'reference'        => array('Supplier reference', 'desc'),
                'supplier_name' => array('Supplier Name', 'asc'),
                'issue_date'    => array('Date', 'desc'),
                'status'        => array('Status', 'asc'),
                'due_amount'    => array('Due', 'desc'),
                'gross_amount'  => array('Total', 'desc')
                ), $sf_data->getRaw('sort'), '@expenses');
            ?>
            <th class="noborder"></th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($expenses as $i => $expense): ?>
            <?php
              $id       = $expense->getId();
              $parity   = ($i % 2) ? 'odd' : 'even';
              $closed   = ($expense->getStatus() == Invoice::CLOSED);
            ?>
            <tr id="expense-<?php echo $id ?>" class="<?php echo "$parity link expense-$id" ?>">
              <td class="check"><input rel="item" type="checkbox" value="<?php echo $id ?>" name="ids[]"></td>
              <td><?php echo $expense ?></td>
              <td><?php echo $expense->getSupplierReference() ?></td>
              <td class="<?php echo $expense->getSentByEmail() ? 'sent' : null ?>"><?php echo $expense->getSupplierName() ?></td>
              <td><?php echo format_date($expense->getIssueDate()) ?></td>
              <td>
                <span class="status <?php echo ($stat = $expense->getStatusString()) ?>">
                  <?php echo __($stat) ?>
                </span>
              </td>
              <td class="right"><?php if ($expense->getDueAmount() != 0) echo format_currency($expense->getDueAmount(), $currency) ?></td>
              <td class="right">
                <?php if ($expense->getDraft()): ?>
                  <span class="draftAmount" title="<?php echo __('This amount is not reflected in the total') ?>"></span>
                <?php endif?>
                <?php echo format_currency($expense->getGrossAmount(), $currency)  ?>
              </td>
              <td class="action payments">
                <?php echo gButton(__("Payments"), "id=load-payments-for-$id type=button rel=payments:show class=payment action-clear {$expense->getStatus()}") ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>

        <tfoot>
          <tr class="noborder">
            <td colspan="10" class="listing-options">
              <?php include_partial('batchActions'); ?>
            </td>
          </tr>
        </tfoot>

      </table>
    </form>

    <?php include_partial('global/pager', array('pager' => $pager, 'route' => '@expenses')) ?>
    
  <?php else: ?>
    <p><?php echo __('No results') ?></p>
  <?php endif ?>
  
</div>
