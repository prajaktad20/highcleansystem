<?php
/* @var $this TimesheetPayDatesController */
/* @var $model TimesheetPayDates */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pay_date'); ?>
		<?php echo $form->textField($model,'pay_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_start_date'); ?>
		<?php echo $form->textField($model,'payment_start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_end_date'); ?>
		<?php echo $form->textField($model,'payment_end_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->