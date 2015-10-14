<?php
/* @var $this InductionController */
/* @var $model Induction */
/* @var $form CActiveForm */
?>

<div class="col-md-12">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'induction-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

	<div class="col-md-7 mr100">



	<div class="form-group">
		<?php echo $form->labelEx($model,'induction_number',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'induction_number',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'induction_number'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'induction_card',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo CHtml::activeFileField($model,'induction_card',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'induction_card'); ?>		
				
		<?php if(!empty($model->induction_card) && file_exists(Yii::app()->basePath.'/../uploads/induction/cards/'.$model->induction_card))	{ ?>
		<a target="_blank" href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/induction/cards/'.$model->induction_card; ?>">Download Induction Card</a>
		<?php } ?>
		
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'completion_date',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'completion_date',array('id'=>'completion_date','size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'completion_date'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'expiry_date',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'expiry_date',array('id'=>'expiry_date','size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'expiry_date'); ?>
		</div>
	</div>

	
		
	<div class="form-group">
	<?php echo $form->labelEx($model, 'induction_status',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
	<?php echo $form->dropDownList($model, 'induction_status', array("pending" => "Pending", "completed" => "Completed"),array('class'=>'form-control')); ?>		
	<?php echo $form->error($model, 'induction_status'); ?>
	</div>
	</div>
					
	
	

	<div class="form-group">
	<label class="col-sm-5"></label>
		<div class="col-sm-7">	
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?> &nbsp;
		<a class='btn btn-primary' href="<?php echo $this->user_role_base_url; ?>?r=Calendar/default/View_inductions" /> Cancel </a>
		</div>
	</div>

  </div>
  
<?php $this->endWidget(); ?>

</div><!-- form -->



<script type="text/javascript">
  

   $(document).ready(function(){

	
   
    $("#completion_date").datepicker({
		dateFormat:'yy-mm-dd',
		//minDate: 0,
        maxDate: "+1000D",
        numberOfMonths: 1,
    });
	
    $("#expiry_date").datepicker({ 
		dateFormat:'yy-mm-dd',
        minDate: 0,
        maxDate:"+1000D",
        numberOfMonths: 2,       
    });  

   
 
$('.radio123').change(function(){
    var value = $( this ).val();
	if(value == 0) {
		$('#document_required').hide();
		$('#induction_link_required').show();
	}	else {
		$('#induction_link_required').hide();
		$('#document_required').show();
	}
});
 
	
	
});


	

</script>
