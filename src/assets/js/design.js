(function($, cartController, designController) {

    var filter = {
        'category': null,
        'sub-category': null,
        'search-text': null,
        'color': null,
        'brands': null,
        'min-price': -1,
        'max-price': -1
    };

    function searchToFilter(search) {
        var queryStr = search.substring(1);
        var queryItemStrs = queryStr.split('&');
        var queryItems = {};

        queryItemStrs.forEach(function (qi) {
            var parts = qi.split('=');
            if (parts.length == 2) {
                queryItems[parts[0]] = parts[1];
            }
        });

        for (var key in queryItems) {
            filter[key] = queryItems[key];
        }
    }

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

                        /*
                        $('#added-to-cart-alert').remove();

                        $('#main-container').prepend(
                            $('<div class="alert alert-success" id="added-to-cart-alert">')
                                .append('<i class="glyphicon glyphicon-ok"> ')
                                .append('<strong> ' + data.addedItem.name + ' successfully added to your cart.</strong>')
                        )
                        */
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {

                    });
            });
        });
    }
    addCartButtonActions();

    function showNoProducts() {
        var products = $('#products');

        products.empty();

        products.append($('<p class="text-center">').append('No products found'));
    }

    function displayProducts(data) {
        var products = $('#products');

        products.empty();

        for (var i = 0; i < data.length; i++) {
            var item = data[i];

            var specialLabel = $('<div class="product-label">');
            if (item.special == 'new') {
                specialLabel.addClass('new');
            } else if (item.special == 'discount') {
                specialLabel.addClass('discount');
            }

            var priceP = $('<p>');
            if (item.discount_percentage != 0) {
                priceP.append(
                    $('<span class="price with-discount">').append('$' + item.price),
                    $('<span class="discount-price">').append(' $' + (item.price - ((item.discount_percentage * item.price) / 100)))
                );
            } else {
                priceP.append('$' + item.price);
            }

            var itemDiv = $('<div class="col-md-4">').append(
                $('<div class="thumbnail product">').append(
                    $('<div class="image-container">').append(
                        specialLabel,
                        $('<img src="/assets/images/product/' + item.id + '.jpg" alt="Thumbnail" class="product-img">')
                    ),
                    $('<div class="caption">').append(
                        $('<h5>').append(item.name),
                        priceP,
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

            if (((i + 1) % 3) == 0) {
                products.append($('<div class="clearfix">'));
            }
        }

        redrawRatings();
        addCartButtonActions();
    }

    function refreshProducts() {
        var loader = $('#items-loader');
        var finalSearch = '?';
        var parts = [];
        for (var key in filter) {
            if (filter[key] !== null && filter[key] != -1) parts.push(key + '=' + filter[key]);
        }

        finalSearch += parts.join('&');

        loader.addClass('visible');
        designController.getItems(finalSearch)
            .done(function(data) {
                var numberOfItems = $('#number-of-items');
                numberOfItems.empty();
                numberOfItems.append(data.length);

                if (data.length > 0) {
                    displayProducts(data);
                } else {
                    showNoProducts();
                }
            })
            .fail(function() {

            })
            .always(function() {
                loader.removeClass('visible');
            });
    }

    $('.color-square > a').each(function(index, element) {
        $(element).on('click', function (e) {
            e.preventDefault();

            var previousColor = filter.color;
            searchToFilter(element.search);

            $('.color-square').each(function (index, element) {
                $(element).removeClass('active');
            });

            if (filter.color == previousColor) {
                filter.color = null;
            } else {
                $(e.target).parent().addClass('active');
            }

            refreshProducts();
        });
    });

    var priceSlider = $("#price-slider").slider();

    priceSlider.on('slide', function(e) {
        $('#price-slider-lower-bound').html('$' + e.value[0]);
        $('#price-slider-upper-bound').html('$' + e.value[1]);

        filter['min-price'] = e.value[0];
        filter['max-price'] = e.value[1];

        refreshProducts();
    });

    $('.categories > li > a').each(function(index, element) {
        $(element).on('click', function (e) {
            e.preventDefault();
            var el = $(element);

            filter['sub-category'] = null;
            var previousCategory = filter.category;
            searchToFilter(element.search);

            $('.categories > li').each(function(index, element) {
                $(element).removeClass('active');
            });
            $('.sub-categories > li').each(function(index, element) {
                $(element).removeClass('active');
            });

            if (previousCategory == filter.category) {
                filter.category = null;
            } else {
                el.parent().addClass('active');
            }

            refreshProducts();
        });
    });

    $('.sub-categories > li > a').each(function(index, element) {
        $(element).on('click', function (e) {
            e.preventDefault();
            var el = $(element);

            searchToFilter(element.search);
            refreshProducts();

            $('.sub-categories > li').each(function(index, element) {
                $(element).removeClass('active');
            });
            el.parent().addClass('active');
        });
    });

    $('.brands > li > label > :checkbox').each(function(index, element) {
        $(element).on('change', function(e) {
            var self = $(this);
            var brand = self.data('brand');

            e.preventDefault();

            filter.brands = filter.brands || [];

            var index;
            if (self.is(':checked') && filter.brands.indexOf(brand) == -1) {
                filter.brands.push(brand);
            } else if (!self.is(':checked') && (index = filter.brands.indexOf(brand)) != -1) {
                filter.brands.splice(index, 1);
            }

            if (filter.brands.length == 0) {
                filter.brands = null;
            }
            refreshProducts();
        });
    });

    $('#to-top').on('click', function (e) {
        $('html, body').animate({scrollTop: 0}, 500);
        return false;
    });

})(jQuery, cartController, designController);