<div class="modal-dialog">
  
  
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload Image</h4>
      </div>
      <div class="modal-body">
        <div id='preview'>
<?php

		$path = Yii::app()->basePath.'/../uploads/quote-building-service/';			
		if(isset($model->image) && $model->image !=NULL && file_exists($path.$model->image)) {			
		$image_url = Yii::app()->getBaseUrl(true)."/uploads/quote-building-service/".$model->image;
		echo "<img width='100%' src='".$image_url."' />";
		} 

?>
		</div>
        <br/>
        <form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo $this->user_role_base_url; ?>?r=Quotes/default/AjaxImageUpload'>
          
		  <div id='imageloadstatus' style="display:none;"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/ajax-loader.gif" alt="Uploading...."/></div>
		  <input type="hidden" name="job_service_id"  value="<?php echo $model->id; ?>" class="form-control" />
          <div id='imageloadbutton'>
            <input type="file" name="photoimg" id="photoimg" />
          </div>
        </form>
      </div>
    </div>
    <!-- modal-content --> 
  
    </div>

	<script type="text/javascript" charset="utf-8">
	
jQuery(document).ready(function() { 

            jQuery('#photoimg').die('click').live('change', function()			{ 
			     
				jQuery("#imageform").ajaxForm({target: '#preview', 
				     beforeSubmit:function(){ 
				
					jQuery("#imageloadstatus").show();
					 jQuery("#imageloadbutton").hide();
					 }, 
					success:function(data){ 
		
					 jQuery("#imageloadstatus").hide();
					 jQuery("#imageloadbutton").show();
					 
					 
					 
					}, 
					error:function(){ 
					
					 jQuery("#imageloadstatus").hide();
					jQuery("#imageloadbutton").show();
					} }).submit();
					
		
			});
        }); 
		


</script>