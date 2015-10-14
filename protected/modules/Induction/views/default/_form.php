<?php
/* @var $this InductionController */
/* @var $model Induction */
/* @var $form CActiveForm */
?>
<style>
.other tr > td
{
  padding-bottom: 1em;
}
.table-responsive .col-md-12{padding:0;}
.titlebar{padding:5px 0 5px 5px; line-height:18px;}
.titlebar h2{float:left; margin:0 0 0 10px; font-size:14px; line-height:23px;}
.titlebar input{float:left;}
.checkbox_user{float:left;  margin-top:9px !important;}
#induction-form table tr{background:#eaeff7; line-height:30px;}
#induction-form table tr td{padding-left:5px;}
#induction-form table tr:nth-child(2n+2){background:#d2deef;}
.titlebar{background:#5B9BD5; padding:10px 5px;}
.titlebar span{float:left;}
.titlebar h2{line-height:19px;}
#induction-form .col-md-2, #induction-form .col-md-2{padding:0 10px 0 0;}
</style>
<div class="col-md-12">

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'induction-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>


<?php 

$induction_users = isset($_POST['induction_users']) ? $_POST['induction_users'] : array();
$induction_company = isset($_POST['induction_company']) ? $_POST['induction_company'] : 0;
$induction_type = isset($_POST['induction_type']) ? $_POST['induction_type'] : 0;
$induction_sites = isset($_POST['induction_sites']) ? $_POST['induction_sites'] : array();
$induction_link_document = isset($_POST['Induction']['induction_link_document']) ? $_POST['Induction']['induction_link_document'] : '0';
$induction_link = isset($_POST['Induction']['induction_link']) ? $_POST['Induction']['induction_link'] : '';
		
?>
	
<?php 
				$criteria = new CDbCriteria();
				$criteria->select = "id,first_name,last_name,email";
				$criteria->condition = "status='1' && $this->where_agent_condition && role_id IN (1,3,5,6)";
				$criteria->order = 'first_name';
				$loop_users_contacts = User::model()->findAll($criteria);
				
				$criteria2 = new CDbCriteria();
				$criteria2->select = "id,site_name";
				$criteria2->order = 'site_name';
				$criteria2->condition = "need_induction='1' && $this->where_agent_condition && induction_company_id=$induction_company";
				$loop_site_contacts = ContactsSite::model()->findAll($criteria2);				
								
				$criteria3 = new CDbCriteria();
				$criteria3->select = "id,name";
				$criteria3->order = 'name';
				$loop_InductionCompany = InductionCompany::model()->findAll($criteria3);;
				
				$criteria4 = new CDbCriteria();
				$criteria4->select = "id,name";
				$criteria4->order = 'name';
				$loop_InductionType = InductionType::model()->findAll($criteria4);
				
				
				
?>




<div class="col-md-2">
<table width="100%">
<tr><th bgcolor="#5B9BD5" align="center" class="titlebar"><input type="checkbox" id="selecctall_user" />&nbsp;&nbsp;&nbsp;<h2>User</h2></th></tr>
<?php foreach ($loop_users_contacts as $value)  { ?>
<tr><td><input  class="checkbox_user" <?php if(count($induction_users) > 0 && in_array($value->id,$induction_users)) echo 'checked="checked"'; ?> type="checkbox" name="induction_users[]" value="<?php echo $value->id; ?>" >&nbsp;&nbsp; <?php echo $value->first_name.' '.$value->last_name; ?></td></tr>
<?php } ?>
</table>
</div>


<div class="col-md-2">
<table width="100%">
<tr><th bgcolor="#5B9BD5" align="center" class="titlebar"><h2>Company</h2></th></tr>
<?php foreach ($loop_InductionCompany as $value)  { ?>
<tr><td>
<input class="induction_companies" <?php if($value->id === $induction_company) echo 'checked="checked"'; ?>  type="radio" name="induction_company" value="<?php echo $value->id; ?>"  id="<?php echo $value->id; ?>" >&nbsp;&nbsp; <?php echo $value->name; ?></td></tr>
<?php } ?>
</table>
</div>


<div class="col-md-3">
<table width="100%">
<tr><th bgcolor="#5B9BD5" align="center" class="titlebar"><h2>Type</h2></th></tr>
<?php foreach ($loop_InductionType as $value)  { ?>
<tr><td><input  <?php if($value->id === $induction_type) echo 'checked="checked"'; ?>  type="radio" name="induction_type" value="<?php echo $value->id; ?>" >&nbsp;&nbsp; <?php echo $value->name; ?></td></tr>
<?php } ?>
</table>
</div>


<div class="col-md-2">
<table id="induction_company_sites" width="100%">
<tr><th bgcolor="#5B9BD5" align="center" class="titlebar"><input type="checkbox" id="selecctall_site" onclick="CheckSelectAllSite();" />&nbsp;&nbsp;&nbsp;<h2>Site</h2></th></tr>
<?php foreach ($loop_site_contacts as $value)  { ?>
<tr><td><input  class="checkbox_site"  <?php if(count($induction_sites) > 0 && in_array($value->id,$induction_sites)) echo 'checked="checked"'; ?> type="checkbox" name="induction_sites[]" value="<?php echo $value->id; ?>" >&nbsp;&nbsp; <?php echo $value->site_name; ?></td></tr>
<?php } ?>
</table>
</div>

<div class="col-md-3">
<table class="other" width="100%">
<tr><th bgcolor="#5B9BD5" align="center" class="titlebar"><h2>Other</h2></th></tr>
<tr><td><?php echo $form->radioButtonList($model,'induction_link_document',array('0'=>'Induction Link', '1'=>'Document'),array('size'=>17,'maxlength'=>17,'class'=>'radio123','separator' => "&nbsp;&nbsp;&nbsp;&nbsp;")); ?></td></tr>
<tr id="induction_link_required" <?php if($induction_link_document != '0') echo 'style="display:none;"'; ?>  ><td><?php echo $form->textField($model,'induction_link',array('value'=>$induction_link,'size'=>60,'maxlength'=>255,'class'=>'form-control','placeholder'=>'Induction Link')); ?></td></tr>
<tr id="document_required" <?php if($induction_link_document != '1') echo 'style="display:none;"'; ?>  ><td><input type="file" name="document" class='form-control' /></td></tr>
<tr><td><?php echo $form->textField($model,'password',array('size'=>60,'maxlength'=>255,'class'=>'form-control','placeholder'=>'Password')); ?></td></tr>
<tr><td><?php echo $form->textField($model,'induction_number',array('size'=>60,'maxlength'=>255,'class'=>'form-control','placeholder'=>'Induction Number')); ?></td></tr>
<tr><td><input type="file" name="induction_card" /> &nbsp;<em>(Induction Card)</em></td></tr>
<tr><td><?php echo $form->textField($model,'completion_date',array('id'=>'completion_date','size'=>60,'maxlength'=>255,'class'=>'form-control')); ?> &nbsp;<em>(Completion Date)</em></td></tr>
<tr><td><?php echo $form->textField($model,'expiry_date',array('id'=>'expiry_date','size'=>60,'maxlength'=>255,'class'=>'form-control')); ?> &nbsp;<em>(Expiry Date)</em> </td></tr>
<tr><td><?php echo $form->dropDownList($model, 'induction_status', array("pending" => "Pending", "completed" => "Completed"),array('class'=>'form-control')); ?> &nbsp;<em>(Induction Status)</em></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td align="center"><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?></td></tr>
</table>
</div>


<?php $this->endWidget(); ?>
</div>




<script type="text/javascript">
  
  
$(document).ready(function() {
    $('#selecctall_user').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox_user').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox_user').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });

	
});


	function CheckSelectAllSite() {
				
		var site_checkbox_status = document.getElementById("selecctall_site").checked;
	
		  if(site_checkbox_status == true) { // check select status
            $('.checkbox_site').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox_site').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
	}
  

	
   $(document).ready(function(){
	   
	   
  jQuery(".induction_companies").click(function(){
	  induction_company_id = jQuery(this).attr("id");
	  	post_data = {
           induction_company_id: induction_company_id,          
       };

		
		  jQuery.ajax(
							{
							url : '?r=Induction/default/getInductionCompanySites',
							type: "POST",
							data : post_data,
							success:function(data, textStatus, jqXHR){
								jQuery('#induction_company_sites').html(data);
								
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
				
	}); 
	
    $("#completion_date").datepicker({
		dateFormat:'yy-mm-dd',
       // minDate: 0,
        maxDate: "+1000D",
        numberOfMonths: 1,
    });
	
    $("#expiry_date").datepicker({ 
		dateFormat:'yy-mm-dd',
        minDate: 0,
        maxDate:"+1000D",
        numberOfMonths: 1,       
    });  

   
 
$('.radio123').change(function(){
    var value = $( this ).val();
	if(value == 0) {
		$('#document_required').hide();
		$('#induction_link_required').show();
	}	else {
		$('#induction_link_required').hide();
		$('#document_required').show();
	}
});
 
	
	
});


	

</script>
