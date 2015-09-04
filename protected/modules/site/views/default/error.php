<?php
$this->title = $name;
?>
<section class="error-wrapper text-center">
    <h2>Oops! <?php echo $name; ?> </h2>
    <h3><?php echo $message; ?></h3>
    <a class="back-btn" href="<?php echo Yii::app()->createAbsoluteUrl('site/default/index') ?>"> Back To Home</a>
</section>