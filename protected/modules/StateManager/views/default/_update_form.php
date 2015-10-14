<?php
/* @var $this OperationManagerController */
/* @var $model OperationManager */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'operation-manager-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'first_name',array('class'=>'col-sm-5')); ?> <div class="col-sm-7">
		<?php echo $form->textField($model,'first_name',array('size'=>60,'class'=>'form-control','maxlength'=>150)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div></div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'last_name',array('class'=>'col-sm-5')); ?> <div class="col-sm-7">
		<?php echo $form->textField($model,'last_name',array('size'=>60,'class'=>'form-control','maxlength'=>150)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div></div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'logo',array('class'=>'col-sm-5')); ?> <div class="col-sm-7">
	<?php echo CHtml::activeFileField($model,'logo'); ?>
		<?php echo $form->error($model,'logo'); ?>
	</div></div>



	<?php $path = Yii::app()->basePath.'/../uploads/state_manager/thumbs/'; ?>	
	<?php if(isset($model->logo) && $model->logo !=NULL && file_exists($path.$model->logo))	 { ?>
	<div class="form-group">
			<label class="col-sm-5">&nbsp;</label>
			 <div class="col-sm-7">
			<img  src="<?php echo Yii::app()->getBaseUrl(true).'/uploads/state_manager/thumbs/'.$model->logo; ?>" alt=""> 
			</div>
	</div>
	<?php }  ?>


	<div class="form-group" >
		<?php echo $form->labelEx($model,'email_address',array('class'=>'col-sm-5')); ?> <div class="col-sm-7">
		<?php echo $form->textField($model,'email_address',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'email_address'); ?>
	</div></div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'password',array('class'=>'col-sm-5')); ?> <div class="col-sm-7">
		<?php echo $form->passwordField($model,'password',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div></div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'phone',array('class'=>'col-sm-5')); ?> <div class="col-sm-7">
		<?php echo $form->textField($model,'phone',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div></div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'mobile',array('class'=>'col-sm-5')); ?> <div class="col-sm-7">
		<?php echo $form->textField($model,'mobile',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'mobile'); ?>
	</div></div>


	<div class="form-group" >
		<?php echo $form->labelEx($model,'street',array('class'=>'col-sm-5')); ?> <div class="col-sm-7">
		<?php echo $form->textField($model,'street',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'street'); ?>
	</div></div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'city',array('class'=>'col-sm-5')); ?> <div class="col-sm-7">
		<?php echo $form->textField($model,'city',array('size'=>60,'class'=>'form-control','maxlength'=>150)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div></div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'state_province',array('class'=>'col-sm-5')); ?> <div class="col-sm-7">
		<?php echo $form->textField($model,'state_province',array('size'=>60,'class'=>'form-control','maxlength'=>100)); ?>
		<?php echo $form->error($model,'state_province'); ?>
	</div></div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'zip_code',array('class'=>'col-sm-5')); ?> <div class="col-sm-7">
		<?php echo $form->textField($model,'zip_code',array('size'=>60,'class'=>'form-control','maxlength'=>100)); ?>
		<?php echo $form->error($model,'zip_code'); ?>
	</div></div>

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
