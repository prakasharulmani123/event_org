<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
if ($model->isNewRecord)
    $title = 'Create';
elseif ($profile)
    $title = 'Profile';
else
    $title = 'Update';
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <section class="panel">
            <header class="panel-heading"><?php echo $title; ?> </header>
            <div class="panel-body">
                <div class="box box-primary">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'user-form',
                        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', "enctype" => "multipart/form-data"),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    ?>
                    <div class="box-body">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'username', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50, 'readonly' => $model->isNewRecord ? false : true)); ?>
                                <?php echo $form->error($model, 'username'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_firstname', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'user_firstname', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                                <?php echo $form->error($model, 'user_firstname'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_lastname', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'user_lastname', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                                <?php echo $form->error($model, 'user_lastname'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'role_id', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->dropDownList($model, 'role_id', Role::roleList(), array('class' => 'form-control')); ?>
                                <?php echo $form->error($model, 'role_id'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_email', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'user_email', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100)); ?>
                                <?php echo $form->error($model, 'user_email'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_phone', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'user_phone', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                                <?php echo $form->error($model, 'user_phone'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_company', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'user_company', array('class' => 'form-control', 'size' => 100, 'maxlength' => 100)); ?>
                                <?php echo $form->error($model, 'user_company'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_address', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textArea($model, 'user_address', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                                <?php echo $form->error($model, 'user_address'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'user_avatar', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                        <?php
                                        $uAvatar = UPLOAD_DIR . str_replace("\\", "/", $model->user_avatar);

                                        if (!file_exists($uAvatar)) {
                                            $uAvatar = "{$this->themeUrl}/images/avatar5.png";
                                        } else {
                                            $uAvatar = $this->createUrl("/" . $uAvatar);
                                        }
                                        ?>
                                        <img src="<?php echo $uAvatar; ?>" alt="AVATAR" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                            <?php echo $form->fileField($model, 'user_avatar', array("class" => "default")); ?>
                                        </span>
                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                    </div>
                                    <?php echo $form->error($model, 'user_avatar'); ?>
                                </div>

                            </div>
                        </div>

                        <?php if (!$model->isNewRecord): ?>
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
                        <?php endif; ?>


                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->checkBox($model, 'status', array('class' => 'js-switch')); ?>
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
<?php
$cs = Yii::app()->getClientScript();
$themeUrl = $this->themeUrl;
$cs_pos_end = CClientScript::POS_END;
$cs->registerCoreScript('jquery');
$cs->registerScriptFile($themeUrl . '/js/ios-switch/switchery.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/ios-switch/ios-init.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/bootstrap-fileupload.min.js', $cs_pos_end);
//$js = <<< EOD
//$(function(){
//    $('.timepicker-default').timepicker({
//        autoclose: true,
//        minuteStep: 5,
//     // showSeconds: true,
//     // showMeridian: false,
//     // defaultTime: '00:00:00'
//    });
//    //$(".sticky-timeline").niceScroll({styler: "fb", cursorcolor: "#65cea7", cursorwidth: '6', cursorborderradius: '0px', background: '#424f63', spacebarenabled: false, cursorborder: '0', zindex: '1000'});
//    $(".toggle_notes").on("click",function(){
//        $(this).closest(".timeline-desk").find(".panel-notes").slideToggle();
//    });
//
//    $("select#filter_role").on("change",function(){
//        _filter_val = $(this).val();
//         $("article.timeline-item").show();
//        if(_filter_val){
//            $("article.timeline-item").filter(function( index ) {
//                return ( $(this).data( "cat-id" ) != _filter_val );
//            }).hide();
//        }
//    });
//    $("#event-form").sticky({topSpacing:60});
//});
//EOD;
//$cs->registerScript('view', $js);
$cs->registerCssFile($themeUrl . '/js/ios-switch/switchery.css');
$cs->registerCssFile($themeUrl . '/css/bootstrap-fileupload.min.css');
?>