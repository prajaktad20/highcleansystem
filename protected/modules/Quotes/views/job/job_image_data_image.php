<style>

.modal-dialog {
margin : 100px auto 30px; !important;	
width: 80%; !important;
}

</style>

<div class="modal-dialog">
  
  
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload Image</h4>
      </div>
      <div class="modal-body">
	  
  <div class="table-responsive">
            <table class="table table-bordered mb30 quote_table quote_details">
              <thead>
<tr><th  align="center">Before Cleaning</th><th  align="center">After Cleaning</th></tr>
<tr> 

<td  align="center"> <form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo $this->user_role_base_url; ?>/?r=Quotes/job/AjaxJobImageBeforeUpload&id=<?php echo $model->job_id; ?>' >
          
		  <div id='imageloadstatus' style="display:none;"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/ajax-loader.gif" alt="Uploading...."/></div>
		  <input type="hidden" name="job_image_id"  value="<?php echo $model->id; ?>" class="form-control" />
          <div id='imageloadbutton'>
            <input type="file" name="photoimg" id="photoimg" />
          </div>
        </form>
</td>	

<td  align="center">    <form id="imageform_after" method="post" enctype="multipart/form-data" action='<?php echo $this->user_role_base_url; ?>/?r=Quotes/job/AjaxJobImageAfterUpload&id=<?php echo $model->job_id; ?>' >
          
		  <div id='imageloadstatus_after' style="display:none;"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/ajax-loader.gif" alt="Uploading...."/></div>
		  <input type="hidden" name="job_image_id"  value="<?php echo $model->id; ?>" class="form-control" />
          <div id='imageloadbutton_after'>
            <input type="file" name="photoimg_after" id="photoimg_after" />
          </div>
        </form>
</td>	  
</tr>

<tr> 


<td  align="center">        <div id='preview'>
<?php

		$path = Yii::app()->basePath.'/../uploads/job_images/';			
		if(isset($model->photo_before) && $model->photo_before !=NULL && file_exists($path.$model->photo_before)) {			
		$image_url = Yii::app()->getBaseUrl(true)."/uploads/job_images/thumbs/".$model->photo_before;
		echo "<img width='100%'  src='".$image_url."' /><br/>";
		} 



?>
		</div>
</td>	


<td align="center">
<div id='preview_after'>		
<?php

		$path = Yii::app()->basePath.'/../uploads/job_images/';			
		if(isset($model->photo_after) && $model->photo_after !=NULL && file_exists($path.$model->photo_after)) {			
		$image_url = Yii::app()->getBaseUrl(true)."/uploads/job_images/thumbs/".$model->photo_after;
		echo "<img width='100%' src='".$image_url."' />";
		} 

?>		
</div>	
</td>	  
</tr>
<thead>
</table>
 </div>		
		
      </div>
    </div>
    <!-- modal-content --> 
  
    </div>

	<script type="text/javascript" charset="utf-8">
	
jQuery(document).ready(function() { 

var job_id = '<?php echo $model->job_id; ?>';

            jQuery('#photoimg_after').die('click').live('change', function()			{ 
			     
				jQuery("#imageform_after").ajaxForm({target: '#preview_after', 
				     beforeSubmit:function(){ 
				
					jQuery("#imageloadstatus_after").show();
					 jQuery("#imageloadbutton_after").hide();
					 }, 
					success:function(data){ 
		
					 jQuery("#imageloadstatus_after").hide();
					 jQuery("#imageloadbutton_after").show();

					jQuery('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
					jQuery.fn.yiiGridView.update('building-grid-'+job_id); 
					 
					 
					 
					}, 
					error:function(){ 
					
					 jQuery("#imageloadstatus_after").hide();
					jQuery("#imageloadbutton_after").show();
					} }).submit();
					
		
			});
			
			
			
			
			
            jQuery('#photoimg').die('click').live('change', function()			{ 
			     
				jQuery("#imageform").ajaxForm({target: '#preview', 
				     beforeSubmit:function(){ 
				
					jQuery("#imageloadstatus").show();
					 jQuery("#imageloadbutton").hide();
					 }, 
					success:function(data){ 
		
					 jQuery("#imageloadstatus").hide();
					 jQuery("#imageloadbutton").show();
					 
					jQuery('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
					jQuery.fn.yiiGridView.update('building-grid-'+job_id); 
					 
					 
					}, 
					error:function(){ 
					
					 jQuery("#imageloadstatus").hide();
					jQuery("#imageloadbutton").show();
					} }).submit();
					
		
			});
			
			
			
			
			
        }); 
		


</script>