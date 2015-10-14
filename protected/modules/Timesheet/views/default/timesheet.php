<style>
.job_detalis {
font-size: 12px;    
}

.contentpanel .btn {
font-size: 10px;    
}
</style>

<style type="text/css">

.timesheet_table table tr:nth-child(2n+3){background:#e9eff7;}
.timesheet_table table tr td{border:1px solid #ccc; line-height:26px; padding:0 3px;}
.time_butt{text-align:center;}
.red{color:#F00;}
.butt_pay{display:inline; padding:5px 10px;}

</style>
<div class="pageheader">
<div class="media">
<div class="media-body">
<ul class="breadcrumb">
<li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
<li>Timesheet</li>
</ul>
<h4>Timesheet</h4>
</div>
</div>
<!-- media --> 
</div>

<?php

$pay_date = isset($_REQUEST['pay_date']) ? $_REQUEST['pay_date'] : '';
//echo '<pre>'; print_r($selected_pay_date_model); echo '</pre>';
?>

<div class="contentpanel">

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>


<?php if(Yii::app()->user->hasFlash('warning')):?>
    <div class="alert alert-warning">
        <?php echo Yii::app()->user->getFlash('warning'); ?>
    </div>
<?php endif; ?>


<div class="container tmesheets_wrepp" style="width:100%;">

<div class="row">

	<?php if($selected_user !==NULL && is_object($selected_user)) { ?>
	<div class="col-md-2" style="text">	
	<strong style="float:right;"> Active Staff : </strong>
	</div>

	<div class="col-md-2" style="text">	
			
			<select class="form-control" onchange="updateSelectedUser(this.value);" style="font-size:12px;">
			
			<?php
			foreach($workers_model as $single_user) { ?>
			<option value="<?php echo $single_user->id; ?>" <?php if($selected_user->id == $single_user->id) echo 'selected'; ?>>
			<?php echo $single_user->first_name.' '.$single_user->last_name; ?>
			</option>
			<?php } ?>
			
			</select>			
	</div>
	<?php } ?>


	<div class="col-md-2" style="text" >
	<strong style="float:right;"> Pay dates : </strong>	
	</div>


	<form action="" method="GET" id="myForm" >    
		<div class="col-md-2">
		<input type="hidden"  name="r" value="Timesheet/default/index"/>		
		<input  class="form-control" type="text"  id="pay_date" name="pay_date" value="<?php echo $pay_date; ?>" />		
		</div>

		<div class="col-md-2">
		<input type="submit" class="btn btn-primary" value="Submit"  />		
		</div>
	</form>

	<div class="col-md-2">
	<?php if(isset($selected_pay_date_model->id) && count($final_calculation_model) > 0) { ?>
	<a href="?r=Timesheet/default/CreateExcel&pay_date_id=<?php echo $selected_pay_date_model->id; ?>">Time Sheet Report</a>
	<?php  } ?>
	</div>

</div>


<div class="clear"></div>
<br/>
<div class="job_detalis">
<div class="row">

<div class="col-md-12 col-sm-12 col-xs-12">
<?php $row_dates = array(); $row_primary_ids = array(); ?>
<?php if(count($right_side_result) > 0) { ?>

<div class="timesheet_table table-responsive">
<table width="100%">
<thead>

<tr class="blue4" style="border:1px solid #ccc;">
<td align="center">Day</td>
<td align="center">Date</td>
<td align="center">Job Location</td>
<td align="center">Service</td>
<td align="center">Job ID</td>
<td align="center">Start Time</td>
<td align="center">End Time</td>
<td align="center">Total Hrs</td>
<td align="center">Reg Hrs</td>
<td align="center">OT Hrs</td>
<td align="center">DT Hrs</td>
<?php if(isset($TimesheetApprovedStatusModel->status) && $TimesheetApprovedStatusModel->status === '0') { ?>
<td align="center">Action</td> 
<?php  } ?>
</tr>



<?php foreach($right_side_result as $record) { ?>
<tr id="<?php echo $record->id; ?>_work_day_row"   <?php  if($record->day === 'Saturday') echo 'style="background-color:#FC8B2F"'; ?> <?php if($record->day === 'Sunday') echo 'style="background-color:#e15258;"' ?>>


		<td>
		<?php echo $record->day; ?>
		<input type="hidden" id="<?php echo $record->id; ?>_day" value="<?php echo $record->day; ?>" />
		</td>

		<td style="width:118px;">
		<?php echo $record->formatted_working_date.' ('.$record->day_night.')'; ?>
		</td>
	
	
		<td align="center" valign="center" >
		<input style="font-size:12px;" class="form-control" type="text" id="<?php echo $record->id; ?>_job_location" size="20"  value="<?php echo $record->job_location; ?>" />
		</td>
		
		<td align="center" valign="center">
		<input style="font-size:12px;" class="form-control" type="text" id="<?php echo $record->id; ?>_service_name" size="15"  value="<?php echo $record->service_name; ?>" />
		</td>

		<td align="center" valign="center">
		<input style="font-size:12px;" class="form-control" type="text" onkeypress="return isNumber(event)"  size="8" id="<?php echo $record->id; ?>_job_id" value="<?php echo $record->job_id; ?>" />
		</td>

	
	<?php if($date_frequency[$record->working_date] == 1) { ?>

		<td align="center" valign="center">
		<select onchange="CalculateHoursDateFrequencyOne('<?php echo $record->id; ?>');" id="<?php echo $record->id; ?>_work_start_time">
		<?php foreach($timeDropdown as $value) { ?>
		<option value="<?php echo $value; ?>" <?php if($record->work_start_time == $value) echo 'selected'; ?> ><?php echo $value; ?></option>
		<?php } ?>
		</select>
		</td>

		<td align="center" valign="center">
		<select onchange="CalculateHoursDateFrequencyOne('<?php echo $record->id; ?>');" id="<?php echo $record->id; ?>_work_end_time">
		<?php foreach($timeDropdown as $value) { ?>
		<option value="<?php echo $value; ?>" <?php if($record->work_end_time == $value) echo 'selected'; ?> ><?php echo $value; ?></option>
		<?php } ?>
		</select>
		</td>

		
		<td width="6%" align="center" valign="center">
		<input type="hidden" size="5" readonly  id="<?php echo $record->id; ?>_total_hours" value="<?php echo $record->total_hours; ?>" />
		<span style="font-weight:bold;" id="<?php echo $record->id; ?>_total_hours_text"><?php echo $record->total_hours; ?></span>
		</td>
		
	
		<td width="6%" align="center" valign="center">
		<input type="hidden" size="5" readonly id="<?php echo $record->id; ?>_regular_hours" value="<?php echo $record->regular_hours; ?>" />
		<span id="<?php echo $record->id; ?>_regular_hours_text"><?php echo $record->regular_hours; ?></span>
		</td>
		
		<td  width="6%" align="center" valign="center">
		<input type="hidden" size="5" readonly id="<?php echo $record->id; ?>_overtime_hours" value="<?php echo $record->overtime_hours; ?>" />
		<span id="<?php echo $record->id; ?>_overtime_hours_text"><?php echo $record->overtime_hours; ?></span>
		</td>
		
		<td width="6%" align="center" valign="center">
		<input type="hidden" size="5" readonly id="<?php echo $record->id; ?>_double_time_hours" value="<?php echo $record->double_time_hours; ?>" />
		<span id="<?php echo $record->id; ?>_double_time_hours_text"><?php echo $record->double_time_hours; ?></span>
		</td>	
		
		<?php if(isset($TimesheetApprovedStatusModel->status) && $TimesheetApprovedStatusModel->status === '0') { ?>
		<?php if($record->saved_status === '1') { $button_status_class = 'class="btn btn-success"'; } else { $button_status_class = 'class="btn btn-primary"'; } ?>
		<td align="center" valign="center" >
		<a style="width:100%;" href="javascript:void(0);" id="<?php echo $record->id; ?>_save_button" <?php echo $button_status_class; ?> onclick="SaveUserTimes('<?php echo $record->id; ?>');">Save</a>
		</td>
		
	<?php } ?>
	<?php } else { ?>

	<!-- Multiple shifts job -->

		<?php 
			
				$temp_Array = array_count_values($row_dates); 
				$shift_value = isset($temp_Array[$record->working_date]) ? $temp_Array[$record->working_date] : 0;
		
		?>
		<td align="center" valign="center">
		<select onchange="CalculateHours('<?php echo $record->id; ?>','<?php echo $date_frequency[$record->working_date]; ?>','<?php echo $shift_value; ?>');" id="<?php echo $record->id; ?>_work_start_time">
		<?php foreach($timeDropdown as $value) { ?>
		<option value="<?php echo $value; ?>" <?php if($record->work_start_time == $value) echo 'selected'; ?> ><?php echo $value; ?></option>
		<?php } ?>
		</select>
		</td>

		<td align="center" valign="center">
		<select onchange="CalculateHours('<?php echo $record->id; ?>','<?php echo $date_frequency[$record->working_date]; ?>','<?php echo $shift_value; ?>');" id="<?php echo $record->id; ?>_work_end_time">
		<?php foreach($timeDropdown as $value) { ?>
		<option value="<?php echo $value; ?>" <?php if($record->work_end_time == $value) echo 'selected'; ?> ><?php echo $value; ?></option>
		<?php } ?>
		</select>
		</td>

		
		<td width="6%" align="center" valign="center">
		<input type="hidden" size="5" readonly  id="<?php echo $record->id; ?>_total_hours" value="<?php echo $record->total_hours; ?>" />
		<span style="font-weight:bold;" id="<?php echo $record->id; ?>_total_hours_text"><?php echo $record->total_hours; ?></span>
		</td>
		
	
		<td width="6%" align="center" valign="center">
		<input type="hidden" size="5" readonly id="<?php echo $record->id; ?>_regular_hours" value="<?php echo $record->regular_hours; ?>" />
		<span id="<?php echo $record->id; ?>_regular_hours_text"><?php echo $record->regular_hours; ?></span>
		</td>
		
		<td  width="6%" align="center" valign="center" >
		<input type="hidden" size="5" readonly id="<?php echo $record->id; ?>_overtime_hours" value="<?php echo $record->overtime_hours; ?>" />
		<span id="<?php echo $record->id; ?>_overtime_hours_text"><?php echo $record->overtime_hours; ?></span>
		</td>
		
		<td width="6%" align="center" valign="center">
		<input type="hidden" size="5" readonly id="<?php echo $record->id; ?>_double_time_hours" value="<?php echo $record->double_time_hours; ?>" />
		<span id="<?php echo $record->id; ?>_double_time_hours_text"><?php echo $record->double_time_hours; ?></span>
		</td>	
		
		<?php if(isset($TimesheetApprovedStatusModel->status) && $TimesheetApprovedStatusModel->status === '0') { ?>
		<?php if($record->saved_status === '1') { $button_status_class = 'class="btn btn-success"'; } else { $button_status_class = 'class="btn btn-primary"'; } ?>
		<td align="center" valign="center" >
		<a style="width:100%;" href="javascript:void(0);" id="<?php echo $record->id; ?>_save_button" <?php echo $button_status_class; ?> onclick="SaveUserTimes('<?php echo $record->id; ?>');">Save</a>
		</td>
		<?php } ?>	
		
		
	<?php } ?>

<?php $row_dates[] = $record->working_date; $row_primary_ids[] = $record->id; ?>	
</tr>
<?php } ?>

<?php if(isset($summaryResult['TH'])) { ?>

<?php if(isset($TimesheetApprovedStatusModel->status) && $TimesheetApprovedStatusModel->status === '0') { ?>
<!--
<tr>
<td colspan="10" align="right">&nbsp;</td>
<td valign="center" colspan="2" >
<button style="width:100%;" data-toggle="modal" data-target="#myModal"  class="btn btn-info mr5"  onclick="return false;" > Add New Row </button>
</td>
</tr>
-->	
<tr>
<td colspan="7">&nbsp;</td>
<td align="center"><strong id="TH"><?php echo $summaryResult['TH']; ?></strong></td>
<td align="center"><strong id="RH"><?php echo $summaryResult['RH']; ?></strong></td>
<td align="center"><strong id="OH"><?php echo $summaryResult['OH']; ?></strong></td>
<td align="center"><strong id="DTH"><?php echo $summaryResult['DTH']; ?></strong></td>
<td><button style="width:100%;" data-toggle="modal" data-target="#myModal"  class="btn btn-info mr5"  onclick="return false;" > Add Row </button></td>
</tr>
<?php } else { ?>

<tr>
<td colspan="7">&nbsp;</td>
<td align="center"><strong id="TH"><?php echo $summaryResult['TH']; ?></strong></td>
<td align="center"><strong id="RH"><?php echo $summaryResult['RH']; ?></strong></td>
<td align="center"><strong id="OH"><?php echo $summaryResult['OH']; ?></strong></td>
<td align="center"><strong id="DTH"><?php echo $summaryResult['DTH']; ?></strong></td>
</tr>
<?php } ?>

<?php } ?>

</table>
</div>
<?php } ?>

<script type='text/javascript'>
<?php
$js_array = json_encode($row_primary_ids);
echo "var javascript_array = ". $js_array . ";\n";
?>
</script>

</div>
</div>       
</div>

<br/>
<div class="clear"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="row">

<?php if($approved_form_model !== NULL) { ?>


<div style="width:33%;float: left;">
<?php if(isset($TimesheetApprovedStatusModel->status) && $TimesheetApprovedStatusModel->status === '0') { ?>
<strong> <?php echo $selected_user->first_name.' '.$selected_user->last_name; ?> </strong> : <span style="color:#FF0000;" >Timesheet not approved yet.</span>
<?php } else { ?>
<strong> <?php echo $selected_user->first_name.' '.$selected_user->last_name; ?> </strong> : <span style="color:#006400;" >Timesheet has been approved.</span>
<?php } ?>
</div>

<?php 
	if(Yii::app()->user->name === 'admin' && $TimesheetApprovedStatusModel->status === '0') {
?>

<div id="repopulate_timesheet_div" style="width:33%;float: left;text-align:center;">

<form id="repopulateTimesheetFrm" action="" method="GET">
<input type="hidden"  name="r" value="Timesheet/default/index"/>
<input type="hidden"  name="pay_date" value="<?php echo $pay_date; ?>"/>
<input type="hidden"  name="selected_user_id" value="<?php echo $selected_user->id; ?>"/>
<input type="text"  name="populate_date_from" readonly id="populate_date_from" style="height:30px;"/>
<a href="javascript:void(0);" class="btn btn-primary" onclick="repopulateTimesheet();">Repopulate Timesheet</a>
</form>

</div>

<?php } ?>


<div style="width:33%;float: right; text-align:right;">
<?php 
	if(Yii::app()->user->name === 'admin' && $TimesheetApprovedStatusModel->status === '0') {

		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'timesheet-approved-status-test1-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// See class documentation of CActiveForm for details on this,
			// you need to use the performAjaxValidation()-method described there.
			'enableAjaxValidation'=>false)); 

		echo '<input type="hidden"  name="r" value="Timesheet/default/index"/>';
		echo '<input type="hidden"  name="selected_user_id" value="'.$selected_user->id.'"/>';				
		echo $form->hiddenField($approved_form_model,'status',array('value'=>'1'));
		//echo CHtml::submitButton('Approve Timesheet  ('.$selected_user->first_name.' '.$selected_user->last_name.') ',array('class'=>'btn btn-primary'));
		echo '<a href="javascript:void(0);" class="btn btn-primary" onclick="ApproveTimesheet();">Approve Timesheet</a>';
		$this->endWidget();
	} 
?>
</div>



</div>
</div>
<?php } ?>


</div>	
</div>		 

<script type="text/javascript">


function repopulateTimesheet() {
	if(confirm("Are you sure ? You want to repopulate timesheet.")) {
		document.getElementById("repopulateTimesheetFrm").submit();
	} else {
		return false;
	}
}

function ApproveTimesheet() {
	if(confirm("Are you sure ? You want to approve timesheet.")) {
		document.getElementById("timesheet-approved-status-test1-form").submit();
	} else {
		return false;
	}
}
</script>

<?php if($add_new_row_model !== NULL) { ?>
<!-- Modal box 1 -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add New Row</h4>
      </div>
	  
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'addnewrowform',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
	
)); ?>
	  
	  
      <div class="modal-body">


        <div class="form-group">
          <?php echo $form->labelEx($add_new_row_model,'working_date',array('class'=>'col-sm-4')); ?>
          <div class="col-sm-8">
		   <?php echo $form->textField($add_new_row_model,'working_date',array('id'=>'working_date','class'=>'form-control','readonly'=>true)); ?>
		</div>
        </div>
		

        <div class="form-group">
          <?php echo $form->labelEx($add_new_row_model,'job_id',array('class'=>'col-sm-4','value'=>'0')); ?>
          <div class="col-sm-8">
		   <?php echo $form->textField($add_new_row_model,'job_id',array('id'=>'working_date','class'=>'form-control')); ?>
		</div>
        </div>
		


	<div class="form-group">
		<?php echo $form->labelEx($add_new_row_model,'day_night',array('class'=>'col-sm-4')); ?>
		<div class="col-sm-8">
		<?php echo $form->radioButtonList($add_new_row_model,'day_night',array('DAY'=>'DAY', 'NIGHT'=>'NIGHT'),array('size'=>17,'maxlength'=>17,'separator' => "&nbsp;&nbsp;&nbsp;&nbsp;")); ?>
		</div>		
	 </div>

		
        <div class="form-group">
          <label class="col-sm-4">&nbsp;</label>
          <div class="col-sm-8">
          <?php echo CHtml::submitButton('Save',array('class'=>'btn btn-primary')); ?>
          </div>
        </div>
		
      </div>
   


