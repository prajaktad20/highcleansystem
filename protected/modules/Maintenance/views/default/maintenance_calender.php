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
              <li>Maintenance Calender</li>	 
            </ul>		

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

		$('#calendar').fullCalendar({
			
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay',
			},
			
			firstDay:1,

			
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
