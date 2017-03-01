(function($, searchController) {

    var searchInput = $('#search');
    var searchResults = $('#search-results');
    var requestWasCancelled = false;

    function showSpinner() {
        searchResults.empty().append(
            $('<span class="loader visible">')
        );
    }

    function hideSearchContainer() {
        searchResults.css('height', '0');
    }

    function showNoResults() {
        searchResults.empty()
            .append(
                $('<div class="no-search-results">')
                    .append(
                        $('<h3>').append('No results')
                    )
            );
    }

    searchInput.on('input', function(e) {
        var target = $(e.target);
        var value = target.val();

        showSpinner();

        if (value != '') {
            requestWasCancelled = false
            searchController.search(value)
                .done(function (data) {
                    if (!requestWasCancelled) {
                        if (data.length == 0) {
                            showNoResults();
                        } else {
                            var container = $('<div class="container-fluid">');
                            data.forEach(function (item) {
                                container.append(
                                    $('<div class="col-md-2 text-center">')
                                        .append($('<img src="/assets/images/product/' + item.id + '.jpg"/>'))
                                        .append($('<h5>').append(item.name))
                                )
                            });

                            searchResults.css('height', '200px').empty().append(container);
                        }
                    }
                })
                .fail(function (status, error) {

                });
        } else {
            searchController.clearDebouncer();
            requestWasCancelled = true;
            showNoResults();
        }
    });

    searchInput.on('blur', function(e) {
        hideSearchContainer();
    });

})(jQuery, searchController);