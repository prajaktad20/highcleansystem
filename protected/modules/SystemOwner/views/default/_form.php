<?php
/* @var $this SystemOwnerController */
/* @var $model SystemOwner */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'system-owner-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'first_name',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
		<?php echo $form->textField($model,'first_name',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>	</div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'last_name',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
		<?php echo $form->textField($model,'last_name',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>	</div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'username',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
		<?php echo $form->textField($model,'username',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>	</div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'password',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
		<?php echo $form->passwordField($model,'password',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>	</div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'email',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
		<?php echo $form->textField($model,'email',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>	</div>

	<div class="form-group" >
	<?php echo $form->labelEx($model, 'status',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
	<?php echo $form->dropDownList($model, 'status', array("1" => "Active", "0" => "Inactive"),array('class'=>'form-control')); ?>		
	<?php echo $form->error($model, 'status'); ?>
	</div>
	</div>

<div class="col-md-12" align="center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary mr5')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
