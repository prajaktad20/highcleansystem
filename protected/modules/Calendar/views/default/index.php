<style>

.fc-center{
	background-color : #ffffff;	
	color : #000000;	
}

.bright_red {
    background: #ff0000; !important;
    color: #ffffff;
}
   
</style>
<link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/css/fullcalendar.css' rel='stylesheet' />
<link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/css/fullcalendar.print.css' rel='stylesheet' media='print' />



<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>

              <li>Job Calender</li>	 
            </ul>		
<h4>Calender</h4>
          </div>
        </div>
        <!-- media --> 
</div> 

			  


<div class="contentpanel">
        <div class="row">
          <div class="col-md-12 quote_section"> 
           
		     <div class="row">
                 <div class="col-md-12 mb20">
			
				 </div> 
			</div> 
				 
              
                <div class="row">
	<div class="col-md-12 mb20">
	<a href="<?php echo $this->user_role_base_url.'/?r=Calendar/default/index&approval_status='.urlencode('Pending Admin Approval'); ?>" ><button class="btn small_btn btn-danger mr5">Not Approved</button></a>
	<a href="<?php echo $this->user_role_base_url.'/?r=Calendar/default/index&approval_status='.urlencode('Approved By Admin'); ?>" ><button class="btn small_btn btn-primary mr5">Approved</button></a>
	<a href="<?php echo $this->user_role_base_url.'/?r=Calendar/default/index&job_status='.urlencode('Started'); ?>" ><button class="btn btn-success small_btn mr5">Started</button></a>
	<a href="<?php echo $this->user_role_base_url.'/?r=Calendar/default/index&job_status='.urlencode('Paused'); ?>" ><button class="btn small_btn mr5 yellowcolor">Paused</button></a>
	<a href="<?php echo $this->user_role_base_url.'/?r=Calendar/default/index&job_status='.urlencode('Completed'); ?>" ><button class="btn small_btn mr5 blackbgcolor">Completed</button></a>
	&nbsp;&nbsp;
	
	<?php if(in_array(Yii::app()->user->name, array('system_owner', 'state_manager', 'operation_manager', 'agent'))) { ?>
	<div style="float:right;margin-right:30%;color:#000000" id="month_value">	</div>
	<?php } ?>
	
	
	
                  </div>
                </div>
		
				
				<div class="row">
                  <div class="col-md-12">
                    <div id="calendar"></div>
                  </div>
                  
                </div>
                <!-- row -->
                
                <div class="clearfix"></div>
             
            
          </div>
        </div>
</div>
      <!-- contentpanel -->
    
<script>

	$(document).ready(function() {

	var job_events = JSON.parse('<?php echo $calender_events; ?>');
	var ajax_url = '<?php echo $this->user_role_base_url.'/?r=Calendar/default/DragJob'; ?>';
	var view_month_year_url = '<?php echo $this->user_role_base_url.'/?r=Calendar/default/GetMonthReport'; ?>';
	//console.log(job_events);

		$('#calendar').fullCalendar({
			
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay',
			},
			
			firstDay:1,
			
			        viewRender: function (view, element) {
						var title = ($('#calendar').fullCalendar('getView').title);
						
							$.ajax({
							url: view_month_year_url,
							type: "GET",
							//dataType: "json",				
							data: 'title='+title,
							success: function(data, textStatus) {
							
							$("#month_value").html(data);
							//$(".fc-center").append(data);
							
							  if (!data)
							  {
							   // revertFunc();
								return;
							  }
							 // calendar.fullCalendar('updateEvent', event);
							},
							error: function() {
							  //revertFunc();
							}
						});
						
			},
			
			
		<?php if(! in_array(Yii::app()->user->name, array('system_owner', 'state_manager', 'operation_manager', 'agent', 'supervisor'))) { ?>	

		eventRender: function(event, element) {
			if (event.id.indexOf("IDENTIFYING_STRING") == -1) 
			{
				event.editable = false;
			}                       
		},		
		<?php } ?>

		
			

		
		eventDrop: function(event, delta, minuteDelta, allDay, revertFunc) {

		var move_date = event.start.format();
		//alert(move_date);
//		alert(event.id + " was dropped on " + event.start.format());		
			
        if (!confirm("Are you sure about this change?")) {
            revertFunc();
        }
    	$.ajax({
					url: ajax_url,
					type: "GET",
					//dataType: "json",				
					data: 'id='+event.id+'&move_date='+move_date,				
					
					success: function(data, textStatus) {
					
					  if (!data)
					  {
					   // revertFunc();
						return;
					  }
					 // calendar.fullCalendar('updateEvent', event);
					},
					error: function() {
					  //revertFunc();
					}
			});
		
		
		
		

    },
			
			defaultDate: '<?php echo date('Y-m-d'); ?>',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: job_events,
			eventClick: function(event) {
        if (event.url) {
            window.open(event.url);
            return false;
        }
    }
			
		});
		
		
	});
	


</script> 
