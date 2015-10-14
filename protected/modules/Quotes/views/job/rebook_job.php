
<style type="text/css">
	@media (max-width: 800px) {
	.clear_lable{float:none !important;}
	
	}
</style>

 <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
              <li>Job</li>
            </ul>
            <h4>Rebook Job</h4>
          </div>
        </div>
        <!-- media --> 
      </div>
      <div class="contentpanel">
	  
	  				
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'buildings-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
		
        <div class="row">
          <div class="col-md-12 quote_section"> 
     	   
                <div class="mb20"></div>
                <div class="panel panel-default">
                  <div class="panel-body titlebar">
                    <span class="glyphicon  glyphicon-th"></span><h2>Rebook Job</h2>
                  </div>
                </div>
		
                <dl class="quotedetaildl col-md-10">
                  
				  <?php echo $form->errorSummary($model); ?>
				  <dt class="col-md-6">Number staff required</dt>
				  
                  <dd class="col-md-6">
				  <?php echo $form->textField($model,'staff_required',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?>
				  </dd> 
				  
				  
				  <dt class="col-md-4"></dt>				  
                  <dd class="col-md-6">&nbsp;
					
				  </dd> 
				  

 
				  
				  <dt class="col-md-6 clear_lable">Job Start Date</dt>				  
                  <dd class="col-md-6">
				  <?php echo $form->textField($model,'job_started_date',array('rows'=>6, 'cols'=>50,'class'=>'form-control','id'=>'job_started_date')); ?>
				  <?php echo $form->error($model,'job_started_date'); ?>					  
				  </dd> 
				  

					<dt class="col-md-4"></dt>				  
                  <dd class="col-md-6">&nbsp;
					
				  </dd> 
				  
				  
				  <dt class="col-md-6">Job Start Time</dt>				  
                  <dd class="col-md-6">
				  <div class="bootstrap-timepicker"><?php echo $form->textField($model,'job_started_time',array('rows'=>6, 'cols'=>50,'class'=>'form-control','id'=>'job_started_time')); ?></div>
				  <?php echo $form->error($model,'job_started_time'); ?>					  
				  </dd> 
				  

				       
				   
				  <dt class="col-md-4"></dt>				  
                  <dd class="col-md-6">&nbsp;
					
				  </dd> 
				  

				       
				  
				  <dt class="col-md-6">Job End Date</dt>
				  
<dd class="col-md-6">
				  				  <?php echo $form->textField($model,'job_end_date',array('rows'=>6, 'cols'=>50,'class'=>'form-control','id'=>'job_end_date')); ?>
	
<?php echo $form->error($model,'job_end_date'); ?>
				  </dd> 
				  
				    <dt class="col-md-4"></dt>				  
                  <dd class="col-md-6">&nbsp;
					
				  </dd> 
				  
				  <dt class="col-md-6">Job End Time</dt>				  
                  <dd class="col-md-6">
				  <div class="bootstrap-timepicker"><?php echo $form->textField($model,'job_end_time',array('rows'=>6, 'cols'=>50,'class'=>'form-control','id'=>'job_end_time')); ?></div>
				  <?php echo $form->error($model,'job_end_time'); ?>					  
				  </dd> 
				  

				
				  
				  <dt class="col-md-4"></dt>				  
                  <dd class="col-md-6">&nbsp;
					
				  </dd> 
				  
				  
				  
				 </dl>
				
				  <dl class="quotedetaildl col-md-12">
				  <dt class="col-md-5">&nbsp;</dt>
				  
                  <dd class="col-md-6">
				  
				  <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
				  
				 <?php if( isset($_REQUEST['from_job_details']) && $_REQUEST['from_job_details'] == 'yes' ) { ?>
				 <a href="<?php echo $this->user_role_base_url.'/?r=Quotes/Job/view&id='.$model->id; ?>" class="btn btn-primary">Cancel</a> 
				 <?php } else { ?>
				  <a href="<?php echo $this->user_role_base_url.'/?r=Quotes/default/view&id='.$model->quote_id; ?>" class="btn btn-primary">Cancel</a> 
				 <?php } ?>
				 
				  </dd>
				  
				  </dl>
	
                <div class="clearfix"></div>


          </div>
        </div>
		
<?php $this->endWidget(); ?>
		
      </div>
      <!-- contentpanel --> 
   
   
<script type="text/javascript">
   
   
   $(document).ready(function(){
   
    $("#job_started_date").datepicker({
		dateFormat:'yy-mm-dd',
        minDate: 0,
        maxDate: "+1000D",
        numberOfMonths: 1,
        onSelect: function(selected) {
          $("#job_end_date").datepicker("option","minDate", selected)
        }
    });
    $("#job_end_date").datepicker({ 
		dateFormat:'yy-mm-dd',
        minDate: 0,
        maxDate:"+1000D",
        numberOfMonths: 1,
        onSelect: function(selected) {
           $("#job_started_date").datepicker("option","maxDate", selected)
        }
    });  


	
	
});


   
</script>


<script type="text/javascript">
jQuery(document).ready(function(){
					jQuery('#job_started_time').timepicker({defaultTIme: false}); 
					jQuery('#job_end_time').timepicker({defaultTIme: false}); 
}); 

</script>