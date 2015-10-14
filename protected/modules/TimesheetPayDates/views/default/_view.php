<?php
/* @var $this TimesheetPayDatesController */
/* @var $data TimesheetPayDates */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pay_date')); ?>:</b>
	<?php echo CHtml::encode($data->pay_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_start_date')); ?>:</b>
	<?php echo CHtml::encode($data->payment_start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_end_date')); ?>:</b>
	<?php echo CHtml::encode($data->payment_end_date); ?>
	<br />


</div>