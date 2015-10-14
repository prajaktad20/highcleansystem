<?php 

// CgridView Records/page
$pageSize = Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

?>

<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/list_item.js"></script> 
		
<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li>Manage List Items</li>
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
<h2>List Item Management</h2>
<!-- DropDown of all list types -->
</div>
</div>


	<div class="form-group">
	<label for="Quotes_building_id" class="col-sm-5 required">Select Type <span class="required">*</span></label>
		<div class="col-sm-7">

		<select id="list_type_id" class="form-control" onchange="return FindListTypeOption(this.value);">
	
<?php

		$criteria = new CDbCriteria();
		$criteria->select = "id,list_name";
		$criteria->order = 'list_name';
		$loop_ListItems = ListItem::model()->findAll($criteria);
		
		foreach ($loop_ListItems as $value)  {	
			if($value->id == 1)		
			echo '<option selected value="'.$value->id.'">'.strtoupper($value->list_name).'</option>';
			else
			echo '<option value="'.$value->id.'">'.strtoupper($value->list_name).'</option>';
		}		
		
		?>
		
		</select>
		
         </div>			
	</div>

	

<div class="panel panel-default">    
<div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
<h2 id="dynamic_list_type_value">BUILDING TYPE MANAGEMENT</h2>
</div>
 </div>  
   
	     <div class="col-md-12">
            <div class="table-responsive">	
<!-- CgridVIew -->
			

<div id="list_type_1">			



          <div class="col-md-6 mb20">
                <!--  <form class="form-horizontal" method="post" enctype="multipart/form-data">-->
                    <div class="form-group">
                      <label class="col-sm-5">Builing Type Name</label>
                      <div class="col-sm-7">
                        <input type="hidden" name="list_buliding_type_id" id="list_buliding_type_id" value="" class="form-control">
                        <input type="text" name="list_buliding_type_name" id="list_buliding_type_name" value="" class="form-control">
                      </div>
                    </div>
                    <!-- form-group -->
                    
                    <div class="form-group">
                     <label class="col-sm-5">&nbsp;</label>
                      <div class="col-sm-7">
                        <button class="btn btn-primary mr5" id="addbtn1" style="display:none;"  onclick="update_list_buliding_type();" >Update</button>
                        <button class="btn btn-default mr5" id="addbtn2" style="display:none;" onclick="reset_list_buliding_type_form();" >Reset</button>
						 <button class="btn btn-primary mr5" id="addbtn0" onclick="add_list_buliding_type();" >Add</button>
                        </div>
                    </div>
				
                    <!-- form-group -->
                  <!--</form>-->
          </div>

<div class="clearfix"></div>		
<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'list_type_1-grid',
	'dataProvider'=>$list_building_type_model->search(),
	'filter'=>$list_building_type_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',	
	'pagerCssClass'=>'pagination',
	'columns'=>array(
		array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ),
				 
				 array(
                'name'=>'name',
                'header'=>'Name',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		
		
		array(
			'class'=>'CButtonColumn',			
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('list_type_1-grid',{ data:{pageSize: $(this).val() }})",
			)),				
			'headerHtmlOptions'=>array('width'=>'150','class'=>'head'),
			'template'=>'{edit} | {delete}',
			'buttons'=>array
						(
						
						   
							'edit' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
								'click'=>"function(){

									
                                    $.fn.yiiGridView.update('list_type_1-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
						var data = jQuery.parseJSON(data);			
					//console.log(data.name);
                                              //$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
											//$.fn.yiiGridView.update('list_type_1-grid');
											$('#list_buliding_type_name').val(data.name);
											$('#list_buliding_type_id').val(data.id);
											
											$('#addbtn1').show();
											$('#addbtn2').show();
											
                                        }
                                    })
									
                                    return false;
                   }
                     ",
					 
