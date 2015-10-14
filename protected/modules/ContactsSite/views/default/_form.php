<?php
/* @var $this ContactsSiteController */
/* @var $model ContactsSite */
/* @var $form CActiveForm */
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contacts-site-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	
<?php
				
				$criteria = new CDbCriteria();
				$criteria->select = "id,first_name,surname,mobile";
                                $criteria->condition = $this->where_agent_condition;
				$criteria->order = 'first_name';
				$loop_contacts = Contact::model()->findAll($criteria);
				
				

?>
	
	
		
	<div class="col-md-6 mb20">

	<div class="form-group">
		<label class="col-sm-5"> Select Contact </label>
		<div class="col-sm-7">
			
			<select name="contact_ids" class="form-control">
			
			<?php foreach ($loop_contacts as $value)  { ?>
			<option <?php if(isset($last_selected_contact_id) && $last_selected_contact_id == $value->id) echo 'selected'; ?> value="<?php echo $value->id; ?>"><?php echo $value->first_name.' '.$value->surname.' (MOB:'.$value->mobile.')'; ?></option>
			<?php } ?>
			</select>
			
		<?php if(isset($contact_ids_error_msg) && !empty($contact_ids_error_msg)) {
			echo "<div class='errorMessage'>Please select at least one contact.</div>";
		 } ?>
		
		</div>		
	</div>
	
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'site_name',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'site_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'site_name'); ?>
		</div>		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'site_id',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'site_id',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'site_id'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'address',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'address'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'suburb',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'suburb',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'suburb'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'state',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'state',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'state'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'postcode',array('class'=>'col-sm-5')); ?>
			<div class="col-sm-7">
		<?php echo $form->textField($model,'postcode',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'postcode'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'phone',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'phone'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'mobile',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'mobile',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'mobile'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'email'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'site_contact',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'site_contact',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'site_contact'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'site_comments',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textArea($model,'site_comments',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'site_comments'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'how_many_buildings',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'how_many_buildings',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'how_many_buildings'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'need_induction',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->radioButtonList($model,'need_induction',array('1'=>'Yes', '0'=>'No'),array('size'=>17,'maxlength'=>17,'class'=>'radio123','separator' => "&nbsp;&nbsp;&nbsp;&nbsp;")); ?>
		<?php echo $form->error($model,'need_induction'); ?>
		</div>
		
	</div>

	
<?php			$display_none = 'style="display:none"'; $last_saved_induction_company = '';
				if(! $model->isNewRecord) {				
					if($model->induction_company_id > 0)
					$display_none = '';				
					$last_saved_induction_company = $model->induction_company_id;
				}
				
				
				$criteria = new CDbCriteria();
				$criteria->select = "id,name";
				$criteria->order = 'name';
				$induction_companies = InductionCompany::model()->findAll($criteria);
				
				foreach ($induction_companies as $value)  {			
				$induction_companies_opotion[$value->id] =  $value->name; 
				}

?>
	
	
		<div class="form-group" id="induction_company_id_div" <?php echo $display_none; ?> >
		<?php echo $form->labelEx($model,'induction_company_id',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->dropDownList($model, 'induction_company_id', $induction_companies_opotion,array('options'=>array($last_saved_induction_company=>array('selected'=>'selected')),'class'=>'form-control')); ?>
		<?php echo $form->error($model,'induction_company_id'); ?>
		</div>		
		</div>

	
<br/>
	<div class="row buttons" align="center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>
<br/><br/>
</div><!-- form -->

 <script type="text/javascript">
 
$('.radio123').change(function(){
    var value = $( this ).val();
	if(value == 0) 
		$('#induction_company_id_div').hide();
	else
		$('#induction_company_id_div').show();
});
 
$(function () {
$('#txtAlphabets').keydown(function (e) {
if (e.shiftKey || e.ctrlKey || e.altKey) {
e.preventDefault();
} else {
var key = e.keyCode;
if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
e.preventDefault();
}
}
});
});
</script>