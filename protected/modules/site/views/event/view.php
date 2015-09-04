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
                    )
            );
            echo "&nbsp;&nbsp;";
            $this->widget(
                    'application.components.MyTbButton', array(
                'label' => 'Download',
                'url' => array('view', 'id' => $model->event_id, 'export' => 'PDF'),
                'buttonType' => 'link',
                'context' => 'warning',
                    )
            );
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

    <?php
    $gridColumns = array(
        'list_title',
        'timing_start',
        'timing_end',
        'timing_notes',
    );

    $this->widget('booster.widgets.TbExtendedGridView', array(
        'type' => 'striped bordered datatable',
        'dataProvider' => $list_dataprovider,
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
            )
    );
    ?>
</div>



