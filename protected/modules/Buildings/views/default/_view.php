<?php
/* @var $this BuildingsController */
/* @var $data Buildings */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('building_name')); ?>:</b>
	<?php echo CHtml::encode($data->building_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('building_no')); ?>:</b>
	<?php echo CHtml::encode($data->building_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('water_source_availability')); ?>:</b>
	<?php echo CHtml::encode($data->water_source_availability); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dist_from_office')); ?>:</b>
	<?php echo CHtml::encode($data->dist_from_office); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_of_floors')); ?>:</b>
	<?php echo CHtml::encode($data->no_of_floors); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('size_of_building')); ?>:</b>
	<?php echo CHtml::encode($data->size_of_building); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('height_of_building')); ?>:</b>
	<?php echo CHtml::encode($data->height_of_building); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('job_notes')); ?>:</b>
	<?php echo CHtml::encode($data->job_notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('site_id')); ?>:</b>
	<?php echo CHtml::encode($data->site_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('building_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->building_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>