'url' => 'Yii::app()->createUrl("/ListItems/default/GetBuldingTypeColumns",array("id" => $data->primaryKey))',

								
							),
							
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ListItems/default/delete",array("id" => $data->primaryKey,"model_name"=>"ListBuildingType"))',
							),
							
						
						),
			 
			 
		),
	),
)); ?>

</div>
	

<div style="display:none;" id="list_type_2">			

 <div class="col-md-6 mb20">
                <!--  <form class="form-horizontal" method="post" enctype="multipart/form-data">-->
                    <div class="form-group">
                      <label class="col-sm-5">Glass Type Name</label>
                      <div class="col-sm-7">
					   <input type="hidden" name="list_glass_type_id" id="list_glass_type_id" value="" class="form-control">
                        <input type="text" name="list_glass_type_name" id="list_glass_type_name" value="" class="form-control">
                      </div>
                    </div>
                    <!-- form-group -->
                    
                    <div class="form-group">
                     <label class="col-sm-5">&nbsp;</label>
                      <div class="col-sm-7">
                        <button class="btn btn-primary mr5" id="list_type_2_addbtn1" style="display:none;"  onclick="update_list_glass_type();" >Update</button>
						<button class="btn btn-default mr5" id="list_type_2_addbtn2" style="display:none;" onclick="reset_list_glass_type_form();" >Reset</button>
						<button class="btn btn-primary mr5" id="addbtn" onclick="add_list_glass_type();" >Add</button>
                      </div>
                    </div>
                    <!-- form-group -->
                  <!--</form>-->
          </div>

<div class="clearfix"></div>	
		
<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'list_type_2-grid',
	'dataProvider'=>$list_glass_type_model->search(),
	'filter'=>$list_glass_type_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',	
	'pagerCssClass'=>'pagination',
	'columns'=>array(
		array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ),
				    array(
                'name'=>'name',
                'header'=>'Name',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		
		
		array(
			'class'=>'CButtonColumn',			
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('list_type_2-grid',{ data:{pageSize: $(this).val() }})",
			)),				
			'headerHtmlOptions'=>array('width'=>'150','class'=>'head'),
			'template'=>'{edit} | {delete}',
			'buttons'=>array
						(
						    
							 'edit' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
								'click'=>"function(){

									
                                    $.fn.yiiGridView.update('list_type_2-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
											var data = jQuery.parseJSON(data);	                                              
											$('#list_glass_type_name').val(data.name);
											$('#list_glass_type_id').val(data.id);
											
											$('#list_type_2_addbtn1').show();
											$('#list_type_2_addbtn2').show();
											
                                        }
                                    })
									
                                    return false;
                   }
                     ",
					 
'url' => 'Yii::app()->createUrl("/ListItems/default/GetGlassTypeColumns",array("id" => $data->primaryKey))',

								
							),
						    
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ListItems/default/delete",array("id" => $data->primaryKey,"model_name"=>"ListGlassType"))',
							),
							
						
						),
			 
			 
		),
	),
)); ?>

</div>
	


<div style="display:none;" id="list_type_3">			
<div class="col-md-6 mb20">
                <!--  <form class="form-horizontal" method="post" enctype="multipart/form-data">-->
                    <div class="form-group">
                      <label class="col-sm-5">Quality Type Name</label>
                      <div class="col-sm-7">
					  <input type="hidden" name="list_quality_type_id" id="list_quality_type_id" value="" class="form-control">
                        <input type="text" name="list_quality_type_name" id="list_quality_type_name" value="" class="form-control">
                      </div>
                    </div>
                    <!-- form-group -->
                    
                    <div class="form-group">
                     <label class="col-sm-5">&nbsp;</label>
                      <div class="col-sm-7">
                        <button class="btn btn-primary mr5" id="list_type_3_addbtn1" style="display:none;"  onclick="update_list_quality_type();" >Update</button>
                        <button class="btn btn-default mr5" id="list_type_3_addbtn2" style="display:none;" onclick="reset_list_quality_type_form();" >Reset</button>
						<button class="btn btn-primary mr5" id="addbtn" onclick="add_list_quality_type();" >Add</button>						 
                      </div>
                    </div>
                    <!-- form-group -->
                  <!--</form>-->
          </div>

