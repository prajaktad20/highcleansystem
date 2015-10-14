<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Update Service</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="edit_jobservice_id" value="<?php echo $model->id; ?>" class="form-control" />
        <input type="hidden" id="edit_job_id" value="<?php echo $model->job_id; ?>" class="form-control" />
            
        <div class="form-group">
          <label class="col-sm-4">Description</label>
          <div class="col-sm-8">
            <input type="text" autocomplete="off" id="edit_description" value="<?php echo $model->service_description; ?>" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4">Quantity</label>
          <div class="col-sm-8">
            <input type="text"  autocomplete="off" id="edit_quantity" value="<?php echo $model->quantity; ?>" onkeypress="return isNumber(event)"  class="pricede form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4">Unit Price</label>
          <div class="col-sm-8">
            <input type="text"  autocomplete="off"  id="edit_unit" value="<?php echo $model->unit_price_rate; ?>" class="pricede form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4">Notes</label>
          <div class="col-sm-8">
            <input type="text"  autocomplete="off"  id="edit_notes" value="<?php echo $model->notes; ?>" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4">&nbsp;</label>
          <div class="col-sm-8">
            <button class="btn btn-primary mr5" id="edit_addbtn1"  onclick="update_building_service(); return false;" >Update</button>
          </div>
        </div>
      </div>
    </div>
 
    </div>

	<script type="text/javascript" charset="utf-8">
	
function update_building_service() {

	var id = jQuery('input#edit_jobservice_id').val(); 
	var job_id = jQuery('input#edit_job_id').val(); 
	var description = jQuery('input#edit_description').val(); 
	var quantity = jQuery('input#edit_quantity').val(); 
	var unit = jQuery('input#edit_unit').val(); 
	var notes = jQuery('input#edit_notes').val(); 
		

		if(description == '' || description == null ) {
		alert("Please enter Description"); return false;
		}
		else if(quantity == '' || quantity == null ) {
		alert("Please enter Quantity"); return false;
		}
		else if(unit == '' || unit == null ) {
		alert("Please enter Unit Price"); return false;
		}
		
	//var post_data = 'description='+description+'&quantity='+quantity+'&unit='+unit+'&notes='+notes+'&id='+id;

		post_data = {
           id: id,
           description: description,
           quantity: quantity,
           unit: unit,
           notes: notes
       };
	   
		  jQuery.ajax(
							{
							url : '/?r=Quotes/default/update_buliding_service',
							type: "POST",
							data : post_data,
							success:function(data, textStatus, jqXHR){
								
								jQuery('input#edit_jobservice_id').val(''); 
								jQuery('input#edit_job_id').val(''); 
								jQuery("input#edit_description").val('');
								jQuery("input#edit_quantity").val('');
								jQuery("input#edit_unit").val('');
								jQuery("input#edit_notes").val('');
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