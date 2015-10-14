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
.title{float:left; margin-top:35px; width:52%;}
.title h1{font-size:30px; margin:0; padding-left:60%; text-align:left;}

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
		.logo_wrepp{padding:0 15px;}
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
<div class="logo_wrepp">
        <div class="logo">
            <p><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/pdf_logo_high.png" /></p>
         </div>
         <div class="title">
            <h1 align="center">Sign Off Sheet</h1>
         </div>   
         <br clear="all" />
</div>
	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'buildings-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	


  	 <div class="container job_detalis" style="width:100%">
    
   		<div class="row">
        	<div class="col-md-12">
        	<div class="clint_div table-responsive">
                    <table width="100%">
                        <thead>
                          
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
                                        <table class="table-responsive Jose" width="100%">
                                            <tr class="td3">
                                                <td width="50%"><?php echo $site_model->site_contact ; ?></td>
                                                <td><?php echo $site_model->phone ; ?></td>
                                            </tr>
                                         </table>
                                    </td>
                                </tr>
                                <tr class="td2">
                                    <td>Client Contact Name/Number</td>
                                    <td class="padding_left">
                                        <table class="table-responsive Jose" width="100%">
                                           <tr class="td2 Jose">
                                                <td width="50%"><?php echo $contact_model->first_name.' '.$contact_model->surname; ?></td>
                                    <td><?php echo $contact_model->phone ; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr class="td3">
                                    <td>Purchase Order Number</td>
                                    <td><?php echo $job_model->purchase_order; ?></td>
                                </tr>
                           
                        </thead>
                    </table>
                </div>
             	<div class="Scope_of_Work table-responsive">
                    <table width="100%">
                        <tr class="heading">
                            <td>Scope of Work</td>
                        </tr>
                    </table>
                </div>
            	<div class="Scope_of_Work table-responsive">
                    <table width="100%">
                        <tr class="td2" height="70px" style="vertical-align:top;">
                            <td><?php foreach($job_services_model as $service) { echo '- '.$service->service_description.'<br/>';  } ?>	</td>
                        </tr>
                    </table>
                </div>  
           
            <div class="Scope_of_Work sign_off_work table-responsive">
                    <table width="100%">
                        <tr class="sign_sheet">
                            <td class="blue">Client Name<span class="required" style="color:red;">*</span></td>
                            <td width="50%" class="td1"><?php echo $form->textField($model,'agent_name',array('class'=> 'form-control')); ?><?php echo $form->error($model, 'agent_name'); ?></td>
                        </tr>
                    </table>
                </div>




                 <div class="Scope_of_Work sign_off_work table-responsive">
                    <table width="100%">
                        <tr class="sign_sheet">
                            <td class="blue">Sign off date<span class="required" style="color:red;">*</span></td>
                            <td width="50%" class="td1"><?php
$this->widget(
    'ext.jui.EJuiDateTimePicker',
    array(
        'model'     => $model,
        'attribute' => 'agent_date',
		//'language'=> 'ru',//default Yii::app()->language
        //'mode'    => 'datetime',//'datetime' or 'time' ('datetime' default)
		'mode'    => 'date',
		'htmlOptions' => array(
                    'class' => 'form-control',
                ),
        'options'   => array(
        'dateFormat' => 'yy-mm-dd',
        'showAnim'=>'slideDown',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
        'changeMonth'=>true,
        'changeYear'=>true,
        'yearRange'=>'1930:'.date("Y"),
        //'minDate' => '2000-01-01',      // minimum date
        'maxDate' => date("Y-m-d"),      // maximum date
		
            //'timeFormat' => '',//'hh:mm tt' default
        ),
    )
);
?><?php echo $form->error($model, 'agent_date'); ?></td>
                        </tr>
                    </table>
                </div>
                 <div class="Scope_of_Work sign_off_work table-responsive">
                    <table width="100%">
                        <tr class="sign_sheet">
                            <td class="blue">Feedback</td>
                            <td width="50%" class="td1"><?php echo $form->textArea($model,'agent_feedback',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?></td>
                        </tr>
                    </table>
                </div>
        
                <div class="Scope_of_Work table-responsive">
                    <table width="100%">
                        <tbody><tr height="120px" style="vertical-align:top;" class="td2">
                            <td>Signature<span class="required" style="color:red;">*</span>
							<div class="sigPad">	
	 
	<ul class="sigNav">     
      <li class="clearButton"><a href="#clear">Clear</a></li>
    </ul>
    <div class="sig sigWrapper">
      <div class="typed"></div>
      <canvas class="pad" width="290" height="98"></canvas>
      <input type="hidden" name="output" class="output">
    </div>
	</div>
						
						
	
							
							</td>
                        </tr>
                    </tbody></table>
                </div>
        
        
           
        <div class="row">
        	<div class="col-md-6 col-sm-6 col-xs-12">
            	<div class="address">
                	High Clean Pty Ltd<br>
                    ABN: 45631025732<br>
                    E: infohighclean.com.au<br>
                    W: www.highclean.com.au<br>
                    A: 1/92 Railway st sotuh, Alton VIC 3018<br>
                    T: 03 8398 0804 F: 03 8398 9899 
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
            	<div style="text-align:left; margin-top:6%;">		 
<?php echo CHtml::submitButton('Save',array('class'=>'btn btn-primary')); ?> &nbsp; 
<!--<a href="<?php // echo $this->user_role_base_url.'/?r=Quotes/Job/SignOffView&id='.$model->id; ?>" class="btn btn-primary">Cancel</a> -->
</div>

            </div>
        </div>       
    </div>
 
<div class="clear"></div>
		
<?php $this->endWidget(); ?>
		

      <!-- contentpanel --> 

<?php

Yii::app()->clientScript->registerCssFile($this->base_url_assets . '/js/assets/jquery.signaturepad.css');
Yii::app()->clientScript->registerScriptFile($this->base_url_assets . '/js/jquery.signaturepad.js');

?>

	  
<script>
    $(document).ready(function() {
      $('.sigPad').signaturePad({drawOnly:true});
    });
</script>

<script>
    $(document).ready(function() {
      $('.sigPad').signaturePad({displayOnly:true}).regenerate(<?php echo $model->client_signature; ?>);
    });
</script>


</div>
  
</body>
</html>