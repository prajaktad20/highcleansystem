<?php
/* @var $this ServiceController */
/* @var $model Service */

?>


   <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
			  <li><a href="<?php echo $this->user_role_base_url; ?>?r=Service/default/admin">Services</a></li>
              <li>Manage Services</li>
            </ul>
         
          </div>
        </div>
        <!-- media --> 
      </div>
      <div class="contentpanel">
        <div class="row">
          <div class="col-md-12 quote_section">
          
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2>Service Management</h2>
              </div>
            </div>
            <div class="col-md-6 mb20">
                <!--  <form class="form-horizontal" method="post" enctype="multipart/form-data">-->
                    <div class="form-group">
                      <label class="col-sm-5">Service Name</label>
                      <div class="col-sm-7">
                        <input type="text" name="service_name" id="service_name" value="" class="form-control">
                      </div>
                    </div>
                    <!-- form-group -->
                    
                    <div class="form-group">
                     <label class="col-sm-5">&nbsp;</label>
                      <div class="col-sm-7">
                        <button class="btn btn-primary mr5" id="addbtn" onclick="addnewservice();" >Add</button> 
						<button class="btn btn-primary mr5" id="updatebtn">Update</button> 
						<button  onclick="resetserviceform();"  class="btn btn-primary">Reset</button>
                      </div>
                    </div>
                    <!-- form-group -->
                  <!--</form>-->
                </div>
				<div style="clear:both;"></div>
            <div class="col-md-6">
            <div class="table-responsive">

			
		
<?php 

// CgridView Records/page
$pageSize = Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'service-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',	
	'pagerCssClass'=>'pagination',
	//'htmlOptions' => array('style' => 'width: 45%;'),
	'columns'=>array(
		/* array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ), */
			
			array(
                'name'=>'service_name',
                'header'=>'Service Name',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		
		
		
/* 	   array(
			'name' => 'status',
			'header' => 'Status',
			'headerHtmlOptions'=>array('class'=>'head'),
			'filter' => array('1'=>'Active','0'=>'InActive'),
			'value' => '$data->status ? "Active" : "Inactive"'
			
		), */
	
		
		array(
			'class'=>'CButtonColumn',			
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('service-grid',{ data:{pageSize: $(this).val() }})",
			)),				
			'headerHtmlOptions'=>array('width'=>'150','class'=>'head'),
			'template'=>'{delete}',
			'buttons'=>array
						(
						
/* 	'change_status' => array
	(
	

'click'=>"function(){

									if (confirm('Are you want to change status?')) {
                                    $.fn.yiiGridView.update('service-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                              $('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                              $.fn.yiiGridView.update('service-grid');
                                        }
                                    })
									}
                                    return false;
                              }
                     ",

	'url' => 'Yii::app()->createUrl("/Service/default/changestatus",array("id" => $data->primaryKey))',
		'label'=>'Change Status',
		'imageUrl'=>null,
		
	), */
						
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
							),
							
						
						),
			 
			 
		),
	),
)); ?>
</div>
              <!-- table-responsive --> 

		   </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
   

<script>

	// add new service if already not exist
		function addnewservice() {

		var service_name = $("input#service_name").val();
		if(service_name == null || service_name == '') {
		alert('Please enter service name');
		return false;
		}
		
		  $.ajax(
							{
							url : '/?r=Service/default/addnewservice',
							type: "POST",
							data : 'service_name='+service_name,
							success:function(data, textStatus, jqXHR){
									
									if(data == 1) {
										alert('This service name already exist. please try again. ');
										return false;
									}
							
								$("input#service_name").val('');
								$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                $.fn.yiiGridView.update('service-grid');
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
									
									return false;
		}		
                                    

	// reset form fields of service
		function resetserviceform() {
			$("input#service_name").val('');
		}
									
									
</script>