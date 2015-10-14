<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Job Sheet</title>
<style>
table{ font-family:sans-serif; font-size:12px; border-collapse:collapse;  border:#666666 solid 1px;}
table td{ font-family:sans-serif; font-size:12px; padding:4px; border-collapse:collapse;  border:#666666 solid 1px;}
table th{ font-family:sans-serif; font-size:14px; padding:4px; border-collapse:collapse; border:#666666 solid 1px;}
.logo{float:left; width:130px;}
.title{float:left; width:400px; margin-top:35px;}
.title h1{font-size:30px; margin:0; padding-left:12%; text-align:left;}

		.heading{background:#5b9bd5; margin-bottom:8px;}
		.agent_name, .Position_wrapper{line-height:28px; font-size:14px;}
		.agent_name td, .Position_wrapper td, .Scope_wrapper td, .Job_Notes_wrapper td, .equipment_wrapper td{padding-left:12px;}
		.td1{background:#deebf7;}
		.td2{background:#e9eff7;}
		.td3{background:#d1deef;}
		.padding_left{padding:0 !important;}
		.table2 tr td{text-align:center;}
		.table2 .td3 td{padding-bottom:10px;}
		.pickup_wrapper{margin:15px 0;}
		.Position_wrapper .table3 .staff_2 td{padding-bottom:50px;}
		.Scope_wrapper{margin:5px 0px;}
		.Scope_wrapper .table4 .td3 td{padding-bottom:50px;}
		.Job_Notes_wrapper .table5 .td3 td{padding-bottom:50px;}
		.border{border:2px solid #000; padding:5px; width:100%;}
		.border td{line-height:28px;}
		.address{padding-left:12px; font-size:12px; margin:20px 0;}
		.border table{border-spacing: 2px !important;  border-collapse: inherit;}
		.padding_left table{border-spacing:0px !important;}
		
		.wtilliams{padding-left:0 !important;}
		.agent_name1{padding-right:0 !important;}
		.heading > td{border-bottom:5px solid #fff;}
		.border table tr td{border:1px solid #fff;}
		.Jose{border:none !important;}
		.Jose tr{border:none !important;}
		.Jose tr td{border:none !important;}
		.Jose td{padding-right:5%;}
		
</style>


</head>

<body>
<?php
	
	$startDay =''; $endDay ='';
	if($job_model->job_started_date != '0000-00-00' ) {
			$timestamp = strtotime($job_model->job_started_date);
				$startDay = date('D', $timestamp);			
			}
	
	if($job_model->job_end_date != '0000-00-00' ) {
		$timestamp = strtotime($job_model->job_end_date);
		$endDay = date('D', $timestamp);
	}		
	
	$toolTypes_array = array(); $toolTypes_array_str = '';
	$toolTypes = explode(',',$job_model->tool_types_ids);
	foreach($toolTypes as $tool_id) {
	$toolTypes_array[] = ListToolsType::Model()->FindByPk($tool_id)->name;
	}
	if(count($toolTypes_array) > 0)
	$toolTypes_array_str = implode(', ',$toolTypes_array);
			
	
?>

<div class="border">
    <div class="logo_wrepp">
        <div class="logo">
<p>
<!--<img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/pdf_logo_high.png" />-->

<?php $path = Yii::app()->basePath.'/../uploads/service-agent-logos/thumbs/'; ?>	
<?php if(isset($this->agent_info->logo) && $this->agent_info->logo !=NULL && file_exists($path.$this->agent_info->logo)) { ?>
<img src="<?php echo Yii::app()->getBaseUrl(true).'/uploads/service-agent-logos/thumbs/'.$this->agent_info->logo; ?>" title="<?php echo $this->agent_info->business_name; ?>" > 
<?php } ?>

</p>
         </div>
         <div class="title">
            <h1 align="center">JOB SHEET</h1>
         </div>   
         <br clear="all" />
	</div>


	<div class="first_section">
        	<div class="agent_name agent_name1">
            	<table width="100%">
                        <thead>
                            <tbody>
                                <tr class="heading" >
                                    <td width="50%">Client Name</td>
                                    <td><?php echo $company_model->name; ?></td>
                                </tr>
                                <tr class="td1">
                                    <td>Site Name</td>
                                    <td><?php echo $site_model->site_name ; ?></td>
                                </tr>
                                <tr class="td2">
                                    <td>Site Address</td>
<td>
<?php 

$site_full_text = '';
if(!empty($site_model->address))
$site_full_text .= ', '.$site_model->address;

if(!empty($site_model->suburb))
$site_full_text .= ', '.$site_model->suburb;

if(!empty($site_model->state))
$site_full_text .= ', '.$site_model->state;

if(!empty($site_model->postcode))
$site_full_text .= ', '.$site_model->postcode;


?>
<?php echo $site_full_text; ?>

</td>
                                </tr>
                                <tr class="td3">
                                    <td>Site Contact Name/Number</td>
                                    <td class="padding_left">
                                        <table class="table-responsive Jose" cellspacing="0" cellpadding="0" width="100%">
                                            <tr class="td3">
                                                <td width="200"><?php echo $site_model->site_contact ; ?></td>
                                                <td><?php echo $site_model->phone ; ?></td>
                                            </tr>
                                         </table>
                                    </td>
                                </tr>
                                <tr class="td2">
                                    <td>Client Contact Name/Number</td>
                                    <td class="padding_left">
                                        <table class="table-responsive Jose" cellspacing="0" cellpadding="0" width="100%">
                                           <tr class="td2">
                                                <td width="200"><?php echo $contact_model->first_name.' '.$contact_model->surname; ?></td>
                                                <td><?php if(!empty($contact_model->mobile)) { echo $contact_model->mobile; } else { echo $contact_model->phone; } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr class="td3">
                                    <td width="50%">Purchase Order Number</td>
                                    <td width="50%"><?php echo $job_model->purchase_order; ?></td>
                                </tr>
                            </tbody>
                        </thead>
                    </table>
            </div>
	</div>
	
	
  	<div class="pickup_wrapper">
        	<table width="100%" class="table2">
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
   


   <div class="Position_wrapper  table-responsive">
        	
        	<table width="100%" class="table3">
                <tr class="heading">
                    <td style="text-align:center;">Position</td>
                    <td style="text-align:center;">Name</td>
                    <td style="text-align:center;">Mobile</td>
                    <td style="text-align:center;">Induction</td>
                    <td style="text-align:center;">Licences</td>
                </tr>
          
<?php $user_count = 0; if(count($job_all_users) > 0) { ?>            
<?php foreach ($job_all_users as $key=>$job_date_user) { ?>

<?php if($user_count > 0 ) { ?>
<tr class="td2">
<?php $split_date_dn = explode('_',$key); ?>    
    <td colspan="5"><strong><?php echo $split_date_dn[0].' ('.$split_date_dn[1].')'; ?></strong></td>
</tr>                    
<?php } ?>		  
		  
				<?php foreach ($job_date_user as $job_user) { ?>
				
				
                <tr class="td3">
				
                    <td><?php echo $job_user['Position']; ?></td>
                    <td><?php echo $job_user['Name']; ?></td>
                    <td style="text-align:center;"><?php echo $job_user['Mobile']; ?></td>
                    <td style="text-align:center;"><?php echo $job_user['Induction']; ?></td>
                    <td style="text-align:center;"><?php echo $job_user['Licences']; ?></td>
                
				
				</tr>
				
				<?php } $user_count++; ?>
<?php } } ?>
				
		  </table>
           
        </div>   
      
	  <div class="Scope_wrapper">
        	
        	<table width="100%" class="table4">
                <tr class="heading">
                	<td>Scope of Work</td>
                </tr>
                <tr class="td3">
                	<td>
					<?php foreach($job_services_model as $service) { echo $service->service_description.'<br/>';  } ?>	
					<?php echo $job_model->extra_scope_of_work; ?>
					</td>
                </tr>
            </table>
            
        </div> 
      

	  <div class="Job_Notes_wrapper">
        	
        	<table width="100%" class="table-responsive table5">
                <tr class="heading">
                	<td>Job Notes</td>
                </tr>
                <tr class="td3">
                	<td>
                            <?php  echo $job_model->job_note; ?>
                            <?php  if(!empty($job_model->si_staff_contractor)) echo '<div class="clear"></div>'.html_entity_decode ($job_model->si_staff_contractor); ?>
                        </td>
                </tr>
            </table>
            
        </div>
		

		
        <div class="equipment_wrapper">
        	
        	<table width="100%" class="table-responsive table6">
                <tr class="heading">
                	<td>Equipment</td>
                </tr>
                <tr class="td3">
                	<td><?php echo $toolTypes_array_str; ?>.</td>
                </tr>
            </table>
            
        </div>   
	
       <!-- <div class="address">
                	High Clean Pty Ltd<br>
                    ABN: 45631025732<br>
                    E: infohighclean.com.au<br>
                    W: www.highclean.com.au<br>
                    A: 1/92 Railway st sotuh, Alton VIC 3018<br>
                    T: 03 8398 0804 F: 03 8398 9899 
        </div>-->

<?php 


$complete_address_text = '';

if(!empty($this->agent_info->business_name)){
$complete_address_text .=  $this->agent_info->business_name.'<br/>';
}


if(!empty($this->agent_info->abn)){
$complete_address_text .=  'ABN: '.$this->agent_info->abn.'<br/>';
}


if(!empty($this->agent_info->business_email_address)){
$complete_address_text .=  'E: '.$this->agent_info->business_email_address.'<br/>';
}


if(!empty($this->agent_info->website)){
$complete_address_text .=  'W: '.$this->agent_info->website.'<br/>';
}

			$concat_business_address = '';
			
			if(!empty($this->agent_info->street))
			$concat_business_address .= $this->agent_info->street;
			
			if(!empty($this->agent_info->city))
			$concat_business_address .= ', '.$this->agent_info->city;			
			
			if(!empty($this->agent_info->state_province))
			$concat_business_address .= ', '.$this->agent_info->state_province;
			
			if(!empty($this->agent_info->zip_code))
			$concat_business_address .= ', '.$this->agent_info->zip_code;
			

if(!empty($concat_business_address)){
$complete_address_text .=  'A: '.$concat_business_address.'<br/>';
}


if(!empty($this->agent_info->phone)){
$complete_address_text .=  'T: '.$this->agent_info->phone;
}

if(!empty($this->agent_info->fax)){
$complete_address_text .=  ' F: '.$this->agent_info->fax;
}



?>

<div class="address"><?php echo $complete_address_text; ?></div>



</div>
  
</body>
</html>
