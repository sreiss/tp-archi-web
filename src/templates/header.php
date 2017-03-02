<header class="main-header">
    <nav class="navbar sub-navbar-soft-market">
        <div class="container">
            <ul class="nav navbar-nav">
                <li>Shop by Phone <b>(01) 123 456 SM</b> <a href="#">Live Chat With Us</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">My Account <span class="caret"></span></a></li>
                <li>
                    <a href="<?php echo HOST . '/shopping-cart'; ?>">
                        My Cart <span id="cart-items-count"><?php echo ((empty($vars['shopping_items_count']) ? '': '(' . $vars['shopping_items_count'] . ')' )); ?></span> <span class="caret"></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <nav class="navbar navbar-soft-market">
        <div class="container no-padding">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo HOST; ?>">
                    <img src="/assets/images/img-01.png" alt="SoftMarket logo">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <form class="navbar-form navbar-right">
                    <div class="form-group">
                        <input type="text" class="form-control search-input" id="search">
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">OFFICE</a></li>
                    <li><a href="#">MULTIMEDIA</a></li>
                    <li><a href="<?php echo HOST . '/design'; ?>">DESIGN</a></li>
                    <li><a href="#">DEVELOPER</a></li>
                    <li><a href="#">UTILITIES</a></li>
                    <li><a href="#">GAMES</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div id="search-results" class="search-results-container">
    </div>
</header>

<div class="page-nav">
    <div class="container">
        <div class="col-md-12">
            <?php if (isset($vars['breadcrumbs']) && is_array($vars["breadcrumbs"])): ?>
                <ol class="breadcrumb">
                    <?php foreach ($vars['breadcrumbs'] as $breadcrumb): ?>
                        <?php if ($breadcrumb->is_active): ?>
                            <li class="active"><?php echo $breadcrumb->title; ?></li>
                        <?php else: ?>
                            <li><a href="<?php echo $breadcrumb->link; ?>"><?php echo $breadcrumb->title; ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            <?php endif; ?>
            <h1><?php echo $vars['page_title']; ?></h1>
        </div>
    </div>
</div>