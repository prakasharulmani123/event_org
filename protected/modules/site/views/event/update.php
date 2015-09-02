<?php
/* @var $this EventController */
/* @var $model Event */

$this->title='Update Events: '. $model->event_id;
$this->breadcrumbs=array(
	'Events'=>array('index'),
	'Update Events',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>