<div class="clearfix"></div>	

		
<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'list_type_3-grid',
	'dataProvider'=>$list_quality_type_model->search(),
	'filter'=>$list_quality_type_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',	
	'pagerCssClass'=>'pagination',
	'columns'=>array(
		array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ),
				    array(
                'name'=>'name',
                'header'=>'Name',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		
		
		array(
			'class'=>'CButtonColumn',			
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('service-grid',{ data:{pageSize: $(this).val() }})",
			)),				
			'headerHtmlOptions'=>array('width'=>'150','class'=>'head'),
			'template'=>'{edit} | {delete}',
			'buttons'=>array
						(
						
						   'edit' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
								'click'=>"function(){

									
                                    $.fn.yiiGridView.update('list_type_3-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
						var data = jQuery.parseJSON(data);			
					//console.log(data.name);
                                              //$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
											//$.fn.yiiGridView.update('list_type_3-grid');
											$('#list_quality_type_name').val(data.name);
											$('#list_quality_type_id').val(data.id);
											
											
											$('#list_type_3_addbtn1').show();
											$('#list_type_3_addbtn2').show();
											
                                        }
                                    })
									
                                    return false;
                   }
                     ",
					 
'url' => 'Yii::app()->createUrl("/ListItems/default/GetQualityTypeColumns",array("id" => $data->primaryKey))',

								
							),
						    
						
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ListItems/default/delete",array("id" => $data->primaryKey,"model_name"=>"ListQualityType"))',
							),
							
						
						),
			 
			 
		),
	),
)); ?>

</div>
	


<div style="display:none;" id="list_type_4">			
<div class="col-md-6 mb20">
                <!--  <form class="form-horizontal" method="post" enctype="multipart/form-data">-->
                    <div class="form-group">
                      <label class="col-sm-5">Access Type Name</label>
                      <div class="col-sm-7">
					   <input type="hidden" name="list_access_type_id" id="list_access_type_id" value="" class="form-control">
                        <input type="text" name="list_access_type_name" id="list_access_type_name" value="" class="form-control">
                      </div>
                    </div>
                    <!-- form-group -->
					<div class="form-group">
                      <label class="col-sm-5">Time per quantity</label>
                      <div class="col-sm-7">
                        <input type="text" name="list_access_type_time_per_quantity" id="list_access_type_time_per_quantity" value="" class="form-control">
                      </div>
                    </div>
                      <!-- form-group -->
					   <div class="form-group">
                      <label class="col-sm-5">Setup time</label>
                      <div class="col-sm-7">
                        <input type="text" name="list_access_type_setup_time" id="list_access_type_setup_time" value="" class="form-control">
                      </div>
                    </div>
					 <!-- form-group -->
                    <div class="form-group">
                     <label class="col-sm-5">&nbsp;</label>
                      <div class="col-sm-7">
                        <button class="btn btn-primary mr5" id="list_type_4_addbtn1" style="display:none;"  onclick="update_list_access_type();" >Update</button>
						<button class="btn btn-default mr5" id="list_type_4_addbtn2" style="display:none;" onclick="reset_list_access_type_form();" >Reset</button>
						<button class="btn btn-primary mr5" id="addbtn" onclick="add_list_access_type();" >Add</button>
                      </div>
                    </div>
                    <!-- form-group -->
                  <!--</form>-->
          </div>