<?php $this->endWidget(); ?>

   </div>
    <!-- modal-content --> 
  </div>
  <!-- modal-dialog --> 
  
</div>
<!-- Modal box 1 --> 
<?php } ?>



<script type="text/javascript">


function CalculateHours(record_primary_id,date_frequency,shift_value) {
	
if(shift_value == 0) {
	CalculateHoursDateFrequencyOne(record_primary_id);
} else if(shift_value == 1) {

var prev_tr_index = javascript_array.indexOf(record_primary_id);
var prev_record_primary_id = javascript_array[prev_tr_index - 1];
prev_record_primary_id = parseInt(prev_record_primary_id);


var prev_total_hours = $("#"+prev_record_primary_id+"_total_hours").val();
prev_total_hours = parseFloat(prev_total_hours);

var prev_regular_hours = $("#"+prev_record_primary_id+"_regular_hours").val();
prev_regular_hours = parseFloat(prev_regular_hours);

var prev_overtime_hours = $("#"+prev_record_primary_id+"_overtime_hours").val();
prev_overtime_hours = parseFloat(prev_overtime_hours);

var prev_double_time_hours = $("#"+prev_record_primary_id+"_double_time_hours").val();
prev_double_time_hours = parseFloat(prev_double_time_hours);

CalculateHoursMultipleShifts(record_primary_id,prev_total_hours,prev_regular_hours,prev_overtime_hours,prev_double_time_hours);

}  else if(shift_value == 2) {

//var prev_record_primary_id = record_primary_id-2;


var prev_tr_index = javascript_array.indexOf(record_primary_id);
var prev_record_primary_id = javascript_array[prev_tr_index - 2];
prev_record_primary_id = parseInt(prev_record_primary_id);


var tprev_total_hours = $("#"+prev_record_primary_id+"_total_hours").val();
tprev_total_hours = parseFloat(tprev_total_hours);

var tprev_regular_hours = $("#"+prev_record_primary_id+"_regular_hours").val();
tprev_regular_hours = parseFloat(tprev_regular_hours);

var tprev_overtime_hours = $("#"+prev_record_primary_id+"_overtime_hours").val();
tprev_overtime_hours = parseFloat(tprev_overtime_hours);

var tprev_double_time_hours = $("#"+prev_record_primary_id+"_double_time_hours").val();
tprev_double_time_hours = parseFloat(tprev_double_time_hours);

//console.log(record_primary_id+' '+tprev_total_hours+' '+tprev_regular_hours+' '+tprev_overtime_hours+' '+tprev_double_time_hours);

//prev_record_primary_id = prev_record_primary_id + 1;

var prev_tr_index = javascript_array.indexOf(record_primary_id);
var prev_record_primary_id = javascript_array[prev_tr_index - 1];
prev_record_primary_id = parseInt(prev_record_primary_id);



var prev_total_hours = $("#"+prev_record_primary_id+"_total_hours").val();
prev_total_hours = parseFloat(prev_total_hours) + tprev_total_hours;

var prev_regular_hours = $("#"+prev_record_primary_id+"_regular_hours").val();
prev_regular_hours = parseFloat(prev_regular_hours) + tprev_regular_hours;

var prev_overtime_hours = $("#"+prev_record_primary_id+"_overtime_hours").val();
prev_overtime_hours = parseFloat(prev_overtime_hours) + tprev_overtime_hours;

var prev_double_time_hours = $("#"+prev_record_primary_id+"_double_time_hours").val();
prev_double_time_hours = parseFloat(prev_double_time_hours) + tprev_double_time_hours;

//console.log(record_primary_id+' '+prev_total_hours+' '+prev_regular_hours+' '+prev_overtime_hours+' '+prev_double_time_hours);
CalculateHoursMultipleShifts(record_primary_id,prev_total_hours,prev_regular_hours,prev_overtime_hours,prev_double_time_hours);

}

}

