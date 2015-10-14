
		function FindListTypeOption() {
			var selected_list_type_id = $('#list_type_id').val();
			var list_type_option = $("#list_type_id option:selected").text();
			$("#dynamic_list_type_value").html(list_type_option+" MANAGEMENT");

				for(var i=1;i<=10;i++) {
				$("#list_type_"+i).hide();
				}
				$("#list_type_"+selected_list_type_id).show();
				
		}


		function reset_list_buliding_type_form() {
		$('input#list_buliding_type_id').val('');
		$('input#list_buliding_type_name').val('');
		return false;
		}
		
	// update new add_list_buliding_type record
		function update_list_buliding_type() {
		 //alert('hi');
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_buliding_type_id = $('input#list_buliding_type_id').val(); // common field for all model
		var list_buliding_type_name = $("input#list_buliding_type_name").val();
		if(list_buliding_type_name == null || list_buliding_type_name == '') {
		alert('Please enter Builing Type name');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/update_list_buliding_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_buliding_type_id='+list_buliding_type_id+'&list_buliding_type_name='+list_buliding_type_name,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Builing Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_buliding_type_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_1-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		
		
	

	// add new add_list_buliding_type record
		function add_list_buliding_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_buliding_type_name = $("input#list_buliding_type_name").val();
		if(list_buliding_type_name == null || list_buliding_type_name == '') {
		alert('Please enter Builing Type name');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/add_list_buliding_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_buliding_type_name='+list_buliding_type_name,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Builing Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_buliding_type_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_1-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		
		
		
// add new add_list_glass_type record
		function add_list_glass_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_glass_type_name = $("input#list_glass_type_name").val();
		if(list_glass_type_name == null || list_glass_type_name == '') {
		alert('Please Enter Glass Type Name');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/add_list_glass_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_glass_type_name='+list_glass_type_name,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Glass Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_glass_type_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_2-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}	
   //reset list_glass_type
		function reset_list_glass_type_form(){
		
								$("input#list_glass_type_name").val('');
		return false;
		}  		
            
		
// Update list_glass_type record
		function update_list_glass_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_glass_type_name = $("input#list_glass_type_name").val();
		var list_glass_type_id = $("input#list_glass_type_id").val();
		if(list_glass_type_name == null || list_glass_type_name == '') {
		alert('Please Enter Glass Type Name');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/Update_list_glass_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_glass_type_name='+list_glass_type_name+'&list_glass_type_id='+list_glass_type_id,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Glass Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_glass_type_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_2-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}	

// add new add_list_quality_type record
		function add_list_quality_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_quality_type_name = $("input#list_quality_type_name").val();
		if(list_quality_type_name == null || list_quality_type_name == '') {
		alert('Please Enter Quality Type Name');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/add_list_quality_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_quality_type_name='+list_quality_type_name,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Quality Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_quality_type_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_3-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}	

  	    //reset list_quality_type
		function reset_list_quality_type_form(){
		
								$("input#list_quality_type_name").val('');
		return false;
		}  		
             	
// Update list_quality_type record
		function update_list_quality_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_quality_type_id = $("input#list_quality_type_id").val();
		var list_quality_type_name = $("input#list_quality_type_name").val();
		if(list_quality_type_name == null || list_quality_type_name == '') {
		alert('Please Enter Quality Type Name');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/update_list_quality_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_quality_type_name='+list_quality_type_name+'&list_quality_type_id='+list_quality_type_id,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Quality Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_quality_type_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_3-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		
             				

// add new add_list_Access_type record
		function add_list_access_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_access_type_name = $("input#list_access_type_name").val();
		var list_access_type_time_per_quantity = $("input#list_access_type_time_per_quantity").val();
		var list_access_type_setup_time = $("input#list_access_type_setup_time").val();
		if(list_access_type_name == null || list_access_type_name == '') {
		alert('Please Enter Access Type Name');
		return false;
		}
		if(list_access_type_time_per_quantity == null || list_access_type_time_per_quantity == '') {
		alert('Please Enter Time Per Quantity');
		return false;
		}
		if(list_access_type_setup_time == null || list_access_type_setup_time == '') {
		alert('Please Enter Setup Time');
		return false;
		}
		  $.ajax(
							{
							url : '?r=ListItems/default/add_list_access_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_access_type_name='+list_access_type_name+'&list_access_type_time_per_quantity='+list_access_type_time_per_quantity+'&list_access_type_setup_time='+list_access_type_setup_time,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Access Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_access_type_name").val('');
								$("input#list_access_type_time_per_quantity").val('');
								$("input#list_access_type_setup_time").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
								$.fn.yiiGridView.update('list_type_4-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		
         
		 
		    //reset Access type
		function reset_list_access_type_form(){
		
								$("input#list_access_type_name").val('');
								$("input#list_access_type_time_per_quantity").val('');
								$("input#list_access_type_setup_time").val('');
		return false;
		}  
		 
// Update list_Access_type record
		function update_list_access_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_access_type_id = $("input#list_access_type_id").val();
		var list_access_type_name = $("input#list_access_type_name").val();
		var list_access_type_time_per_quantity = $("input#list_access_type_time_per_quantity").val();
		var list_access_type_setup_time = $("input#list_access_type_setup_time").val();
		if(list_access_type_name == null || list_access_type_name == '') {
		alert('Please Enter Access Type Name');
		return false;
		}
		if(list_access_type_time_per_quantity == null || list_access_type_time_per_quantity == '') {
		alert('Please Enter Time Per Quantity');
		return false;
		}
		if(list_access_type_setup_time == null || list_access_type_setup_time == '') {
		alert('Please Enter Setup Time');
		return false;
		}
		  $.ajax(
							{
							url : '?r=ListItems/default/update_list_access_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_access_type_name='+list_access_type_name+'&list_access_type_time_per_quantity='+list_access_type_time_per_quantity+'&list_access_type_setup_time='+list_access_type_setup_time+'&list_access_type_id='+list_access_type_id,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Access Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_access_type_name").val('');
								$("input#list_access_type_time_per_quantity").val('');
								$("input#list_access_type_setup_time").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
								$.fn.yiiGridView.update('list_type_4-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		
		 
// add new add_list_display_for_client record
		function add_list_display_for_client() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_display_for_client_name = $("input#list_display_for_client_name").val();
		if(list_display_for_client_name == null || list_display_for_client_name == '') {
		alert('Please Enter Display For Client Name');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/add_list_display_for_client',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_display_for_client_name='+list_display_for_client_name,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Display For client name already exist. please try again. ');
										return false;
									}
							
								$("input#list_display_for_client_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_5-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		
       //reset Display For client	
		function reset_list_display_for_client_form(){
		$("input#list_display_for_client_name").val('');
		return false;
		}   
		 
// Update list_display_for_client record
		function update_list_display_for_client() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_display_for_client_name = $("input#list_display_for_client_name").val();
		var list_display_for_client_id = $("input#list_display_for_client_id").val();
		if(list_display_for_client_name == null || list_display_for_client_name == '') {
		alert('Please Enter Display For Client Name');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/update_list_display_for_client',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_display_for_client_name='+list_display_for_client_name+'&list_display_for_client_id='+list_display_for_client_id,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Display For client name already exist. please try again. ');
										return false;
									}
							
								$("input#list_display_for_client_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_5-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		
    
        
// add new add_list_equipment_type record
		function add_list_equipment_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_equipment_type_name = $("input#list_equipment_type_name").val();
		var list_equipment_type_cost_per_day = $("input#list_equipment_type_cost_per_day").val();
		
		if(list_equipment_type_name == null || list_equipment_type_name == '') {
		alert('Please Enter Equipment Type Name');
		return false;
		}
		if(list_equipment_type_cost_per_day == null || list_equipment_type_cost_per_day == '') {
		alert('Please Enter Cost Per Day');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/add_list_equipment_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_equipment_type_name='+list_equipment_type_name+'&list_equipment_type_cost_per_day='+list_equipment_type_cost_per_day,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Equipment Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_equipment_type_name").val('');
								$("input#list_equipment_type_cost_per_day").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_6-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		
		
	   //reset Equipment type 	
		function reset_list_equipment_type_form(){
		 $("input#list_equipment_type_name").val('');
         $("input#list_equipment_type_cost_per_day").val('');
		return false;
		}     
// Update list_equipment_type record
		function update_list_equipment_type() {
		
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_equipment_type_id = $("input#list_equipment_type_id").val();
		var list_equipment_type_name = $("input#list_equipment_type_name").val();
		var list_equipment_type_cost_per_day = $("input#list_equipment_type_cost_per_day").val();
		
		if(list_equipment_type_name == null || list_equipment_type_name == '') {
		alert('Please Enter Equipment Type Name');
		return false;
		}
		if(list_equipment_type_cost_per_day == null || list_equipment_type_cost_per_day == '') {
		alert('Please Enter Cost Per Day');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/update_list_equipment_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_equipment_type_name='+list_equipment_type_name+'&list_equipment_type_cost_per_day='+list_equipment_type_cost_per_day+'&list_equipment_type_id='+list_equipment_type_id,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Equipment Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_equipment_type_name").val('');
								$("input#list_equipment_type_cost_per_day").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_6-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}			        
		
		// add new add_list_pane_size_type record
		function add_list_pane_size_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_pane_size_type_name = $("input#list_pane_size_type_name").val();
		var list_pane_size_time_per_quantity = $("input#list_pane_size_time_per_quantity").val();
		var list_pane_size_setup_time = $("input#list_pane_size_setup_time").val();
		
		if(list_pane_size_type_name == null || list_pane_size_type_name == '') {
		alert('Please Enter Pane Size Type Name');
		return false;
		}
		
		if(list_pane_size_time_per_quantity == null || list_pane_size_time_per_quantity == '') {
		alert('Please Enter Time Per Quantity');
		return false;
		}
		
		if(list_pane_size_setup_time == null || list_pane_size_setup_time == '') {
		alert('Please Enter Setup Time');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/add_list_pane_size_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_pane_size_type_name='+list_pane_size_type_name+'&list_pane_size_time_per_quantity='+list_pane_size_time_per_quantity+'&list_pane_size_setup_time='+list_pane_size_setup_time,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Pane Size Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_pane_size_type_name").val('');
								$("input#list_pane_size_time_per_quantity").val('');
								$("input#list_pane_size_setup_time").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_7-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}	

 //reset pane Size type 	
		function reset_list_pane_size_form(){
		
								$("input#list_pane_size_type_name").val('');
								$("input#list_pane_size_time_per_quantity").val('');
								$("input#list_pane_size_setup_time").val('');
		return false;
		}	

// Update list_pane_size_client record
		function update_list_pane_size_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_pane_size_type_id = $("input#list_pane_size_type_id").val();
		var list_pane_size_type_name = $("input#list_pane_size_type_name").val();
		var list_pane_size_time_per_quantity = $("input#list_pane_size_time_per_quantity").val();
		var list_pane_size_setup_time = $("input#list_pane_size_setup_time").val();
		
		if(list_pane_size_type_name == null || list_pane_size_type_name == '') {
		alert('Please Enter Pane Size Type Name');
		return false;
		}
		
		if(list_pane_size_time_per_quantity == null || list_pane_size_time_per_quantity == '') {
		alert('Please Enter Time Per Quantity');
		return false;
		}
		
		if(list_pane_size_setup_time == null || list_pane_size_setup_time == '') {
		alert('Please Enter Setup Time');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/update_list_pane_size_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_pane_size_type_name='+list_pane_size_type_name+'&list_pane_size_time_per_quantity='+list_pane_size_time_per_quantity+'&list_pane_size_setup_time='+list_pane_size_setup_time+'&list_pane_size_type_id='+list_pane_size_type_id,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Pane Size Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_pane_size_type_name").val('');
								$("input#list_pane_size_time_per_quantity").val('');
								$("input#list_pane_size_setup_time").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_7-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		

		
		
    // add new add_list_service_type record
		function add_list_service_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_service_type_name = $("input#list_service_type_name").val();
		var list_service_type_cost_per_hour = $("input#list_service_type_cost_per_hour").val();
		
		if(list_service_type_name == null || list_service_type_name == '') {
		alert('Please Enter Service Type Name');
		return false;
		}
		if(list_service_type_cost_per_hour == null || list_service_type_cost_per_hour == '') {
		alert('Please Enter Cost Per Hour');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/add_list_service_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_service_type_name='+list_service_type_name+'&list_service_type_cost_per_hour='+list_service_type_cost_per_hour,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Equipment Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_service_type_name").val('');
								$("input#list_service_type_cost_per_hour").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_8-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}	
		
		function reset_list_service_type_form(){
		$("input#list_service_type_name").val('');
        $("input#list_service_type_cost_per_hour").val('');
		return false;
		}
// Update list_service_type record
		function update_list_service_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_service_type_id = $("input#list_service_type_id").val();
		var list_service_type_name = $("input#list_service_type_name").val();
		var list_service_type_cost_per_hour = $("input#list_service_type_cost_per_hour").val();
		
		if(list_service_type_name == null || list_service_type_name == '') {
		alert('Please Enter Service Type Name');
		return false;
		}
		if(list_service_type_cost_per_hour == null || list_service_type_cost_per_hour == '') {
		alert('Please Enter Cost Per Hour');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/update_list_service_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_service_type_name='+list_service_type_name+'&list_service_type_cost_per_hour='+list_service_type_cost_per_hour+'&list_service_type_id='+list_service_type_id,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Equipment Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_service_type_name").val('');
								$("input#list_service_type_cost_per_hour").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_8-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}	

		
// add new add_list_side_type record
		function add_list_side_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_side_type_name = $("input#list_side_type_name").val();
		if(list_side_type_name == null || list_side_type_name == '') {
		alert('Please Enter Side Type Name');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/add_list_side_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_side_type_name='+list_side_type_name,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Side Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_side_type_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_9-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		
             	
		
// add new add_list_side_type record
		function add_list_side_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_side_type_name = $("input#list_side_type_name").val();
		if(list_side_type_name == null || list_side_type_name == '') {
		alert('Please Enter Side Type Name');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/add_list_side_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_side_type_name='+list_side_type_name,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Side Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_side_type_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_9-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		
        //reset side type 	
		function reset_list_side_type_form(){
		$("input#list_side_type_name").val('');
		return false;
		}    	
		// Update list_side_type record
		function update_list_side_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_side_type_name = $("input#list_side_type_name").val();
		var list_side_type_id = $("input#list_side_type_id").val();
		if(list_side_type_name == null || list_side_type_name == '') {
		alert('Please Enter Side Type Name');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/update_list_side_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_side_type_name='+list_side_type_name+'&list_side_type_id='+list_side_type_id,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Side Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_side_type_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_9-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}
// add new add_list_tools_type record
		function add_list_tools_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_tools_type_name = $("input#list_tools_type_name").val();
		if(list_tools_type_name == null || list_tools_type_name == '') {
		alert('Please Enter Tools Type Name');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/add_list_tools_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_tools_type_name='+list_tools_type_name,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Tools Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_tools_type_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_10-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		
				
           
 //reset Tool type 	
		function reset_list_tools_type_form(){
		$("input#list_tools_type_name").val('');
		return false;
		}	

// Update list_tools_type record
		function update_list_tools_type() {
		var list_item_id = $('#list_type_id').val(); // common field for all model
		var list_tools_type_id = $("input#list_tools_type_id").val();
		var list_tools_type_name = $("input#list_tools_type_name").val();
		if(list_tools_type_name == null || list_tools_type_name == '') {
		alert('Please Enter Tools Type Name');
		return false;
		}
		
		  $.ajax(
							{
							url : '?r=ListItems/default/update_list_tools_type',
							type: "POST",
							data : 'list_item_id='+list_item_id+'&list_tools_type_name='+list_tools_type_name+'&list_tools_type_id='+list_tools_type_id,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This Tools Type already exist. please try again. ');
										return false;
									}
							
								$("input#list_tools_type_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('list_type_10-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		
					
