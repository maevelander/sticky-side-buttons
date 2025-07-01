// SSB UI jQuery
jQuery(function ($) {

    // Animation Slide
    var ssb_panel = $('#ssb-container'),
        sbb_display_margin = 50,
        window_width = jQuery(window).width();

    // Function to get current panel width
    function getPanelWidth() {
        return ssb_panel.outerWidth();
    }

    ssb_panel.css('z-index', ssb_ui_data.z_index);

    if (ssb_panel.hasClass('ssb-btns-left') && (ssb_panel.hasClass('ssb-anim-slide') || ssb_panel.hasClass('ssb-anim-icons'))) {

        ssb_panel.css('left', '-' + (getPanelWidth() - sbb_display_margin) + 'px');

    } else if (ssb_panel.hasClass('ssb-btns-right') && (ssb_panel.hasClass('ssb-anim-slide') || ssb_panel.hasClass('ssb-anim-icons'))) {

        ssb_panel.css('right', '-' + (getPanelWidth() - sbb_display_margin) + 'px');

    }

    // Slide when hover
    if (window_width >= 768) {
        ssb_panel.hover(function () {

            if (ssb_panel.hasClass('ssb-btns-left') && ssb_panel.hasClass('ssb-anim-slide')) {

                ssb_panel.stop().animate({'left': 0}, 300);

            } else if (ssb_panel.hasClass('ssb-btns-right') && ssb_panel.hasClass('ssb-anim-slide')) {

                ssb_panel.stop().animate({'right': 0}, 300);

            }

        }, function () {

            if (ssb_panel.hasClass('ssb-btns-left') && ssb_panel.hasClass('ssb-anim-slide')) {

                ssb_panel.animate({'left': '-' + (getPanelWidth() - sbb_display_margin) + 'px'}, 300);

            } else if (ssb_panel.hasClass('ssb-btns-right') && ssb_panel.hasClass('ssb-anim-slide')) {

                ssb_panel.animate({'right': '-' + (getPanelWidth() - sbb_display_margin) + 'px'}, 300);

            }

        });

    } else {
        ssb_panel.click(function (e) {

            if (jQuery(this).hasClass('ssb-open')) {
                jQuery(this).removeClass('ssb-open');
                if (ssb_panel.hasClass('ssb-btns-left') && ssb_panel.hasClass('ssb-anim-slide')) {

                    ssb_panel.animate({'left': '-' + (getPanelWidth() - sbb_display_margin) + 'px'}, 300);

                } else if (ssb_panel.hasClass('ssb-btns-right') && ssb_panel.hasClass('ssb-anim-slide')) {

                    ssb_panel.animate({'right': '-' + (getPanelWidth() - sbb_display_margin) + 'px'}, 300);

                }
            } else {
                e.preventDefault();
                jQuery(this).addClass('ssb-open');

                if (ssb_panel.hasClass('ssb-btns-left') && ssb_panel.hasClass('ssb-anim-slide')) {

                    ssb_panel.stop().animate({'left': 0}, 300);

                } else if (ssb_panel.hasClass('ssb-btns-right') && ssb_panel.hasClass('ssb-anim-slide')) {

                    ssb_panel.stop().animate({'right': 0}, 300);

                }
            }

        });
    }


});