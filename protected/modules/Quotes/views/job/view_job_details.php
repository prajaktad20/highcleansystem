<?php 

$leftDiv = 'class="col-md-10 col-sm-12"';
$rightDiv = 'class="col-md-2 col-sm-12"';
$staffTableStyle = '';

if($this->IsUsingDevice) { 

	$leftDiv = 'class="col-md-9 col-sm-9"';
	$rightDiv = 'class="col-md-3 col-sm-3"';
	$staffTableStyle = 'style="font-size: 10px"';
	
?>

<style>
body {
    font-size: 10px;    
}
</style>

<?php } ?>

<?php

$criteria = new CDbCriteria();
$criteria->select = "id,first_name,last_name,mobile_phone";
$criteria->condition = "role_id in(1,5) && status='1' && $this->where_agent_condition";
$criteria->order = 'first_name';
$supervisors = User::model()->findAll($criteria);

?>

<div class="pageheader">
    <div class="media">
        <div class="media-body">
            <h4>Job Details</h4>
        </div>
    </div>
</div>

<input type="hidden" id="job_id" readonly value="<?php echo $model->id; ?>" class="form-control" />


<?php
        $contacts_options = array();
        $selected_company_id = $quote_model->company_id;
        $criteria = new CDbCriteria();
        $criteria->select = "id,first_name,surname,mobile";
        $criteria->condition = "company_id =:company_id";
        $criteria->params = array(':company_id' => $selected_company_id);
        $criteria->order = 'first_name';
        $loop_contacts = Contact::model()->findAll($criteria);

        foreach ($loop_contacts as $value)  {			
        $contacts_options[$value->id] =  $value->first_name.' '.$value->surname.' (mobile-'.$value->mobile.')'; 
        }

?>

<div class="container job_detalis" style="width:100%;">
    <div class="row">  
		
        <div <?php echo $leftDiv; ?> >
            <div class="table-responsive">
                <table width="100%">

                    <tbody>
                        <tr class="heading">
                            <td width="25%">Job Number</td>
                            <td width="25%">Quote Number</td>
                            <td>Number of Staff Required</td>
                            <td>Job Hours</td>
                        </tr>
                        <tr class="td1">
                            <td><?php echo $job_model->id; ?></td>
                            <td><?php echo $job_model->quote_id; ?></td>
                            <td><?php echo $job_model->staff_required; ?></td>
                            <td width="23%">
							 <span style="float:left" >
                                    <span id="job_total_working_hour_value"><?php echo $job_model->job_total_working_hour; ?></span>
                                    <input id="job_total_working_hour" size="10" value="<?php echo $job_model->job_total_working_hour ?>" class="form-control"  style="display:none;" />
                                </span>

                                <span class="pull-right" style="margin-right:10px;">
                                    <a   href="javascript:void(0);" id="job_total_working_hour_action_edit">Edit</a>
                                    <a  style="display:none;" href="javascript:void(0);" id="job_total_working_hour_action_save" onclick="update_job_total_working_hour();
                                            return false;" >Save</a>							
                                </span>							
							</td>
                        </tr>
                    </tbody>

                </table>
            </div>
            <div class="clint_div table-responsive">
                <table width="100%">

                    <tbody>
                        <tr class="heading" >
                            <td width="50%">Client Name</td>
                            <td><?php echo $company_model->name; ?></td>
                        </tr>
                        <tr class="td1">
                            <td>Site Name</td>
                            <td><?php echo $site_model->site_name; ?></td>
                        </tr>
                        <tr class="td2">
                            <td>Site Address</td>

<?php

$site_full_text ='';

if(!empty($site_model->address))
$site_full_text .= $site_model->address;

if(!empty($site_model->suburb))
$site_full_text .= ', '.$site_model->suburb;

if(!empty($site_model->state))
$site_full_text .= ', '.$site_model->state;

if(!empty($site_model->postcode))
$site_full_text .= ' '.$site_model->postcode;