<div class="clearfix"></div>

		
<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'list_type_4-grid',
	'dataProvider'=>$list_access_type_model->search(),
	'filter'=>$list_access_type_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',	
	'pagerCssClass'=>'pagination',
	'columns'=>array(
		array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ),
				    array(
                'name'=>'name',
                'header'=>'Name',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		array(
                'name'=>'time_per_quantity',
                'header'=>'Time Per Quantity',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
			array(
                'name'=>'setup_time',
                'header'=>'Setup Time',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		
		array(
			'class'=>'CButtonColumn',			
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('service-grid',{ data:{pageSize: $(this).val() }})",
			)),				
			'headerHtmlOptions'=>array('width'=>'150','class'=>'head'),
			'template'=>'{edit} | {delete}',
			'buttons'=>array
						(
						
						  'edit' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
								'click'=>"function(){

									
                                    $.fn.yiiGridView.update('list_type_4-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
						var data = jQuery.parseJSON(data);			
					//console.log(data.name);
                                              //$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
											//$.fn.yiiGridView.update('list_type_3-grid');
											$('#list_access_type_name').val(data.name);
											$('#list_access_type_id').val(data.id);
											$('#list_access_type_time_per_quantity').val(data.time_per_quantity);
											$('#list_access_type_setup_time').val(data.setup_time);
											
											
											$('#list_type_4_addbtn1').show();
											$('#list_type_4_addbtn2').show();
											
                                        }
                                    })
									
                                    return false;
                   }
                     ",
					 
'url' => 'Yii::app()->createUrl("/ListItems/default/GetAccessTypeColumns",array("id" => $data->primaryKey))',

								
							),
						
						
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ListItems/default/delete",array("id" => $data->primaryKey,"model_name"=>"ListAccessType"))',
							),
							
						
						),
			 
			 
		),
	),
)); ?>

</div>
	


<div style="display:none;" id="list_type_5">			
<div class="col-md-6 mb20">
                <!--  <form class="form-horizontal" method="post" enctype="multipart/form-data">-->
                    <div class="form-group">
                      <label class="col-sm-5">Display For Client Name</label>
                      <div class="col-sm-7">
					    <input type="hidden" name="list_display_for_agent_id" id="list_display_for_agent_id" value="" class="form-control">
                        <input type="text" name="list_display_for_agent_name" id="list_display_for_agent_name" value="" class="form-control">
                      </div>
                    </div>
                    <!-- form-group -->
                    
                    <div class="form-group">
                     <label class="col-sm-5">&nbsp;</label>
                      <div class="col-sm-7">
						<button class="btn btn-primary mr5" id="list_type_5_addbtn1" style="display:none;"  onclick="update_list_display_for_client();" >Update</button>
						<button class="btn btn-default mr5" id="list_type_5_addbtn2" style="display:none;" onclick="reset_list_display_for_agent_form();" >Reset</button>
						<button class="btn btn-primary mr5" id="addbtn" onclick="add_list_display_for_client();" >Add</button>
                      </div>
                    </div>
                    <!-- form-group -->
                  <!--</form>-->
          </div>

<div class="clearfix"></div>	
		
<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'list_type_5-grid',
	'dataProvider'=>$list_display_for_agent_model->search(),
	'filter'=>$list_display_for_agent_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',	
	'pagerCssClass'=>'pagination',
	'columns'=>array(
		array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ),
				    array(
                'name'=>'name',
                'header'=>'Name',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		
		
		array(
			'class'=>'CButtonColumn',			
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('service-grid',{ data:{pageSize: $(this).val() }})",
			)),				
			'headerHtmlOptions'=>array('width'=>'150','class'=>'head'),
			'template'=>'{edit} | {delete}',
			'buttons'=>array
						(
						
						'edit' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
								'click'=>"function(){

									
                                    $.fn.yiiGridView.update('list_type_5-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
						var data = jQuery.parseJSON(data);			
					//console.log(data.name);
                                              //$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
											//$.fn.yiiGridView.update('list_type_3-grid');
											$('#list_display_for_agent_name').val(data.name);
											$('#list_display_for_agent_id').val(data.id);
											$('#list_type_5_addbtn1').show();
											$('#list_type_5_addbtn2').show();
											
                                        }
                                    })
									
                                    return false;
                   }
                     ",
					 
