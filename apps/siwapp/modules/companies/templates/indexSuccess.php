<?php
use_helper('JavascriptBase', 'Number', 'Siwapp', 'Date');

$companys = $pager->getResults();
$csrf     = new sfForm();
?>

<div class="content">
  
  <?php if (count($companys)): ?>
    
    <?php echo form_tag('companies/batch', 'id=batch_form class=batch') ?>
      <?php echo $csrf['_csrf_token']->render(); ?>
      <input type="hidden" name="batch_action" id="batch_action">


      <table id="listing" class="listing">
        <thead>

          <tr class="empty noborder listing-options">
            <td colspan="2">
              <?php echo gButton_to_function(__("Delete"), "do_batch('delete')", array('class'=>'batch delete action-clear', 'confirm'=>__('Are you sure?'))) ?>
            </td>   
          </tr>

          <tr class="empty noborder">
            <td colspan="1000"></td>
          </tr>

          <tr>
            <th class="xs"><input id="select_all" rel="all" type="checkbox" name="select_all"></th>
            <?php
              // sort parameter => array (Name, default order)
              renderHeaders(array(
                'name' => array('Name', 'asc'),
                'address'    => array('Address', 'desc'),
                'email'    => array('Email', 'desc'),
                'phone' => array('Phone', 'desc')
                ), $sf_data->getRaw('sort'), '@companies');
            ?>
            
          </tr>
        </thead>

        <tbody>
          <?php foreach ($companys as $i => $company): ?>
            <?php
              $id       = $company->getId();
              $parity   = ($i % 2) ? 'odd' : 'even';
            ?>
            <tr id="companies-<?php echo $id ?>" class="<?php echo "$parity link companies-$id " ?>">
              <td class="check"><input rel="item" type="checkbox" value="<?php echo $id ?>" name="ids[]"></td>
              <td><?php echo $company->name ?></td>
                <td><?php echo $company->address ?></td>
              <td><?php echo $company->email ?></td>            
              <td><?php echo $company->phone ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>

        <tfoot>
          <tr class="noborder">
            <td colspan="10" class="listing-options">
              <?php echo gButton_to_function(__("Delete"), "do_batch('delete')", array('class'=>'batch delete action-clear', 'confirm'=>__('Are you sure?'))) ?>
            </td>
          </tr>
        </tfoot>

      </table>
    </form>

    <?php include_partial('global/pager', array('pager' => $pager, 'route' => '@companies')) ?>
    
  <?php else: ?>
    <p><?php echo __('No results') ?></p>
  <?php endif ?>
  
</div>
