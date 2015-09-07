<?php
$baseUrl = Yii::app()->baseUrl;
$themeUrl = Yii::app()->theme->baseUrl;
?>

<?php
$this->title = 'Reset Password';
$this->breadcrumbs = array(
    $this->title
);
?>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array('class' => 'form-signin cmxform', 'role' => 'form')
    ));
    ?>
<div class="form-signin-heading text-center">
    <h1 class="sign-title"><?php echo CHtml::encode($this->title) ?></h1>
</div>

<div class="login-wrap">
    <?php if (isset($this->flashMessages)): ?>
            <?php foreach ($this->flashMessages as $key => $message) { ?>
                <div class="alert alert-<?php echo $key; ?> fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert">
                        <i class="fa fa-times"></i>
                    </button>
                    <?php echo $message; ?>
                </div>
            <?php } ?>
        <?php endif ?>

    <?php echo $form->passwordField($model, 'new_password', array('autofocus', 'class' => 'form-control', 'placeholder' => 'New Password')); ?>
    <?php echo $form->error($model, 'new_password') ?>
    <?php echo $form->passwordField($model, 'confirm_password', array('autofocus', 'class' => 'form-control', 'placeholder' => 'Confirm Password')); ?>
    <?php echo $form->error($model, 'confirm_password') ?>
    <?php echo CHtml::submitButton('Reset Password', array('class' => 'btn bg-success btn-block', 'name' => 'reset')) ?>
    <label class="checkbox">
        <span class="pull-right">
            <?php echo CHtml::link('Login >>', array('/site/default/login')); ?>
        </span>
    </label>
</div>
<?php $this->endWidget(); ?>