function CalculateHoursMultipleShifts(record_primary_id,prev_total_hours,prev_regular_hours,prev_overtime_hours,prev_double_time_hours) {
	
		var work_start_time = $("#"+record_primary_id+"_work_start_time").val();
		var work_end_time = $("#"+record_primary_id+"_work_end_time").val();
		var selected_day = $("#"+record_primary_id+"_day").val();

		var total_hours = 0.00;
		var regular_hours = 0.00;
		var overtime_hours = 0.00;
		var double_time_hours = 0.00;
		var total_diff_seconds = 0.00;


if(work_start_time == work_end_time) {
			
			$("#"+record_primary_id+"_total_hours").val(parseFloat(total_hours).toFixed(2));
			$("#"+record_primary_id+"_total_hours_text").text(parseFloat(total_hours).toFixed(2));

			$("#"+record_primary_id+"_regular_hours").val(parseFloat(regular_hours).toFixed(2));
			$("#"+record_primary_id+"_regular_hours_text").text(parseFloat(regular_hours).toFixed(2));
		
			$("#"+record_primary_id+"_overtime_hours").val(parseFloat(overtime_hours).toFixed(2));
			$("#"+record_primary_id+"_overtime_hours_text").text(parseFloat(overtime_hours).toFixed(2));
		
			$("#"+record_primary_id+"_double_time_hours").val(parseFloat(double_time_hours).toFixed(2));
			$("#"+record_primary_id+"_double_time_hours_text").text(parseFloat(double_time_hours).toFixed(2));
		
return false;

}

		
		var work_start_time_split = work_start_time.split(":");
		var work_end_time_split = work_end_time.split(":");
		var work_start_time_split_minutes = (parseInt(work_start_time_split[0]) * 60) + parseInt(work_start_time_split[1]);
		var work_end_time_split_minutes = (parseInt(work_end_time_split[0]) * 60) + parseInt(work_end_time_split[1]);

		var temp_start_time_total_seconds = work_start_time_split_minutes * 60;
		var temp_end_time_total_seconds = work_end_time_split_minutes * 60;
		total_diff_seconds = temp_end_time_total_seconds - temp_start_time_total_seconds;

		if(total_diff_seconds > 0) {			
			total_hours = total_diff_seconds/3600;
		} else {

			var total_diff_seconds1	= 86400 - temp_start_time_total_seconds;
			var total_diff_seconds2	= temp_end_time_total_seconds;
			total_diff_seconds = total_diff_seconds1 + total_diff_seconds2; 
			total_hours = total_diff_seconds/3600;
		}

		total_hours = Math.round(total_hours * 100) / 100;
		
		if(total_hours < 0)
			return false;
		
		var remaining_hours = total_hours;
	
	
			if(selected_day == 'Saturday') {
				overtime_hours = total_hours;
			} else if(selected_day == 'Sunday') {
				double_time_hours = total_hours;
			} else {
			
			
							
					if(remaining_hours > 0)	{

					var tregular_hours = 7.6 - prev_regular_hours;
					tregular_hours = Math.round(tregular_hours * 100) / 100;
							
						if(remaining_hours > tregular_hours)
						regular_hours = tregular_hours;	
						else 
						regular_hours = remaining_hours;	
					
						remaining_hours = remaining_hours - regular_hours;
					} else {
						regular_hours = 0.00;
					}
					
					if(remaining_hours > 0)	{			
					remaining_hours = Math.round(remaining_hours * 100) / 100;
						
						var tovertime_hours = 2 - prev_overtime_hours;
						tovertime_hours = Math.round(tovertime_hours * 100) / 100;
							
							if(remaining_hours > tovertime_hours)
							overtime_hours = tovertime_hours;	
							else
							overtime_hours = remaining_hours;	
						
							remaining_hours = remaining_hours - overtime_hours;
						} else {
							overtime_hours = 0.00;
						}
						
						
					if(remaining_hours > 0)	{
						remaining_hours = Math.round(remaining_hours * 100) / 100;
						
						var double_time_hours = remaining_hours;
						double_time_hours = Math.round(double_time_hours * 100) / 100;
						} else {
							double_time_hours = 0.00;
						}
					
			
			} // end else

			$("#"+record_primary_id+"_total_hours").val(parseFloat(total_hours).toFixed(2));
			$("#"+record_primary_id+"_total_hours_text").text(parseFloat(total_hours).toFixed(2));

			$("#"+record_primary_id+"_regular_hours").val(parseFloat(regular_hours).toFixed(2));
			$("#"+record_primary_id+"_regular_hours_text").text(parseFloat(regular_hours).toFixed(2));
		
			$("#"+record_primary_id+"_overtime_hours").val(parseFloat(overtime_hours).toFixed(2));
			$("#"+record_primary_id+"_overtime_hours_text").text(parseFloat(overtime_hours).toFixed(2));
		
			$("#"+record_primary_id+"_double_time_hours").val(parseFloat(double_time_hours).toFixed(2));
			$("#"+record_primary_id+"_double_time_hours_text").text(parseFloat(double_time_hours).toFixed(2));
	
}


