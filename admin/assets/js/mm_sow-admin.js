
/*global jQuery:false*/

jQuery(document).ready(function () {
    MM_SOW_JS.init();
    // Run tab open/close event
    MM_SOW_Tab.event();
});

// Init all fields functions (invoked from ajax)
var MM_SOW_JS = {
    init: function () {
        // Run tab open/close
        MM_SOW_Tab.init();
        // Load colorpicker if field exists
        MM_SOW_ColorPicker.init();
    }
};


var MM_SOW_ColorPicker = {
    init: function () {
        var $colorPicker = jQuery('.mm_sow-colorpicker');
        if ($colorPicker.length > 0) {

            $colorPicker.wpColorPicker();

        }
    }
};

var MM_SOW_Tab = {
    init: function () {
        // display the tab chosen for initial display in content
        jQuery('.mm_sow-tab.selected').each(function () {
            MM_SOW_Tab.check(jQuery(this));
        });
    },
    event: function () {
        jQuery(document).on('click', '.mm_sow-tab', function () {
            MM_SOW_Tab.check(jQuery(this));
        });
    },
    check: function (elem) {
        var chosen_tab_name = elem.data('target');
        elem.siblings().removeClass('selected');
        elem.addClass('selected');
        elem.closest('.mm_sow-inner').find('.mm_sow-tab-content').removeClass('mm_sow-tab-show').hide();
        elem.closest('.mm_sow-inner').find('.mm_sow-tab-content.' + chosen_tab_name + '').addClass('mm_sow-tab-show').show();
    }
};