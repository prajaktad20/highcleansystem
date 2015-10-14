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
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=ContactsSite/default/admin">Sites</a></li>
			  <li>View Building Details</li>
            </ul>
            <h4>
<?php echo CHtml::link(
                Yii::t("ContactsSite.admin", "Manage"),
                array("admin"),
                array("class"=>"btn btn-primary pull-right")
 ); ?>
			
			</h4>
          </div>
        </div>
        <!-- media --> 
      </div>
	  <div class="contentpanel">
        <div class="row">
          <div class="col-md-12 quote_section">
            <!--<div class="mb20"></div>
            <div class="col-md-6">
              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="col-sm-5">Enter some keywords to search building</label>
                  <div class="col-sm-7">
                    <input type="text" name="account_name" value="" class="form-control" />
                  </div>
                </div>
                
                
                <div class="form-group">
                  <label class="col-sm-5"></label>
                  <div class="col-sm-7">
                    <button class="btn btn-primary mr5">Search</button>
                  </div>
                </div>
                
              </form>
            </div>-->
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2><?php echo ContactsSite::Model()->FindByPk($model->id)->site_name;  ?> : View Buildings </h2>
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
	'dataProvider'=>$buildings_model->search(),
	'filter'=>$buildings_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'columns'=>array(

		array(
                'name'=>'building_name',
                'header'=>'Building Name',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
			array(
                'name'=>'building_no',
                'header'=>'Building No',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		
			
		
		array(
                'name'=>'building_type_id',
                'header'=>'Building Type',
                'headerHtmlOptions'=>array('class'=>'head'),
				'filter' => CHtml::listData(ListBuildingType::model()->findAll(), 'id', 'name'), // fields from country table
				'value' => 'ListBuildingType::Model()->FindByPk($data->building_type_id)->name',
            ),
			
		array(
                'name'=>'dist_from_office',
                'header'=>'Dist. From Office',
                'headerHtmlOptions'=>array('class'=>'head'),
				
            ),
			
		
		array(
                'name'=>'no_of_floors',
                'header'=>'No Of Floors',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
			
		array(
                'name'=>'size_of_building',
                'header'=>'Size Of Building',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
			
			array(
                'name'=>'height_of_building',
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
			'headerHtmlOptions'=>array('width'=>'150','class'=>'head'),
			'template'=>'{view} | {update} | {delete}',
			'buttons'=>array
						(
							'view' => array
							(
								'label'=>'View',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/Buildings/default/view",array("id" => $data->primaryKey))',
							),
							
							'update' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/Buildings/default/update",array("id" => $data->primaryKey))',
							),
							
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/Buildings/default/delete",array("id" => $data->primaryKey))',
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