?>

                            <td><?php echo $site_full_text; ?></td>
                        </tr>
                        <tr class="td3">
                            <td>Site Contact Name/Number</td>
                            <td>
	<div style="width:50%;float:left;"><?php echo $site_model->site_contact; ?></div>
	<div style="width:5%;text-align:center;float:left;color:#FFFFFF;">|</div>
	<div style="width:44%;float:left;"><?php echo $site_model->phone; ?></div>                           
                            </td>
                        </tr>
                        
                        <tr class="td2">
                            <td>Client Contact Name/Number (<a href="javascript:void(0);" onclick="allow_change_contact();" > Change Contact </a>)</td>
                            <td>
									<div style="width:50%;float:left;"><?php echo $contact_model->first_name . ' ' . $contact_model->surname; ?></div>
									<div style="width:5%;text-align:center;float:left;color:#FFFFFF;">|</div>
									<div style="width:44%;float:left;"><?php if(!empty($contact_model->mobile)) { echo $contact_model->mobile; } else { echo $contact_model->phone; } ?></div>
                            </td>
                        </tr>
                        
                        <tr class="td2" id="change_quote_contact" style="display:none;">
                            <td>Change Contact</td>
                            <td>
                            
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'quotes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
                            
 <?php echo $form->dropDownList($quote_model, 'contact_id',$contacts_options,array('onchange' => 'return FindContactSites(this.value);','class'=>'form-control','id' => 'company_contacts','style'=>'width:80%;float: left;') ); ?>
 <?php echo CHtml::submitButton('Save',array('class'=>'btn btn-primary','style'=>'float:right')); ?>
 <?php $this->endWidget(); ?>
                            
                            </td>
                        </tr>
                        
                        <tr class="td3">
                            <td>Purchase Order Number</td>
                            <td>
                                <span style="float:left" >
                                    <span id="purchase_order_value"><?php echo $job_model->purchase_order; ?></span>
                                    <input id="purchase_order" value="<?php echo $job_model->purchase_order ?>" class="form-control"  style="display:none;" />
                                </span>

                                <span class="pull-right" style="margin-right:10px;">
                                    <a   href="javascript:void(0);" id="purchase_order_action_edit">Edit</a>
                                    <a  style="display:none;" href="javascript:void(0);" id="purchase_order_action_save" onclick="update_purchase_order();
                                            return false;" >Save</a>							
                                </span>


                            </td>
                        </tr>

                        <tr class="td2">
                            <td>Approval Status</td>
                            <td>
                                <span id="approval_status">
                                    <?php if ($model->approval_status == 'Pending Admin Approval') { ?>
                                        <span class="pull-right" style="margin-right:10px;"><a href="javascript:void(0);" onclick="approve_job('<?php echo $model->id; ?>');
                                                    return false;">Approve Job</a></span>
                                            <?php
                                        } else {
                                            echo $model->approval_status;
                                        }
                                        ?>
                                </span>	

                            </td>
                        </tr>

						
<?php
		if ($model->signed_off === 'Yes') {
			$job_status = 'Signed Off';
		} else {
			$job_status = $model->job_status;
		}
?>						
						
                        <tr class="td3">
                            <td>Job Status</td>
                              <td>
							  <span id="current_job_status" style="float:left;"><?php echo $job_status; ?></span>
							  <div style="float:right;"><?php if ($model->job_status == 'NotStarted') { ?>
                                        <input type="button" value="Start Job" id="start_job" class="job_button_started" />  
                                    <?php } ?>

                                    <?php $DisplayNone = 'style="display:none;"'; ?>

                                    <input type="button" value="Restart Job" id="restart_job" class="job_button_approved" <?php
                                    if ($model->job_status == 'Paused') {
                                        echo '';
                                    } else {
                                        echo $DisplayNone;
                                    }
                                    ?> />  

                                    <input type="button" value="Pause Job" id="pause_job" class="job_button_paused" <?php
                                    if ($model->job_status == 'Started' || $model->job_status == 'Restarted') {
                                        echo '';
                                    } else {
                                        echo $DisplayNone;
                                    }
                                    ?> />  

                                    <input type="button" value="Complete Job" id="complete_job" class="job_button_completed" <?php
                                    if ($model->job_status == 'Started' || $model->job_status == 'Restarted') {
                                        echo '';
                                    } else {
                                        echo $DisplayNone;
                                    }
                                    ?> />  </div>
									</td>
                        </tr>

                    </tbody>

                </table>
            </div>
            <div class="pickup_wrapp table-responsive">
                <table width="100%">
                    <tr class="heading">
                        <td>Pick up Van</td>
                        <td>On site</td>
                        <td>Finish on Site</td>
                    </tr>
                   
                    <tr class="td3">
                                           
                        <td><?php echo $times['pick_up_van_time_date']; ?></td>
                        <td><?php echo $times['site_time_date']; ?></td>
                        <td><?php echo $times['finish_time_date']; ?></td>
                       
                    </tr>
                    
                </table>
            </div>



            <div class="clint_div table-responsive">
                <table class="table table-bordered mb30 quote_table">
                    <thead>
                        <tr class="heading">
                            <td width="40%">Description</td>
                            <td  width="8%">Quantity</td>
                            <td  width="12%">Rate</td>
                            <td  width="10%">Total</td>
                            <td  width="20%">Photo</td>                    
                        </tr>
                    </thead>
                    <tbody>

