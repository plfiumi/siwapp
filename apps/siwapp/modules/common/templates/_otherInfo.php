<div id="other_info-data" class="global-data block">
  <h3><?php echo __('Other info') ?></h3>
  <br>
  <ul>
    <li>
      <span class="_25"><?php echo __('Buy order number')?><?php echo __(': ')?><?php echo render_tag($invoiceForm['buy_order_number'])?></span>
    </li>
    <br>
    <br>
    <li>
      <span class="_25"><?php echo __('Delivery note number')?><?php echo __(': ')?><?php echo render_tag($invoiceForm['delivery_note_number'])?></span>
    </li>
    <br>
    <br>
    <li>
      <span class="_25"><?php echo __('Shipping Company Data')?><?php echo __(': ')?><?php echo render_tag($invoiceForm['shipping_company_data'])?></span>
    </li>
  </ul>
</div>