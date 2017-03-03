<div class="container">
    <?php if (isset($vars['shopping_cart']) && count($vars['shopping_cart']) > 0): ?>
        <table class="table table-cart" id="cart-table">
            <thead>
            <tr>
                <th>Item name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($vars['shopping_cart'] as $item): ?>
                <tr>
                    <td class="product-detail">
                        <img src="/assets/images/product/<?php echo $item->get_item()->get_id();?>.jpg" alt="Product" />
                        <?php echo $item->get_item()->get_name(); ?>
                    </td>
                    <td id="cart-price-<?php echo $item->get_item()->get_id(); ?>"><?php echo $item->get_item()->get_price(); ?></td>
                    <td>
                        <label for="cart-quantity-<?php echo $item->get_item()->get_id(); ?>" class="sr-only">Modify quantity</label>
                        <input id="cart-quantity-<?php echo $item->get_item()->get_id(); ?>" type="number" class="form-control" min="0" value="<?php echo $item->get_quantity(); ?>" data-item-id="<?php echo $item->get_item()->get_id(); ?>"/>
                    </td>
                    <td id="cart-subtotal-<?php echo $item->get_item()->get_id(); ?>"><?php echo $item->compute_subtotal(); ?></td>
                    <td class="text-center"><a href="#" id="cart-delete-<?php echo $item->get_item()->get_id(); ?>" data-item-id="<?php echo $item->get_item()->get_id(); ?>"><img src="/assets/images/cart-02.png" alt="Delete"></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="well">
            You have no items in your cart
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-4">
            <h4 class="col-title">Estimate Shipping & taxes</h4>
            <div class="col-content">
                <p>Enter your destination to get a shipping estimation.</p>
                <div class="form-group">
                    <label for="estimate-country">Country</label>
                    <input type="text" id="estimate-country" name="estimate_country" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="estimate-state">State / Province</label>
                    <input type="text" id="estimate-state" name="estimate_state" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="estimate-zip-code">Zip / Postal Code</label>
                    <input type="text" id="estimate-zip-code" name="estimate_zip_code" class="form-control"/>
                </div>
                <div class="text-center-md">
                    <a href="#" class="cart-button"><img src="/assets/images/cart-05.png" alt="Get a quote"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h4 class="col-title">Discount Coupon</h4>
            <div class="col-content">
                <p>Enter a coupon code below if you have one.</p>
                <div class="form-group">
                    <label for="discount-coupon">Get a coupon discount here</label>
                    <input type="text" id="discount-coupon" name="discount_coupon" class="form-control"/>
                </div>
                <div class="text-center-md">
                    <a href="#" class="cart-button"><img src="/assets/images/cart-04.png" alt="Apply coupon" /></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h4 class="col-title">Order Total</h4>
            <div class="col-content">
                <table class="cart-total-table">
                    <tr>
                        <td>
                            Subtotal
                        </td>
                        <td id="cart-subtotal">
                            $<?php echo $vars['subtotal']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Grand total
                        </td>
                        <td id="cart-grand-total" class="grand-total">
                            <span class="grand-total-value">$<?php echo $vars['grand_total']; ?></span>
                            <span class="loader"></span>
                        </td>
                    </tr>
                </table>
                <div class="text-center-md">
                    <a href="#" class="cart-button"><img src="/assets/images/cart-03.png" alt="Proceed"></a>
                </div>
            </div>
        </div>
    </div>
</div>