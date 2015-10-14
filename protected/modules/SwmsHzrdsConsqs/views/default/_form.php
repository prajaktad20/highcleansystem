<?php
/* @var $this SwmsHzrdsConsqsController */
/* @var $model SwmsHzrdsConsqs */
/* @var $form CActiveForm */
?>

<div class="col-md-12">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'swms-hzrds-consqs-form',
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
	

	
<?php 

	$swms_type_options = array();
	$swms_type_options[''] = "--Please select SWMS type --";
	

				$criteria = new CDbCriteria();
				$criteria->select = "id,name";
				$criteria->order = 'name';
				$loop_swms_types = Swms::model()->findAll($criteria);				
				foreach ($loop_swms_types as $value)  {			
				$swms_type_options[$value->id] =  $value->name; 
				}
	

?>					
	
	<tr>
    <th><?php echo $form->labelEx($model,'swms_id',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">	
	<?php echo $form->dropDownList($model, 'swms_id', $swms_type_options ,array('onchange' => 'return FindSwmsTask(this.value);','class'=>'form-control')); ?>
	<?php echo $form->error($model,'swms_id'); ?>
	</div>
	</td>
	</tr>
	
<?php 

	$task_options = array();
	$task_options[''] = "--Please select Task--";
	
	if(isset($model->swms_id) && !empty($model->swms_id)) { 	
				$selected_swms_id = $model->swms_id;
	
				$criteria = new CDbCriteria();
				$criteria->select = "id,task,task_sort_order";
				$criteria->condition = "swms_id =:swms_id";
				$criteria->params = array(':swms_id' => $selected_swms_id);
				$criteria->order = 'task_sort_order';
				$loop_tasks = SwmsTask::model()->findAll($criteria);
				
				foreach ($loop_tasks as $value)  {			
				$task_options[$value->id] =  $value->task.' ('.$value->task_sort_order.')'; 
				}
	}

?>		
	<tr>
    <th><?php echo $form->labelEx($model,'task_id',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
	<?php echo $form->dropDownList($model, 'task_id', $task_options ,array('class'=>'form-control','id'=>'task_dropdown')); ?>	
	<?php echo $form->error($model,'task_id'); ?>
	</div>
	</td>
	</tr>

	
	<tr>
    <th><?php echo $form->labelEx($model,'hazards',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
	<?php echo $form->textField($model,'hazards',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
	<?php echo $form->error($model,'hazards'); ?>
	</div>
	</td>
	</tr>

		
	<tr>
    <th><?php echo $form->labelEx($model,'consequences',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
	<?php echo $form->textField($model,'consequences',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
	<?php echo $form->error($model,'consequences'); ?>
	</div>
	</td>
	</tr>


		
<?php 

	$risk_initails_options = array();


				$criteria = new CDbCriteria();
				$criteria->select = "id,name";
				$criteria->order = 'name';
				$loop_risk_initails_types = RiskLevel::model()->findAll($criteria);				
				foreach ($loop_risk_initails_types as $value)  {			
				$risk_initails_options[$value->id] =  $value->name; 
				}
	

?>					
	
	
	<tr>
    <th><?php echo $form->labelEx($model,'risk',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">	
	<?php echo $form->dropDownList($model, 'risk', $risk_initails_options ,array('class'=>'form-control')); ?>
	<?php echo $form->error($model,'risk'); ?>
	</div>
	</td>
	</tr>
	
	
	


		
	<tr>
    <th><?php echo $form->labelEx($model,'control_measures',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
	<?php echo $form->textArea($model,'control_measures',array('id'=>'editor1')); ?>
	<?php //echo $form->textField($model,'control_measures',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
	<?php echo $form->error($model,'control_measures'); ?>
	</div>
	</td>
	</tr>


	<tr>
    <th><?php echo $form->labelEx($model,'residual_risk',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">	
	<?php echo $form->dropDownList($model, 'residual_risk', $risk_initails_options ,array('class'=>'form-control')); ?>
	<?php echo $form->error($model,'residual_risk'); ?>
	</div>
	</td>
	</tr>
	


		
	<tr>
    <th><?php echo $form->labelEx($model,'person_responsible',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
	<?php echo $form->textField($model,'person_responsible',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
	<?php echo $form->error($model,'person_responsible'); ?>
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
    <th><?php echo $form->labelEx($model,'hrd_consq_sort_order',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
	<?php echo $form->textField($model,'hrd_consq_sort_order',array('size'=>11,'maxlength'=>11,'class'=>'form-control')); ?>
	<?php echo $form->error($model,'hrd_consq_sort_order'); ?>
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


<script type="text/javascript" >

function FindSwmsTask(swms_id) {

	$.ajax(
	{
		url: "?r=SwmsHzrdsConsqs/default/FindSwmsTask",
		type : 'post',
		data:'swms_id='+swms_id,
		dataType: "html",
		success: function (data)
		{
		$("#task_dropdown").html(data);
		}

	});



}

</script>
<script type="text/javascript">    CKEDITOR.replace( 'editor1' ); </script>
