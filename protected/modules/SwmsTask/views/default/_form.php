<?php
/* @var $this SwmsTaskController */
/* @var $model SwmsTask */
/* @var $form CActiveForm */
?>

<div class="col-md-12">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'swms-task-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	
	<div class="table-responsive">
    <table class="table table-bordered mb30 create_quote_table">
    <tbody>
	
	
    <tr>
    <th><?php echo $form->labelEx($model,'swms_id',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
	<?php echo $form->dropDownList($model, 'swms_id', CHtml::listData(Swms::model()->findAll(array('order'=>"name ASC")), 'id', 'name'),array('class'=>'form-control')); ?>
	<?php echo $form->error($model,'swms_id'); ?>
	</div>
	</td>
	</tr>

		
		
    <tr>
    <th><?php echo $form->labelEx($model,'task',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
	<?php echo $form->textField($model,'task',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
	<?php echo $form->error($model,'task'); ?>
	</div>
	</td>
	</tr>


	<tr>
    	<th>
	<?php echo $form->labelEx($model, 'status',array('class'=>'col-sm-5')); ?>
	</th>
	<td>
	<div class="createselect2 mr30">
	<?php echo $form->dropDownList($model, 'status', array("1" => "Active", "0" => "Inactive"),array('class'=>'form-control')); ?>		
	<?php echo $form->error($model, 'status'); ?>
	</div>
	</td>
	</tr>

		
    	<tr>
    	<th><?php echo $form->labelEx($model,'task_sort_order',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
	<?php echo $form->textField($model,'task_sort_order',array('size'=>11,'maxlength'=>11,'class'=>'form-control')); ?>
	<?php echo $form->error($model,'task_sort_order'); ?>
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
	
	
	</tbody>	 
    </table>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
