<?php
/* @var $this UserController */
/* @var $model User */

$this->title='View User:'.$model->user_id;
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'View '.'User',
);
?>
<div class="user-view">
    <?php    if ($export == false) {
    ?>
    <p>
        <?php        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' =>  $model->user_id ),
                    'buttonType' => 'link',
                    'context' => 'primary',
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' =>  $model->user_id ),
                    'buttonType' => 'link',
                    'context' => 'danger',
                    'htmlOptions' => array('confirm' => 'Are you sure you want to delete this item?'),
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
            'label' => 'Download',
            'url' => array('view', 'id' =>  $model->user_id , 'export' => 'PDF'),
            'buttonType' => 'link',
            'context' => 'warning',
                )
        );
        ?>
    </p>
    <?php    }
    ?>
    <?php    if ($export) { ?>
        <h3 class="text-center">User <?php echo $this->title ?></h3>
    <?php        
    }
    ?>
    <?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
        'htmlOptions' => array('class'=>'table table-striped table-bordered'),
	'attributes'=>array(
		'user_id',
		'username',
		'password_hash',
		'password_reset_token',
		'user_firstname',
		'user_lastname',
		'role_id',
		'user_email',
		'user_phone',
		'user_address',
		array(
                'name' => 'Active',
                'type' => 'raw',
                'value' => $model->status == 1 ? '<i class="fa fa-circle text-green"></i>' : '<i class="fa fa-circle text-red"></i>'
            ),
	),
)); ?>
</div>



