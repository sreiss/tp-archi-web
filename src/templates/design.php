<div class="container">
    <div class="design-main">
        <div class="col-md-3 filter-panel">
            <div class="panel panel-shop-by">
                <div class="panel-heading">
                    Shop by
                </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="list-group-item-heading">CATEGORIES</div>
                        <ul class="categories">
                            <?php foreach ($vars['categories'] as $category): ?>
                                <?php $c_class = (isset($vars['category_id']) && $vars['category_id'] == $category->get_id()) ? ' class="active"' : ''; ?>
                                <li<?php echo $c_class; ?>>
                                    <a href="<?php echo BASEURL . '?category=' . $category->get_id(); ?>">
                                        <?php echo $category->get_name(); ?>
                                        <span class="category-items-count">(<?php echo $category->get_items_count(); ?>)</span>
                                    </a>
                                    <?php if (!empty($sub_categories = $category->get_sub_categories())): ?>
                                        <ul class="sub-categories">
                                            <?php foreach ($sub_categories as $sub_category): ?>
                                                <?php $s_c_class = (isset($vars['sub_category_id']) && $vars['sub_category_id'] == $sub_category->get_id()) ? ' class="active"' : ''; ?>
                                                <li<?php echo $s_c_class; ?>>
                                                    <a href="<?php echo BASEURL . '?category=' . $category->get_id() . '&sub-category=' . $sub_category->get_id(); ?>">
                                                        <?php echo $sub_category->get_name(); ?>
                                                        <span class="sub-category-items-count">(<?php echo $sub_category->get_items_count(); ?>)</span>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                                <!--<li>Vivamus mauris</li>
                                <li class="active">
                                    Rhoncus vitae semper
                                    <ul>
                                        <li>Vivamus mauris</li>
                                        <li>Rhoncus vitae semper</li>
                                    </ul>
                                </li>-->
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="list-group-item">
                        <div class="list-group-item-heading">PRICE</div>
                        <input id="price-slider" type="text" data-provide="slider" data-slider-ticks="[1, 2, 3]"
                               data-slider-ticks-labels='["short", "medium", "long"]' data-slider-min="100"
                               data-slider-max="10000" data-slider-step="10" data-slider-value="[100, 10000]" data-slider-tooltip="hide" />
                        <div class="row">
                            <div class="col-md-6" id="price-slider-lower-bound">
                                $100
                            </div>
                            <div class="col-md-6 text-right" id="price-slider-upper-bound">
                                $10000
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="list-group-item-heading">COLOR</div>
                        <ul>
                            <?php foreach ($vars['colors'] as $color): ?>
                                <?php $color_active = (isset($vars['color']) && $color->get_name() == $vars['color']) ? ' active': ''; ?>
                                <li class="color-square bg-<?php echo $color->get_name() . $color_active; ?>">
                                    <a href="<?php echo BASEURL . 'design?color=' . $color->get_name(); ?>"><span class="sr-only"><?php echo $color->get_name(); ?></span></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <div class="list-group-item-heading">BRAND</div>
                        <ul>
                            <?php foreach ($vars['brands'] as $brand): ?>
                                <li>
                                    <label>
                                        <input type="checkbox"> <?php echo $brand->get_name(); ?> (<?php echo $brand->get_count(); ?>)
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9 products-main">
            <img src="/assets/images/img-03.png" alt="Banner" />
            <nav class="navbar items-nav">
                <div class="nav navbar-nav">
                    <p class="navbar-text"><?php echo count($vars['items']); ?> item(s)</p>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><img src="/assets/images/img-04.png"/></a></li>
                    <li><a href="#"><img src="/assets/images/img-05.png"/></a></li>
                    <li><a href="#"><img src="/assets/images/img-06.png"/></a></li>
                    <li><a href="#"><img src="/assets/images/img-07.png"/></a></li>
                </ul>
                <div class="clearfix"></div>
            </nav>
            <div class="clearfix"></div>
            <div id="products">
                <?php foreach ($vars['items'] as $i => $item): ?>
                    <div class="col-md-4">
                        <div class="thumbnail product">
                            <div class="image-container">
                                <?php if ($item->get_special()) : ?>
                                    <?php $special_class = ($item->get_special() == 'discount') ? ' discount' : ' new'; ?>
                                    <div class="product-label<?php echo $special_class; ?>"></div>
                                <?php endif; ?>
                                <img src="/assets/images/product/<?php echo $item->get_id(); ?>.jpg" alt="Thumbnail" class="product-img">
                            </div>
                            <div class="caption">
                                <h5><?php echo $item->get_name(); ?></h5>

                                <p>$<?php echo $item->get_price(); ?></p>
                                <p><input type="hidden" class="rating" data-readonly value="<?php echo $item->get_rating(); ?>"/></p>
                            </div>
                            <ul class="thumbnail-links">
                                <li>
                                    <a href="#" class="add-to-cart-button" data-item-id="<?php echo $item->get_id(); ?>">
                                        <img src="/assets/images/img-11.png" alt="Add to cart"/>
                                    </a>
                                </li>
                            </ul>
                            <ul class="thumbnail-links thumbnail-links-right">
                                <li><a href="#"><img src="/assets/images/img-12.png" alt="Add to cart"/></a></li>
                                <li><a href="#"><img src="/assets/images/img-13.png" alt="Add to cart"/></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="clearfix"></div>
            <div class="text-center">
                <ul class="pagination">
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">Next page</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>