function CalculateHoursDateFrequencyOne(record_primary_id) {
	
	
		var work_start_time = $("#"+record_primary_id+"_work_start_time").val();
		var work_end_time = $("#"+record_primary_id+"_work_end_time").val();
		var selected_day = $("#"+record_primary_id+"_day").val();

		var total_hours = 0.00;
		var regular_hours = 0.00;
		var overtime_hours = 0.00;
		var double_time_hours = 0.00;
		var total_diff_seconds = 0.00;



if(work_start_time == work_end_time) {

			$("#"+record_primary_id+"_total_hours").val(parseFloat(total_hours).toFixed(2));
			$("#"+record_primary_id+"_total_hours_text").text(parseFloat(total_hours).toFixed(2));

			$("#"+record_primary_id+"_regular_hours").val(parseFloat(regular_hours).toFixed(2));
			$("#"+record_primary_id+"_regular_hours_text").text(parseFloat(regular_hours).toFixed(2));
		
			$("#"+record_primary_id+"_overtime_hours").val(parseFloat(overtime_hours).toFixed(2));
			$("#"+record_primary_id+"_overtime_hours_text").text(parseFloat(overtime_hours).toFixed(2));
		
			$("#"+record_primary_id+"_double_time_hours").val(parseFloat(double_time_hours).toFixed(2));
			$("#"+record_primary_id+"_double_time_hours_text").text(parseFloat(double_time_hours).toFixed(2));
				
return false;

}

		
		var work_start_time_split = work_start_time.split(":");
		var work_end_time_split = work_end_time.split(":");
		var work_start_time_split_minutes = (parseInt(work_start_time_split[0]) * 60) + parseInt(work_start_time_split[1]);
		var work_end_time_split_minutes = (parseInt(work_end_time_split[0]) * 60) + parseInt(work_end_time_split[1]);

		var temp_start_time_total_seconds = work_start_time_split_minutes * 60;
		var temp_end_time_total_seconds = work_end_time_split_minutes * 60;
		total_diff_seconds = temp_end_time_total_seconds - temp_start_time_total_seconds;

		if(total_diff_seconds > 0) {			
			total_hours = total_diff_seconds/3600;
		} else {

			var total_diff_seconds1	= 86400 - temp_start_time_total_seconds;
			var total_diff_seconds2	= temp_end_time_total_seconds;
			total_diff_seconds = total_diff_seconds1 + total_diff_seconds2; 
			total_hours = total_diff_seconds/3600;
		}

		total_hours = Math.round(total_hours * 100) / 100;

				
		if(selected_day == 'Saturday') { 
			overtime_hours = total_hours;
		} else if(selected_day == 'Sunday') {
			double_time_hours = total_hours;
		} else {
			
			
			if(total_hours <= 7.60) {
				regular_hours = total_hours;
				overtime_hours = 0.0;
				double_time_hours = 0.0;
			}
		
			if(total_hours > 7.60) {
				regular_hours = 7.60;
				overtime_hours = total_hours - regular_hours;
				overtime_hours = Math.round(overtime_hours * 100) / 100;

				double_time_hours = 0.0;
				if(overtime_hours > 2) {
					overtime_hours = 2;			
					double_time_hours = total_hours-9.60;
					double_time_hours = Math.round(double_time_hours * 100) / 100;
				}
			}
		
		
		} // end else
			
		
			$("#"+record_primary_id+"_total_hours").val(parseFloat(total_hours).toFixed(2));
			$("#"+record_primary_id+"_total_hours_text").text(parseFloat(total_hours).toFixed(2));

			$("#"+record_primary_id+"_regular_hours").val(parseFloat(regular_hours).toFixed(2));
			$("#"+record_primary_id+"_regular_hours_text").text(parseFloat(regular_hours).toFixed(2));
		
			$("#"+record_primary_id+"_overtime_hours").val(parseFloat(overtime_hours).toFixed(2));
			$("#"+record_primary_id+"_overtime_hours_text").text(parseFloat(overtime_hours).toFixed(2));
		
			$("#"+record_primary_id+"_double_time_hours").val(parseFloat(double_time_hours).toFixed(2));
			$("#"+record_primary_id+"_double_time_hours_text").text(parseFloat(double_time_hours).toFixed(2));
		

	
}

