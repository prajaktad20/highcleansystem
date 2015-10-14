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
	
	
			
		<div class="Job_Notes_wrapper">
        	
        	<table width="100%" class="table-responsive table5">
                <tr class="heading">
                	<td>Notes for Staff From</td>
                </tr>
                <tr class="td3">
                	<td><?php echo $job_model->si_staff_contractor; ?></td>
                </tr>
            </table>
            
        </div>
			
		<div class="Job_Notes_wrapper">
        	
        	<table width="100%" class="table-responsive table5">
                <tr class="heading">
                	<td>Job Note:</td>
                </tr>
                <tr class="td3">
                	<td>
					<?php foreach($job_services_model as $service) { echo '- '.$service->service_description.'<br/>';  } ?>	
					<br/>
					<?php echo $job_model->job_note; ?>
					</td>	
                </tr>
            </table>
            
        </div>
	
	
</body>
</html>