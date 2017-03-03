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
        searchResults.removeClass('visible');
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

        searchResults.addClass('visible');
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

                            searchResults.empty().append(container);
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

    $(document).on('click', function(e) {
        var srOffset = searchResults.offset();

        var srBottomOffset = srOffset.top + searchResults.height();

        if (e.pageY < srOffset.top || e.pageY > srBottomOffset) {
            hideSearchContainer();
        }
    });

})(jQuery, searchController);