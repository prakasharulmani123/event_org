<?php
/* @var $this EventController */
/* @var $model Event */
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
                        'id' => 'event-form',
                        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    $roleUsers = Role::roleUsers();
                    ?>
                    <div class="box-body">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'event_name', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'event_name', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                                <?php echo $form->error($model, 'event_name'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'event_date', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'event_date', array('class' => 'form-control')); ?>
                                <?php echo $form->error($model, 'event_date'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'event_users', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-md-5">
                                <?php echo $form->dropDownList($model, 'event_users', $roleUsers, array('multiple'=>"multiple", 'class'=>"multi-select-group")); ?>
                                <?php echo $form->error($model, 'event_users'); ?>
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
                                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </section>

    </div><!-- ./col -->
</div>

<!--multi-select-->
<?php
$cs = Yii::app()->getClientScript();
$themeUrl = $this->themeUrl;
$cs_pos_end = CClientScript::POS_END;
$cs->registerCoreScript('jquery');
$cs->registerScriptFile($themeUrl . '/js/jquery-multi-select/js/jquery.multi-select.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/jquery-multi-select/js/jquery.quicksearch.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/multi-select-init.js', $cs_pos_end);
$cs->registerCssFile($themeUrl . '/js/jquery-multi-select/css/multi-select.css');
?>