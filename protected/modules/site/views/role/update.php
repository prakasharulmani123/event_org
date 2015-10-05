<?php
/* @var $this RoleController */
/* @var $model Role */

$this->title='Update Categories: '. $model->role_id;
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Update Categories',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>