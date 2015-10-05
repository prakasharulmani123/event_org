<?php
/* @var $this RoleController */
/* @var $model Role */

$this->title='Create Categories';
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
