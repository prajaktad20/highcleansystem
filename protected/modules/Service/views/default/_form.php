<?php
/* @var $this ServiceController */
/* @var $model Service */
/* @var $form CActiveForm */
?>


<div class="col-md-12">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'service-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'service_name',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'service_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
         </div>		
		<?php echo $form->error($model,'service_name'); ?>
	</div>


    <div class="form-group">
                    <?php echo $form->labelEx($model, 'status',array('class'=>'col-sm-5')); ?>
					<div class="col-sm-7">
                    <?php echo $form->dropDownList($model, 'status', array("1" => "Active", "0" => "Inactive"),array('class'=>'form-control')); ?>
					</div>
                    <?php echo $form->error($model, 'status'); ?>
    </div>

	<div class="row buttons" align="center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary mr5')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->