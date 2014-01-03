(function($){

  $.fn.SearchForm = function() {
    var settings = $.extend({

    }, arguments[0]||{});

    $(this).each(function(){
      var f  = $(this);
      var id = f.attr('id');

      // Toggle tag cloud trigger
      f.find('.toggleTagCloud:first').bind('click', { form: f }, function(e){
        e.preventDefault();
        var btn = $(this);
        var img = btn.find('img');
        var frm = e.data.form;

        $.get(siwapp_urls.toggleTagCloud);
        btn.toggleClass('tags-selected');
        frm.parent().find('.tagselect').toggle();
        img.attr('src', img.attr('src').replace(/contract|expand/, btn.hasClass('tags-selected') ? 'contract' : 'expand'));
      });

      // Selectable tags
      f.parent().find('.tagselect:first span.tag')
        .SelectableTag({
          output: '#' + id + ' input[name=search[tags]]'
        });

      // Form reset button
      f.find('button[type=reset]:first').bind('click', { form: f }, function(e){
        e.preventDefault();
        var frm = e.data.form;
        Tools.resetFields(frm);
        frm.prepend($('<input type="hidden" name="reset" value="1" />'));
        frm.parent().find('.tagselect span').removeClass('selected');
        frm.submit();
      });

      // Status filters
      f.find('ul.filters a.status').bind('click', { form: f }, function(e){
        e.preventDefault();
        var frm = e.data.form;
        var status = $(this).attr('class').match(/#(.*)#/).pop();
        frm.find('input[name=search[status]]').val(status);
        frm.submit();
      });

      // Quick Dates
      f.find('select[name=search[quick_dates]]').bind('change', { form: f }, function(e){
        var frm = e.data.form;
        var val = $(this).val().toLowerCase();
        var from_mod = new Date(),to_mod = new Date(), to, from;

        // function to get the monday date of the week
        function getMonday(d) {
          var day = d.getDay(),
              diff = d.getDate() - day + (day == 0 ? -6:1); // adjust when day is sunday
          return new Date(d.setDate(diff));
        }


        if (!val) {
            frm.find('#search_to_year').val('');
            frm.find('#search_to_month').val('');
            frm.find('#search_to_day').val('');

            frm.find('#search_from_year').val('');
            frm.find('#search_from_month').val('');
            frm.find('#search_from_day').val('');
        }

        else {

          switch(val) {
            case 'last_week'    : from_mod = '-7';  break;
            case 'last_month'   : from_mod = '-1m'; break;
            case 'last_year'    : from_mod = '-1y'; break;
            case 'last_5_years' : from_mod = '-5y'; break;
            case 'this_week':
                from_mod = getMonday(new Date());
                break;
            case 'this_month':
                from_mod.setDate(1);
                break;
            case 'this_year':
                from_mod.setDate(1);
                from_mod.setMonth(0);
                break;
            case 'past_month':
                from_mod.setMonth(from_mod.getMonth()-1)
                from_mod.setDate(1);
                to_mod.setDate(0);
                break;
            case 'past_year':
                from_mod.setYear(from_mod.getFullYear()-1);
                from_mod.setDate(1);
                from_mod.setMonth(0);
                to_mod.setYear(to_mod.getFullYear()-1);
                to_mod.setDate(31);
                to_mod.setMonth(11);
                break;
            case 'first_quarter':
                from_mod.setDate(1);
                from_mod.setMonth(0);
                to_mod.setMonth(2);
                to_mod.setDate(31);
                break;
            case 'second_quarter':
                from_mod.setDate(1);
                from_mod.setMonth(3);
                to_mod.setDate(30);
                to_mod.setMonth(5);
                break;
            case 'third_quarter':
                from_mod.setDate(1);
                from_mod.setMonth(6);
                to_mod.setDate(30);
                to_mod.setMonth(8);
                break;
            case 'fourth_quarter':
                from_mod.setDate(1);
                from_mod.setMonth(9);
                to_mod.setMonth(11);
                to_mod.setDate(31);
                break;
            default:
                from_mod = null;
                to_mod = null;
                break;
          }

          from = $('#search_from_jquery_control').datepicker('setDate', from_mod).datepicker('getDate');

          to = $('#search_to_jquery_control').datepicker('setDate', to_mod).datepicker('getDate');

          to   = $.datepicker.formatDate('yy-mm-dd', to).split('-');
          from = $.datepicker.formatDate('yy-mm-dd', from).split('-');

          to[1]   = to[1].replace(/^0{0,1}/, '');
          from[1] = from[1].replace(/^0{0,1}/, '');

          // Temporary solution while I find how to update them directly.
          frm.find('#search_to_year').val(parseInt(to[0]));
          frm.find('#search_to_month').val(parseInt(to[1]));
          frm.find('#search_to_day').val(to[2]);

          frm.find('#search_from_year').val(parseInt(from[0]));
          frm.find('#search_from_month').val(parseInt(from[1]));
          frm.find('#search_from_day').val(from[2]);
        }
      });

    });
  };

  $(function(){
    $('form.searchform').SearchForm();
  });
})(jQuery);

// this is to replace the customer_id value with the customer name in autocomplete_search_customer_id
$(document).ready(function() {
  if(typeof(window.customer_name_autocomplete) != 'undefined')
  {
    $('#autocomplete_search_customer_id').val(customer_name_autocomplete);
  }
});



