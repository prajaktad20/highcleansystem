<?php
/* @var $this SwmsHzrdsConsqsController */
/* @var $model SwmsHzrdsConsqs */
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
		<?php echo $form->label($model,'hazards'); ?>
		<?php echo $form->textField($model,'hazards'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'consequences'); ?>
		<?php echo $form->textField($model,'consequences'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'risk'); ?>
		<?php echo $form->textField($model,'risk'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'control_measures'); ?>
		<?php echo $form->textArea($model,'control_measures',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->