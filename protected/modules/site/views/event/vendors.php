<div class="timeline-title m-bot15">
    <h3>
        <?php
        $this->widget('ext.editable.EditableField', array(
            'model' => $event,
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
            'model' => $event,
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
                    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal adminex-form'),
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => false,
                    ),
                    'enableAjaxValidation' => true,
                ));
                $role_lists = Role::roleList();
                echo $form->hiddenField($frmModel, 'evt_vendor');
                ?>
                <div class="form-group ">
                    <div class="col-lg-4">
                        <?php
                        echo CHtml::dropDownList('category_id', '', $role_lists, array(
                            "class" => "form-control",
                            'prompt' => 'Select Category',
                            'ajax' => array(
                                'type' => 'POST', //request type
                                'url' => CController::createUrl('/site/event/getusers'), //url to call.
                                'update' => '#EventVendors_evt_user_id',
                        )));
                        ?>
                    </div>
                    <div class="col-lg-4">
                        <?php echo $form->dropDownList($frmModel, "evt_user_id", array(), array("class" => "form-control", "prompt" => "Select Users")); ?>
                        <?php echo $form->error($frmModel, 'evt_user_id'); ?>
                    </div>
                    <div class="col-lg-1">
                        <?php echo CHtml::submitButton('ADD', array('class' => 'btn btn-success', 'id' => 'add-edit')); ?>
                    </div>
                    <div class="col-lg-1">
                        <?php echo CHtml::resetButton('Cancel', array('class' => 'btn', 'onclick' => '$("#event-form").reset();')); ?>
                    </div>
                    <div class="col-lg-2">
                        <?php echo CHtml::link('+ Add Vendor','#', array('id' => 'add-vendor', 'data-toggle' => 'modal', 'data-target' => '#addVendor','class'=>'pull-right')); ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>


                <?php
                $gridColumns = array(
                    array(
                        'name' => 'evt_user_id',
                        'value' => '$data->evtUser->fullname'
                    ),
                    array(
                        'header' => 'Role',
                        'value' => '$data->evtUser->role->role_name'
                    ),
                    array(
                        'header' => 'Actions',
                        'class' => 'application.components.MyActionButtonColumn',
                        'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                        'template' => '{delete_vendor}',
                        'buttons' => array(
                            'delete_vendor' => array(
                                'url' => 'Yii::app()->createUrl("/site/event/vendorsdelete", array("id"=>$data->evt_vendor))',
                                'label' => '<i class="glyphicon glyphicon-trash"></i>',
                                'options' => array('title' => 'Delete', 'class' => 'delete', 'confirm' => "Are you sure want to delete?"),
                            ),
                        ),
                    ),
                );

                $this->widget('booster.widgets.TbExtendedGridView', array(
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
$this->beginWidget(
        'booster.widgets.TbModal', array('id' => 'addVendor')
);
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4 id="modelTitle">Add Vendor</h4>
</div>
<div class="modal-body">
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
            <?php echo $form->labelEx($userModel, 'username', array('class' => 'col-sm-3 control-label')); ?>
            <div class="col-sm-5">
                <?php echo $form->textField($userModel, 'username', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50, 'readonly' => $userModel->isNewRecord ? false : true)); ?>
                <?php echo $form->error($userModel, 'username'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($userModel, 'user_firstname', array('class' => 'col-sm-3 control-label')); ?>
            <div class="col-sm-5">
                <?php echo $form->textField($userModel, 'user_firstname', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                <?php echo $form->error($userModel, 'user_firstname'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($userModel, 'user_lastname', array('class' => 'col-sm-3 control-label')); ?>
            <div class="col-sm-5">
                <?php echo $form->textField($userModel, 'user_lastname', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                <?php echo $form->error($userModel, 'user_lastname'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($userModel, 'role_id', array('class' => 'col-sm-3 control-label')); ?>
            <div class="col-sm-5">
                <?php echo $form->dropDownList($userModel, 'role_id', Role::roleList(), array('class' => 'form-control','prompt'=>'Select Role')); ?>
                <?php echo $form->error($userModel, 'role_id'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($userModel, 'user_email', array('class' => 'col-sm-3 control-label')); ?>
            <div class="col-sm-5">
                <?php echo $form->textField($userModel, 'user_email', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100)); ?>
                <?php echo $form->error($userModel, 'user_email'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($userModel, 'user_phone', array('class' => 'col-sm-3 control-label')); ?>
            <div class="col-sm-5">
                <?php echo $form->textField($userModel, 'user_phone', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                <?php echo $form->error($userModel, 'user_phone'); ?>
            </div>
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
        <div class="form-group">
            <div class="col-sm-0 col-sm-offset-4">
                <?php echo CHtml::submitButton($userModel->isNewRecord ? 'Create' : 'Save', array('class' => $userModel->isNewRecord ? 'btn btn-success' : 'btn btn-success')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php $this->endWidget(); ?>

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

function vendorEdit(id){
        alert("jojo");
//    $('input[name="parent"]').val(10);
    // or, in case you added a class to the column
    // $('some-grid table.items th.parent input').val(10);
}

EOD;
$cs->registerScript('view', $js);
$cs->registerCssFile($themeUrl . '/js/bootstrap-timepicker/css/timepicker.css');
?>
