<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $dataProvider CActiveDataProvider */

<?php
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->title='$label';\n";
echo "\$this->breadcrumbs=array(
	'$label',
);\n";

echo "\$themeUrl = \$this->themeUrl;\n";
echo "\$cs = Yii::app()->getClientScript();\n";
echo "\$cs_pos_end = CClientScript::POS_END;\n\n";

echo "\$cs->registerScriptFile(\$themeUrl . '/js/datatables/jquery.dataTables.js', \$cs_pos_end);\n";
echo "\$cs->registerScriptFile(\$themeUrl . '/js/datatables/dataTables.bootstrap.js', \$cs_pos_end);\n";
?>
?>
<?php
$restrict = $this->giiGenerateHiddenFields();
$count=0;
$activeFields = $this->giiGenerateActiveInActiveFields();
?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                Manage <?php echo ($this->modelClass); ?>
                <?php echo "<?php"; ?>
        $this->widget(
                'application.components.MyTbButton', array(
            'label' => 'Create <?php echo $this->modelClass; ?>',
            'icon' => 'fa fa-plus',
            'url' => array('/site/<?php echo strtolower($this->modelClass); ?>/create'),
            'buttonType' => 'link',
            'context' => 'success',
            'htmlOptions' => array('class' => 'pull-right btn-sm mtm5'),
                )
        );
        ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">

<?php echo "<?php\n"; ?>
        $gridColumns = array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
    if($column->isPrimaryKey || in_array($column->name, $restrict))
		continue;
	if(++$count==7)
		echo "\t\t/*\n";
        if(in_array($column->name, $activeFields)):
            $green = '<i class="fa fa-circle text-green"></i>';
            $red = '<i class="fa fa-circle text-red"></i>';
            echo "\t\tarray(
                'name' => '{$column->name}',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle'),
                'type' => 'raw',
                'value' => function(\$data) {
                    echo (\$data->{$column->name} == 1) ? '{$green}' : '{$red}';
                },
            ),\n";
        else:
            echo "\t\t'".$column->name."',\n";
        endif;
}
if($count>=7)
	echo "\t\t*/\n";
?>
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