<?php
$sub_total = 0;
foreach ($BuildingServices as $ServiceRow) {
    $sub_total += $ServiceRow->total
    ?>

                            <tr class="td3">
                                <td><?php echo $ServiceRow->service_description; ?></td>
                                <td><?php echo $ServiceRow->quantity; ?></td>
                                <td><?php echo '$' . $ServiceRow->unit_price_rate; ?></td>
                                <td><?php echo '$' . $ServiceRow->total; ?></td>				  
                                <td><a id="<?php echo $ServiceRow->id; ?>" class="upload_service_image" href="javascript:void(0);" >Upload photo</a></td>
                            </tr>

<?php } ?>

<?php if ($model->discount > 0) { ?>

                            <tr class="td3">
                                <td><strong>Subtotal</strong></td>
                                <td></td>
                                <td></td>
                                <td  align="center"><strong><?php echo '$' . number_format((float) $sub_total, 2, '.', ''); ?> </strong></td>
                                <td></td>
                            </tr>


                            <tr class="td3">
                                <td><strong>Discount</strong></td>
                                <td></td>
                                <td></td>
                                <td  align="center"><strong><?php echo $model->discount; ?> %</strong></td>
                                <td></td>
                            </tr>
<?php } ?>

                        <tr class="td3">
                            <td><strong>Total</strong></td>
                            <td></td>
                            <td></td>
                            <td  align="center"><strong><?php echo '$' . $model->final_total; ?></strong></td>                    
                            <td  align="center"><strong>(excl. GST)</strong></td>
                        </tr>

                        <tr class="td3">
                            <td colspan="5" ><strong><a href="<?php echo Yii::app()->getBaseUrl(true) . '/?r=Quotes/Job/UpdateJob&id=' . $model->id; ?>">Click here to update services</a></strong></td>                    
                        </tr>

                    </tbody>
                </table>
            </div>
            <!-- table-responsive --> 


            <div class="Supervisor table-responsive">
                <table width="100%">
                    <tr class="heading">
                        <td>Select Supervisor</td>
                        <td colspan="2" width="30%;"> 

                            <span id="allocation_supervisor_dropdown" <?php if (isset($supervisor[0]->name)) echo 'style="display:none;"'; ?> >
                                <select class="form-control" name="assign_supervisor_id" id="assign_supervisor_id">
                                    <option value="0">Select Supervisor</option>
                                <?php foreach ($supervisors as $value) { ?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->first_name . ' ' . $value->last_name; ?></option>
<?php } ?>
                                </select>
                            </span>

                            <span id="allocation_supervisor_value">
                            <?php if (isset($supervisor[0]->name)) echo $supervisor[0]->name; ?>
                            </span>

                        </td>

                        <td>
                            <?php $job_remove_supervisor_class = 'style="color:#ffffff;display:none;"'; ?>
                            <?php $job_allocate_supervisor_class = 'style="color:#ffffff;display:none;"'; ?>
<?php
if (isset($supervisor[0]->name))
    $job_remove_supervisor_class = 'style="color:#ffffff;"';
else
    $job_allocate_supervisor_class = 'style="color:#ffffff;"';
?>
                            <a id="job_remove_supervisor"  <?php echo $job_remove_supervisor_class; ?> href="javascript:void(0)" >Remove Supervisor</a>
                            <a id="job_allocate_supervisor"  <?php echo $job_allocate_supervisor_class; ?> href="javascript:void(0)" onclick="assign_supervisor('<?php echo $model->id; ?>')">Allocate Supervisor</a>

                        </td>
                    </tr>
                </table>
            </div>
            
