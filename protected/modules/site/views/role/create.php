<?php
/* @var $this RoleController */
/* @var $model Role */

$this->title='Create Roles';
$this->breadcrumbs=array(
	'Roles'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
