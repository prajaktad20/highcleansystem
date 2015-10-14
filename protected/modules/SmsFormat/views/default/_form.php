<?php
/* @var $this SmsFormatController */
/* @var $model SmsFormat */
/* @var $form CActiveForm */
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sms-format-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

	
	<div class="table-responsive">
    <table class="table table-bordered mb30 create_quote_table">
    <tbody>
	
	
	
	<tr>
    <th><?php echo $form->labelEx($model,'title',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>300,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	</td>
	</tr>

	
	
	<tr>
    <th><?php echo $form->labelEx($model,'sms_text',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
		<?php echo $form->textArea($model,'sms_text', array("style"=>"width:auto; min-height: 150px;width: 100%;",'class'=>'form-control')); ?>
		<?php echo $form->error($model,'sms_text'); ?>
	</div>
	</td>
	</tr>


	<tr>
	<td colspan="2" align="center">
	<div class="col-md-12" align="center">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary mr5')); ?>
	</div>	
	</td>
	</tr>


<?php $this->endWidget(); ?>

</div>
