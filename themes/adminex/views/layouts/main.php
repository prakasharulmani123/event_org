<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!--  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
          <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
          <meta name="description" content="">
          <meta name="author" content="ThemeBucket">-->
        <link rel="shortcut icon" href="#" type="image/png">

        <title><?php echo CHtml::encode($this->title); ?></title>

        <?php
        $themeUrl = $this->themeUrl;
        $cs = Yii::app()->getClientScript();

        //  <!--icheck-->
        $cs->registerCssFile($themeUrl . '/js/iCheck/skins/minimal/minimal.css');
        $cs->registerCssFile($themeUrl . '/js/iCheck/skins/square/square.css');
        $cs->registerCssFile($themeUrl . '/js/iCheck/skins/square/red.css');
        $cs->registerCssFile($themeUrl . '/js/iCheck/skins/square/blue.css');

        //  <!--dashboard calendar-->
//        $cs->registerCssFile($themeUrl . '/css/clndr.css');
        //  <!--common-->
        $cs->registerCssFile($themeUrl . '/css/style.css');
        $cs->registerCssFile($themeUrl . '/css/style-responsive.css');
        $cs->registerCssFile($themeUrl . '/css/custom.css');
        ?>


        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="sticky-header">

        <section>
            <!-- left side start-->
            <?php $this->renderPartial('//layouts/_sidebarNav'); ?>
            <!-- left side end-->

            <!-- main content start-->
            <div class="main-content" >

                <!-- header section start-->
                <?php $this->renderPartial('//layouts/_headerBar'); ?>
                <!-- header section end-->

                <!--body wrapper start-->
                <div class="wrapper">
                <?php echo $content; ?>
                </div>
                <!--body wrapper end-->

                <!--footer section start-->
<!--                <footer>
                    <?php echo date('Y'); ?> &copy; <?php echo SITENAME; ?>
                </footer>-->
                <!--footer section end-->
            </div>
            <!-- main content end-->
        </section>

        <?php
        $cs_pos_end = CClientScript::POS_END;

        $cs->registerCoreScript('jquery');

//        $cs->registerScriptFile($themeUrl . '/js/jquery-1.10.2.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/jquery-ui-1.9.2.custom.min.js', $cs_pos_end);
//        $cs->registerScriptFile($themeUrl . '/js/jquery-migrate-1.2.1.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/bootstrap.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/modernizr.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/jquery.nicescroll.js', $cs_pos_end);

        /* <!--icheck--> */
        $cs->registerScriptFile($themeUrl . '/js/iCheck/jquery.icheck.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/icheck-init.js', $cs_pos_end);

        /* <!--common scripts for all pages--> */
        $cs->registerScriptFile($themeUrl . '/js/scripts.js', $cs_pos_end);
        ?>

        <!--easy pie chart-->
<!--        <script src="js/easypiechart/jquery.easypiechart.js"></script>
        <script src="js/easypiechart/easypiechart-init.js"></script>-->

        <!--Sparkline Chart-->
<!--        <script src="js/sparkline/jquery.sparkline.js"></script>
        <script src="js/sparkline/sparkline-init.js"></script>-->


        <!-- jQuery Flot Chart-->
<!--        <script src="js/flot-chart/jquery.flot.js"></script>
        <script src="js/flot-chart/jquery.flot.tooltip.js"></script>
        <script src="js/flot-chart/jquery.flot.resize.js"></script>
        <script src="js/flot-chart/jquery.flot.pie.resize.js"></script>
        <script src="js/flot-chart/jquery.flot.selection.js"></script>
        <script src="js/flot-chart/jquery.flot.stack.js"></script>
        <script src="js/flot-chart/jquery.flot.time.js"></script>
        <script src="js/main-chart.js"></script>-->

        <!--common scripts for all pages-->
        <!--<script src="js/scripts.js"></script>-->


    </body>
</html>