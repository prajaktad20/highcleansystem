<?php
/* @var $this SettingController */
/* @var $data Setting */
?>

<div class="view">

	<strong><?php echo CHtml::encode($data->getAttributeLabel('setting_id')); ?>:</strong>
	<?php echo CHtml::link(CHtml::encode($data->setting_id), array('view', 'id'=>$data->setting_id)); ?>
	<br />

	<strong><?php echo CHtml::encode($data->getAttributeLabel('meta_key')); ?>:</strong>
	<?php echo CHtml::encode($data->meta_key); ?>
	<br />

	<strong><?php echo CHtml::encode($data->getAttributeLabel('meta_value')); ?>:</strong>
	<?php echo CHtml::encode($data->meta_value); ?>
	<br />


</div>