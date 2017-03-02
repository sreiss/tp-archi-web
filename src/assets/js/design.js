(function($, cartController, designController) {

    var currentSearch = '';

    function redrawRatings() {
        $('.rating').each(function (index, element) {
            $(element).rating({
                empty: 'glyphicon glyphicon-star'
            });
        });
    }
    redrawRatings();

    function addCartButtonActions() {
        $('.add-to-cart-button').each(function(index, addToCartButton) {
            var $addToCartButton = $(addToCartButton);
            $addToCartButton.on('click', {id: $addToCartButton.data('item-id')},function(e) {
                e.preventDefault();
                var data = e.data;

                cartController.addToCart(data)
                    .done(function(data, textStatus) {
                        $('#cart-items-count').html('(' + data.shoppingItemsCount + ')');

                        $('#added-to-cart-alert').remove();

                        $('#main-container').prepend(
                            $('<div class="alert alert-success" id="added-to-cart-alert">')
                                .append('<i class="glyphicon glyphicon-ok"> ')
                                .append('<strong> ' + data.addedItem.name + ' successfully added to your cart.</strong>')
                        )
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {

                    });
            });
        });
    }
    addCartButtonActions();

    function displayProducts(data) {
        var products = $('#products');

        products.empty();

        data.forEach(function(item) {
            var specialLabel = $('<div class="product-label">');
            if (item.special == 'new') {
                specialLabel.addClass('new');
            } else if (item.special == 'discount') {
                specialLabel.addClass('discount');
            }


            var itemDiv = $('<div class="col-md-4">').append(
                $('<div class="thumbnail product">').append(
                    $('<div class="image-container">').append(
                        specialLabel,
                        $('<img src="/assets/images/product/' + item.id + '.jpg" alt="Thumbnail" class="product-img">')
                    ),
                    $('<div class="caption">').append(
                        $('<h5>').append(item.name),
                        $('<p>').append('$' + item.price),
                        $('<p>').append(
                            $('<input type="hidden" class="rating" data-readonly value="' + item.rating + '"/>')
                        )
                    )
                ).append(
                    $('<ul class="thumbnail-links">').append(
                        $('<li>').append(
                            $('<a href="#" class="add-to-cart-button" data-item-id="' + item.id + '">').append(
                                $('<img src="/assets/images/img-11.png" alt="Add to cart"/>')
                            )
                        )
                    )
                ).append(
                    $('<ul class="thumbnail-links thumbnail-links-right">').append($('<li><a href="#"><img src="/assets/images/img-12.png" alt="Add to cart"/></a></li>'))
                        .append($('<li><a href="#"><img src="/assets/images/img-13.png" alt="Add to cart"/></a></li>'))
                ).append('<div class="clearfix">')
            );



            products.append(itemDiv);
        });

        redrawRatings();
        addCartButtonActions();
    }

    function refreshProducts() {
        var finalSearch = currentSearch;

        designController.getItems(finalSearch)
            .done(function(data) {
                displayProducts(data);
            })
            .fail(function() {

            });
    }

    $('.color-square > a').each(function(index, element) {
        $(element).on('click', function (e) {
            e.preventDefault();

            currentSearch = element.search;

            $('.color-square').each(function(index, element) {
                $(element).removeClass('active');
            });
            $(e.target).parent().addClass('active');

            refreshProducts();
        });
    });

    var priceSlider = $("#price-slider").slider();

    priceSlider.on('slide', function(e) {
        $('#price-slider-lower-bound').html('$' + e.value[0]);
        $('#price-slider-upper-bound').html('$' + e.value[1]);
    });

    $('.categories > li > a').each(function(index, element) {
        $(element).on('click', function (e) {
            e.preventDefault();
            var el = $(element);

            currentSearch = element.search;
            refreshProducts();

            $('.categories > li').each(function(index, element) {
                $(element).removeClass('active');
            });
            $('.sub-categories > li').each(function(index, element) {
                $(element).removeClass('active');
            });
            el.parent().addClass('active');
        });
    });

    $('.sub-categories > li > a').each(function(index, element) {
        $(element).on('click', function (e) {
            e.preventDefault();
            var el = $(element);

            currentSearch = element.search;
            refreshProducts();

            $('.sub-categories > li').each(function(index, element) {
                $(element).removeClass('active');
            });
            el.parent().addClass('active');
        });
    });

})(jQuery, cartController, designController);