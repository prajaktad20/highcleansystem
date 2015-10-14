<style>
body {
    font-size: 10px;    
}
</style>

 <div class="pageheader">
	<div class="media">
	  <div class="media-body">
		<ul class="breadcrumb">
		   <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
		  <li><a href="<?php echo $this->user_role_base_url; ?>?r=Swms/default/admin">SWMS</a></li>
		  <li>Manage Swms Hazards/Consequences</li>
		</ul>
		
<h4>			
<?php
				  
				  echo CHtml::link(
					Yii::t("SwmsHzrdsConsqs.create", "Add SWMS Hazards/Consequences"),
					array("create"),
					array("class"=>"btn btn-primary pull-right")						
				);
				  
?>	</h4>
	  </div>
	</div>
	<!-- media --> 
  </div>
	  
      <div class="contentpanel">
        <div class="row">
          <div class="col-md-12 user_section">
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2>SWMS Hazards/Consequences</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
			  <div class="col-md-12 pull-right mb10 pr0" style="text-align:right">
			  


<?php 

// CgridView Records/page
$pageSize = Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'swms-grid',
	'dataProvider'=>$model->search(),
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'filter'=>$model,
	'columns'=>array(
		

 	array(
		'name' => 'swms_id',
		'header' => 'SWMS Type',
		'headerHtmlOptions'=>array('width'=>'13%','class'=>'head'),
		'filter' => CHtml::listData(Swms::model()->findAll(), 'id', 'name'), // fields from country table
		'value' => 'Swms::Model()->FindByPk($data->swms_id)->name',
		'htmlOptions'=>array('style'=>'text-align:left;'),
	),
	
	
 	array(
		'name' => 'task_id',
		'header' => 'Task/Activity',
		'headerHtmlOptions'=>array('width'=>'13%','class'=>'head'),
		'filter' => CHtml::listData(SwmsTask::model()->findAll(), 'id', 'task'), // fields from country table
		'value' => 'SwmsTask::Model()->FindByPk($data->task_id)->task',
		'htmlOptions'=>array('style'=>'text-align:left;'),
	),
	
	 
		//'control_measures',
		
	array(
			'name'=>'hazards',
			'headerHtmlOptions'=>array('width'=>'13%','class'=>'head'),
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),
					
	array(
			'name'=>'consequences',
			'headerHtmlOptions'=>array('width'=>'13%','class'=>'head'),
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),
						
	array(
			'name' => 'risk',
			'header' => 'Risk Initial',
			'headerHtmlOptions'=>array('width'=>'7%','class'=>'head'),
			'filter' => CHtml::listData(RiskLevel::model()->findAll(), 'id', 'name'), // fields from country table
			'value' => 'RiskLevel::Model()->FindByPk($data->risk)->name',
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),
					
						
	
					
	array(
			'name'=>'control_measures',
			'type'=>'raw',
			'value' => 'html_entity_decode($data->control_measures)',
			'headerHtmlOptions'=>array('width'=>'18%','class'=>'head'),
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),


array(
			'name' => 'residual_risk',
			'header' => 'Residual Risk',
			'headerHtmlOptions'=>array('width'=>'7%','class'=>'head'),
			'filter' => CHtml::listData(RiskLevel::model()->findAll(), 'id', 'name'), // fields from country table
			'value' => 'RiskLevel::Model()->FindByPk($data->residual_risk)->name',
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),
				
	array(
			'name'=>'person_responsible',
			'headerHtmlOptions'=>array('width'=>'12%','class'=>'head'),
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),




			
	array(
			'name'=>'hrd_consq_sort_order',
			'header'=> 'order',
			'headerHtmlOptions'=>array('width'=>'6%','class'=>'head'),
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),

/*'consequences',*/
		array(
			'class'=>'CButtonColumn',
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('swms-grid',{ data:{pageSize: $(this).val() }})",
			)),	
			'headerHtmlOptions'=>array('width'=>'11%','class'=>'head'),
			'template'=>'{update} {delete}',
						'buttons'=>array
						(
							
	
	'view' => array
	(
		'label'=>'View',
		'imageUrl'=>null,
	),
		
	'update' => array
	(
		'label'=>'Edit',
		'imageUrl'=>null,
	),
	
	'delete' => array
	(
		'label'=>'Delete',
		'imageUrl'=>null,
	),
	
						
						),
			
			
			
			
			
			
		),
	),
)); ?>


<h4>			
<?php
				  
				  echo CHtml::link(
					Yii::t("SwmsHzrdsConsqs.create", "Add SWMS Hazards/Consequences"),
					array("create"),
					array("class"=>"btn btn-primary pull-right")						
				);
				  
?>	</h4>
		   </div>
              <!-- table-responsive --> 


            </div>
            <div class="clearfix"></div>

          </div>
        </div>
      </div>
      <!-- contentpanel -->
  
  
