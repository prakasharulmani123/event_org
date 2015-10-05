<?php
/* @var $this EventController */
/* @var $model Event */

$this->title='Update Timelines: '. $model->event_name;
$this->breadcrumbs=array(
	'Timelines'=>array('index'),
	'Update Timelines',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model','lists')); ?></div>