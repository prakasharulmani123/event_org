<?php
/* @var $this EventController */
/* @var $model Event */

$this->title='Update Events: '. $model->event_name;
$this->breadcrumbs=array(
	'Events'=>array('index'),
	'Update Events',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model','lists')); ?></div>