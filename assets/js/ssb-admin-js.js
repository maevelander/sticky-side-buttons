// Sticky Side Buttons JS
jQuery(function ($) {

    // Buttons accorion + sortable
    $('#ssb-sortable-buttons')
        .accordion({
            header: "> li > header",
            active: false,
            collapsible: true,
            heightStyle: "content",
            activate: function (event, ui) {

                // SSB action
                ssb_action($(this));

            }
        })
        .sortable({
            axis: "y",
            update: function (event, ui) {

                // SSB action
                ssb_action($(this));

            }
        });

    // Add new button
    $('.ssb-add-btn').click(function () {

        var li_count = ($('#ssb-sortable-buttons li').length) - 1;
        var new_li = li_count + 1;
        var ul = $('#ssb-sortable-buttons');
        var li = '<li id="ssb_btn_' + new_li + '"><header><i class="fa fa-caret-down" aria-hidden="true"></i>New Button</header><div class="ssb-btn-body"><div class="ssb-body-left"><p><label for="button-text-' + new_li + '">Button Text</label><input type="text" id="button-text-' + new_li + '" class="widefat" name="ssb_buttons[btns][' + new_li + '][btn_text]"></p><p class="ssb-iconpicker-container"><label for="button-icon-' + new_li + '">Button icon</label><input type="text" id="button-icon-' + new_li + '" class="widefat ssb-iconpicker" data-placement="bottomRight" name="ssb_buttons[btns][' + new_li + '][btn_icon]"><span class="ssb-icon-preview input-group-addon"></span></p><p><label for="button-link-' + new_li + '">link URL</label><input type="text" id="button-link-' + new_li + '" class="widefat" name="ssb_buttons[btns][' + new_li + '][btn_link]"></p></div><div class="ssb-body-right"><p><label for="button-color-' + new_li + '">Button Color</label><input type="text" id="button-color-' + new_li + '" class="widefat ssb-colorpicker" name="ssb_buttons[btns][' + new_li + '][btn_color]"></p><p><label for="button-font-color-' + new_li + '">font color</label><input type="text" id="button-font-color-' + new_li + '" class="widefat ssb-colorpicker" name="ssb_buttons[btns][' + new_li + '][btn_font_color]"></p></div><div class="ssb-btn-controls"><a href="#" class="ssb-remove-btn">Remove</a> | <a href="#" class="ssb-close-btn">Close</a></div></div></li>';

        ul.prepend(li);

        $('#ssb-sortable-buttons').accordion( "refresh" );

        $('.ssb-iconpicker').iconpicker();

        $('.ssb-colorpicker').wpColorPicker();

        ssb_action('#ssb-sortable-buttons');

        return false;

    });

    // SSB Action
    function ssb_action(el) {

        // Update sorting
        var btns_sort = $(el).sortable('serialize', {key: 'sort'});
        $('#ssb-btns-order').val(btns_sort);

        // On click close
        $('.ssb-close-btn').click(function () {
            $('#ssb-sortable-buttons').accordion('option', {active: false});
            return false;
        });

        // On click remove
        $('.ssb-remove-btn').click(function () {
            $('#ssb-sortable-buttons').accordion('option', {active: false});
            $(this).parents('li').remove();
            return false;
        });

    }

    // Icon Picker
    $('.ssb-iconpicker').iconpicker();

    // Color picker
    $('.ssb-colorpicker').wpColorPicker();

});