'url' => 'Yii::app()->createUrl("/ListItems/default/GetDisplayForClientColumns",array("id" => $data->primaryKey))',

								
							),
						
						
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ListItems/default/delete",array("id" => $data->primaryKey,"model_name"=>"ListDisplayForClient"))',
							),
							
						
						),
			 
			 
		),
	),
)); ?>

</div>
	


<div style="display:none;" id="list_type_6">			
<div class="col-md-6 mb20">
                <!--  <form class="form-horizontal" method="post" enctype="multipart/form-data">-->
                    <div class="form-group">
                      <label class="col-sm-5">Equipment Type Name</label>
                      <div class="col-sm-7">
					 <input type="hidden" name="list_equipment_type_id" id="list_equipment_type_id" value="" class="form-control">
                        <input type="text" name="list_equipment_type_name" id="list_equipment_type_name" value="" class="form-control">
                      </div>
                    </div>
                    <!-- form-group -->
					 <div class="form-group">
                      <label class="col-sm-5">Cost Per Day</label>
                      <div class="col-sm-7">
                        <input type="text" name="list_equipment_type_cost_per_day" id="list_equipment_type_cost_per_day" value="" class="form-control">
                      </div>
                    </div>
                    
                    <div class="form-group">
                     <label class="col-sm-5">&nbsp;</label>
                      <div class="col-sm-7">
                        <button class="btn btn-primary mr5" id="list_type_6_addbtn1" style="display:none;"  onclick="update_list_equipment_type();" >Update</button>
						<button class="btn btn-default mr5" id="list_type_6_addbtn2" style="display:none;" onclick="reset_list_equipment_type_form();" >Reset</button>
						<button class="btn btn-primary mr5" id="addbtn" onclick="add_list_equipment_type();" >Add</button>
                      </div>
                    </div>
                    <!-- form-group -->
                  <!--</form>-->
          </div>

<div class="clearfix"></div>	

		
<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'list_type_6-grid',
	'dataProvider'=>$list_equipment_type_model->search(),
	'filter'=>$list_equipment_type_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',	
	'pagerCssClass'=>'pagination',
	'columns'=>array(
		array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ),
				    array(
                'name'=>'name',
                'header'=>'Name',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		array(
                'name'=>'cost_per_day',
                'header'=>'Cost Per Day',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		
		array(
			'class'=>'CButtonColumn',			
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('service-grid',{ data:{pageSize: $(this).val() }})",
			)),				
			'headerHtmlOptions'=>array('width'=>'150','class'=>'head'),
			'template'=>'{edit} | {delete}',
			'buttons'=>array
						(
							'edit' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
								'click'=>"function(){

									
                                    $.fn.yiiGridView.update('list_type_6-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
						var data = jQuery.parseJSON(data);			
					//console.log(data.name);
                                              //$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
											//$.fn.yiiGridView.update('list_type_3-grid');
											
											$('#list_equipment_type_name').val(data.name);
											$('#list_equipment_type_id').val(data.id);
											$('#list_equipment_type_cost_per_day').val(data.cost_per_day);
											$('#list_type_6_addbtn1').show();
											$('#list_type_6_addbtn2').show();
											
                                        }
                                    })
									
                                    return false;
                   }
                     ",
					 
'url' => 'Yii::app()->createUrl("/ListItems/default/GetEquipmentTypeColumns",array("id" => $data->primaryKey))',

								
							),
						
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ListItems/default/delete",array("id" => $data->primaryKey,"model_name"=>"ListEquipmentType"))',
							),
							
						
						),
			 
			 
		),
	),
)); ?>

</div>
	


<div style="display:none;" id="list_type_7">			

