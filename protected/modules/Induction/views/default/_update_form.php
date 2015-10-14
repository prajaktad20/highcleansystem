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


<?php 

	$users_option = array();
	$users_option[''] = "--Please select User--";
	
		
				$criteria = new CDbCriteria();
				$criteria->select = "id,first_name,last_name,email";
				$criteria->condition = "role_id IN (1,3,5,6)";
				$criteria->order = 'first_name';
				$loop_users_contacts = User::model()->findAll($criteria);
				
				foreach ($loop_users_contacts as $value)  {			
				$users_option[$value->id] =  $value->first_name.' '.$value->last_name.' ('.$value->email.')'; 
				}


?>					

				  

	
	<div class="form-group">
		<?php echo $form->labelEx($model,'user_id',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->dropDownList($model, 'user_id', $users_option ,array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'user_id'); ?>
		</div>
	</div>


<?php 

	$site_options = array();
	$site_options[''] = "--Please select Site--";
	
		
				$criteria = new CDbCriteria();
				$criteria->select = "id,site_name";
				$criteria->order = 'site_name';
				$loop_site_contacts = ContactsSite::model()->findAll($criteria);
				
				foreach ($loop_site_contacts as $value)  {			
				$site_options[$value->id] =  $value->site_name; 
				}


?>					

		
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'site_id',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->dropDownList($model, 'site_id', $site_options ,array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'site_id'); ?>
	</div>
	</div>

<?php 

	$induction_type_options = array();
	$induction_type_options[''] = "--Please select Induction Type--";
	
		
				$criteria = new CDbCriteria();
				$criteria->select = "id,name";
				$criteria->order = 'name';
				$loop_InductionType = InductionType::model()->findAll($criteria);
				
				foreach ($loop_InductionType as $value)  {			
				$induction_type_options[$value->id] =  $value->name; 
				}


?>					
	
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'induction_type_id',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->dropDownList($model, 'induction_type_id', $induction_type_options ,array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'induction_type_id'); ?>
	</div>
	</div>

		

<?php 

	$induction_company_options = array();
	$induction_company_options[''] = "--Please select Induction Company--";
	
		
				$criteria = new CDbCriteria();
				$criteria->select = "id,name";
				$criteria->order = 'name';
				$loop_InductionCompany = InductionCompany::model()->findAll($criteria);
				
				foreach ($loop_InductionCompany as $value)  {			
				$induction_company_options[$value->id] =  $value->name; 
				}


?>					
	
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'induction_company_id',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
	<?php echo $form->dropDownList($model, 'induction_company_id', $induction_company_options ,array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'induction_company_id'); ?>
	</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'induction_link_document',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->radioButtonList($model,'induction_link_document',array('0'=>'Induction Link', '1'=>'Document'),array('size'=>17,'maxlength'=>17,'class'=>'radio123','separator' => "&nbsp;&nbsp;&nbsp;&nbsp;")); ?>
		<?php echo $form->error($model,'induction_link_document'); ?>
		</div>
	</div>

	<div class="form-group" id="induction_link_required"  <?php if($model->induction_link_document == 1) { ?> style="display:none;" <?php } ?> >
		<?php echo $form->labelEx($model,'induction_link',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'induction_link',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'induction_link'); ?>
	</div>
	</div>

	<div class="form-group"  id="document_required" <?php if($model->induction_link_document == 0) { ?> style="display:none;" <?php } ?> >
		<?php echo $form->labelEx($model,'document',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo CHtml::activeFileField($model,'document',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'document'); ?>
		
		<?php if(!empty($model->document) && file_exists(Yii::app()->basePath.'/../uploads/induction/documents/'.$model->document))	{ ?>
		<a  target="_blank" href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/induction/documents/'.$model->document; ?>">Download Document</a>
		<?php } ?>
		
		</div>
	</div>

	
	<div class="form-group">
		<?php echo $form->labelEx($model,'password',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'password',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'password'); ?>
		</div>
	</div>


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
					
	


	<div class="col-sm-12" align="center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
	</div>

  </div>
  
<?php $this->endWidget(); ?>

</div><!-- form -->



<script type="text/javascript">
  

   $(document).ready(function(){

	
   
    $("#completion_date").datepicker({
		dateFormat:'yy-mm-dd',
       // minDate: 0,
        maxDate: "+1000D",
        numberOfMonths: 1,
    });
	
    $("#expiry_date").datepicker({ 
		dateFormat:'yy-mm-dd',
        minDate: 0,
        maxDate:"+1000D",
        numberOfMonths: 1,       
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
