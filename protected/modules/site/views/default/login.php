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
    'htmlOptions' => array(
        'class' => 'form-signin',
        )));
?>
<div class="form-signin-heading text-center">
    <h1 class="sign-title">Sign In</h1>
    <!--<img src="images/login-logo.png" alt=""/>-->
</div>

<div class="login-wrap">
    
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
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Forgot Password ?</h4>
            </div>
            <div class="modal-body">
                <p>Enter your e-mail address below to reset your password.</p>
                <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                <button class="btn btn-primary" type="button">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
<!--<div class="form-box" id="login-box">

    <div class="header"><?php echo CHtml::encode($this->title) ?></div>
    <div class="body bg-gray">
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
        <p>Please fill out the following fields to login:</p>
        <div class="form-group">
<?php echo $form->labelEx($model, 'username') ?>
<?php echo $form->textField($model, 'username', array('autofocus', 'class' => 'form-control')); ?>
<?php echo $form->error($model, 'username') ?>
        </div>
        <div class="form-group">
<?php echo $form->labelEx($model, 'password') ?>
<?php echo $form->passwordField($model, 'password', array('autofocus', 'class' => 'form-control')); ?>
<?php echo $form->error($model, 'password') ?>
        </div>
<?php echo $form->checkBox($model, 'rememberMe', array('id' => 'check', 'checked' => 'checked')); ?>
<?php echo ' Remember Me'; ?>
    </div>
    <div class="footer">
        <p><?php echo CHtml::link('I forgot my password', array('/site/user/forgot')) ?></p>
    </div>
</div>-->