<div class="col-md-6 mb20">
                <!--  <form class="form-horizontal" method="post" enctype="multipart/form-data">-->
                    <div class="form-group">
                      <label class="col-sm-5">Pane Size Type Name</label>
                      <div class="col-sm-7">
					  <input type="hidden" name="list_pane_size_type_id" id="list_pane_size_type_id" value="" class="form-control">
                        <input type="text" name="list_pane_size_type_name" id="list_pane_size_type_name" value="" class="form-control">
                      </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-5">Time per quantity</label>
                      <div class="col-sm-7">
                        <input type="text" name="list_pane_size_time_per_quantity" id="list_pane_size_time_per_quantity" value="" class="form-control">
                      </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-5">Setup time</label>
                      <div class="col-sm-7">
                        <input type="text" name="list_pane_size_setup_time" id="list_pane_size_setup_time" value="" class="form-control">
                      </div>
                    </div>
                    <!-- form-group -->
					 <div class="form-group">
                     <label class="col-sm-5">&nbsp;</label>
                      <div class="col-sm-7">
                        <button class="btn btn-primary mr5" id="list_type_7_addbtn1" style="display:none;"  onclick="update_list_pane_size_type();" >Update</button>
						<button class="btn btn-default mr5" id="list_type_7_addbtn2" style="display:none;" onclick="reset_list_pane_size_form();" >Reset</button>
						<button class="btn btn-primary mr5" id="addbtn" onclick="add_list_pane_size_type();" >Add</button>
                      </div>
                    </div>
                    <!-- form-group -->
                  <!--</form>-->
          </div>

<div class="clearfix"></div>
		
<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'list_type_7-grid',
	'dataProvider'=>$list_pane_size_type_model->search(),
	'filter'=>$list_pane_size_type_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',	
	'pagerCssClass'=>'pagination',
	'columns'=>array(
		array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ),
				    array(
                'name'=>'name',
                'header'=>'Name',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		 array(
                'name'=>'time_per_quantity',
                'header'=>'Time Per Quantity',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		array(
                'name'=>'setup_time',
                'header'=>'Setup Time',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		
		array(
			'class'=>'CButtonColumn',			
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('service-grid',{ data:{pageSize: $(this).val() }})",
			)),				
			'headerHtmlOptions'=>array('width'=>'150','class'=>'head'),
			'template'=>'{edit} | {delete}',
			'buttons'=>array
						(
							
							'edit' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
								'click'=>"function(){

									
                                    $.fn.yiiGridView.update('list_type_7-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
						var data = jQuery.parseJSON(data);			
					//console.log(data.name);
                                              //$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
											//$.fn.yiiGridView.update('list_type_3-grid');
											
											$('#list_pane_size_type_name').val(data.name);
											$('#list_pane_size_type_id').val(data.id);
											$('#list_pane_size_time_per_quantity').val(data.time_per_quantity);
											$('#list_pane_size_setup_time').val(data.setup_time);
											$('#list_type_7_addbtn1').show();
											$('#list_type_7_addbtn2').show();
											
                                        }
                                    })
									
                                    return false;
                   }
                     ",
					 
'url' => 'Yii::app()->createUrl("/ListItems/default/GetPaneSizeTypeColumns",array("id" => $data->primaryKey))',

								
							),
							
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ListItems/default/delete",array("id" => $data->primaryKey,"model_name"=>"ListPaneSizeType"))',
							),
							
						
						),
			 
			 
		),
	),
)); ?>

</div>
	



<div style="display:none;" id="list_type_8">			

