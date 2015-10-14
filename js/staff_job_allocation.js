    $(document).ready(function(){

	$( ".headerwrapper" ).addClass( "collapsed" );
	$( ".mainwrapper" ).addClass( "collapsed" );	
	jQuery('#yard_time').timepicker({defaultTIme: false}); 
	jQuery('#site_time').timepicker({defaultTIme: false}); 
	jQuery('#finish_time').timepicker({defaultTIme: false}); 
	jQuery('#pop_up_form_yard_time').timepicker({defaultTIme: false}); 
	jQuery('#pop_up_form_site_time').timepicker({defaultTIme: false}); 
	jQuery('#pop_up_form_finish_time').timepicker({defaultTIme: false}); 


        $('#hide_right_panel').click(function(){
            $("#left_panel" ).removeClass( "col-md-8" ).addClass( "col-md-12" );
            $("#right_panel").hide();            
        });
        
        $('.job_date_row').click(function(){
             
            id = $(this).closest('tr').attr('id');
             
            $('#left_panel tr').removeClass("td3");
            $(this).closest('tr').addClass("td3");
            
            var split_jobID_workingDate = id.split("_");
            var tr_row = split_jobID_workingDate[0]; 
            var job_id = split_jobID_workingDate[1];
            var working_date = split_jobID_workingDate[2];
            var day_night = split_jobID_workingDate[3];

            var last_selected_job_id = $('#form_selected_job_id').val();
            var last_selected_working_date = $('#form_selected_working_date').val();
            var last_selected_working_day_night = $('#form_selected_working_day_night').val();
/*
            if(last_selected_job_id != '' && last_selected_job_id !=null && last_selected_job_id == job_id 
            && last_selected_working_date != '' && last_selected_working_date !=null && last_selected_working_date == working_date 
            && last_selected_working_day_night != '' && last_selected_working_day_night !=null && last_selected_working_day_night == day_night)		
             return false;
		 */
            jQuery("#imageloadstatus").show();                    
            jQuery("#imageloadstatus2").show();         
            
            $('#form_selected_tr_row').val(tr_row);
            $('#form_selected_job_id').val(job_id);
            $('#form_selected_working_date').val(working_date);
            $("#form_selected_working_day_night").val(day_night);
            //pop up add new record
            $('#pop_up_form_job_id').val(job_id);
            $('#pop_up_form_job_id_text').text(job_id);
            $('#pop_up_form_working_date').val(working_date);
            $('#pop_up_form_working_date_text').text(working_date);
            
            
            
                    post_data = {
                            job_id: job_id,
                            working_date: working_date,
                            day_night: day_night
                    };


                     jQuery.ajax(
                    {
                            url: '?r=StaffJobAllocation/default/UpdateRightSideBar',
                            type: "POST",
                            data: post_data,
                            success: function (data, textStatus, jqXHR) {

                            var result = JSON.parse(data);
                            //console.log(result);
                            //console.log(result.job_id);
                            //text inputs
                            $("#form_selected_job_id").val(result.job_id);	
                            $("#form_selected_working_date").val(result.default_mysql_working_date);

                            //labels
                            $("#selected_job_id").html('Job ID : &nbsp;<a style="float:right;color:#FFF;font-size:1em;" href="?r=Quotes/Job/view&id='+result.job_id+'" target="_blank"> '+result.job_id+' </a>');	
                            $("#selected_working_date").text(result.working_date+' ('+result.working_day.toUpperCase()+'-'+day_night+')');	
                            $("#selected_site_name").text(result.site_name);	
                            $("#selected_service_name").text(result.service_name);	
                            $("#staff_required").val(result.staff_required);	
                            $("#job_total_working_hour").val(result.job_total_working_hour);	
                            $("#selected_scope").html(result.scope);	
                            $("#extra_scope_of_work").html(result.extra_scope_of_work);
                            $("#allocation_staff").html(result.staff_html_text);
                            $("#day_night_radio").html(result.day_night_radio_text);
			    $("#selected_job_status").html(result.job_status);
                           
                            //times	
                            $("#yard_time").val(result.yard_time);
                            $("#site_time").val(result.site_time);
                            $("#finish_time").val(result.finish_time);
                        
                            // last selected supervisor
                            document.getElementById("assign_supervisor_id").value = result.supervisor_id;
                            document.getElementById("assign_site_supervisor_id").value = result.site_supervisor_id;

                            $("#extra_scope_action_edit").show();
                            $("#extra_scope_value").show();
                            $("#extra_scope_action_save").hide();
                            $("#extra_scope_of_work").hide();

							
							if(day_night === 'NIGHT') {
								$('.job_button_paused').show();
							} else {
								$('.job_button_paused').hide();
							}
							
                            $("#left_panel" ).removeClass( "col-md-12" ).addClass( "col-md-8" );
                            $("#right_panel").show();
                            
                            
                           

                            
                            jQuery("#imageloadstatus").hide();
							jQuery("#imageloadstatus2").hide();	
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                            }
                    });
		 
        });        
        
 
         $('.job_button_paused').click(function(){
   
    var job_id = $('#form_selected_job_id').val();   
	var working_date = jQuery('#form_selected_working_date').val();
    var day_night = $('#form_selected_working_day_night').val();
	var tr_row = $('#form_selected_tr_row').val();
	
	var tr_id = tr_row+'_'+job_id+'_'+working_date+'_'+day_night;

	
	if(day_night != 'NIGHT') {
		alert('Only night job you can delete.');
		return false;
	}
			post_data = {
                            job_id: job_id,
                            working_date: working_date
                    };

        var r = confirm("Are you sure, do you want to delete night job ?");
        if (r == true) {

                     jQuery.ajax(
                    {
                            url: '?r=StaffJobAllocation/default/DeleteJobWorkingRecord',
                            type: "POST",
                            data: post_data,
                            success: function (data, textStatus, jqXHR) {
								$('#'+tr_id).remove();
								 $("#left_panel" ).removeClass( "col-md-8" ).addClass( "col-md-12" );
								$("#right_panel").hide();
								
								 alert("Successfully deleted night job.");
								
								
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                            }
                    });
				}
				
        });        
        
 

    $("#allocate_supervisor_btn").click(function () {
    var job_id = $('#form_selected_job_id').val();   
    var user_id = jQuery('#assign_supervisor_id').val();

    if (user_id == '' || user_id == 0) {
        //alert("Please select supervisor.");
		 alert('Please select supervisor.');
		
        return false;
    }

    var post_data = 'id=' + job_id + '&user_id=' + user_id;
  
 
   post_data = {
                            id: job_id,
                            user_id: user_id
                    };

	jQuery("#imageloadstatus").show();
	jQuery("#imageloadstatus2").show();
		
    jQuery.ajax(
            {
                url: '?r=Quotes/Job/assign_supervisor',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {
                   
                    if (data == 'invalid') {
                        document.getElementById("assign_supervisor_id").value = 0;
                        //alert("Supervisor can be assigned to only approved and booked jobs");
						 alert("Supervisor can be assigned to only approved and booked jobs");
						
						jQuery("#imageloadstatus").hide();
					jQuery("#imageloadstatus2").hide();
                        return false;
                    }


                    if (data == 0) {
                        //alert("Please select different user.");
						 alert("Please select different user.");
						
						jQuery("#imageloadstatus").hide();
					jQuery("#imageloadstatus2").hide();
                        return false;
                    }

                    if (data == 1) {
                         //alert("Successfully allocated supervisor.");
						  alert("Successfully allocated supervisor.");
						 
						jQuery("#imageloadstatus").hide();
					jQuery("#imageloadstatus2").hide();
                        return false;
                    }
					
					

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });


    return false;





    });



    $("#allocate_site_supervisor_btn").click(function () {
    var job_id = $('#form_selected_job_id').val();   
    var user_id = jQuery('#assign_site_supervisor_id').val();
    var day_night = $('#form_selected_working_day_night').val();      
    var job_date = jQuery('#form_selected_working_date').val();
    

    if (user_id == '' || user_id == 0) {
        //alert("Please select site supervisor.");
		 alert("Please select site supervisor.");
		
        return false;
    }

 
 
	post_data = {
           id: job_id,
           user_id: user_id,
           day_night: day_night,
           job_date: job_date
       };
		
	jQuery("#imageloadstatus").show();
	jQuery("#imageloadstatus2").show();		
     
    jQuery.ajax(
            {
                url: '?r=Quotes/Job/assign_site_supervisor',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {
                  

                    if (data == 'invalid') {
                        document.getElementById("assign_site_supervisor_id").value = 0;
                        //alert("Site Supervisor can be assigned to only approved and booked jobs");
						 alert("Site Supervisor can be assigned to only approved and booked jobs");
						
						jQuery("#imageloadstatus").hide();
						jQuery("#imageloadstatus2").hide();
                        return false;
                    }

                    if (data == 'assign_supervisor') {
                        document.getElementById("assign_site_supervisor_id").value = 0;
                        //alert("Please allocate Supervisor first.");
						 alert("Please allocate Supervisor first.");
						
						jQuery("#imageloadstatus").hide();
						jQuery("#imageloadstatus2").hide();
                        return false;
                    }


                    if (data == '0') {
                        document.getElementById("assign_site_supervisor_id").value = 0;
                        //alert("Please select different user.");
						 alert("Please select different user.");
						
						jQuery("#imageloadstatus").hide();
						jQuery("#imageloadstatus2").hide();
                        return false;
                    }

                    if (data == '1') {
                        
                        
                        
     post_data = {
           job_id: job_id,
           day_night: day_night,
           working_date: job_date
       };
    var tr_row = $('#form_selected_tr_row').val();
        
    jQuery.ajax(
            {
                url: '?r=StaffJobAllocation/default/getWorkingDateSupervsior',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {
                   
                       $("#"+tr_row+'_SS').html('<span style="color:#ff00ff;">'+data+'</span>'); 
					    alert("Successfully allocated site supervisor.");
					   
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });



                        
                      jQuery("#imageloadstatus").hide();
					jQuery("#imageloadstatus2").hide();  
                        
                        
                        
                        
                        //alert("Successfully allocated site supervisor.");
                        //return false;
                    }

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });


    //return false;




    });



     $("#allocate_staff_btn").click(function () {
     var job_id = $('#form_selected_job_id').val(); 
     var user_id = getValueUsingClass();
     var day_night = $('#form_selected_working_day_night').val();      
     var job_date = jQuery('#form_selected_working_date').val();
	
	if(user_id == '' || user_id == 0 ) {
		//alert("Please select staff.");
		 alert("Please select staff.");
		
		return false;
		}


	post_data = {
           id: job_id,
           user_id: user_id,
           day_night: day_night,
           job_date: job_date
       };	
		 
		 jQuery("#imageloadstatus").show();
	jQuery("#imageloadstatus2").show();
		
		  jQuery.ajax(
                                    {
                                    url : '?r=Quotes/Job/assign_staff',
                                    type: "POST",
                                    data : post_data,
                                    success:function(data, textStatus, jqXHR){

                                    if(data == 'invalid') {
                                   // alert("Staff can be assigned to only approved and booked jobs");
									 alert("Staff can be assigned to only approved and booked jobs");
									
										jQuery("#imageloadstatus").hide();
					jQuery("#imageloadstatus2").hide();
                                    return false;
                                    }

										if(data == 'submit_main_form') {
											document.getElementById("myForm").submit();
										}
											

                                            if(data == 'assign_supervisor') {                                                                    
                                                    //alert("Please allocate Supervisor first.");
													 alert("Please allocate Supervisor first.");
													
												jQuery("#imageloadstatus").hide();
					jQuery("#imageloadstatus2").hide();
                                                    return false;
                                            }


                                            if(data == 'assign_site_supervisor') {
                                                    //alert("Please allocate Site Supervisor first.");
													 alert("Please allocate Site Supervisor first.");
													
												jQuery("#imageloadstatus").hide();
					jQuery("#imageloadstatus2").hide();
                                                    return false;
                                            }

                                            if(data == 0) {
                                           // alert("This staff already assigned for your selected date.");
											 alert("This staff already assigned for your selected date.");
											
												jQuery("#imageloadstatus").hide();
					jQuery("#imageloadstatus2").hide();
                                            return false;
                                            } else	if(data == 1) {


     post_data = {
           job_id: job_id,
           day_night: day_night,
           working_date: job_date
       };
       
  var tr_row = $('#form_selected_tr_row').val();
     
    jQuery.ajax(
            {
                url: '?r=StaffJobAllocation/default/getWorkingDateStaffs',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {
                   
                       $("#"+tr_row+'_ST').html('<span style="color:#ff00ff;">'+data+'</span>'); 
					    alert("successfully assigned staff to this job.");
					   

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });

jQuery("#imageloadstatus").hide();
	jQuery("#imageloadstatus2").hide();

                                                    //alert("successfully assigned staff to this job.");
                                                    return false;
                                            }

                                    },
                                    error: function(jqXHR, textStatus, errorThrown)
                                            {}
                    });
	
								
			return false;




    });
   
   
 
            $("#job_from_date").datepicker({
                numberOfMonths: 1,
                dateFormat:'yy-mm-dd',
                onSelect: function(selected) {
                  $("#job_to_date").datepicker("option","minDate", selected)
                }
            });
            
            $("#job_to_date").datepicker({ 
                numberOfMonths: 1,
                dateFormat:'yy-mm-dd',
                onSelect: function(selected) {
                   $("#job_from_date").datepicker("option","maxDate", selected)
                }
            });  
            
          
 jQuery("#extra_scope_action_edit").click(function () {
        
    var job_id = $('#form_selected_job_id').val();   
   
    post_data = {
        job_id: job_id
    };

    jQuery.ajax(
            {
                url: '?r=StaffJobAllocation/default/get_extra_scope',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {
        
                    $("#extra_scope_action_edit").hide();
                    $("#extra_scope_value").hide();
                    $("#extra_scope_action_save").show();
                    $("#extra_scope_of_work").show();

                    $("#extra_scope_of_work").html(data);

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });
            return false;
        
        
    });



  $("#save_times_btn").click(function () {
		var job_id = $('#form_selected_job_id').val(); 
		var working_date = jQuery('#form_selected_working_date').val();
		var last_day_night = $('#form_selected_working_day_night').val();      
		var yard_time = $('#yard_time').val();   
		var site_time = $('#site_time').val();   
		var finish_time = $('#finish_time').val();   
         
if(yard_time == '')	
yard_time = site_time;
	
                var day_night_selected = $("input[type='radio'][name='job_day_or_night']:checked");
               
                if (day_night_selected.length > 0) {
                    day_night = day_night_selected.val();
                }

	   
		post_data = {
			   job_id: job_id,
			   working_date: working_date,
			   day_night: day_night,           
			   yard_time: yard_time,
			   site_time: site_time,
			   finish_time: finish_time,
               last_day_night: last_day_night,
		   };
	


var tr_row = $('#form_selected_tr_row').val();

jQuery.ajax(
            {
                url: '?r=StaffJobAllocation/default/AddUpdateWorkingDate',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {
                    
                    
                    if(data == 'same_day_night_switch') {
                        //alert('same_day_night_switch'); 
                         alert('Sorry! the same job '+job_id+' on same date '+working_date+' '+day_night+' is already available. You can not switch.');
                        
						return false;
                    }
                    
                    if(data == 'inserted' || data == 'updated') {
                       
                            //change id of tr elements
                            var last_tr_id = tr_row+'_'+job_id+'_'+working_date+'_'+last_day_night;
                            var current_tr_id = tr_row+'_'+job_id+'_'+working_date+'_'+day_night;                            
                            $('#'+last_tr_id).attr("id", current_tr_id);
                            
                           
                            $("#"+tr_row+"_yard_time").html('<span style="color:#ff00ff;">'+yard_time+'</span>');
                            $("#"+tr_row+"_site_time").html('<span style="color:#ff00ff;">'+site_time+'</span>');
                            $("#"+tr_row+"_finish_time").html('<span style="color:#ff00ff;">'+finish_time+'</span>');
                            $("#"+tr_row+"_day_night").html('<span style="color:#ff00ff;">'+day_night+'</span>');
                            
                             alert('Data Saved Successfully.');
                            $('#form_selected_working_day_night').val(day_night);	
                            
                           
                            
                            
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });


    return false;
	   
    });


            
    
});


function update_job_parameters_value() {

    var job_id = $('#form_selected_job_id').val();   
    var staff_required = jQuery('#staff_required').val();
    var job_total_working_hour = jQuery('#job_total_working_hour').val();


	if(staff_required == '')
		staff_required = 0;
	
	if(job_total_working_hour == '')
		job_total_working_hour = 0;
	
	
	
    post_data = {
        id: job_id,
        staff_required: staff_required,
        job_total_working_hour: job_total_working_hour
    };

    jQuery.ajax(
            {
                url: '?r=Quotes/job/Update_job_parameters_value',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {
						alert("successfully updated details.");

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });
    return false;


}



function getValueUsingClass(){
			/* declare an checkbox array */
			var chkArray = [];
			
			/* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
			$(".chk:checked").each(function() {
				chkArray.push($(this).val());
			});
			
			/* we join the array separated by the comma */
			var selected;
			selected = chkArray.join('_') + "_";
			
			/* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
			if(selected.length > 1){
				//alert("You have selected " + selected);	
				return selected; 
			}else{
				return 0;	
			}
	}

	


function update_extra_scope() {

    var job_id = $('#form_selected_job_id').val();   
    var extra_scope_of_work = jQuery('#extra_scope_of_work').val();

    post_data = {
        id: job_id,
        extra_scope_of_work: extra_scope_of_work
    };

    jQuery.ajax(
            {
                url: '?r=Quotes/job/update_extra_scope',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {

                    $("#extra_scope_of_work_p").html(extra_scope_of_work);
                    $("."+job_id+"_extra_scope_of_work_p").html('<span style="color:#ff00ff;">'+extra_scope_of_work+'</span>');
                    $("#extra_scope_action_edit").show();
                    $("#extra_scope_value").show();
                    $("#extra_scope_action_save").hide();
                    $("#extra_scope_of_work").hide();


                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });
    return false;

}


