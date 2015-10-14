<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Update Service</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="edit_jobimage_id" value="<?php echo $model->id; ?>" class="form-control" />
        <input type="hidden" id="edit_job_id" value="<?php echo $model->job_id; ?>" class="form-control" />
            
        <div class="form-group">
          <label class="col-sm-4">Area</label>
          <div class="col-sm-8">
            <input type="text" autocomplete="off" id="edit_area" value="<?php echo $model->area; ?>" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4">Note</label>
          <div class="col-sm-8">
            <input type="text"  autocomplete="off"  id="edit_note" value="<?php echo $model->note; ?>" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4">&nbsp;</label>
          <div class="col-sm-8">
            <button class="btn btn-primary mr5" id="edit_addbtn1"  onclick="update_job_image_data(); return false;" >Update</button>
          </div>
        </div>
      </div>
    </div>
 
    </div>

	<script type="text/javascript" charset="utf-8">
	
function update_job_image_data() {

	var job_image_id = jQuery('input#edit_jobimage_id').val(); 
	var job_id = jQuery('input#edit_job_id').val(); 
	var area = jQuery('input#edit_area').val(); 
	var note = jQuery('input#edit_note').val(); 
		

		if(area == '' || area == null ) {
		alert("Please enter Description"); return false;
		}
	//var post_data = 'area='+area+'&note='+note+'&id='+id;

	
		post_data = {
           id: job_id,
           job_image_id: job_image_id,
           area: area,
           note: note
       };
		
		  jQuery.ajax(
							{
							url : '/?r=Quotes/job/Update_JobImageData',
							type: "POST",
							data : post_data,
							success:function(data, textStatus, jqXHR){
								
								jQuery('input#edit_jobimage_id').val(''); 
								jQuery('input#edit_job_id').val(''); 
								jQuery("input#edit_area").val('');
								jQuery("input#edit_note").val('');
								jQuery('#ajaxModal').modal('hide');
								
								jQuery('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                jQuery.fn.yiiGridView.update('building-grid-'+job_id); 
								 
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;

}


</script>