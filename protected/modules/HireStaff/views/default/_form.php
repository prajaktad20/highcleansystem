<?php
/* @var $this HireStaffController */
/* @var $model HireStaff */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'hire-staff-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
<div class="col-md-12">

<!--- Main Details left side section ----->
<div class="col-md-10 mr100">

	<div class="form-group">
		<?php echo $form->labelEx($model,'first_name',array('class'=>'col-sm-3')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		</div>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'last_name',array('class'=>'col-sm-3')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		</div>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email',array('class'=>'col-sm-3')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		</div>
		<?php echo $form->error($model,'email'); ?>
	</div>
	
	<div class="form-group">
		<div class="col-sm-2">
		<input type="checkbox" value="1" id="send_email" name="send_email" checked="checked">
		</div>
		<div class="col-sm-7">
		<label>Send Staff Registration Link</label>
		</div>
		
	</div>
	

	<div class="row buttons" align="center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->