<?php
/* @var $this SwmsHzrdsConsqsController */
/* @var $data SwmsHzrdsConsqs */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hazards')); ?>:</b>
	<?php echo CHtml::encode($data->hazards); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('consequences')); ?>:</b>
	<?php echo CHtml::encode($data->consequences); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('risk')); ?>:</b>
	<?php echo CHtml::encode($data->risk); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('control_measures')); ?>:</b>
	<?php echo CHtml::encode($data->control_measures); ?>
	<br />


</div>