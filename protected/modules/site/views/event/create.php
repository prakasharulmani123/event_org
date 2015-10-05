<?php
/* @var $this EventController */
/* @var $model Event */

$this->title='Create Timeline';
$this->breadcrumbs=array(
	'Timelines'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model','lists')); ?>
</div>
