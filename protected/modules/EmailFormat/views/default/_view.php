<?php
/* @var $this EmailFormatController */
/* @var $data EmailFormat */
?>

<div class="view">

	<strong><?php echo CHtml::encode($data->getAttributeLabel('email_format_ID')); ?>:</strong>
	<?php echo CHtml::link(CHtml::encode($data->email_format_ID), array('view', 'id'=>$data->email_format_ID)); ?>
	<br />

	<strong><?php echo CHtml::encode($data->getAttributeLabel('email_format_name')); ?>:</strong>
	<?php echo CHtml::encode($data->email_format_name); ?>
	<br />

	<strong><?php echo CHtml::encode($data->getAttributeLabel('email_format')); ?>:</strong>
	<?php echo CHtml::encode($data->email_format); ?>
	<br />


</div>