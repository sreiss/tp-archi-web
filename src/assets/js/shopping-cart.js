(function($, cartController) {

    function showNoItemsLabel() {
        var cartTable = $('#cart-table');
        cartTable.parent().prepend($('<div>').text('You have no items in your cart').addClass('well'));
        cartTable.remove();
    }

    function updateGrandTotalAndSubtotal() {
        var total = 0;
        var rows = 0;
        $('[id^=cart-subtotal-]').each(function (index, element) {
            total += parseInt($(element).html(), 10);
            rows += 1;
        });
        $('#cart-grand-total').find('.grand-total-value').html('$' + total);
        $('#cart-subtotal').html('$' + total);
        if (rows == 0) {
            showNoItemsLabel();
        }
    }

    function updateItem(element, itemId) {
        var price = parseInt($('#cart-price-' + itemId).html(), 10);
        var value = parseInt(element.val(), 10);
        var subtotal = price * value;
        $('#cart-subtotal-' + itemId).html(subtotal);
        updateGrandTotalAndSubtotal();
    }

    function updateCart(element) {
        var value = element.val();
        var itemId = element.data('item-id');

        $('#cart-grand-total').find('.loader').addClass('visible');

        cartController.updateCart(itemId, value)
            .done(function(data) {
                updateItem(element, itemId);
            })
            .fail(function(error) {

            })
            .always(function() {
                $('#cart-grand-total').find('.loader').removeClass('visible');
            });
    }

    function deleteItem(element) {
        var value = element.val();
        var itemId = element.data('item-id');

        $('#cart-grand-total').find('.loader').addClass('visible');

        cartController.removeFromCart(itemId)
            .done(function(data) {
                element.parent().parent().remove();
                updateGrandTotalAndSubtotal();
                var result = JSON.parse(data);
                $('#cart-items-count').html('(' + result.shoppingItemsCount + ')');
            })
            .fail(function (request, error, status) {

            })
            .always(function() {
                $('#cart-grand-total').find('.loader').removeClass('visible');
            });
    }

    $('input[id^=cart-quantity-]').each(function(index, element) {
        $(element).on('change, input', function(e) {
            e.preventDefault();
            updateCart($(this));
        });
    });

    $('a[id^=cart-delete-]').each(function (index, element) {
        $(element).on('click', function(e) {
            e.preventDefault();
            var element = $(this);
            deleteItem(element);
        });
    })

})(jQuery, cartController);