<?php
/* @var $this MaintenanceController */
/* @var $model Maintenance */
/* @var $form CActiveForm */
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'maintenance-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
)); ?>

	
	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'date',array('class'=>'col-sm-3')); ?>
		<div class="col-sm-5">
		<?php echo $form->textField($model,'date',array('class'=>'form-control','id'=>'date')); ?>		
		<?php echo $form->error($model,'date'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'equipment',array('class'=>'col-sm-3')); ?>
		<div class="col-sm-5">
		<?php echo $form->textField($model,'equipment',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'equipment'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'note',array('class'=>'col-sm-3')); ?>
		<div class="col-sm-5">
		<?php echo $form->textField($model,'note',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'photo',array('class'=>'col-sm-3')); ?>
		<div class="col-sm-5">
		<?php echo  CHtml::activeFileField($model,'photo',array('class'=>'form-control','class'=>'form-control')); ?>   
		

<?php if(!empty($model->photo) && file_exists(Yii::app()->basePath.'/../uploads/maintenances/thumb/'.$model->photo))	{ ?>
		<a target="_blank" href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/maintenances/'.$model->photo;?>"><img src="<?php echo Yii::app()->getBaseUrl(true).'/uploads/maintenances/thumb/'.$model->photo;?>" /></a>
<?php } ?>
		
		
	</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'status',array('class'=>'col-sm-3')); ?>
		<div class="col-sm-5">
		<?php echo $form->dropDownList($model, 'status', array("Pending" => "Pending", "Completed" => "Completed"),array('class'=>'form-control')); ?>		
		<?php echo $form->error($model, 'status'); ?>
	</div>
	</div>

	<div class="form-group">
          <label class="col-sm-3">&nbsp;</label>
          <div class="col-sm-5">
		  <?php echo CHtml::submitButton('Save',array('class'=>'btn btn-primary')); ?>
         <a href="?r=Maintenance/default/admin" class="btn btn-primary">Cancel</a>
    </div>
	</div>

<?php $this->endWidget(); ?>

  
  <script type="text/javascript">
  	jQuery(document).ready(function(){
	

    $("#date").datepicker({
		dateFormat:'yy-mm-dd',
       // minDate: 0,
        maxDate: "+1000D",
        numberOfMonths: 1,
    });
	
	}); 
			
  </script>
  
  
