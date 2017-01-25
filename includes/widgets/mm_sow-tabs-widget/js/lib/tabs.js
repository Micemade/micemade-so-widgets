/* Credit for tab styles - http://tympanus.net/codrops/2014/09/02/tab-styles-inspiration/ */

jQuery(function ($) {

    $('.mm_sow-tabs').each(function () {

        var tabs = $(this);
        new MM_SOW_Tabs(tabs);

    });

});

var MM_SOW_Tabs = function (tabs) {

    this.tabs = tabs;

    // tabs elems
    this.tabNavs = tabs.find('.mm_sow-tab');

    // content items
    this.items = tabs.find('.mm_sow-tab-pane');

    // current index
    this.current = 0;

    // show current content item
    this.show();

    // init events
    this.initEvents();

    // make the tab responsive
    this.makeResponsive();
};

MM_SOW_Tabs.prototype.show = function (index) {
    // Clear out existing tab
    this.tabNavs.eq(this.current).removeClass('mm_sow-active');
    this.items.eq(this.current).removeClass('mm_sow-active');

    // change current
    if (index != undefined)
        this.current = index;
    this.tabNavs.eq(this.current).addClass('mm_sow-active');
    this.items.eq(this.current).addClass('mm_sow-active');
};

MM_SOW_Tabs.prototype.initEvents = function () {
    var self = this;

    this.tabNavs.click(function (event) {
        event.preventDefault();
        self.show(self.tabNavs.index(jQuery(this)));
    });

};

MM_SOW_Tabs.prototype.makeResponsive = function () {

    var self = this;

    /* Trigger mobile layout based on an user chosen browser window resolution */
    var mediaQuery = window.matchMedia('(max-width: ' + self.tabs.data('mobile-width') + 'px)');
    if (mediaQuery.matches) {
        self.tabs.addClass('mm_sow-mobile-layout');
    }
    mediaQuery.addListener(function (mediaQuery) {
        if (mediaQuery.matches)
            self.tabs.addClass('mm_sow-mobile-layout');
        else
            self.tabs.removeClass('mm_sow-mobile-layout');
    });

    /* Close/open the mobile menu when a tab is clicked and when menu button is clicked */
    this.tabNavs.click(function (event) {
        event.preventDefault();
        self.tabs.toggleClass('mm_sow-mobile-open');
    });

    this.tabs.find('.mm_sow-tab-mobile-menu').click(function (event) {
        event.preventDefault();
        self.tabs.toggleClass('mm_sow-mobile-open');
    });
};
