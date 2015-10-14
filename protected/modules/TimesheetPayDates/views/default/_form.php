<?php
/* @var $this SwmsController */
/* @var $model Swms */
/* @var $form CActiveForm */
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'timesheet-pay-dates-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="table-responsive">

   	 <table class="table table-bordered">
 

    	<tr>
    	<th><?php echo $form->labelEx($model,'pay_date',array('class'=>'col-sm-6')); ?></th>
	<td>
	<div class="createselect2 mr30">
	<?php echo $form->textField($model,'pay_date',array('readonly'=>true,'size'=>60,'maxlength'=>255,'class'=>'form-control','id'=>'pay_date','value'=>$next_date['pay_date'])); ?>
	<?php echo $form->error($model,'pay_date'); ?>
	</div>
	</td>
	</tr>

	
    	<tr>
    	<th><?php echo $form->labelEx($model,'payment_start_date',array('class'=>'col-sm-6')); ?></th>
	<td>
	<div class="createselect2 mr30">
	<?php echo $form->textField($model,'payment_start_date',array('readonly'=>true,'size'=>60,'maxlength'=>255,'class'=>'form-control','id'=>'payment_start_date','value'=>$next_date['payment_start_date'])); ?>
	<?php echo $form->error($model,'payment_start_date'); ?>
	</div>
	</td>
	</tr>

	
    	<tr>
    	<th><?php echo $form->labelEx($model,'payment_end_date',array('class'=>'col-sm-6')); ?></th>
	<td>
	<div class="createselect2 mr30">
	<?php echo $form->textField($model,'payment_end_date',array('readonly'=>true,'size'=>60,'maxlength'=>255,'class'=>'form-control','id'=>'payment_end_date','value'=>$next_date['payment_end_date'])); ?>
	<?php echo $form->error($model,'payment_end_date'); ?>
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
	 
	 
    </table>
    </div>
	
	
<?php $this->endWidget(); ?>

<script type="text/javascript">

  $("#pay_date").datepicker({
				minDate:'<?php echo $next_date['pay_date']; ?>',
                numberOfMonths: 1,
                dateFormat:'yy-mm-dd',                
            });

  $("#payment_start_date").datepicker({
                numberOfMonths: 1,
				minDate:'<?php echo $next_date['payment_start_date']; ?>',
                dateFormat:'yy-mm-dd',
                onSelect: function(selected) {
                  $("#payment_end_date").datepicker("option","minDate", selected)
                }
            });
            
    $("#payment_end_date").datepicker({ 
        numberOfMonths: 1,
		maxDate:'<?php echo $next_date['payment_end_date']; ?>',
        dateFormat:'yy-mm-dd',
        onSelect: function(selected) {
           $("#payment_start_date").datepicker("option","maxDate", selected)
        }
    });  
            
</script>
