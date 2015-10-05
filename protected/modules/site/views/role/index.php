<?php
/* @var $this RoleController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Categories';
$this->breadcrumbs = array(
    'Categories',
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
                Manage Category <?php
        $this->widget(
                'application.components.MyTbButton', array(
            'label' => 'Create Category',
            'icon' => 'fa fa-plus',
            'url' => array('/site/role/create'),
            'buttonType' => 'link',
            'context' => 'success',
            'htmlOptions' => array('class' => 'pull-right btn-sm mtm5'),
                )
        );
        ?></header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <?php
                    $gridColumns = array(
                        'role_name',
//                        'rank',
                        array(
                            'name' => 'status',
                            'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle'),
                            'type' => 'raw',
                            'value' => function($data) {
                        echo ($data->status == 1) ? '<i class="fa fa-circle text-green"></i>' : '<i class="fa fa-circle text-red"></i>';
                    },
                            'filter'=> array('1' => 'Active', '0' => 'In-active'),
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
//                        'filter' => $model,
                        'type' => 'striped bordered datatable',
                        'dataProvider' => $model->dataProvider(),
                        'responsiveTable' => true,
                        'template' => '<div class="panel panel-primary"><div class="panel-body">{items}{pager}</div><div class="panel-body row"><div class="col-lg-6"><div class="dataTables_info" id="editable-sample_info">{summary}</div></div></div></div>',
                        'columns' => $gridColumns,
                            )
                    );
                    ?>

                </div>
            </div>
        </section>
    </div>
</div>