function updateSelectedUser(user_id)   {
  var pay_date = '<?php echo $pay_date; ?>';
  window.location = "?r=Timesheet/default/index&pay_date="+pay_date+"&selected_user_id="+user_id ;
}

function SaveUserTimes(record_primary_id) {

var job_location = $("#"+record_primary_id+"_job_location").val();
var service_name = $("#"+record_primary_id+"_service_name").val();	
var work_start_time = $("#"+record_primary_id+"_work_start_time").val();
var work_end_time = $("#"+record_primary_id+"_work_end_time").val();
var total_hours = $("#"+record_primary_id+"_total_hours").val();
var regular_hours = $("#"+record_primary_id+"_regular_hours").val();
var overtime_hours = $("#"+record_primary_id+"_overtime_hours").val();
var double_time_hours = $("#"+record_primary_id+"_double_time_hours").val();
var selected_day = $("#"+record_primary_id+"_day").val();


post_data = {
	record_primary_id: record_primary_id,
	job_location: job_location,
	service_name: service_name,
	work_start_time: work_start_time,
	work_end_time: work_end_time,
	total_hours: total_hours,
	regular_hours: regular_hours,
	overtime_hours: overtime_hours,
	double_time_hours: double_time_hours
};


jQuery.ajax(
{
url: '/?r=Timesheet/default/SaveUserTimes',
type: "POST",
data: post_data,
success: function (data, textStatus, jqXHR) {

var result = JSON.parse(data);

$("#TH").text(result.TH);
$("#RH").text(result.RH);
$("#OH").text(result.OH);
$("#DTH").text(result.DTH);

var text_result = "<span style='font-size:12px;font-weight:bold;'>Successfully saved! check grand total below,</span> <br/>";
text_result += "<span style='font-size:12px;font-weight:bold;'> Total Hours : "+result.TH+"</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
text_result += "<span style='font-size:12px;font-weight:bold;'> Regular Hours : "+result.RH+"</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
text_result += "<span style='font-size:12px;font-weight:bold;'> Overtime Hours : "+result.OH+"</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
text_result += "<span style='font-size:12px;font-weight:bold;'> Double Time Hours : "+result.DTH+"</span>";
 


var buttonClassName = $("#"+record_primary_id+"_save_button").attr('class');
if(buttonClassName == 'btn btn-primary') {
$( "#"+record_primary_id+"_save_button" ).removeClass( "btn-primary" ).addClass( "btn-success" );
} else {
$( "#"+record_primary_id+"_save_button" ).removeClass( "btn-success" ).addClass( "btn-primary" );	
}
	$.notifyBar({ html: text_result, position: "bottom" });
},
error: function (jqXHR, textStatus, errorThrown)
{
}
});

}

