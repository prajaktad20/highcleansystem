<?php
/* @var $this BuildingsController */
/* @var $model Buildings */

?>
<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Buildings/default/admin">Buildings</a></li>
			  <li>Manage Buildings</li>
            </ul>
            <h4>
<?php
					  
					  echo CHtml::link(
						Yii::t("Buildings.create", "Add New Building"),
						array("create"),
						array("class"=>"btn btn-primary pull-right")
					);
					  
?>	
			
			</h4>
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
                <h2>Buildings Management</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
			   <div class="col-md-12 pull-right mb10 pr0" style="text-align:right">

</div>
<?php 

// CgridView Records/page
$pageSize = Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'buildings-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
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
                'name'=>'site_id',
                'header'=>'Site Name',
                'headerHtmlOptions'=>array('class'=>'head','width'=>'15%'),
				'filter' => CHtml::listData(ContactsSite::model()->findAll(), 'id', 'site_name'), // fields from country table
				'value' => 'ContactsSite::Model()->FindByPk($data->site_id)->site_name',
            ),
			
		array(
                'name'=>'building_name',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'15%'),
                'header'=>'Building Name',
                
            ),
			array(
                'name'=>'building_no',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'10%'),
                'header'=>'Building No',
                
            ),
		
			
		
		array(
                'name'=>'building_type_id',
                'header'=>'Building Type',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'10%'),
                'filter' => CHtml::listData(ListBuildingType::model()->findAll(), 'id', 'name'), // fields from country table
				'value' => 'ListBuildingType::Model()->FindByPk($data->building_type_id)->name',
            ),
			
		array(
                'name'=>'dist_from_office',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'10%'),
                'header'=>'Dist. From Office',
				
            ),
			
		
		array(
                'name'=>'no_of_floors',
                'header'=>'No Of Floors',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'5%'),
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
			
		array(
                'name'=>'size_of_building',
                'header'=>'Size Of Building',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'10%'),
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
			
			array(
                'name'=>'height_of_building',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'10%'),
                'header'=>'Height Of Building',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		
		
		/*
		building_no
		'size_of_building',
		'height_of_building',
		'job_notes',
		'site_id',
		'building_type_id',
		'created_at',
		'updated_at',
		*/
		array(
			'class'=>'CButtonColumn',
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('buildings-grid',{ data:{pageSize: $(this).val() }})",
			)),	
			'headerHtmlOptions'=>array('width'=>'15%','class'=>'head'),
			'template'=>'{view} | {update} {delete} | {photos}',
			'buttons'=>array
						(
							'view' => array
							(
								'label'=>'View',
								'imageUrl'=>false,
							),
							
							'update' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
							),
							
							'delete' => array
							(
								'label'=>'| Delete',
								'imageUrl'=>false,
								'visible'=>'(Yii::app()->user->profile=="admin") ? true : false',
							),
							
							'photos' => array
							(
								'label'=>'Photos/Documents',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/Buildings/default/BuildingDocuments",array("id" => $data->primaryKey))',
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
