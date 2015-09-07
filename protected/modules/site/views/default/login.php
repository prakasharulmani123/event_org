<?php
$this->title = 'Sign In';
$this->breadcrumbs = array(
    $this->title
);
$themeUrl = $this->themeUrl;
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('class' => 'form-signin', 'role' => 'form')
        ));
?>
<div class="form-signin-heading text-center">
    <h1 class="sign-title">Sign In</h1>
    <!--<img src="images/login-logo.png" alt=""/>-->
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

    <?php echo $form->textField($model, 'username', array('autofocus', 'class' => 'form-control', 'placeholder' => 'Username')); ?>
    <?php echo $form->error($model, 'username') ?>
    <?php echo $form->passwordField($model, 'password', array('autofocus', 'class' => 'form-control', 'placeholder' => 'Password')); ?>
    <?php echo $form->error($model, 'password') ?>
    <?php
    echo CHtml::tag('button', array('class' => 'btn btn-lg btn-login btn-block', 'type' => 'submit'), '<i class="fa fa-check"></i>');
    ?>

    <label class="checkbox">
        <?php echo $form->checkBox($model, 'rememberMe', array('id' => 'check', 'checked' => 'checked')); ?> Remember me
        <span class="pull-right">
            <a data-toggle="modal" href="#myModal"> Forgot Password?</a>
        </span>
    </label>
</div>
<?php $this->endWidget(); ?>

<!-- Modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
    <div class="modal-dialog">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'user-form',
            'enableAjaxValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions' => array('class' => '', 'role' => 'form')
        ));
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Forgot Password ?</h4>
            </div>
            <div class="modal-body">
                <p>Enter your e-mail address below to reset your password.</p>
                <?php echo $form->textField($forgot_model, 'email', array('autofocus', 'class' => 'form-control placeholder-no-fix', 'placeholder' => 'Email')); ?>
                <?php echo $form->error($forgot_model, 'email') ?>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                <?php echo CHtml::submitButton('Get Password', array('class' => 'btn btn-primary', 'name' => 'forgot')) ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>