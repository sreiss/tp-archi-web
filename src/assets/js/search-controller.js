var SearchController = (function($) {

    var debouncer;

    var SearchController = function() {};

    SearchController.prototype.clearDebouncer = function() {
        if (debouncer) {
            clearTimeout(debouncer);
            delete debouncer;
        }
    };

    SearchController.prototype.search = function(searchText) {
        this.clearDebouncer();

        var deferred = $.Deferred();

        debouncer = setTimeout(function() {
            $.ajax(host + '/design/items?search-text=' + searchText, {
                method: 'GET'
            }).done(function (data) {
                deferred.resolve(data);
            }).fail(function (request, error, status) {
                deferred.reject(error);
            });
        }, 500);

        return deferred;
    };

    return SearchController;

})(jQuery);

var searchController = new SearchController();