var DesignController = (function ($) {

    var debouncer;

    function DesignController() {}

    DesignController.prototype.clearDebouncer = function() {
        if (debouncer) {
            clearTimeout(debouncer);
            delete debouncer;
        }
    };

    DesignController.prototype.getItems = function(filter) {
        this.clearDebouncer();
        filter = filter || '';

        var deferred = $.Deferred();

        debouncer = setTimeout(function() {
            $.ajax(host + '/design/items' + filter, {
                method: 'GET'
            }).done(function(data) {
                deferred.resolve(data);
            }).fail(function (request, error, status) {
                deferred.reject(error);
            });
        }, 250);

        return deferred;
    };

    return DesignController;

})(jQuery);

var designController = new DesignController();