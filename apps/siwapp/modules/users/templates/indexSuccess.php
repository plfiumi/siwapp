<?php
use_helper('JavascriptBase', 'Number', 'Siwapp', 'Date');

$users = $pager->getResults();
$csrf     = new sfForm();
?>

<div class="content">

  <?php if (count($users)): ?>

    <?php echo form_tag('users/batch', 'id=batch_form class=batch') ?>
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
                'username' => array('Username', 'asc'),
                'first_name' => array('First name', 'asc'),
                'last_name' => array('Last name', 'asc'),
                'email'    => array('Email', 'desc'),
                ), $sf_data->getRaw('sort'), '@users');
            ?>

          </tr>
        </thead>

        <tbody>
          <?php foreach ($users as $i => $user): ?>
            <?php
              $id       = $user->getId();
              $parity   = ($i % 2) ? 'odd' : 'even';
            ?>
            <tr id="users-<?php echo $id ?>" class="<?php echo "$parity link users-$id " ?>">
              <td class="check"><input rel="item" type="checkbox" value="<?php echo $id ?>" name="ids[]"></td>
              <td><?php echo $user->getUser()->username ?></td>
              <td><?php echo $user->first_name ?></td>
                <td><?php echo $user->last_name ?></td>
              <td><?php echo $user->email ?></td>
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

    <?php include_partial('global/pager', array('pager' => $pager, 'route' => '@users')) ?>

  <?php else: ?>
    <p><?php echo __('No results') ?></p>
  <?php endif ?>

</div>