<?php if(count($job_all_users) > 0) { ?> 
<form action="?r=Quotes/Job/view&id=<?php echo $model->id; ?>" method="POST">            
            <div class="Position_wrapper table-responsive">
                <table width="100%" class="table3"  <?php echo $staffTableStyle; ?> >
                    <tr class="heading">
                        <td>Position</td>
                        <td>Name</td>
                        <td>Start Time</td>
                        <td>Mobile</td>
                        <td>Induction</td>
                        <td>Licences</td>
                        <td>Yard</td>
                        <td>Site</td>
                        <td style="width:65px"><input type="submit" class="send_sms_btn" value="S-SMS" name="send_sms_button"></td>
                        <td style="width:65px"><input type="submit" class="receive_reply_sms_btn" value="R-SMS" name="reply_sms_button"></td>
                    </tr>


<?php 

$count_records = 0;
foreach ($job_all_users as $key=>$job_date_user) { ?>


<tr class="td2">
<?php $split_date_dn = explode('_',$key); ?>    
<td colspan="12">
<strong><?php echo $split_date_dn[0].' ('.$split_date_dn[1].')'; ?></strong>
&nbsp;&nbsp;&nbsp;

</td>
</tr>                    

<?php foreach ($job_date_user as $job_user) { ?>    

<?php

$_sent_box_color_css_style = '<img src="'.$this->base_url_assets.'/images/small-icons/very_light_blue.png" style="margin-top:-6px;">'; // blue white mixture default
$_recieved_box_color_css_style = '<img src="'.$this->base_url_assets.'/images/small-icons/very_light_blue.png" style="margin-top:-6px;">'; // blue white mixture default

if($job_user['msg_sms_service_used'] === '1') {

	//sent message
	if($job_user['msg_sent_status'] === 'Sent')
	$_sent_box_color_css_style = '<img src="'.$this->base_url_assets.'/images/small-icons/circle-green.png" style="margin-top:-6px;">'; // green if sent
	else if($job_user['msg_sent_status'] === 'Failed')
	$_sent_box_color_css_style = '<img src="'.$this->base_url_assets.'/images/small-icons/circle-red.png" style="margin-top:-6px;">'; // red if not failed
      
        // replied message
	
        if($job_user['msg_replied_status'] === '1' && in_array($job_user['msg_replied_text'],array('y','Y'))) { 
			// green if Replied 'yes'		
         $_recieved_box_color_css_style = '<img src="'.$this->base_url_assets.'/images/small-icons/circle-green.png" style="margin-top:-6px;">'; 
		 } else if($job_user['msg_replied_status'] === '1' && !in_array($job_user['msg_replied_text'],array('y','Y'))) {
			// red if not Replied 
        $_recieved_box_color_css_style = '<img src="'.$this->base_url_assets.'/images/small-icons/circle-red.png" style="margin-top:-6px;">'; 
		}
        
}



?>                        
			

<?php 

$place_to_come = 'YARD';
if($job_user['place_to_come'] === 'SITE')
$place_to_come = 'SITE';

if($place_to_come == 'YARD') {
	$td_start_time_value = $job_user['yard_start_time']; 
} else if($place_to_come == 'SITE')  {
	$td_start_time_value = $job_user['site_start_time']; 
} else {
	$td_start_time_value = $job_user['working_time'];
}

?>
<tr class="td3">
    
<td><input type="checkbox" name="sent_sms[<?php echo $job_user['Position']; ?>][]" value="<?php echo $job_user['auto_id']; ?>" />&nbsp;<?php echo $job_user['Position']; ?></td>
<td><?php echo $job_user['Name']; ?></td>                       
<td id="<?php echo 'td_start_time_'.$count_records; ?>" ><?php echo $td_start_time_value; ?></td>
<td><?php echo $job_user['Mobile']; ?></td>
<td align="center"><?php echo $job_user['Induction']; ?></td>
<td align="center"><?php echo $job_user['Licences']; ?></td>
<td align="center" class="chec_box">
<input type="radio" onchange="set_worker_start_time('<?php echo $job_user['yard_start_time']; ?>','<?php echo $count_records; ?>');" name="ys[<?php echo $job_user['Position']; ?>][<?php echo $job_user['auto_id']; ?>]" value="YARD" <?php if($place_to_come === 'YARD') echo 'checked'; ?> />
</td>

<td align="center" class="chec_box">
    <input type="radio"  onchange="set_worker_start_time('<?php echo $job_user['site_start_time']; ?>','<?php echo $count_records; ?>');" name="ys[<?php echo $job_user['Position']; ?>][<?php echo $job_user['auto_id']; ?>]" value="SITE" <?php if($place_to_come === 'SITE') echo 'checked'; ?> />
</td>



<td align="center" class="chec_box" >
 <?php echo $_sent_box_color_css_style; ?> 
</td>

<td align="center" class="chec_box" >
<?php echo $_recieved_box_color_css_style; ?>
</td>

</tr>
                    
<?php $count_records++ ; } ?>

                  
                    
<?php } ?>


                </table>
            </div>
    
</form>     
<?php } ?>




            <!-- extra scope of work -->	
            <div class="Scope_of_Work table-responsive">
                <table width="100%">
                    <tr class="heading">
                        <td style="padding-right:12px;">Scope of Work 
                            <span class="pull-right">
                                <a  style="color:#ffffff;"  href="javascript:void(0);" id="extra_scope_action_edit">Edit</a>
                                <a  style="color:#ffffff;display:none;" href="javascript:void(0);" id="extra_scope_action_save" onclick="update_extra_scope();
                                        return false;" >Save</a>							
                            </span>

                        </td>	

                    </tr>
                </table>
            </div>   
            <div class="Scope_of_Work table-responsive">
                <table width="100%">
                    <tr class="td1" height="70px" style="vertical-align:top;">
                        <td><?php foreach($job_services_model as $service) { echo $service->service_description.'<br/>';  } ?>
                            <span id="extra_scope_value"><?php echo $job_model->extra_scope_of_work; ?></span>
                            <textarea id="extra_scope_of_work" value="" class="form-control"  style="display:none;" ><?php echo $job_model->extra_scope_of_work; ?></textarea>	
                        </td>
                    </tr>
                </table>
            </div>  



            <!-- job note -->
            <div class="Scope_of_Work table-responsive">
                <table width="100%">
                    <tr class="heading">
                        <td style="padding-right:12px;">Job Notes 
                            <span class="pull-right">
                                <a  style="color:#ffffff;"  href="javascript:void(0);" id="job_note_action_edit">Edit</a>
                                <a  style="color:#ffffff;display:none;" href="javascript:void(0);" id="job_note_action_save" onclick="update_job_note();
                                        return false;" >Save</a>							
                            </span>
                        </td>
                    </tr>
                </table>
            </div>   
            <div class="Scope_of_Work table-responsive">
                <table width="100%">
                    <tr class="td1" height="70px" style="vertical-align:top;">
                        <td>
                            <span id="job_note_value"><?php echo $job_model->job_note; ?></span>
                            <textarea id="job_note" value="" class="form-control"  style="display:none;" ><?php echo $job_model->job_note; ?></textarea>
                        </td>
                    </tr>
                </table>
            </div>  


            <!-- equipment -->		 
            <div class="Scope_of_Work table-responsive">
                <table width="100%">
                    <tr class="heading">
                        <td style="padding-right:12px;">Equipment 
                        
                         <span class="pull-right">
                                <a  style="color:#ffffff;" href="javascript:void(0);" onclick="update_tool_types();
                                        return false;" >Update</a>							
                            </span>
                        
                        </td>				

                    </tr>
                </table>
            </div>   

            <div class="Scope_of_Work table-responsive">
                <table width="100%">
                    <tr class="td1">
                        <td>
                            <span id="tool_type_value"><?php echo $tool_type_html_text; ?></span>
                            <div id="tool_type" style="display:none;">checkbox</div>
                        </td>
                    </tr>
                </table>
            </div> 


            
            
            


        </div>


        <div <?php echo $rightDiv; ?> >
            <div class="button" <?php echo $staffTableStyle; ?>>
                <form>
                    <a href="<?php echo Yii::app()->getBaseUrl(true) . '/?r=Quotes/default/view&id=' . $model->quote_id.'&job_id=' . $model->id; ?>">
					<input type="button" value="VIEW ALL JOBS" class="button1" />
					</a>
                </form>

				
		<form>
                    <a href="<?php echo Yii::app()->getBaseUrl(true) . '/?r=Quotes/Job/DownloadQuote&id=' . $model->id; ?>">
					<input type="button" value="QUOTE SHEET" class="button_paused" />
					</a>
                </form>

				

			<?php if ($model->booked_status == 'Booked' && $model->job_status === 'NotStarted') { ?>
				<form>
					<a href="<?php echo Yii::app()->getBaseUrl(true) . '/?r=Quotes/Job/RebookJob&from_job_details=yes&id=' . $model->id; ?>">
					<input type="button" value="REBOOK JOB" class="button_paused" />
					</a>
				</form>
			<?php } ?>    

			
			<?php 
				
				
				$job_start_date_five_days_before = date('Y-m-d',(strtotime ( '-5 day' , strtotime ( $model->job_started_date ) ) ));
				$job_start_date_ten_days_after = date('Y-m-d',(strtotime ( '10 day' , strtotime ( $model->job_started_date ) ) ));
			
			?>
			
				<form>
                    <a href="<?php echo Yii::app()->getBaseUrl(true) . '/?r=StaffJobAllocation/default/index&referenced_job_id='.$model->id.'&job_from_date='. $job_start_date_five_days_before. '&job_to_date='. $job_start_date_ten_days_after; ?>" > 
					<input type="button" value="ALLOCATE STAFF" class="button1" />
					</a>
                </form>
				
				<form>
                    <a href="<?php echo Yii::app()->getBaseUrl(true) . '/?r=Quotes/Job/DownloadJobsheet&id=' . $model->id; ?>"> 
					<input type="button" value="JOB SHEET" class="button1" />
					</a>
                </form>

              <!--- SWMS => Before sign : blue , after sign : black -->
                <form>
                    <a href="<?php echo Yii::app()->getBaseUrl(true) . '/?r=Quotes/Job/DownloadSwms&id=' . $model->id; ?>">
					<input type="button" value="SWMS" class=" <?php if ($model->swms_signature_lock === '0') { echo 'button1'; } else { echo 'button3'; } ?>" />
					</a>
                </form>

				  <?php if ($model->swms_signature_lock === '0') { ?>
                    <form>
                        <a href="<?php echo Yii::app()->getBaseUrl(true) . '/?r=Quotes/Job/SwmsSign&id=' . $model->id; ?>">
						<input type="button" value="SIGN SWMS" class="button_started" />
						</a>
                    </form>
                <?php } ?>
				
										
				<?php if($model->client_signed_off_through == '3') { 
				if(!empty($model->sign_off_document) && file_exists(Yii::app()->basePath.'/..//uploads/sign_off_document/'.$model->sign_off_document)) { ?>
				<form><a target="_blank" href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/sign_off_document/'.$model->sign_off_document; ?>" >
				<input type="button" value="SIGNOFF SHEET" class="<?php if ($model->signed_off === 'Yes') { echo 'button3'; } else { echo 'button1'; } ?>" />
				</a></form>
				<?php }  ?>
				<?php } else { ?>
				<form><a href="<?php echo $this->user_role_base_url.'/?r=Quotes/Job/DownloadSignOffSheet&id='.$model->id; ?>" >
				<input type="button" value="SIGNOFF SHEET" class="<?php if ($model->signed_off === 'Yes') { echo 'button3'; } else { echo 'button1'; } ?>" />
				</a>
				</form>
				<?php } ?>
				
								
				
				<form>
                    <a href="<?php echo Yii::app()->getBaseUrl(true) . '/?r=Quotes/Job/BuildingDocuments&id=' . $model->id; ?>">
					<input type="button" value="BLDG PHOTOS/DOCS" class="button1" style="font-size:11px;"/>
					</a>
                </form>
              

                <form>
                    <a href="<?php echo Yii::app()->getBaseUrl(true) . '/?r=Quotes/Job/JobImages&id=' . $model->id; ?>">   
					<input type="button" value="JOB CLEANING REPORT" class="button1" style="font-size:11px;"/>
					</a>
                </form>


				<?php if ($model->job_status == 'Completed' && $model->signed_off != 'Yes') { ?>
                    <form>
                        <a href="<?php echo Yii::app()->getBaseUrl(true) . '/?r=Quotes/Job/SignOffView&id=' . $model->id; ?>"> 
						<input type="button" value="SIGNOFF JOB" class="button_started" />
						</a>
                    </form>
				<?php } ?>

                <form>
                    <input type="button" value="HAZARD REPORT" class="button_orange" />
                </form>

                <form>
                    <input type="button" value="INCIDENT REPORT" class="button5" />
                </form>


            </div>
        </div>
   
	
	</div>       
</div>



<!----------- pop ups ----------------->

<div class="modal fade" id="myModal2" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">


        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Upload Image</h4>
            </div>


            <div class="modal-body">
                <div id='before_preview'>


                </div>
                <br/>
                <form id="before_imageform" method="post" enctype="multipart/form-data" action='<?php echo $this->user_role_base_url; ?>?r=Quotes/default/AjaxImageUpload'>

                    <div id='before_imageloadstatus' style="display:none;">
                        <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/ajax-loader.gif" alt="Uploading...."/>
                    </div>

                    <input type="hidden" name="job_service_id" id="job_service_id"  value="<?php echo $model->id; ?>" class="form-control" />
                    <div id='before_imageloadbutton'>
                        <input type="file" name="photoimg" id="before_photoimg" />
                    </div>
                </form>
            </div>


        </div>
        <!-- modal-content --> 



    </div>
</div>