<div class="col-md-6 mb20">
                <!--  <form class="form-horizontal" method="post" enctype="multipart/form-data">-->
                    <div class="form-group">
                      <label class="col-sm-5">Service Type Name</label>
                      <div class="col-sm-7">
					  <input type="hidden" name="list_service_type_id" id="list_service_type_id" value="" class="form-control">
                        <input type="text" name="list_service_type_name" id="list_service_type_name" value="" class="form-control">
                      </div>
                    </div>
                    <!-- form-group -->
					 <div class="form-group">
                      <label class="col-sm-5">Cost Per Hour</label>
                      <div class="col-sm-7">
                        <input type="text" name="list_service_type_cost_per_hour" id="list_service_type_cost_per_hour" value="" class="form-control">
                      </div>
                    </div>
                    
                    <div class="form-group">
                     <label class="col-sm-5">&nbsp;</label>
                      <div class="col-sm-7">
                        <button class="btn btn-primary mr5" id="list_type_8_addbtn1" style="display:none;"  onclick="update_list_service_type();" >Update</button>
						<button class="btn btn-default mr5" id="list_type_8_addbtn2" style="display:none;" onclick="reset_list_service_type_form();" >Reset</button>
						<button class="btn btn-primary mr5" id="addbtn" onclick="add_list_service_type();" >Add</button>
                      </div>
                    </div>
                    <!-- form-group -->
                  <!--</form>-->
          </div>

<div class="clearfix"></div>	
		
<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'list_type_8-grid',
	'dataProvider'=>$list_service_type_model->search(),
	'filter'=>$list_service_type_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',	
	'pagerCssClass'=>'pagination',
	'columns'=>array(
		array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ),
				    array(
                'name'=>'name',
                'header'=>'Name',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		array(
                'name'=>'cost_per_hour',
                'header'=>'Cost Per Hour',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		
		array(
			'class'=>'CButtonColumn',			
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('service-grid',{ data:{pageSize: $(this).val() }})",
			)),				
			'headerHtmlOptions'=>array('width'=>'150','class'=>'head'),
			'template'=>'{edit} | {delete}',
			'buttons'=>array
						(
						
								'edit' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
								'click'=>"function(){

									
                                    $.fn.yiiGridView.update('list_type_8-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
						var data = jQuery.parseJSON(data);
                     
											$('#list_service_type_name').val(data.name);
											$('#list_service_type_id').val(data.id);
											$('#list_service_type_cost_per_hour').val(data.cost_per_hour);
											$('#list_type_8_addbtn1').show();
											$('#list_type_8_addbtn2').show();
											
                                        }
                                    })
									
                                    return false;
                   }
                     ",
					 
'url' => 'Yii::app()->createUrl("/ListItems/default/GetServiceTypeColumns",array("id" => $data->primaryKey))',

								
							),
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ListItems/default/delete",array("id" => $data->primaryKey,"model_name"=>"ListServiceType"))',
							),
							
						
						),
			 
			 
		),
	),
)); ?>

</div>
	



<div style="display:none;" id="list_type_9">			
<div class="col-md-6 mb20">
                <!--  <form class="form-horizontal" method="post" enctype="multipart/form-data">-->
                    <div class="form-group">
                      <label class="col-sm-5">Side type Name</label>
                      <div class="col-sm-7">
					   <input type="hidden" name="list_side_type_id" id="list_side_type_id" value="" class="form-control">
                        <input type="text" name="list_side_type_name" id="list_side_type_name" value="" class="form-control">
                      </div>
                    </div>
                    <!-- form-group -->
                    
                    <div class="form-group">
                     <label class="col-sm-5">&nbsp;</label>
                      <div class="col-sm-7">
                        <button class="btn btn-primary mr5" id="list_type_9_addbtn1" style="display:none;"  onclick="update_list_side_type();" >Update</button>
						<button class="btn btn-default mr5" id="list_type_9_addbtn2" style="display:none;" onclick="reset_list_side_type_form();" >Reset</button>
						<button class="btn btn-primary mr5" id="addbtn" onclick="add_list_side_type();" >Add</button>
                      </div>
                    </div>
                    <!-- form-group -->
                  <!--</form>-->
          </div>

<div class="clearfix"></div>	
		
