<?php
/* @var $this EventController */
/* @var $model Event */
$this->title = $event->event_name;
$this->breadcrumbs = array($event->event_date => '#');
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
                $role_lists = Role::roleList();
                ?>
                <div class="form-group ">
                    <div class="col-lg-6">
                        <?php echo $form->textField($frmModel, 'evt_vendor_name', array('class' => 'form-control m-bot15', 'size' => 60, 'maxlength' => 255, 'placeholder' => $frmModel->getAttributeLabel('evt_vendor_name'))); ?>
                        <?php echo $form->error($frmModel, 'evt_vendor_name'); ?>
                    </div>
                    <div class="col-lg-6">
                        <?php echo $form->textField($frmModel, 'evt_vendor_email', array('class' => 'form-control m-bot15', 'size' => 60, 'maxlength' => 255, 'placeholder' => $frmModel->getAttributeLabel('evt_vendor_email'))); ?>
                        <?php echo $form->error($frmModel, 'evt_vendor_email'); ?>
                    </div>
                    <div class="col-lg-6">
                        <?php echo $form->textField($frmModel, 'evt_vendor_phone', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255, 'placeholder' => $frmModel->getAttributeLabel('evt_vendor_phone'))); ?>
                        <?php echo $form->error($frmModel, 'evt_vendor_phone'); ?>
                    </div>
                    <div class="col-lg-4">
                        <?php echo $form->dropDownList($frmModel, "evt_vendor_role", $role_lists, array("class" => "form-control", "prompt" => "Select Category")); ?>
                        <?php echo $form->error($frmModel, 'evt_vendor_role'); ?>
                    </div>
                    <div class="col-lg-2">
                        <label class=" control-label"> <p>&nbsp;  </p> </label>
                        <?php echo CHtml::submitButton('ADD', array('class' => 'btn btn-primary')); ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>


                <?php
                $gridColumns = array(
                    array(
                        'class' => 'ext.editable.EditableColumn',
                        'name' => 'evt_vendor_name',
                        'editable' => array('url' => $this->createUrl('/site/event/updateVendor'))
                    ),
                    array(
                        'class' => 'ext.editable.EditableColumn',
                        'name' => 'evt_vendor_email',
                        'editable' => array('url' => $this->createUrl('/site/event/updateVendor'))
                    ),
                    array(
                        'class' => 'ext.editable.EditableColumn',
                        'name' => 'evt_vendor_phone',
                        'editable' => array('url' => $this->createUrl('/site/event/updateVendor'))
                    ),
                    array(
                            'class' => 'ext.editable.EditableColumn',
                            'name' => 'evt_vendor_role',
                            'filter'=> $role_lists,
                            'editable' => array(
                                'type' => 'select',
                                'url' => $this->createUrl('/site/event/updateVendor'),
                                'source' => $role_lists,
//                                'options' => array(
//                                    'display' => 'js: function(value, sourceData) {
//                                        var selected = $.grep(sourceData, function(o){ return value == o.value; }),
//                                        colors = {1: "green", 2: "blue", 3: "red", 4: "gray"};
//                                        $(this).text(selected[0].text).css("color", colors[value]);
//                                    }',
//                                    'onSave' => 'js: function(e, params) {
//                                        console && console.log("saved value: "+params.newValue);
//                                    }',
//                                ),
                            )
                        ),
                );

                $this->widget('booster.widgets.TbExtendedGridView', array(
                    'filter' => $model,
                    'type' => 'striped bordered datatable',
                    'dataProvider' => $model->dataProvider(),
                    'responsiveTable' => true,
                    'template' => '<div class="panel panel-primary"><div class="panel-body">{items}{pager}</div><div class="panel-body row"><div class="col-lg-6"><div class="dataTables_info" id="editable-sample_info">{summary}</div></div></div></div>',
                    'columns' => $gridColumns,
                    'emptyText' => 'Oops, nothing to show!',
                        )
                );
                ?>

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