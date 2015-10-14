<?php if($this->IsUsingDevice) { ?>
<style>
body {
    font-size: 10px;    
}
</style>
<?php } ?>

<div class="pageheader">
    <div class="media">
        <div class="media-body">
            <h4>Job Details</h4>
        </div>
    </div>
</div>

<input type="hidden" id="job_id" readonly value="<?php echo $model->id; ?>" class="form-control" />

<?php 

$leftDiv = 'class="col-md-10 col-sm-12"';
$rightDiv = 'class="col-md-2 col-sm-12"';
$staffTableStyle = '';

if($this->IsUsingDevice) { 

	$leftDiv = 'class="col-md-9 col-sm-9"';
	$rightDiv = 'class="col-md-3 col-sm-3"';
	$staffTableStyle = 'style="font-size: 10px"';


} ?>


<div class="container job_detalis" style="width:100%;">
    <div class="row">
        <div class="col-md-12 col-sm-12">
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
                            <td width="23%"><?php echo $job_model->job_total_working_hour; ?></td>
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
                            <td class="padding_left">
                                <table class="table-responsive Jose" width="100%">
                                    <tr class="td3">
                                        <td width="50%"><?php echo $site_model->site_contact; ?></td>
                                        <td><?php echo $site_model->phone; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="td2">
                            <td>Client Contact Name/Number</td>
                            <td class="padding_left">
                                <table class="table-responsive Jose" width="100%">
                                    <tr class="td2 Jose">
                                        <td width="50%"><?php echo $contact_model->first_name . ' ' . $contact_model->surname; ?></td>
                                        <td><?php echo $contact_model->phone; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="td3">
                            <td>Purchase Order Number</td>
                            <td><?php echo $job_model->purchase_order; ?></td>
                        </tr>

                        <tr class="td2">
                            <td>Approval Status</td>
                            <td><?php echo $model->approval_status; ?></td>
                        </tr>

                        <tr class="td3">
                            <td>Job Status</td>
							<?php
                                    if ($model->signed_off === 'Yes') {
                                        $job_status = 'Signed Off';
                                    } else {
                                        $job_status = $model->job_status;
                                    }
                               ?>
                              <td><?php echo $job_status; ?></td>
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



            
<?php if(count($job_all_users) > 0) { ?> 

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
                        <td style="width:65px">S-SMS</td>
                        <td style="width:65px">R-SMS</td>
                    </tr>


<?php foreach ($job_all_users as $key=>$job_date_user) { ?>


<tr class="td2">
<?php $split_date_dn = explode('_',$key); ?>    
<td colspan="12">
<strong><?php echo $split_date_dn[0].' ('.$split_date_dn[1].')'; ?></strong>
&nbsp;&nbsp;&nbsp;

</td>
</tr>                    

<?php foreach ($job_date_user as $job_user) { ?>    

<?php

$_sent_box_color_css_style = '<img src="'.$this->base_url_assets.'/images/small-icons/very_light_blue.png" style="margin-top:-6px;">'; // black default
$_recieved_box_color_css_style = '<img src="'.$this->base_url_assets.'/images/small-icons/very_light_blue.png" style="margin-top:-6px;">'; // black default

if($job_user['msg_sms_service_used'] === '1') {

	//sent message
	if($job_user['msg_sent_status'] === 'Sent')
	$_sent_box_color_css_style = '<img src="'.$this->base_url_assets.'/images/small-icons/circle-green.png" style="margin-top:-6px;">'; // green if sent
	else if($job_user['msg_sent_status'] === 'Failed')
	$_sent_box_color_css_style = '<img src="'.$this->base_url_assets.'/images/small-icons/circle-red.png" style="margin-top:-6px;">'; // red if not failed
      
        // replied message
	
        if($job_user['msg_replied_status'] === '1' && in_array($job_user['msg_replied_text'],array('y','Y')))
         $_recieved_box_color_css_style = '<img src="'.$this->base_url_assets.'/images/small-icons/circle-green.png" style="margin-top:-6px;">'; // green if Replied 'yes'		
        else if($job_user['msg_replied_status'] === '1' && !in_array($job_user['msg_replied_text'],array('y','Y')))
        $_recieved_box_color_css_style = '<img src="'.$this->base_url_assets.'/images/small-icons/circle-red.png" style="margin-top:-6px;">'; // red if not Replied
        
}



?>                        
			


<tr class="td3">
    
<td><?php echo $job_user['Position']; ?></td>
<td><?php echo $job_user['Name']; ?></td>                       
<td><?php echo $job_user['working_time']; ?></td>
<td><?php echo $job_user['Mobile']; ?></td>
<td align="center"><?php echo $job_user['Induction']; ?></td>
<td align="center"><?php echo $job_user['Licences']; ?></td>

<?php 

$place_to_come = 'YARD';
if($job_user['place_to_come'] === 'SITE')
$place_to_come = 'SITE';

?>

<td align="center" class="chec_box">
    <input type="radio" value="YARD" <?php if($place_to_come === 'YARD') echo 'checked'; ?> />
</td>

<td align="center" class="chec_box">
    <input type="radio" value="SITE" <?php if($place_to_come === 'SITE') echo 'checked'; ?> />
</td>



<td align="center" class="chec_box" >
 <?php echo $_sent_box_color_css_style; ?> 
</td>

<td align="center" class="chec_box" >
<?php echo $_recieved_box_color_css_style; ?>
</td>

</tr>
                    
<?php } ?>

                  
                    
<?php } ?>


                </table>
            </div>
    

<?php } ?>


 
            
            


        </div>

    </div>       
</div>

