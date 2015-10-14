<div class="col-md-12">
<?php $keywords = array('{quote_number}','{induction_company}','{induction_type}','{service_required}','{company_name}','{sign_off_link}','{service_description}','{site_name}','{quote_created_user}','{contact_name}','{site_id}','{site_address}','{building_name}','{building_id}','{quote_approved_user}','{quote_declined_user}','{job_number}','{supervisor_full_name}','{admin_full_name}','{job_from_date}','{job_to_date}','{job_frequency}','{site_supervisor_full_name}','{staff_full_name}','{supervisor_mobile_number}','{site_supervisor_mobile_number}','{agent_first_name}','{job_completed_date}','{sign_off_name}'); 
sort($keywords);
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'email-format-form',
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
	
	
	<tr>
    <th><?php echo $form->labelEx($model,'email_format_name',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
		<?php echo $form->textField($model,'email_format_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'email_format_name'); ?>
	</div>
	</td>
	</tr>

	

	<tr>
    <th><?php echo $form->labelEx($model,'email_format',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
        <?php echo $form->textArea($model, 'email_format', array('id'=>'editor1')); ?>
		<?php echo $form->error($model,'email_format'); ?>
	</div>
	</td>
	</tr>

	<tr>
    <th><?php echo $form->labelEx($model,'note',array('class'=>'col-sm-5')); ?></th>
	<td>
	<div class="createselect2 mr30">
		<?php echo $form->textArea($model,'note', array("style"=>"width:auto; min-height: 150px;width: 100%;",'class'=>'form-control')); ?>
		<?php echo $form->error($model,'note'); ?>
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

<br/>
<br/>
	<div class="table-responsive">
    <table class="table table-bordered mb30 create_quote_table">
    <tbody>
	
	<tr>
	<th colspan="2">Keywords : </th>	
	</tr>
	
<?php for( $i=0; $i < count($keywords); $i = $i+4 ) { ?>
<tr>
<td align="center"><?php  if(isset($keywords[$i])) echo $keywords[$i]; ?></td>
<td align="center"><?php if(isset($keywords[$i+1])) echo $keywords[$i+1]; ?></td>
<td align="center"><?php if(isset($keywords[$i+2]))  echo $keywords[$i+2]; ?></td>
<td align="center"><?php if(isset($keywords[$i+3]))  echo $keywords[$i+3]; ?></td>
<?php } ?>
</tr>

	</tbody>
	</table>



</div><!-- form -->
    
<script type="text/javascript">    CKEDITOR.replace( 'editor1' ); </script>