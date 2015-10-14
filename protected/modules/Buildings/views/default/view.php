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
			  <li>View  Building Details</li>
            </ul>
            <h4><?php echo CHtml::link(
                Yii::t("Buildings.admin", "Manage"),
                array("admin"),
                array("class"=>"btn btn-primary pull-right")
 ); ?></h4>
			
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
                <h2><?php echo $model->building_name; ?> : View Building Details</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		'building_name',
		'building_no',
		//'water_source_availability',
		
		array(
            'name' => 'Water Source',
            'value' => $model->water_source_availability ? 'Available' : "Not Available"
        ),
		
		'dist_from_office',
		'no_of_floors',
		'size_of_building',
		'height_of_building',
		'job_notes',
		//'site_id',
		array(
            'name' => 'Site Name',
            'value' => ContactsSite::Model()->FindByPk($model->site_id)->site_name
        ),
		array(
            'name' => 'Building Type',
            'value' => ListBuildingType::Model()->FindByPk($model->building_type_id )->name
        ),
		
		//'building_type_id',
		'created_at',
		'updated_at',
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
