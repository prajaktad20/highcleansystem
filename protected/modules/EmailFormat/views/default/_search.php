<?php
/* @var $this EmailFormatController */
/* @var $model EmailFormat */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<!--<div class="row">
		<?php echo $form->label($model,'email_format_ID'); ?>
		<?php echo $form->textField($model,'email_format_ID'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'email_format_name'); ?>
		<?php echo $form->textField($model,'email_format_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->label($model,'email_format'); ?>
		<?php echo $form->textArea($model,'email_format',array('rows'=>6, 'cols'=>50)); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search',array('class' => 'btn btn-info')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->