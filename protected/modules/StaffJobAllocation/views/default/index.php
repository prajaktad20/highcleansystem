<style>

#left_panel td 
{
    text-align:center; 
    vertical-align:top;
}

.col-md-8 {
	font-size : 11px;
}

#allocation_staff , #day_night_radio, #selected_scope , small {
	font-size : 11px;
}
	
</style>    


<div class="pageheader">
            <div class="media">
              <div class="media-body">
                <ul class="breadcrumb">
                  <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
                  <li>Staff Job Allocation</li>
                </ul>
                <h4>Staff Job Allocation</h4>
              </div>
            </div>
            <!-- media --> 
</div>
    <br/>

    <?php

	    $current_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 5, date('Y')));
            $Date_After_Five_Days = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 10, date('Y')));
			
            $job_from_date = isset($_REQUEST['job_from_date']) ? $_REQUEST['job_from_date'] : $current_date;
            $job_to_date = isset($_REQUEST['job_to_date']) ? $_REQUEST['job_to_date'] : $Date_After_Five_Days;
           
	
	
    ?>



        <div class="container" style="width:100%;">


         <div class="row">
          <form action="" method="GET" id="myForm" >     
        <div class="col-md-12">  
			<input type="hidden"  name="r" value="StaffJobAllocation/default/index"/>
            <div class="col-md-3">        
                <input type="text" id="job_from_date" autocomplete="off" name="job_from_date" value="<?php echo $job_from_date; ?>" class="form-control" placeholder="Start Date"/>
            </div>

            <div class="col-md-3">
               <input type="text" id="job_to_date" autocomplete="off" name="job_to_date" value="<?php echo $job_to_date; ?>"  class="form-control" placeholder="End Date"/>
            </div>

            <div class="col-md-3">
                <input type="submit" class="btn btn-primary" value="Search Booked and Approved Jobs"  />
            </div>

			<div class="col-md-3">
			<img  id='imageloadstatus' style="display:none;" src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/ajax-loader-bar.gif" alt="Loading...."/>
			</div>

        </div>    
          </form> 
        </div>
			
<div class="clear" style="margin-top:20px;"></div>
			
<?php if(! empty($job_from_date) && ! empty($job_to_date)) { ?>			

<div class="alert alert-success" style="display:none;"></div>	
<div class="alert alert-danger" style="display:none;"></div>	

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('danger')):?>
    <div class="alert alert-danger">
        <?php echo Yii::app()->user->getFlash('danger'); ?>
    </div>
