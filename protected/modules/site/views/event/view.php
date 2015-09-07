<?php
/* @var $this EventController */
/* @var $model Event */

$this->title = 'View Event: ' . $model->event_name;
$this->breadcrumbs = array(
    'Events' => array('index'),
    'View ' . 'Event',
);
?>
<div class="user-view">
    <?php if ($export == false) {
        ?>
        <p>
            <?php
            $this->widget(
                    'application.components.MyTbButton', array(
                'label' => 'Update',
                'url' => array('update', 'id' => $model->event_id),
                'buttonType' => 'link',
                'context' => 'primary',
                'visible' => UserIdentity::checkAdmin(),
                    )
            );
            echo "&nbsp;&nbsp;";
            $this->widget(
                    'application.components.MyTbButton', array(
                'label' => 'Delete',
                'url' => array('delete', 'id' => $model->event_id),
                'buttonType' => 'link',
                'context' => 'danger',
                'htmlOptions' => array('confirm' => 'Are you sure you want to delete this item?'),
                'visible' => UserIdentity::checkAdmin(),
                    )
            );
            echo "&nbsp;&nbsp;";
//            $this->widget(
//                    'application.components.MyTbButton', array(
//                'label' => 'Download',
//                'url' => array('view', 'id' => $model->event_id, 'export' => 'PDF'),
//                'buttonType' => 'link',
//                'context' => 'warning',
//                    )
//            );
            ?>
        </p>
    <?php }
    ?>
    <?php if ($export) { ?>
        <h3 class="text-center"><?php echo $this->title ?></h3>
        <?php
    }
    ?>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
        'attributes' => array(
//            'event_id',
            'event_name',
            'event_date',
            'userlist',
            array(
                'name' => 'Active',
                'type' => 'raw',
                'value' => $model->status == 1 ? '<i class="fa fa-circle text-green"></i>' : '<i class="fa fa-circle text-red"></i>'
            ),
        ),
    ));
    ?>

    <section class="panel">
        <header class="panel-heading">Event List</header>
        <div class="panel-body">
            <div class="adv-table">
                <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                        <tr>
                            <th><?php echo EventLists::model()->getAttributeLabel('list_title'); ?></th>
                            <th><?php echo EventLists::model()->getAttributeLabel('timing_start'); ?></th>
                            <th><?php echo EventLists::model()->getAttributeLabel('timing_end'); ?></th>
                            <th class="hidden-phone"><?php echo EventLists::model()->getAttributeLabel('timing_notes'); ?></th>
                            <th style="width: 50px;">Make Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model->eventlists as $list): ?>
                            <tr class="gradeX">
                                <td><?php echo $list->list_title; ?></td>
                                <td><?php echo $list->timing_start; ?></td>
                                <td><?php echo $list->timing_end; ?></td>
                                <td class="center hidden-phone"><?php echo $list->timing_notes; ?></td>
                                <td>
                                    <?php
                                    $this->widget(
                                            'booster.widgets.TbButton', array(
                                        'icon' => 'fa fa-clock-o',
                                        'label' => '',
                                        'context' => 'primary',
                                        'htmlOptions' => array(
                                            'data-toggle' => 'modal',
                                            'data-target' => '#myModal',
                                            'onclick' => "{
                                                $('#event_list_id').val('$list->timing_id');
                                                $('#list_title').val('$list->list_title');
                                                $('#timing_start, #event_hist_from').val('$list->timing_start');
                                                $('#timing_end, #event_hist_to').val('$list->timing_end');
                                                }
                                            "
                                        ),
                                            )
                                    );
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="panel">
        <header class="panel-heading">Event History</header>
        <div class="panel-body">
            <div class="adv-table">
                <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                        <tr>
                            <th><?php echo EventLists::model()->getAttributeLabel('list_title'); ?></th>
                            <th><?php echo EventHistory::model()->getAttributeLabel('event_hist_from'); ?></th>
                            <th><?php echo EventHistory::model()->getAttributeLabel('event_hist_to'); ?></th>
                            <th><?php echo EventHistory::model()->getAttributeLabel('event_hist_excess_time'); ?></th>
                            <th><?php echo EventHistory::model()->getAttributeLabel('event_hist_reason'); ?></th>
                            <th><?php echo EventHistory::model()->getAttributeLabel('created_by'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        <?php foreach ($model->eventlists as $list): ?>
                            <?php foreach ($list->eventHistories as $history): ?>
                                <tr class="gradeX">
                                    <td><?php echo $list->list_title; ?></td>
                                    <td><?php echo $history->event_hist_from; ?></td>
                                    <td><?php echo $history->event_hist_to; ?></td>
                                    <td><?php echo $history->event_hist_excess_time; ?></td>
                                    <td><?php echo $history->event_hist_reason; ?></td>
                                    <td><?php echo $history->createdBy->fullname; ?></td>
                                </tr>
                            <?php $i++; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                            <?php if($i == 0){ ?>
                                <tr class="gradeX">
                                    <td colspan="6">No data found</td>
                                </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <?php
    $this->beginWidget(
            'booster.widgets.TbModal', array('id' => 'myModal')
    );
    ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Make Time</h4>
    </div>
    <div class="modal-body">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'event-history-form',
            'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'enableAjaxValidation' => true,
        ));
        echo $form->hiddenField($history_model, 'event_list_id', array('id' => 'event_list_id'));
        echo $form->hiddenField($history_model, 'event_hist_from', array('id' => 'event_hist_from'));
        echo $form->hiddenField($history_model, 'event_hist_to', array('id' => 'event_hist_to'));
        ?>
        <div class="form-group">
            <label class="col-sm-3 control-label required"><?php echo $model->getAttributeLabel('list_title'); ?> <span class="required">*</span></label>
            <div class="col-sm-5">
                <?php echo CHtml::textField('list_title', '', array('class' => 'form-control', 'readonly' => true, 'id' => 'list_title')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label required"><?php echo $model->getAttributeLabel('timing_start'); ?> <span class="required">*</span></label>
            <div class="col-sm-5">
                <?php echo CHtml::textField('timing_start', '', array('class' => 'form-control', 'readonly' => true, 'id' => 'timing_start')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label required"><?php echo $model->getAttributeLabel('timing_end'); ?> <span class="required">*</span></label>
            <div class="col-sm-5">
                <?php echo CHtml::textField('timing_end', '', array('class' => 'form-control', 'readonly' => true, 'id' => 'timing_end')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($history_model, 'event_hist_excess_time', array('class' => 'col-sm-3 control-label')); ?>
            <div class="col-sm-5">
                <div class="input-group bootstrap-timepicker">
                    <?php echo $form->textField($history_model, 'event_hist_excess_time', array('class' => 'form-control timepicker-default')); ?>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                    </span>
                </div>
                <?php echo $form->error($history_model, 'event_hist_excess_time'); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($history_model, 'event_hist_reason', array('class' => 'col-sm-3 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->textArea($history_model, 'event_hist_reason', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->error($history_model, 'event_hist_reason'); ?>
            </div>
        </div>
        <?php echo CHtml::submitButton($history_model->isNewRecord ? 'Create' : 'Save', array('class' => $history_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
        <?php $this->endWidget(); ?>
    </div>
    <?php $this->endWidget(); ?>
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
        showSeconds: true,
        showMeridian: false,
        defaultTime: '00:00:00'
    });
});
EOD;
$cs->registerScript('view', $js);
$cs->registerCssFile($themeUrl . '/js/bootstrap-timepicker/css/timepicker.css');
?>