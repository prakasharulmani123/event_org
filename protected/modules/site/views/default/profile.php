<?php
$this->title = 'My Profile';
$this->breadcrumbs = array(
    $this->title
);
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <section class="panel">
            <header class="panel-heading"><?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> </header>
            <div class="panel-body">
                <div class="box box-primary">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'profile-form',
                        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    ?>
                    <div class="box-body">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'username', array('class' => 'col-sm-2 control-label')) ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'username', array('autofocus', 'class' => 'form-control')); ?>
                                <?php echo $form->error($model, 'username') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_firstname', array('class' => 'col-sm-2 control-label')) ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'user_firstname', array('autofocus', 'class' => 'form-control')); ?>
                                <?php echo $form->error($model, 'user_firstname') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_lastname', array('class' => 'col-sm-2 control-label')) ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'user_lastname', array('autofocus', 'class' => 'form-control')); ?>
                                <?php echo $form->error($model, 'user_lastname') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'new_password', array('class' => 'col-sm-2 control-label')) ?>
                            <div class="col-sm-5">
                                <?php echo $form->passwordField($model, 'new_password', array('autofocus', 'class' => 'form-control')); ?>
                                <?php echo $form->error($model, 'new_password') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'confirm_password', array('class' => 'col-sm-2 control-label')) ?>
                            <div class="col-sm-5">
                                <?php echo $form->passwordField($model, 'confirm_password', array('autofocus', 'class' => 'form-control')); ?>
                                <?php echo $form->error($model, 'confirm_password') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_avatar', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->fileField($model, 'user_avatar', array('class' => 'form-control')); ?>
                                <?php echo $form->error($model, 'user_avatar'); ?>
                            </div>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-0 col-sm-offset-2">
                                <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-success')) ?>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </section>

    </div><!-- ./col -->
</div>

<?php
$script = <<< JS
    $(document).ready(function(){
        $(':password').val('');
    });
JS;

Yii::app()->getClientScript()->registerScript($script, CClientScript::POS_END);
?>
