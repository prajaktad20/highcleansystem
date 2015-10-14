<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sign Off Sheet</title>
<style>
table{ font-family:sans-serif; font-size:12px; border-collapse:collapse;  border:#666666 solid 1px;}
table td{ font-family:sans-serif; font-size:12px; padding:4px; border-collapse:collapse;  border:#666666 solid 1px;}
table th{ font-family:sans-serif; font-size:14px; padding:4px; border-collapse:collapse; border:#666666 solid 1px;}
	
.logo{float:left; width:130px;}
.title{float:left; width:400px; margin-top:35px;}
.title h1{font-size:30px; margin:0; padding-left:12%; text-align:left;}

		.heading{background:#5b9bd5;}
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
		.Job_Notes_wrapper .table5 .td3 td{padding:35px 0;}
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
		.sign_sheet .blue{background:#5b9bd5;}
		.sign_off_work{border-bottom:5px solid #fff;}
		
</style>


</head>

<body><?php
	
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
            <p><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/pdf_logo_high.png" /></p>
         </div>
         <div class="title">
            <h1 align="center">Sign Off Sheet</h1>
         </div>   
         <br clear="all" />
	</div>
<div class="table_wrapper">
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
                <td><?php echo $site_model->address . ', ' . $site_model->suburb. ', ' . $site_model->state. ' ' . $site_model->postcode; ?></td>
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
    <div class="Scope_of_Work table-responsive">
        <table width="100%">
        	<thead>
            <tbody>
            <tr class="heading">
                <td>Scope of Work</td>
            </tr>
            </thead>
            </tbody>
        </table>
    </div>
    <div class="Scope_of_Work table-responsive">
        <table width="100%">
            <tr class="td2">
                <td height="70px" style="vertical-align:top;">
				<?php foreach($job_services_model as $service) { echo $service->service_description.'<br/>';  } ?>	
				<?php echo $job_model->extra_scope_of_work; ?>
				</td>
				
            </tr>
        </table>
    </div>  
    <div class="Scope_of_Work sign_off_work table-responsive">
        <table width="100%">
            <tr class="sign_sheet">
                <td class="heading">Client Name</td>
                <td width="50%" class="td1"><?php echo $job_model->client_name; ?></td>
            </tr>
        </table>
    </div>
     <div class="Scope_of_Work sign_off_work table-responsive">
        <table width="100%">
            <tr class="sign_sheet">
                <td class="heading">Sign off date</td>
                <td width="50%" class="td1"><?php echo date("d-m-Y", strtotime($job_model->client_date)); ?></td>
            </tr>
        </table>
    </div>
     <div class="Scope_of_Work sign_off_work table-responsive">
        <table width="100%">
            <tr class="sign_sheet">
                <td class="heading">Feedback</td>
            </tr>
        </table>
    </div>
    <div class="Scope_of_Work table-responsive">
        <table width="100%">
            <tbody><tr class="td1">
                <td height="70px" style="vertical-align:top;"><?php echo $job_model->client_feedback; ?></td>
            </tr>
        </tbody></table>
    </div>
    <div class="Scope_of_Work">
        <table width="100%">
            <tbody>
            <tr class="td2">
                <td height="120" style="vertical-align:top;">Signature<br/>
				
	<?php $png_path_file = Yii::app()->basePath . '/../uploads/temp/'.$job_model->id.'.png'; ?>
	<?php if(file_exists($png_path_file)) { ?>
	<img src="<?php echo Yii::app()->getBaseUrl(true).'/uploads/temp/'. $job_model->id.'.png'; ?>" />
	<?php  } ?>
		
					
				</td>
            </tr>
        </tbody></table>
    </div>
    <div class="address">
        High Clean Pty Ltd<br>
        ABN: 45631025732<br>
        E: info@highclean.com.au<br>
        W: www.highclean.com.au<br>
        A: 1/92 Railway St South, Altona VIC 3018<br>
        T: 03 8398 0804 F: 03 8398 9899 
    </div>
</div>
  


</div>
  
</body>
</html>