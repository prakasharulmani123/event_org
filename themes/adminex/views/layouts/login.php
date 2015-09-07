<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="ThemeBucket">
        <link rel="shortcut icon" href="#" type="image/png">
        <title><?php echo CHtml::encode($this->title); ?></title>
        <?php
        $themeUrl = $this->themeUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($themeUrl . '/css/style.css');
        $cs->registerCssFile($themeUrl . '/css/login.css');
        $cs->registerCssFile($themeUrl . '/css/style-responsive.css');
        ?>
    </head>
    <body class="login-body">
        <div class="container">
            <?php echo $content ?>
        </div>
        <?php
        $cs_pos_end = CClientScript::POS_END;
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($themeUrl . '/js/jquery-ui-1.9.2.custom.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/bootstrap.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/modernizr.min.js', $cs_pos_end);
        ?>
    </body>
</html>