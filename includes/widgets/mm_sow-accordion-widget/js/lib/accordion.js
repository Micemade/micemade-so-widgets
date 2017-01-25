
jQuery(function ($) {

    $('.mm_sow-accordion').each(function () {

        var accordion = $(this);

        new MM_SOW_Accordion(accordion);

    });

});

var MM_SOW_Accordion = function (accordion) {

    // toggle elems
    this.panels = accordion.find('.mm_sow-panel');

    this.toggle = false;

    if (accordion.data('toggle') == true)
        this.toggle = true;

    this.current = null;

    // init events
    this.initEvents();
};

MM_SOW_Accordion.prototype.show = function (panel) {

    if (this.toggle) {
        if (panel.hasClass('mm_sow-active')) {
            this.close(panel);
        }
        else {
            this.open(panel);
        }
    }
    else {
        // if the panel is already open, close it else open it after closing existing one
        if (panel.hasClass('mm_sow-active')) {
            this.close(panel);
            this.current = null;
        }
        else {
            this.close(this.current);
            this.open(panel);
            this.current = panel;
        }
    }

};

MM_SOW_Accordion.prototype.close = function (panel) {

    if (panel !== null) {
        panel.children('.mm_sow-panel-content').slideUp(300);
        panel.removeClass('mm_sow-active');
    }

};

MM_SOW_Accordion.prototype.open = function (panel) {

    if (panel !== null) {
        panel.children('.mm_sow-panel-content').slideDown(300);
        panel.addClass('mm_sow-active');
    }

};


MM_SOW_Accordion.prototype.initEvents = function () {

    var self = this;

    this.panels.find('.mm_sow-panel-title').click(function (event) {

        event.preventDefault();

        var panel = jQuery(this).parent();

        self.show(panel);
    });
};

