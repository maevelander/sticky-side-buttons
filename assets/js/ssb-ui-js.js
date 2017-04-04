// SSB UI jQuery
jQuery(function ($) {

    // Animation Slide
    var ssb_panel = $('#ssb-container'),
        ssb_panel_w = ssb_panel.width(),
        sbb_display_margin = 50;

    ssb_panel.css('z-index', ssb_ui_data.z_index);

    if (ssb_panel.hasClass('ssb-btns-left') && (ssb_panel.hasClass('ssb-anim-slide') || ssb_panel.hasClass('ssb-anim-icons'))) {

        ssb_panel.css('left', '-' + (ssb_panel_w - sbb_display_margin) + 'px');

    } else if (ssb_panel.hasClass('ssb-btns-right') && (ssb_panel.hasClass('ssb-anim-slide') || ssb_panel.hasClass('ssb-anim-icons'))) {

        ssb_panel.css('right', '-' + (ssb_panel_w - sbb_display_margin) + 'px');

    }

    // Slide when hover
    ssb_panel.hover(function () {

        if (ssb_panel.hasClass('ssb-btns-left') && ssb_panel.hasClass('ssb-anim-slide')) {

            ssb_panel.stop().animate({'left': 0}, 300);

        } else if (ssb_panel.hasClass('ssb-btns-right') && ssb_panel.hasClass('ssb-anim-slide')) {

            ssb_panel.stop().animate({'right': 0}, 300);

        }

    }, function () {

        if (ssb_panel.hasClass('ssb-btns-left') && ssb_panel.hasClass('ssb-anim-slide')) {

            ssb_panel.animate({'left': '-' + (ssb_panel_w - sbb_display_margin) + 'px'}, 300);

        } else if (ssb_panel.hasClass('ssb-btns-right') && ssb_panel.hasClass('ssb-anim-slide')) {

            ssb_panel.animate({'right': '-' + (ssb_panel_w - sbb_display_margin) + 'px'}, 300);

        }

    });



});