<?php
/* @var $this BuildingsController */
/* @var $model Buildings */
/* @var $form CActiveForm */
?>
<div class="col-md-12">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'buildings-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>

<?php 

	$site_options = array();
	$site_options[''] = "--Select Site--";
	
		
				$criteria = new CDbCriteria();
				$criteria->select = "id,site_name";
                                $criteria->condition = $this->where_agent_condition;
				$criteria->order = 'site_name';                                
				$loop_contacts = ContactsSite::model()->findAll($criteria);
				
				foreach ($loop_contacts as $value)  {			
				$site_options[$value->id] =  $value->site_name; 
				}


?>    
    
    
<div class="col-md-5 mr100">
<div class="form-group">
		<?php echo $form->labelEx($model,'site_id',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->dropDownList($model, 'site_id',$site_options,array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'site_id'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'building_name',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'building_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'building_name'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'building_no',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'building_no',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'building_no'); ?>
		</div>
		
	</div>
	
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'building_type_id',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->dropDownList($model, 'building_type_id', CHtml::listData(ListBuildingType::model()->findAll(), 'id', 'name'),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'building_type_id'); ?>
		</div>
		
	</div>

	

	<div class="form-group">
		<?php echo $form->labelEx($model,'water_source_availability',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->checkBox($model,'water_source_availability',array('size'=>1,'maxlength'=>1,'class'=>'')); ?>
		<?php echo $form->error($model,'water_source_availability'); ?>
		</div>
		
	</div>
	
</div>


<div class="col-md-5">
	<div class="form-group">
		<?php echo $form->labelEx($model,'dist_from_office',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'dist_from_office',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'dist_from_office'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'no_of_floors',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'no_of_floors',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'no_of_floors'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'size_of_building',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'size_of_building',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'size_of_building'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'height_of_building',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'height_of_building',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'height_of_building'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'job_notes',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textArea($model,'job_notes',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'job_notes'); ?>
		</div>
		
	</div>

</div>
	<div class="col-sm-12" align="center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->