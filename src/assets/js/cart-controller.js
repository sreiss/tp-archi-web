var CartController = (function ($) {

    var debouncer;

    function CartController() {}

    /**
     * Makes an HTTP PUT request to update the item on the server.
     * @param {int} itemId The item id (not the shopping item id).
     * @param {int} value The new number of items.
     * @returns {*}
     */
    CartController.prototype.updateCart = function(itemId, value) {
        if (debouncer) {
            clearTimeout(debouncer);
            delete debouncer;
        }

        var deferred = $.Deferred();

        debouncer = setTimeout(function() {
            $.ajax(host + '/shopping-cart/' + itemId, {
                method: 'PUT',
                data: {
                    quantity: value
                },
                contentType: 'application/json'
            }).done(function (data) {
                deferred.resolve(data);
            }).fail(function (request, error, status) {
                deferred.reject(error);
            });
        }, 500);

        return deferred;
    };

    /**
     * Makes an HTTP DELETE request to remove the item from the cart.
     * @param {int} itemId The item id (not the shopping item id).
     * @returns {*}
     */
    CartController.prototype.removeFromCart = function(itemId) {
        return $.ajax(host + '/shopping-cart/' + itemId, {
            method: 'DELETE'
        });
    };

    /**
     * Makes an HTTP POST request to add an item to the cart.
     * @param {object} data The data to send
     * @param {int} data.id The item id to add (not the shopping item id).
     * @returns {*}
     */
    CartController.prototype.addToCart = function (data) {
        return $.ajax(host + '/shopping-cart', {
            method: 'POST',
            data: data,
            contentType: 'application/json'
        });
    };

    return CartController;

})(jQuery);

var cartController = new CartController();