 <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
              <li>Job</li>
            </ul>
            <h4>Add Purchase Order</h4>
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
                    <span class="glyphicon  glyphicon-th"></span><h2>Job Purchase Order</h2>
                  </div>
                </div>
		
                <dl class="quotedetaildl col-md-6">
                  
				  <?php echo $form->errorSummary($model); ?>
				  <dt class="col-md-4">Purchase Order</dt>
				  
                  <dd class="col-md-6">
				  <?php echo $form->textField($model,'purchase_order',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?>
				  </dd> 
			
				  
				 </dl>
				
				  <dl class="quotedetaildl col-md-6">
				  <dt class="col-md-4">&nbsp;</dt>
				  
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
   
   