<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'list_type_9-grid',
	'dataProvider'=>$list_side_type_model->search(),
	'filter'=>$list_side_type_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',	
	'pagerCssClass'=>'pagination',
	'columns'=>array(
		array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ),
				    array(
                'name'=>'name',
                'header'=>'Name',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
			
		
		
		array(
			'class'=>'CButtonColumn',			
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('service-grid',{ data:{pageSize: $(this).val() }})",
			)),				
			'headerHtmlOptions'=>array('width'=>'150','class'=>'head'),
			'template'=>'{edit} | {delete}',
			'buttons'=>array
						(
							'edit' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
								'click'=>"function(){

									
                                    $.fn.yiiGridView.update('list_type_9-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
						var data = jQuery.parseJSON(data);
                     
											$('#list_side_type_name').val(data.name);
											$('#list_side_type_id').val(data.id);
											$('#list_type_9_addbtn1').show();
											$('#list_type_9_addbtn2').show();
											
                                        }
                                    })
									
                                    return false;
                   }
                     ",
					 
'url' => 'Yii::app()->createUrl("/ListItems/default/GetSideTypeColumns",array("id" => $data->primaryKey))',

								
							),
						
						
						
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ListItems/default/delete",array("id" => $data->primaryKey,"model_name"=>"ListSideType"))',
							),
							
						
						),
			 
			 
		),
	),
)); ?>

</div>
	



<div style="display:none;" id="list_type_10">			
<div class="col-md-6 mb20">
                <!--  <form class="form-horizontal" method="post" enctype="multipart/form-data">-->
                    <div class="form-group">
                      <label class="col-sm-5">Tools type Name</label>
                      <div class="col-sm-7">
					   <input type="hidden" name="list_tools_type_id" id="list_tools_type_id" value="" class="form-control">
                        <input type="text" name="list_tools_type_name" id="list_tools_type_name" value="" class="form-control">
                      </div>
                    </div>
                    <!-- form-group -->
                    
                    <div class="form-group">
                     <label class="col-sm-5">&nbsp;</label>
                      <div class="col-sm-7">
					  <button class="btn btn-primary mr5" id="list_type_10_addbtn1" style="display:none;"  onclick="update_list_tools_type();" >Update</button>
						<button class="btn btn-default mr5" id="list_type_10_addbtn2" style="display:none;" onclick="reset_list_tools_type_form();" >Reset</button>
                        <button class="btn btn-primary mr5" id="addbtn" onclick="add_list_tools_type();" >Add</button>
                      </div>
                    </div>
                    <!-- form-group -->
                  <!--</form>-->
          </div>

<div class="clearfix"></div>	

		
<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'list_type_10-grid',
	'dataProvider'=>$list_tools_type_model->search(),
	'filter'=>$list_tools_type_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',	
	'pagerCssClass'=>'pagination',
	'columns'=>array(
		array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ),
				    array(
                'name'=>'name',
                'header'=>'Name',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		
		
		array(
			'class'=>'CButtonColumn',			
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('service-grid',{ data:{pageSize: $(this).val() }})",
			)),				
			'headerHtmlOptions'=>array('width'=>'150','class'=>'head'),
			'template'=>'{edit} | {delete}',
			'buttons'=>array
						(
						
						   'edit' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
								'click'=>"function(){

									
                                    $.fn.yiiGridView.update('list_type_10-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
						var data = jQuery.parseJSON(data);
                     
											$('#list_tools_type_name').val(data.name);
											$('#list_tools_type_id').val(data.id);
											$('#list_type_10_addbtn1').show();
											$('#list_type_10_addbtn2').show();
											
                                        }
                                    })
									
                                    return false;
                   }
                     ",
					 
'url' => 'Yii::app()->createUrl("/ListItems/default/GetToolsTypeColumns",array("id" => $data->primaryKey))',

								
							),
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ListItems/default/delete",array("id" => $data->primaryKey,"model_name"=>"ListToolsType"))',
							),
							
						
						),
			 
			 
		),
	),
)); ?>

</div>
	

	
			
			
			




</div>
              <!-- table-responsive --> 

		   </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
	  


	  