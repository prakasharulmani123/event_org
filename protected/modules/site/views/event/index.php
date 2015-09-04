<?php
/* @var $this EventController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Events';
$this->breadcrumbs = array(
    'Events',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                Manage Event                <?php
                $this->widget(
                        'application.components.MyTbButton', array(
                    'label' => 'Create Event',
                    'icon' => 'fa fa-plus',
                    'url' => array('/site/event/create'),
                    'buttonType' => 'link',
                    'context' => 'success',
                    'htmlOptions' => array('class' => 'pull-right btn-sm mtm5'),
                        )
                );
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">

                    <?php
                    $array_params = array(1,2);
                    $gridColumns = array(
                        'event_name',
                        array(
                            'name' => 'event_date',
                            'value' => '($data->event_date == 0000-00-00) ? "Not Set" : date_format(new DateTime($data->event_date), "Y-m-d")',
                            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'attribute' => 'event_date',
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeYear' => 'true',
                                    'changeMonth' => 'true',
                                    'showAnim' => 'slide',
                                    'yearRange' => '1900:' . (date('Y') + 1),
                                    'buttonImage' => Yii::app()->request->baseUrl . '/images/calendar.png',
                                ),
                                'htmlOptions' => array(
                                    'id' => 'event_date',
                                    'class' => 'form-control',
                                ),
                                    ), true),
                        ),
                        array(
                            'name' => 'userlist',
                            'filter' => false,
                        ),
//                        'event_date',
//                        array(
//                            'name' => 'event_users',
//                            'filter' => $this->widget('zii.widgets.jui.CJuiAutoComplete', $array_params, true),
//                        ),
//                        'userlist',
                        array(
                            'name' => 'status',
                            'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle'),
                            'type' => 'raw',
                            'value' => function($data) {
                        echo ($data->status == 1) ? '<i class="fa fa-circle text-green"></i>' : '<i class="fa fa-circle text-red"></i>';
                    },
                            'filter' => array('1' => 'Active', '0' => 'In-active'),
                        ),
                        array(
                            'header' => 'Actions',
                            'class' => 'application.components.MyActionButtonColumn',
                            'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                            'template' => '{view} {update} {delete}',
                            'viewButtonIcon' => 'fa fa-eye',
                            'updateButtonIcon' => 'fa fa-pencil',
                            'deleteButtonIcon' => 'fa fa-trash-o',
                        )
                    );

                    $this->widget('booster.widgets.TbExtendedGridView', array(
                        'filter' => $model,
                        'afterAjaxUpdate' => 'reInstallDatepicker',
                        'type' => 'striped bordered datatable',
                        'dataProvider' => $model->dataProvider(),
                        'responsiveTable' => true,
                        'template' => '<div class="panel panel-primary"><div class="panel-body">{items}{pager}</div><div class="panel-body row"><div class="col-lg-6"><div class="dataTables_info" id="editable-sample_info">{summary}</div></div></div></div>',
                        'columns' => $gridColumns,
                        'emptyText' => 'Ops, nothing to show!',
                            )
                    );
                    ?>

                </div>
            </div>
        </section>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript('for-date-picker', "
function reInstallDatepicker(id, data){
$('#event_date').datepicker({'dateFormat':'yy-mm-dd'});
}
");
?>