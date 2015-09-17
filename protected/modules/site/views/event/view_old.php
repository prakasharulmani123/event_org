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
                'name' => 'created_by',
                'value' => $model->createdBy->fullname
            ),
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
                <table  class="display table table-bordered table-striped" id="dynamic-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th style="width: 15%;"><?php echo EventLists::model()->getAttributeLabel('list_title'); ?></th>
                            <th style="width: 10%;"><?php echo EventLists::model()->getAttributeLabel('event_type'); ?></th>
                            <th style="width: 10%;"><?php echo EventLists::model()->getAttributeLabel('timing_start'); ?></th>
                            <th style="width: 10%;"><?php echo EventLists::model()->getAttributeLabel('timing_end'); ?></th>
                            <th style="width: 25%;"class="hidden-phone"><?php echo EventLists::model()->getAttributeLabel('timing_notes'); ?></th>
                            <?php if (!UserIdentity::checkAdmin()) { ?>
                                <th style="width: 30%;">Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model->eventlists as $list): ?>
                            <tr class="gradeX">
                                <td><?php echo $list->list_title; ?></td>
                                <td><?php echo $list->eventtypes($list->event_type); ?></td>
                                <td><?php echo date('h:i A', strtotime($list->timing_start)); ?></td>
                                <td><?php echo date('h:i A', strtotime($list->timing_end)); ?></td>
                                <td class="center hidden-phone"><?php echo $list->timing_notes; ?></td>
                                <?php if (!UserIdentity::checkAdmin()) { ?>
                                    <td>
                                        <?php
                                        if ($list->event_type == 'FL' /*&& $list->event_adjusted == 'N'*/) {
                                            $this->widget(
                                                    'booster.widgets.TbButton', array(
                                                'icon' => 'fa fa-minus',
                                                'label' => 'Make Time',
                                                'context' => 'info',
                                                'htmlOptions' => array(
                                                    'data-toggle' => 'modal',
                                                    'data-target' => '#myModal',
                                                    'onclick' => "{
                                                $('#event_list_id').val('$list->timing_id');
                                                $('#list_title').val('$list->list_title');
                                                $('#timing_start, #event_hist_from').val('$list->timing_start');
                                                $('#timing_end, #event_hist_to').val('$list->timing_end');
                                                $('#event_hist_time_separator').val('-');
                                                $('#modelTitle').html('Make Time');
                                                $('#event_hist_type').val('MT');
                                                }
                                            "
                                                ),
                                                    )
                                            );
                                            echo '&nbsp;&nbsp;';
                                            $this->widget(
                                                    'booster.widgets.TbButton', array(
                                                'icon' => 'fa fa-plus',
                                                'label' => 'Push Time',
                                                'context' => 'warning',
                                                'htmlOptions' => array(
                                                    'data-toggle' => 'modal',
                                                    'data-target' => '#myModal',
                                                    'onclick' => "{
                                                $('#event_list_id').val('$list->timing_id');
                                                $('#list_title').val('$list->list_title');
                                                $('#timing_start, #event_hist_from').val('$list->timing_start');
                                                $('#timing_end, #event_hist_to').val('$list->timing_end');
                                                $('#event_hist_time_separator').val('+');
                                                $('#modelTitle').html('Push Time');
                                                $('#event_hist_type').val('PT');
                                                }
                                            "
                                                ),
                                                    )
                                            );
                                        }
                                        ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <?php $i = 0; ?>
    <div class="timeline">
        <?php foreach ($model->eventlists as $list): ?>
           
                <article class="timeline-item alt">
                    <div class="text-right">
                        <div class="time-show first">
                            <a data-original-title="<?php echo $list->list_title; ?>" data-placement="top" data-toggle="tooltip " href="#" class="btn btn-primary tooltips" title="<?php echo $list->list_title; ?>"><?php echo strlen($list->list_title) > 20 ? substr($list->list_title, 0, 17).'..' : $list->list_title; echo '<br />'.date('h:i A', strtotime($list->timing_start)).'-'.date('h:i A', strtotime($list->timing_end)); ?></a>
                        </div>
                    </div>
                </article>
                <?php foreach ($list->eventHistories as $history): ?>
                    <article class="timeline-item <?php echo $i % 2 ? '' : 'alt' ?>">
                        <div class="timeline-desk">
                            <div class="panel">
                                <div class="panel-body">
                                    <span class="arrow<?php echo $i % 2 ? '' : '-alt' ?>"></span>
                                    <span class="timeline-icon"></span>
                                    <h1 class="<?php echo $i % 2 ? 'red' : 'green' ?>"><b><?php echo date('h:i A', strtotime($history->event_hist_new_to)); ?></b></h1>
                                    <h1 class="<?php echo $i % 2 ? 'green' : 'red' ?>"><?php echo $history->historytype($history->event_hist_type); ?> : <?php echo date('H', strtotime($history->event_hist_excess_time)).' hours '.date('i', strtotime($history->event_hist_excess_time)).' minutes '.date('s', strtotime($history->event_hist_excess_time)).' sec'; ?></h1>
                                    <p><?php echo $history->event_hist_reason; ?></p>
                                    <p>By: <?php echo $history->createdBy->fullname; ?></p>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php $i++; ?>
                <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php
$this->beginWidget(
        'booster.widgets.TbModal', array('id' => 'myModal')
);
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4 id="modelTitle">Push Time</h4>
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
    echo $form->hiddenField($history_model, 'event_hist_time_separator', array('id' => 'event_hist_time_separator'));
    echo $form->hiddenField($history_model, 'event_hist_type', array('id' => 'event_hist_type'));
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