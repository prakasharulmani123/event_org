<?php
/* @var $this EventController */
/* @var $model Event */
$this->title = $model->event_name;
$this->breadcrumbs = array($model->event_date => '#');
?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'event-form',
                    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal adminex-form'),
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => false,
                    ),
                    'enableAjaxValidation' => true,
                ));
                ?>
                <div class="form-group ">
                    <div class="col-lg-4">
                        <?php echo $form->labelEx($frmModel, 'list_title', array('class' => 'control-label')); ?>
                        <?php echo $form->textField($frmModel, 'list_title', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($frmModel, 'list_title'); ?>
                    </div>
                    <div class="col-lg-3 timefields">
                        <?php echo $form->labelEx($frmModel, 'time', array('class' => 'control-label')); ?>
                        <div></div>
                        <?php echo $form->textField($frmModel, "timing_start", array("class" => "form-control timepicker-default time-field")); ?>
                        <span>  :  </span>
                        <?php echo $form->textField($frmModel, "timing_end", array("class" => "form-control timepicker-default time-field")); ?>
                        <?php echo $form->error($frmModel, 'timing_start'); ?>
                        <?php echo $form->error($frmModel, 'timing_end'); ?>
                    </div>
                    <div class="col-lg-3">
                        <?php echo $form->labelEx($frmModel, 'list_role', array('class' => 'control-label')); ?>
                        <?php echo $form->dropDownList($frmModel, "list_role", Role::roleList(), array("class" => "form-control m-bot15","prompt" => "Select Category")); ?>
                        <?php echo $form->error($frmModel, 'list_role'); ?>
                    </div>
                    <div class="col-lg-2">
                        <label class=" control-label"> <p>&nbsp;  </p> </label>
                        <?php echo CHtml::submitButton('ADD', array('class' => 'btn btn-primary', "style" => "margin-top:25px;")); ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>


                <div class="sticky-timeline">
                <div class="timeline">
                    <?php foreach ($model->eventlists as $k => $list): ?>
                        <article class="timeline-item <?php echo ($k % 2 == 0) ? "alt" : "" ?>">
                            <div class="timeline-desk">
                                <div class="panel">
                                    <div class="panel-body">
                                        <span class="arrow"></span>
                                        <span class="timeline-icon"></span>
                                        <span class="timeline-date"><?php echo date('h:i A', strtotime($list->timing_start)); ?></span>
                                        <p><?php echo date('h:i A', strtotime($list->timing_start)); ?> <?php echo strlen($list->list_title) > 8 ? substr($list->list_title, 0, 6) . '..' : $list->list_title ?></p>
                                        <p>
                                            <?php
                                            $this->widget('ext.editable.EditableField', array(
                                                'type' => 'textarea',
                                                'model' => $list,
                                                'attribute' => 'timing_notes',
                                                'title' => 'Enter notes',
                                                'text' => '<i class="fa fa-chevron-circle-down"></i>',
                                                'encode' => false,
                                                'url' => $this->createUrl('/site/event/notesupdate'),
                                                'htmlOptions' => array('data-value' => $list->timing_notes),
                                                'options' => array('autovalue' => false, 'display' => false),
                                                'success' => 'function(response, newValue) { if(response.status != "error")  { $notesDiv = $(this).closest(".timeline-desk").find(".panel-notes .data_notes"); if(!$notesDiv.length){  $(this).closest(".timeline-desk").append(\'<div class="panel panel-notes"><div class="panel-body"><i>NOTES:</i><br /> <span class="data_notes">\'+newValue+\'</span></div></div>\'); }else{ $notesDiv.html(newValue); } } }'
                                            ));
                                            ?>
    <!--                                            <a href="javascript:void(0);" data-placement="top"  data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?"><i class="fa fa-chevron-circle-down"></i></a>-->
                                        </p>
                                    </div>
                                </div>
                                <?php if ($list->timing_notes): ?>
                                    <div class="panel panel-notes">
                                        <div class="panel-body"><i>NOTES:</i><br /> <span class="data_notes"><?php echo $list->timing_notes; ?></span></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php
$cs = Yii::app()->getClientScript();
$themeUrl = $this->themeUrl;
$cs_pos_end = CClientScript::POS_END;
$cs->registerCoreScript('jquery');
$cs->registerScriptFile($themeUrl . '/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/bootstrap-timepicker/js/bootstrap-timepicker.js', $cs_pos_end);
$js = <<< EOD
$(function(){
    $('.timepicker-default').timepicker({
        autoclose: true,
        minuteStep: 5,
     // showSeconds: true,
     // showMeridian: false,
     // defaultTime: '00:00:00'
    });
    //$(".sticky-timeline").niceScroll({styler: "fb", cursorcolor: "#65cea7", cursorwidth: '6', cursorborderradius: '0px', background: '#424f63', spacebarenabled: false, cursorborder: '0', zindex: '1000'});

});
EOD;
$cs->registerScript('view', $js);
$cs->registerCssFile($themeUrl . '/js/bootstrap-timepicker/css/timepicker.css');
?>