<?php endif; ?>



        <div class="row">

        <div class="col-md-12" id="left_panel" style="padding: 1; overflow-y: auto;max-height:900px;">

               <div class="table-responsive">
                <table class="table table-bordered mb30 quote_table" >
                            <thead>
                                <tr class="heading" style="color:#FFFFFF;">
                                    <td width="5%">Job ID</td>
                                    <td width="8%">Date</td> 
                                    <td width="5%" class="tr_record_click_hide">Day</td> 
                                    <td width="5%">D/N</td> 
                                    <td width="13%">Site & Service</td> 
                                    <td width="25%" class="tr_record_click_hide">Scope</td> 
                                    <td width="10%">SS</td> 
                                    <td width="14%">ST</td> 
                                    <td width="5%" class="tr_record_click_hide">Yard Time</td> 
                                    <td width="5%" class="tr_record_click_hide">Site Time</td> 
                                    <td width="5%" class="tr_record_click_hide">Finish Time</td> 
                                </tr>
                     </thead>


                    <?php
                    $i=0;
                    foreach($jobs as $singleDate=>$singleDateRecords) { 
                        foreach ($singleDateRecords as $job) { $trClass = 'class="job_date_row '.$job['id'].'"' ;      ?>


<tr style="cursor: pointer;" <?php echo $trClass; ?> id="<?php echo $i.'_'.$job['id'].'_'.$job['job_working_date'].'_'.$job['job_working_day_night']; ?>" >
<td><a target="_blank" href="<?php echo $this->user_role_base_url."?r=Quotes/Job/view&id=".$job['id']; ?>"><?php echo $job['id']; ?></a></td>
<td><?php echo date("d-m-Y", strtotime($job['job_working_date'])); ?></td>
<td class="tr_record_click_hide" <?php if($job['job_working_day'] === 'Sat' || $job['job_working_day'] === 'Sun') { echo "style='color:#ff0000;'"; } ?> ><?php echo $job['job_working_day']; ?></td>
<td id="<?php echo $i.'_day_night'; ?>"><?php echo $job['job_working_day_night']; ?></td>
<td style="text-align:left;">
<strong><?php echo $job['site_name']; ?></strong>
<div class="clear"></div>
<?php echo $job['service_name']; ?>
</td>
<td class="tr_record_click_hide" ><div style="overflow-y: auto;max-height:150px;text-align:left;"><?php echo $job['scope'].' '.$job['extra_scope_of_work']; ?></div></td>                 
<td style="text-align:left;" style="text-align:left;" id="<?php echo $i.'_SS'; ?>"><?php echo $job['site_supervisor_name']; ?></td>
<td style="text-align:left;"  ><div id="<?php echo $i.'_ST'; ?>" style="overflow-y: auto;max-height:150px;text-align:left;"><?php echo $job['staff_names']; ?></div></td>
<td class="tr_record_click_hide" id="<?php echo $i.'_yard_time'; ?>" ><?php echo $job['yard_time']; ?></td>
<td class="tr_record_click_hide" id="<?php echo $i.'_site_time'; ?>" ><?php echo $job['site_time']; ?></td>
<td class="tr_record_click_hide" id="<?php echo $i.'_finish_time'; ?>" ><?php echo $job['finish_time']; ?></td>
</tr> 
                            <?php $i++; } ?>


                             <?php  }  ?>

                        </table>
               </div>



             </div>   

   <div class="col-md-4" style="padding: 0;display:none;" id="right_panel">

       <input type="hidden" id="form_selected_tr_row" />
	   <input type="hidden" id="form_selected_job_id" />
       <input type="hidden" id="form_selected_working_date" />
       <input type="hidden" id="form_selected_working_day_night" />

                          <table class="table table-bordered mb30" width="100%">
                                   <tbody>
        <tr class="heading">
        <td colspan="2" width="66%" style="color:#FFF;">
        <strong>Working Date : </strong>
        <span id="selected_working_date"  style="font-size:12px;"></span>
        <div class="clear"></div>
        <span id="selected_site_name" style="font-size:12px;"></span>
        <div class="clear"></div>
        <span id="selected_service_name" style="color:#FFF; float:left;font-size:12px;" class="clear"></span>
        </td>   

        <td width="33%">
        <span id="selected_job_id" style="color:#FFF; float:left;cursor:pointer;"></span>
        <span id="hide_right_panel" style="color:#FFF;float:right;cursor: pointer;font-size:12px;">X</span>
        <div class="clear"></div>
        <input type="button" value="Delete" id="pause_job" class="job_button_paused" style="margin-top:15px;float:right;">
        </td>
        </tr>
                                 </tbody> 

        <tr>

        <td width="33%">
                <small><strong>No. of ST</strong></small><div class="clear"></div>
                <input id="staff_required" class="form-control"  />
        </td>

        <td width="33%">
        <small><strong>Job Hours</strong></small><div class="clear"></div>
                <input id="job_total_working_hour" class="form-control"  />
        </td>

        <td width="33%">

                 <small>&nbsp;</small><div class="clear"></div>
         <a  class="btn btn-primary" href="javascript:void(0);" id="job_parameters_action_save" onclick="update_job_parameters_value();return false;" style="width:100%;">Save</a>	
        </td>
        </tr>

                                <tr>
                                   <td colspan="3"><strong>Scope : </strong>
                                           <span id="selected_scope"></span>
                                            <div class="clear"></div>
                                            <textarea id="extra_scope_of_work" rows="4" value="" class="form-control"  style="display:none;" ></textarea>    
                                               
                                   </td>                           
                                </tr>
								
				  <tr>
                                   <td colspan="3">
	         		<a href="javascript:void(0);" style="width:100%;" class="btn btn-primary" id="extra_scope_action_edit">Edit</a>
                                   <a class="btn btn-primary" style="width:100%;display:none;" href="javascript:void(0);" id="extra_scope_action_save" onclick="update_extra_scope();return false;" >Save</a>							
                                   </td>                           
                                </tr>
                     					
				  <tr>
                                   <td><strong>Job Status</strong></td>
                                   <td colspan="2"><span id="selected_job_status"></span></td>
                                </tr>
                                
                        <tr><td colspan="3"><small><strong>Note :</strong> If Yard time and Site time is same then worker should suppose to come at site directly otherwise worker should suppose to come at yard.</small></td></tr>
                        <tr>
                                <td class="bootstrap-timepicker">
                                <small><strong>Yard Time</strong></small><div class="clear"></div>
                                <input type="text" id="yard_time" class="form-control">
                                </td>
                                <td class="bootstrap-timepicker">
                                <small><strong>Site Time</strong></small><div class="clear"></div>
                                <input type="text" id="site_time" class="form-control">
                                </td>
                                <td class="bootstrap-timepicker">
                                <small><strong>Finish Time</strong></small><div class="clear"></div>
                                <input type="text" id="finish_time" class="form-control">
                                </td>
                        </tr>

                        <tr>
                               
								<td style="text-align:center;" id="day_night_radio" >
								<input type="radio" name="job_day_or_night" value="DAY" checked="checked">&nbsp;DAY &nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="job_day_or_night" value="NIGHT">&nbsp;NIGHT
								</td>								
								
								<td><input type="button" class="btn btn-primary" id="save_times_btn" value="Save" style="width:100%;"/></td>
                                <td><button data-toggle="modal" data-target="#myModal"  class="add_new_row btn btn-primary mr5" style="width:100%;" onclick="return false;" > Add Night Job </button></td>                           
                        </tr>



                            <tr>

                                    <td colspan="2">
                                      <select <?php if(Yii::app()->user->name === 'supervisor')	{ echo 'disabled'; } ?> class="form-control" name="assign_supervisor_id" id="assign_supervisor_id">
                                      <option value="0">Select Supervisor</option>
                                    <?php foreach ($supervisors as $value)  {	 ?>
                                      <option value="<?php echo $value->id; ?>"><?php echo $value->first_name.' '.$value->last_name; ?></option>
                                      <?php } ?>
                                       </select>
                                    </td>                           

                            <td>
							<?php if(in_array(Yii::app()->user->name,array('system_owner', 'state_manager', 'operation_manager')))	{ ?><input type="button" id="allocate_supervisor_btn"  class="btn btn-primary" value="Allocate S" style="width:100%;" /><?php } else { ?>&nbsp;&nbsp;<?php } ?></td>                           
                            </tr>

                            <tr>
                                    <td colspan="2">
                                        <select class="form-control " name="assign_site_supervisor_id" id="assign_site_supervisor_id">
                                        <option value="0">Select Site Supervisor</option>
                                        <?php foreach ($site_supervisors as $value)  {	 ?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->first_name.' '.$value->last_name; ?></option>
                                        <?php } ?>
                                        </select>
                                    </td>   
                                    <td><input type="button" class="btn btn-primary" id="allocate_site_supervisor_btn" value="Allocate SS" style="width:100%;"/></td>                           
                            </tr>


                            <tr>
                                <td id="allocation_staff" colspan="3">

                                                              <?php foreach ($staff as $value)  { ?>
                                                              <input class="chk" name="assign_staff_id" type="checkbox" value="<?php echo $value->id; ?>" />&nbsp;&nbsp;&nbsp;<?php echo $value->first_name.' '.$value->last_name; ?><br/>
                                                              <?php } ?>
                                                             </td>  


                            </tr>


                            <tr>
                                <td colspan="3"><input type="button" class="btn btn-primary" id="allocate_staff_btn" value="Allocate Staff" style="width:100%;"/></td>                           

                            </tr>
							<tr>
                                <td><strong style="text-decoration: line-through; color:#000000;">Black Scratch</strong> :  Staff already allocated</td>                           
                                <td><strong style="text-decoration: line-through; color:#FF0000;">Red Scratch</strong> : Staff working two shifts in one day</td>                           
                                <td><strong  style="text-decoration: line-through; color:#006400;">Green Scratch</strong> : Staff working previous NIGHT</td>                           

                            </tr>

                    </table>

	   <div class="clear"></div>
	   <div style="text-align:center;">
		   
		   <div class="alert alert-success" style="display:none;"></div>	
			<div class="alert alert-danger" style="display:none;"></div>	

			<?php if(Yii::app()->user->hasFlash('success')):?>
				<div class="alert alert-success">
					<?php echo Yii::app()->user->getFlash('success'); ?>
				</div>
			<?php endif; ?>

			<?php if(Yii::app()->user->hasFlash('danger')):?>
				<div class="alert alert-danger">
					<?php echo Yii::app()->user->getFlash('danger'); ?>
				</div>
			<?php endif; ?>
		   <img  id='imageloadstatus2' style="display:none;" src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/ajax-loader-bar.gif" alt="Loading...."/>
	   </div>
	   
 </div>    

        </div>    

			<?php } ?>
			
        </div>		 


