<?php
/* @var $this SwmsHzrdsConsqsController */
/* @var $model SwmsHzrdsConsqs */
?>

<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
               <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
             <li>SWMS</li>
            </ul>
            <h4>View SWMS Hazards/Consequences<?php echo CHtml::link(
                Yii::t("SwmsHzrdsConsqs.admin", "Manage"),
                array("admin"),
                array("class"=>"btn btn-primary pull-right")
 ); ?></h4>
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
                <h2>View SWMS</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">




<?php 

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		'task_id',
		'hazards',
		'consequences',
		'risk',
		'control_measures',
		
	),
));

?>


	  </div>
	  <!-- table-responsive --> 
	</div>
	<div class="clearfix"></div>
  </div>
</div>
</div>
<!-- contentpanel -->

