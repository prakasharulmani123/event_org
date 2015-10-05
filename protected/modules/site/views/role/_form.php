<?php
/* @var $this RoleController */
/* @var $model Role */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <section class="panel">
            <header class="panel-heading"><?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> </header>
            <div class="panel-body">
                <div class="box box-primary">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'role-form',
                        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    ?>
                    <div class="box-body">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'role_name', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'role_name', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                                <?php echo $form->error($model, 'role_name'); ?>
                            </div>
                        </div>

                        <div class="form-group hide">
                            <?php echo $form->labelEx($model, 'rank', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'rank', array('class' => 'form-control')); ?>
                                <?php echo $form->error($model, 'rank'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->checkBox($model, 'status', array('class' => '')); ?>
                                <?php echo $form->error($model, 'status'); ?>
                            </div>
                        </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-0 col-sm-offset-2">
                                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success')); ?>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </section>

    </div><!-- ./col -->
</div>