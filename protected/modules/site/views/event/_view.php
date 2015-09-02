<?php
/* @var $this EventController */
/* @var $data Event */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->event_id), array('view', 'id'=>$data->event_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_name')); ?>:</b>
	<?php echo CHtml::encode($data->event_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_date')); ?>:</b>
	<?php echo CHtml::encode($data->event_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_users')); ?>:</b>
	<?php echo CHtml::encode($data->event_users); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_by')); ?>:</b>
	<?php echo CHtml::encode($data->modified_by); ?>
	<br />

	*/ ?>

</div>