</script>

<?php $json_pay_dates = json_encode($pay_dates); ?>
<script type="text/javascript">

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

var availableDates = JSON.parse('<?php echo $json_pay_dates; ?>');

function available(date) {
	dmy = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
	if ($.inArray(dmy, availableDates) != -1) {
	return [true, "","Available"];
	} else {
	return [false,"","unAvailable"];
	}
}


$("#pay_date").datepicker({
	beforeShowDay: available,
	maxDate: '<?php echo date('Y-m-d', strtotime(date('Y-m-d').' +13 days')); ?>',
	numberOfMonths: 1,
	dateFormat:'yy-mm-dd',                
});

<?php if($selected_pay_date_model !== null) { 
$maxDate = date("Y-m-d");
if($maxDate > $selected_pay_date_model->payment_end_date)
$maxDate = $selected_pay_date_model->payment_end_date;

?>
$("#working_date").datepicker({
	minDate: '<?php echo $selected_pay_date_model->payment_start_date; ?>',
	maxDate: '<?php echo $maxDate; ?>',
	numberOfMonths: 1,
	dateFormat:'yy-mm-dd',                
});

$("#populate_date_from").datepicker({
	minDate: '<?php echo $selected_pay_date_model->payment_start_date; ?>',
	maxDate: '<?php echo $maxDate; ?>',
	numberOfMonths: 1,
	dateFormat:'yy-mm-dd',                
});


<?php } ?>



</script>
