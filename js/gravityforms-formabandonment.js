// Based partly on http://dave-taylor.co.uk/blog/wp-content/uploads/2013/08/form-tracking-google-analytics-v2.js
jQuery(document).ready(function($) { 

    // Set variables 
    var d              = 0;
    var t              = 0;
    var formPage       = document.title;
    var formIdentifier = 'Error - no Gravity Form found';

    $('.gform_wrapper :input').focus(function () {
        d = new Date();
        t = d.getTime();
    });

    $('.gform_wrapper :input').blur(function() {
        var form           = $(this).closest('div.gform_wrapper form');
        var formIdentifier = $(form).attr('class') || $(form).attr('id');
        var fieldLabel     = $(this).closest('li').find('label').text();
        var e              = new Date();
        var x              = e.getTime();
        var exit           = Math.round((x - t)/1000);

        if($(this).val().length > 0){
            _gaq.push(['_trackEvent', 'Page: ' + formPage + ', Form: ' + formIdentifier, 'Field filled', fieldLabel, exit]);
        } else {
            _gaq.push(['_trackEvent', 'Page: ' + formPage + ', Form: ' + formIdentifier, 'Field skipped', fieldLabel, exit]);
        }
    });
 
    $( ".gform_wrapper input[type=checkbox], .gform_wrapper [type=radio]" ).click (function () {
        var form           = $(this).closest('div.gform_wrapper form');
        var formIdentifier = $(form).attr('class') || $(form).attr('id');
        var fieldSetLabel  = $(this).closest('li.gfield').find('label').first().text();
        var fieldValue     = $(this).val();

        if ($(this).attr("checked") == "checked") {
            _gaq.push(['_trackEvent', 'Page: ' + formPage + ', Form: ' + formIdentifier, 'Checkbox/Radio checked', fieldSetLabel + ': ' + fieldValue]);
        } else {
            _gaq.push(['_trackEvent', 'Page: ' + formPage + ', Form: ' + formIdentifier, 'Checkbox/Radio unchecked', fieldSetLabel + ': ' + fieldValue]);
        }
    });
    
    $( ".gform_wrapper input[type=submit]" ).click (function () {
        var form           = $(this).closest('div.gform_wrapper form');
        var formIdentifier = $(form).attr('class') || $(form).attr('id');
        
        _gaq.push(['_trackEvent', 'Page: ' + formPage + ', Form: ' + formIdentifier, 'Submit', 'click']);
    });
    
 }); 