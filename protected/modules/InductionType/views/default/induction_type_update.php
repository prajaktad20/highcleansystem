<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Update Induction Type Name</h4>
      </div>
      <div class="modal-body">
     
        <div class="form-group">
          <label class="col-sm-4">Induction Type Name</label>
          <div class="col-sm-8">
            <input type="hidden" id="induction_type_id" value="<?php echo $model->id; ?>" class="form-control" />
            <input type="text"  autocomplete="off"  id="edit_InductionTypeName" value="<?php echo $model->name; ?>"  class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4">&nbsp;</label>
          <div class="col-sm-8">
            <button class="btn btn-primary mr5"  onclick="update_induction_type(); return false;" >Update</button>
          </div>
        </div>
      </div>
    </div>
 
    </div>

	<script type="text/javascript" charset="utf-8">
	
function update_induction_type() {

		var induction_type_id = jQuery('input#induction_type_id').val(); 
		var edit_InductionTypeName = jQuery('input#edit_InductionTypeName').val(); 
		
		if(edit_InductionTypeName == '' || edit_InductionTypeName == null ) {
		alert("Please enter Induction Type Name"); return false;
		}
		
	
	post_data = {          
           induction_type_id: induction_type_id,
           edit_InductionTypeName: edit_InductionTypeName
       };

	
	
	  jQuery.ajax(
							{
							url : '/?r=InductionType/default/updateInductionType',
							type: "POST",
							data : post_data,
							success:function(data, textStatus, jqXHR){
								if(data == 'already_exist') {
									alert('This Induction Type already exist.');	return false;
								}	
								jQuery("input#induction_type_id").val('');											
								jQuery("input#InductionTypeName").val('');	
								jQuery('#ajaxModal').modal('hide');											
								jQuery('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                jQuery.fn.yiiGridView.update('induction-type-grid'); 
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
	
								
									return false;


}


</script>