<!-- Modal box 1 -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add New License</h4>
      </div>
	  
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-licenses-form1-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
	
)); ?>


              
            

		 
	  <?php echo $form->hiddenField($model,'job_id',array('class'=>'form-control','id'=>'pop_up_form_job_id')); ?> 
	  <?php echo $form->hiddenField($model,'working_date',array('class'=>'form-control','id'=>'pop_up_form_working_date')); ?> 
	  <?php echo $form->hiddenField($model,'day_night',array('class'=>'form-control','value'=>'NIGHT')); ?> 
	<input type="hidden" id="job_from_date" autocomplete="off" name="job_from_date" value="<?php echo $job_from_date; ?>" class="form-control" />
    <input type="hidden" id="job_to_date" autocomplete="off" name="job_to_date" value="<?php echo $job_to_date; ?>"  class="form-control" />
           
      <div class="modal-body">
     
	         <table class="table table-bordered" width="100%">
			 <tr>
			 <td><strong>Job ID : </strong><div class="clear"></div><span id="pop_up_form_job_id_text"></span></td>
			 <td><strong>Working Date : </strong><div class="clear"></div><span id="pop_up_form_working_date_text"></span></td>
			 <td><strong>DAY/NIGHT : </strong><div class="clear"></div><span>NIGHT</span></td>			 
			 </tr>
			
			<tr>
			 
                                <td class="bootstrap-timepicker">
                                <small><strong>Yard Time</strong></small><div class="clear"></div>
                                <?php echo $form->textField($model,'yard_time',array('class'=>'form-control','id'=>'pop_up_form_yard_time')); ?> 
                                </td>
                                <td class="bootstrap-timepicker">
                                <small><strong>Site Time</strong></small><div class="clear"></div>
                                <?php echo $form->textField($model,'site_time',array('class'=>'form-control','id'=>'pop_up_form_site_time')); ?> 
                                </td>
                                <td class="bootstrap-timepicker">
                                <small><strong>Finish Time</strong></small><div class="clear"></div>
                                <?php echo $form->textField($model,'finish_time',array('class'=>'form-control','id'=>'pop_up_form_finish_time')); ?> 
                                </td>
			 </tr>
			 
			 <tr><td colspan="3"><small><strong>Note :</strong> When you need 2 jobs day and night on same date, then only click on save button, Otherwise you can switch day job to night job.</small></td></tr>
			 <tr><td colspan="3" style="text-align:center;"><?php echo CHtml::submitButton('Save',array('class'=>'btn btn-primary')); ?></td></tr>
			 
			 </table>
	 
		
      </div>
   


<?php $this->endWidget(); ?>

   </div>
    <!-- modal-content --> 
  </div>
  <!-- modal-dialog --> 
  
</div>
		
<?php 

$referenced_job_id = isset($_REQUEST['referenced_job_id']) ? $_REQUEST['referenced_job_id'] : 0;
if( $referenced_job_id > 0 ) { 
?>

<script type="text/javascript">
var referenced_job_id = '<?php echo $referenced_job_id; ?>'
$( "."+referenced_job_id ).addClass( "td3" );

</script>

<?php } ?>
