<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Update Company Name</h4>
      </div>
      <div class="modal-body">
     
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'licences-type-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	 
	 
	 
        <div class="form-group">
          <label class="col-sm-4">Induction Company Name</label>
          <div class="col-sm-8">
            <input type="hidden" id="induction_company_id" value="<?php echo $model->id; ?>" class="form-control" />
            <input type="text"  autocomplete="off"  id="edit_InductionCompanyName" value="<?php echo $model->name; ?>"  class="form-control" />
          </div>
        </div>
       
		
		 <div class="form-group">
		<?php echo $form->labelEx($model,'single_induction',array('class'=>'col-sm-4')); ?>
		<div class="col-sm-7">
		<?php echo $form->dropDownList($model, 'single_induction', array("0" => "No", "1" => "Yes"),array('id'=>'edit_single_induction','class'=>'form-control')); ?>		
		<?php echo $form->error($model,'single_induction'); ?>
		</div>		
		</div>

		
        <div class="form-group">
          <label class="col-sm-4">&nbsp;</label>
          <div class="col-sm-8">
            <button class="btn btn-primary mr5"  onclick="update_induction_company(); return false;" >Update</button>
          </div>
        </div>
     
<?php $this->endWidget(); ?>

	 </div>
    </div>
 
    </div>

	<script type="text/javascript" charset="utf-8">
	
function update_induction_company() {

		var induction_company_id = jQuery('input#induction_company_id').val(); 
		var edit_InductionCompanyName = jQuery('input#edit_InductionCompanyName').val(); 
		var edit_single_induction = jQuery('#edit_single_induction').val(); 
		
		if(edit_InductionCompanyName == '' || edit_InductionCompanyName == null ) {
		alert("Please enter Induction Company Name"); return false;
		}
		
	
	post_data = {          
           induction_company_id: induction_company_id,
           edit_InductionCompanyName: edit_InductionCompanyName,
           edit_single_induction: edit_single_induction
       };

		
		  jQuery.ajax(
							{
							url : '/?r=InductionCompany/default/updateInductionCompany',
							type: "POST",
							data : post_data,
							success:function(data, textStatus, jqXHR){
								if(data == 'already_exist') {
									alert('This Induction Company already exist.'); return false;
								}						
								jQuery("input#induction_company_id").val('');								
								jQuery("input#edit_InductionCompanyName").val('');	
								jQuery('#ajaxModal').modal('hide');								
								jQuery('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                jQuery.fn.yiiGridView.update('InductionCompanyNamegrid'); 
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
								
									return false;


}


</script>