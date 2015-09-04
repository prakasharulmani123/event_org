<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Users';
$this->breadcrumbs = array(
    'Users',
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
            <header class="panel-heading">Manage User
                    <?php
                    $this->widget('application.components.MyTbButton', array(
                        'label' => 'Create User',
                        'icon' => 'fa fa-plus',
                        'url' => array('/site/user/create'),
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
                    $gridColumns = array(
                        'username',
                        'user_firstname',
                        'user_lastname',
                        array(
                            'name' => 'role_id',
                            'value' => '$data->role->role_name',
                            'filter' => Role::roleList()
                        ),
                        /*
                          'user_email',
                          'user_phone',
                          'user_address',
                          array(
                          'name' => 'status',
                          'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle'),
                          'type' => 'raw',
                          'value' => function($data) {
                          echo ($data->status == 1) ? '<i class="fa fa-circle text-green"></i>' : '<i class="fa fa-circle text-red"></i>';
                          },
                          ),
                         */
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
                        'type' => 'striped bordered datatable',
                        'dataProvider' => $model->dataProvider(),
                        'responsiveTable' => true,
                        'template' => '<div class="panel panel-primary"><div class="panel-body">{items}{pager}</div><div class="panel-body row"><div class="col-lg-6"><div class="dataTables_info" id="editable-sample_info">{summary}</div></div></div></div>',
                        'columns' => $gridColumns
                            )
                    );
                    ?>

                </div>
            </div>
        </section>
    </div>
</div>