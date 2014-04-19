/**
 * Override alert() With jQuery UI Dialog
 * Since old alert has no title, if you send title as false, assumes old alert 
 * 
 * Examples:
 * New Alert
 * @example alert('This is a <strong>new</strong> alert!', 'title');
 * 
 * Old Alert:
 * @example alert('This is an old, boring alert.', false);
 * Or:
 * @example old_alert('This is an old, boring alert.');
 *  
 * @author Pablo Leonardo Fiumidinisi (plfiumi@gmail.com)
 * @author Andrew Ensley
 * @see http://andrewensley.com/2012/07/override-alert-with-jquery-ui-dialog/
 */

window.old_alert = window.alert;

window.alert = function(message, title){
    // if title is false, send old_alert
    if(title === false)
    {
        old_alert(message);
        return;
    }
    
    // set default value to title if undefined
    title = (typeof title === 'undefined') ? "Alert" : title;
    
    $(document.createElement('div'))
        .attr({title: title, 'class': 'alert'})
        .html(message)
        .dialog({
            close: function(){$(this).remove();},
            draggable: true,
            modal: false,
            resizable: false,
            width: 'auto',
            height: 80,
            minHeight: 80
        });
};