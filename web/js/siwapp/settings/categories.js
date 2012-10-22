// SETTINGS PAGE

jQuery(function($) {
  
  // What happens when you "remove" key/value items like taxes or series?
  $('#settings-wrapper #product_categories ul a.remove').live('click', function(e){
    e.preventDefault();
    // Find item
    var item = $(this).parents('ul:first');
    // Update "remove" hidden field
    item.find('input.remove').val(1);
    // Hide row
    item.hide();
  });
  
  $('#addNewCategory').click(function(e){
    e.preventDefault();
    var a = $(this);
    // Find target element
    var r = (new RegExp('to:(.*)')).exec(a.attr('class'));
    if (!r || r.length < 2)
      throw "addNewNameValueItem TARGET was not set in the class attribute (to:targetId)";
    r = (r[1].split(/\s+/))[0];
    if (!siwapp_urls.addNewNameValueItem)
      throw "addNewNameValueItem URL was not set";
    // Add item
    $.post(siwapp_urls.addNewNameValueItem, { to: r }, function(data, status) { $('#' + r).append(data); });
  });
  
});
