<?php
/* @var $this RoleController */
/* @var $model Role */

$this->title='Update Roles: '. $model->role_id;
$this->breadcrumbs=array(
	'Roles'=>array('index'),
	'Update Roles',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>