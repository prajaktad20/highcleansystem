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
     	   
	<?php if(Yii::app()->user->hasFlash('input_zero')):?>
    <div class="errorMessage">
    <?php echo Yii::app()->user->getFlash('input_zero'); ?>
    </div>
	<?php endif; ?>
	
					  
	<?php if(Yii::app()->user->hasFlash('input_hundred')):?>
    <div class="errorMessage">
    <?php echo Yii::app()->user->getFlash('input_hundred'); ?>
    </div>
	<?php endif; ?>
		   
                <div class="mb20"></div>
                <div class="panel panel-default">
                  <div class="panel-body titlebar">
                    <span class="glyphicon  glyphicon-th"></span>
					<h2>
					Add more frequency jobs to Quote - <?php  echo Buildings::Model()->FindByPk($model->building_id)->building_name; ?>
					</h2>
                  </div>
                </div>
		
                <dl class="quotedetaildl col-md-6"> 
				  <dt class="col-md-4">Number of Frequency</dt>
				  <dd class="col-md-6">
				  <?php $number_of_jobs = isset($_POST['number_of_jobs']) ? $_POST['number_of_jobs'] : 0; ?>
				  <input type="text" name="number_of_jobs"  onkeypress="return isNumber(event)" value="<?php echo $number_of_jobs; ?>" class="form-control" />
				  </dd> 
				  
				  
				  <dt class="col-md-4"></dt>				  
                  <dd class="col-md-6">
					&nbsp;
				  </dd> 
				</dl>
		  
				
				  <dl class="quotedetaildl col-md-6">
				  <dt class="col-md-4">&nbsp;</dt>				  
                  <dd class="col-md-6">
				  <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
				  </dd>				  
				  </dl>
	
                <div class="clearfix"></div>


          </div>
        </div>
		
<?php $this->endWidget(); ?>
		
      </div>
      <!-- contentpanel --> 
   
   
<script type="text/javascript">

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}		

</script>