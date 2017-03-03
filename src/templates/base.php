<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SoftMarket</title>
        <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../bower_components/bootstrap-slider/slider.css" />
        <link rel="stylesheet" href="../assets/css/style.css" />
        <link rel="stylesheet" href="../assets/css/colors.css" />
    </head>
    <body>
        <?php include 'header.php'; ?>
        <?php include $template_name; ?>
        <?php include 'footer.php'; ?>
        <script type="text/javascript">
            var host = '<?php echo HOST; ?>';
        </script>
        <script src="/bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
        <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/bower_components/bootstrap-slider/bootstrap-slider.js" type="text/javascript"></script>
        <script src="/bower_components/bootstrap-rating/bootstrap-rating.js" type="text/javascript"></script>
        <script src="/assets/js/cart-controller.js" type="text/javascript"></script>
        <script src="/assets/js/design-controller.js" type="text/javascript"></script>
        <script src="/assets/js/search-controller.js" type="text/javascript"></script>
        <script src="/assets/js/common.js" type="text/javascript"></script>
        <script src="/assets/js/<?php echo $vars['script_file']; ?>.js" type="text/javascript"></script>
    </body>
</html>