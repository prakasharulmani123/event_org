<?php
$roles = Role::roleList();
$event_types = EventLists::eventtypes();
?>
<div class="timeline-title m-bot15">
    <h3>
        <?php
        $this->widget('ext.editable.EditableField', array(
            'model' => $model,
            'attribute' => 'event_name',
            'title' => 'Change Timeline',
            'placement' => 'bottom',
            'url' => $this->createUrl('/site/event/timelineupdate'),
        ));
        ?>
    </h3>
    <p class="timeline-date">
        <?php
        $this->widget('ext.editable.EditableField', array(
            'type' => 'date',
            'model' => $model,
            'attribute' => 'event_date',
            'title' => 'Change Timeline Date',
            'placement' => 'bottom',
            'url' => $this->createUrl('/site/event/timelineupdate'),
        ));
        ?>
    </p>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'event-form',
                    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal adminex-form text-center container'),
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => false,
                    ),
                    'enableAjaxValidation' => true,
                ));
                ?>
                <div class="form-group ">
                    <div class="col-lg-3">
                        <?php echo $form->labelEx($frmModel, 'list_title', array('class' => 'control-label')); ?>
                        <?php echo $form->textField($frmModel, 'list_title', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($frmModel, 'list_title'); ?>
                    </div>
                    <div class="col-lg-2">
                        <?php echo $form->labelEx($frmModel, 'timing_start', array('class' => 'control-label')); ?>
                        <?php echo $form->textField($frmModel, "timing_start", array("class" => "form-control timepicker-default time-field")); ?>
                        <?php echo $form->error($frmModel, 'timing_start'); ?>
                    </div>
                    <div class="col-lg-2">
                        <?php echo $form->labelEx($frmModel, 'list_role', array('class' => 'control-label')); ?>
                        <?php echo $form->dropDownList($frmModel, "list_role", $roles, array("class" => "form-control m-bot15", "prompt" => "Select Category")); ?>
                        <?php echo $form->error($frmModel, 'list_role'); ?>
                    </div>
                    <div class="col-lg-2">
                        <?php echo $form->labelEx($frmModel, 'event_type', array('class' => 'control-label')); ?>
                        <?php echo $form->dropDownList($frmModel, "event_type", $event_types, array("class" => "form-control m-bot15", "prompt" => "Select Type")); ?>
                        <?php echo $form->error($frmModel, 'event_type'); ?>
                    </div>
                    <div class="col-lg-2">
                        <label class=" control-label"> <p>&nbsp;  </p> </label>
                        <?php echo CHtml::submitButton('ADD', array('class' => 'btn btn-success', "style" => "margin-top:25px;")); ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
                <div class="form-horizontal adminex-form">
                    <div class="form-group ">
                        <div class="col-lg-4 col-lg-offset-8">
                            <label class=" control-label">Filter By</label>
                            <?php echo CHtml::dropDownList("filter_role", '', $roles, array("class" => "form-control m-bot15", "empty" => "ALL")); ?>
                        </div>
                    </div>
                </div>

                <div class="sticky-timeline">
                    <div class="timeline">
                        <?php foreach ($model->eventlists as $k => $list): ?>
                            <article class="timeline-item <?php echo ($k % 2 == 0) ? "alt" : "" ?>" data-cat-id="<?php echo $list->list_role; ?>">
                                <div class="timeline-desk">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <span class="arrow"></span>
                                            <span class="timeline-icon"></span>
                                            <p>
                                                <?php
                                                $this->widget('ext.editable.EditableField', array(
                                                    'model' => $list,
                                                    'attribute' => 'timing_start',
                                                    'title' => 'Change Time',
                                                    'url' => $this->createUrl('/site/event/notesupdate'),
                                                    'inputclass' => 'timepicker-default',
                                                ));
                                                echo "-";
                                                $this->widget('ext.editable.EditableField', array(
                                                    'model' => $list,
                                                    'attribute' => 'list_title',
                                                    'title' => 'Change Name',
                                                    'url' => $this->createUrl('/site/event/notesupdate'),
                                                    'htmlOptions' => array('class' => 'event_name')
                                                ));
                                                echo "<br />";
                                                $this->widget('ext.editable.EditableField', array(
                                                    'model' => $list,
                                                    'attribute' => 'list_role',
                                                    'source' => $roles,
                                                    'type' => 'select',
                                                    'title' => 'Change Category',
                                                    'url' => $this->createUrl('/site/event/notesupdate'),
                                                    'inputclass' => 'input-md',
                                                    'htmlOptions' => array('class' => 'event_name')
                                                ));
                                                echo "<br />";
                                                $this->widget('ext.editable.EditableField', array(
                                                    'model' => $list,
                                                    'attribute' => 'event_type',
                                                    'source' => $event_types,
                                                    'type' => 'select',
                                                    'title' => 'Change Type',
                                                    'url' => $this->createUrl('/site/event/notesupdate'),
                                                    'inputclass' => 'input-md',
                                                    'htmlOptions' => array('class' => 'event_name')
                                                ));
                                                ?>
                                            </p>
                                            <p>
                                                <?php echo CHtml::link('<i class="fa fa-chevron-circle-down"></i>', 'javascript:void(0);', array('class' => 'toggle_notes')) ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="panel panel-notes">
                                        <div class="panel-body"><i>NOTES:</i><br /> <span class="data_notes">
                                                <?php
                                                $this->widget('ext.editable.EditableField', array(
                                                    'type' => 'textarea',
                                                    'model' => $list,
                                                    'attribute' => 'timing_notes',
                                                    'title' => 'Enter notes',
//                                                'text' => '<i class="fa fa-chevron-circle-down"></i>',
//                                                'encode' => false,
                                                    'url' => $this->createUrl('/site/event/notesupdate'),
//                                                'htmlOptions' => array('data-value' => $list->timing_notes),
//                                                'options' => array('autovalue' => false, 'display' => false),
//                                                'success' => 'function(response, newValue) { if(response.status != "error")  { $notesDiv = $(this).closest(".timeline-desk").find(".panel-notes .data_notes"); if(!$notesDiv.length){  $(this).closest(".timeline-desk").append(\'<div class="panel panel-notes"><div class="panel-body"><i>NOTES:</i><br /> <span class="data_notes">\'+newValue+\'</span></div></div>\'); }else{ $notesDiv.html(newValue); } } }'
                                                ));
                                                ?>
                                            </span></div>
                                    </div>
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
$cs->registerScriptFile($themeUrl . '/js/jquery.sticky.js', $cs_pos_end);
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
    $(".toggle_notes").on("click",function(){
        $(this).closest(".timeline-desk").find(".panel-notes").slideToggle();
    });

    $("select#filter_role").on("change",function(){
        _filter_val = $(this).val();
         $("article.timeline-item").show();
        if(_filter_val){
            $("article.timeline-item").filter(function( index ) {
                return ( $(this).data( "cat-id" ) != _filter_val );
            }).hide();
        }
    });
    $("#event-form").sticky({topSpacing:60});
});
EOD;
$cs->registerScript('view', $js);
$cs->registerCssFile($themeUrl . '/js/bootstrap-timepicker/css/timepicker.css');
?>