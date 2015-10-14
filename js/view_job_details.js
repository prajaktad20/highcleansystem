

jQuery(document).ready(function () {

    var job_id = $('#job_id').val();

    $("#start_job").click(function () {

        var r = confirm("Do you want to start job ?");        
        if(r == false)        
        return false;
        
        var job_status = 'Started';        
        post_data = {
            id: job_id,
            job_status: job_status
        };

        jQuery.ajax(
                {
                    url: '?r=Quotes/job/change_job_status',
                    type: "POST",
                    data: post_data,
                    success: function (data, textStatus, jqXHR) {

                        if (data == 'assign_supervisor') {
                            alert('Please assign supervisor first.');
                            return false;
                        } else if (data == 'assign_site_supervisor') {
                            alert('Please assign site supervisor first.');
                            return false;
                        } else if (data == 'assign_staff') {
                            alert('Please assign staff first.');
                            return false;
                        }

                        if (data == '1') {
		   	 $("#current_job_status").text(job_status);	
                            $("#start_job").hide();
                            $("#pause_job").show();
                            $("#complete_job").show();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                    }
                });
        return false;



    });

    $("#restart_job").click(function () {


        var r = confirm("Do you want to restart job ?");        
        if(r == false)        
        return false;
        


        var job_status = 'Restarted';
        post_data = {
            id: job_id,
            job_status: job_status
        };
        jQuery.ajax(
                {
                    url: '?r=Quotes/job/change_job_status',
                    type: "POST",
                    data: post_data,
                    success: function (data, textStatus, jqXHR) {

                        if (data == 'assign_supervisor') {
                            alert('Please assign supervisor first.');
                            return false;
                        } else if (data == 'assign_site_supervisor') {
                            alert('Please assign site supervisor first.');
                            return false;
                        } else if (data == 'assign_staff') {
                            alert('Please assign staff first.');
                            return false;
                        }

                        if (data == '1') {
			$("#current_job_status").text(job_status);
                            $("#restart_job").hide();
                            $("#pause_job").show();
                            $("#complete_job").show();
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                    }
                });
        return false;



    });

    $("#pause_job").click(function () {



        var r = confirm("Do you want to pause job ?");        
        if(r == false)        
        return false;
        
        var job_status = 'Paused';
        
      
        post_data = {
            id: job_id,
            job_status: job_status
        };

        jQuery.ajax(
                {
                    url: '?r=Quotes/job/change_job_status',
                    type: "POST",
                    data: post_data,
                    success: function (data, textStatus, jqXHR) {

                        if (data == 'assign_supervisor') {
                            alert('Please assign supervisor first.');
                            return false;
                        } else if (data == 'assign_site_supervisor') {
                            alert('Please assign site supervisor first.');
                            return false;
                        } else if (data == 'assign_staff') {
                            alert('Please assign staff first.');
                            return false;
                        }

                        if (data == '1') {
			$("#current_job_status").text(job_status);
                            $("#restart_job").show();
                            $("#pause_job").hide();
                            $("#complete_job").hide();
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                    }
                });
        return false;



    });

    $("#complete_job").click(function () {



        var r = confirm("Do you want to complete job ?");        
        if(r == false)        
        return false;
        

        var job_status = 'Completed';
        
   
        post_data = {
            id: job_id,
            job_status: job_status
        };
        jQuery.ajax(
                {
                    url: '?r=Quotes/job/change_job_status',
                    type: "POST",
                    data: post_data,
                    success: function (data, textStatus, jqXHR) {

                        if (data == 'assign_supervisor') {
                            alert('Please assign supervisor first.');
                            return false;
                        } else if (data == 'assign_site_supervisor') {
                            alert('Please assign site supervisor first.');
                            return false;
                        } else if (data == 'assign_staff') {
                            alert('Please assign staff first.');
                            return false;
                        }

                        if (data == '1') {
							$("#current_job_status").text(job_status);
                            $("#complete_job").hide();
                            $("#pause_job").hide();
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                    }
                });
        return false;



    });


    jQuery(".upload_service_image").click(function () {

        $('#before_preview').html();
        var job_service_id = jQuery(this).attr("id");
        jQuery("#job_service_id").val(job_service_id);
        var post_data = 'job_service_id=' + job_service_id;
        jQuery("#before_imageloadstatus").show();
        jQuery.ajax(
                {
                    url: '?r=Quotes/Job/GetImageSrcByServiceId',
                    type: "POST",
                    data: post_data,
                    success: function (data, textStatus, jqXHR) {
                        $('#myModal2').modal('show');
                        $('#before_preview').html(data);
                        jQuery("#before_imageloadstatus").hide();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                    }
                });

    });




    jQuery('#before_photoimg').die('click').live('change', function () {

        jQuery("#before_imageform").ajaxForm({target: '#before_preview',
            beforeSubmit: function () {

                jQuery("#before_imageloadstatus").show();
                jQuery("#before_imageloadbutton").hide();
            },
            success: function (data) {

                jQuery("#before_imageloadstatus").hide();
                jQuery("#before_imageloadbutton").show();



            },
            error: function () {

                jQuery("#before_imageloadstatus").hide();
                jQuery("#before_imageloadbutton").show();

            }}).submit();


    });




    jQuery("#job_remove_supervisor").click(function () {

        var txt;
        var r = confirm("Are you sure to remove supervisor ?");
        if (r == true) {

            $("#job_remove_supervisor").hide();
            $("#allocation_supervisor_value").hide();
            $("#allocation_supervisor_dropdown").show();
            $("#job_allocate_supervisor").show();


            post_data = {
                id: job_id,
            };

            jQuery.ajax(
                    {
                        url: '?r=Quotes/job/Delete_job_supervisor',
                        type: "POST",
                        data: post_data,
                        success: function (data, textStatus, jqXHR) {

                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                        }
                    });
            return false;
        }


    });


    jQuery("#purchase_order_action_edit").click(function () {
        $("#purchase_order_action_edit").hide();
        $("#purchase_order_value").hide();
        $("#purchase_order_action_save").show();
        $("#purchase_order").show();
    });


   jQuery("#job_total_working_hour_action_edit").click(function () {
        $("#job_total_working_hour_action_edit").hide();
        $("#job_total_working_hour_value").hide();
        $("#job_total_working_hour_action_save").show();
        $("#job_total_working_hour").show();
    });





    jQuery("#extra_scope_action_edit").click(function () {
        $("#extra_scope_action_edit").hide();
        $("#extra_scope_value").hide();
        $("#extra_scope_action_save").show();
        $("#extra_scope_of_work").show();
    });


    jQuery("#job_note_action_edit").click(function () {
        $("#job_note_action_edit").hide();
        $("#job_note_value").hide();
        $("#job_note_action_save").show();
        $("#job_note").show();
    });



});


function update_tool_types() {

    var job_id = jQuery('input#job_id').val();
    var tool_type_ids = getValueUsingClass();
   

    post_data = {
        id: job_id,
        tool_type_ids: tool_type_ids
    };

    jQuery.ajax(
            {
                url: '?r=Quotes/job/update_tool_types',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {

                        if(data == 1)
                            alert('Data saved successfully.');
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });
    return false;

}

function update_job_note() {

    var job_id = jQuery('input#job_id').val();
    var job_note = jQuery('#job_note').val();
    //var post_data = 'job_id='+job_id+'&job_note='+job_note;

    post_data = {
        id: job_id,
        job_note: job_note
    };

    jQuery.ajax(
            {
                url: '?r=Quotes/job/update_job_note',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {



                    $("#job_note_value").html($("#job_note").val());
                    $("#job_note_action_edit").show();
                    $("#job_note_value").show();
                    $("#job_note_action_save").hide();
                    $("#job_note").hide();


                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });
    return false;

}

function update_extra_scope() {

    var job_id = jQuery('input#job_id').val();
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



                    $("#extra_scope_value").html($("#extra_scope_of_work").val());
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

function update_purchase_order() {

    var job_id = jQuery('input#job_id').val();
    var purchase_order = jQuery('#purchase_order').val();

    post_data = {
        id: job_id,
        purchase_order: purchase_order
    };

    jQuery.ajax(
            {
                url: '?r=Quotes/job/update_purchase_order',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {


                    $("#purchase_order_value").html(purchase_order);
                    $("#purchase_order_action_edit").show();
                    $("#purchase_order_value").show();
                    $("#purchase_order_action_save").hide();
                    $("#purchase_order").hide();



                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });
    return false;


}

function update_job_total_working_hour() {

    var job_id = jQuery('input#job_id').val();
    var job_total_working_hour = jQuery('#job_total_working_hour').val();

    post_data = {
        id: job_id,
        job_total_working_hour: job_total_working_hour
    };

    jQuery.ajax(
            {
                url: '?r=Quotes/job/update_job_total_working_hour',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {


                    $("#job_total_working_hour_value").html(job_total_working_hour);
                    $("#job_total_working_hour_action_edit").show();
                    $("#job_total_working_hour_value").show();
                    $("#job_total_working_hour_action_save").hide();
                    $("#job_total_working_hour").hide();


                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });
    return false;


}


function approve_job(job_id) {


    var post_data = 'id=' + job_id;

    jQuery.ajax(
            {
                url: '?r=Quotes/Job/approve_job',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {

                    if (data == 1)
                        jQuery("#approval_status").text('Approved By Admin');

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });


    return false;


}

function assign_supervisor(job_id) {



    var user_id = jQuery('#assign_supervisor_id').val();

    if (user_id == '' || user_id == 0) {
        alert("Please select supervisor.");
        return false;
    }

    var post_data = 'id=' + job_id + '&user_id=' + user_id;
    jQuery("#allocate_supervisor_loader").show();

    jQuery.ajax(
            {
                url: '?r=Quotes/Job/assign_supervisor',
                type: "POST",
                data: post_data,
                success: function (data, textStatus, jqXHR) {
                    jQuery("#allocate_supervisor_loader").hide();

                    if (data == 'invalid') {
                        alert("Supervisor can be assigned to only approved and booked jobs");
                        return false;
                    }


                    if (data == 0) {
                        alert("This user already assigned");
                        return false;
                    }

                    if (data == 1) {
                        
                        $("#allocation_supervisor_value").html($("#allocation_supervisor_dropdown").val());
                        $("#job_remove_supervisor").show();
                        $("#allocation_supervisor_value").show();
                        $("#allocation_supervisor_dropdown").hide();
                        $("#job_allocate_supervisor").hide();

                        $("#allocation_supervisor_dropdown").hide();
                        $("#allocation_supervisor_value").html($("#assign_supervisor_id option:selected").text());
                        alert("Successfully allocated supervisor.");
                        return false;
                    }

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                }
            });


    return false;



}



function getValueUsingClass() {
    /* declare an checkbox array */
    var chkArray = [];

    /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
    $(".chk:checked").each(function () {
        chkArray.push($(this).val());
    });

    /* we join the array separated by the comma */
    var selected;
    selected = chkArray.join('_') + "_";

    /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
    if (selected.length > 1) {
//alert("You have selected " + selected);
        return selected;
    } else {
        return 0;
    }
}

function allow_change_contact() {
    $("#change_quote_contact").show();
}

function set_worker_start_time(time,element_row_value) {
	var td_working_time_id = "td_start_time_"+element_row_value;
	$("#"+td_working_time_id).text(time);
}
