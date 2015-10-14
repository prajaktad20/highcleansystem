<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
			  <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/Job/view&id=<?php echo $model->id; ?>">This Job</a></li>
            </ul>
			<a href="<?php echo Yii::app()->getBaseUrl(true).'/?r=Quotes/Job/view&id='.$model->id; ?>" class="btn btn-primary pull-right">Back To Job Details</a>
            <h4>Sign Off Job</h4>
          </div>
        </div>
        <!-- media --> 
</div>
      
<div class="contentpanel">
	  
  <div class="row">
          <div class="col-md-12 quote_section"> 
		  
  
    <div class="alert alert-danger">
        <strong>Warning!</strong>&nbsp;&nbsp; This job is not yet completed. Only completed job should only be signed off.<br/>
    </div>

				
		  </div>		
  </div>		

</div>
		