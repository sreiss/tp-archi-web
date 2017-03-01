var DesignController = (function ($) {

    function DesignController() {}

    DesignController.prototype.getItems = function(filter) {
        filter = filter || '';

        return $.ajax(host + '/design/items' + filter, {
            method: 'GET'
        });
    };

    return DesignController;

})(jQuery);

var designController = new DesignController();