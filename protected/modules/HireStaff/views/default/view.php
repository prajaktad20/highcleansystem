<?php
/* @var $this HireStaffController */
/* @var $model HireStaff */

$this->breadcrumbs=array(
	'Hire Staff'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List HireStaff', 'url'=>array('index')),
	array('label'=>'Create HireStaff', 'url'=>array('create')),
	array('label'=>'Update HireStaff', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete HireStaff', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage HireStaff', 'url'=>array('admin')),
);
?>
<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
               <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li>My Profile</li>
            </ul>
              <h4><?php echo CHtml::link(
                Yii::t("HireStaff.admin", "Manage"),
                array("admin"),
                array("class"=>"btn btn-primary pull-right")); ?></h4>
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
                <h2><?php echo $model->first_name.' '.$model->last_name.'\'s'; ?>  Profile</h2>
              </div>
            </div>
			
            <div class="col-md-12">
              <div class="table-responsive">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'last_name',
		'email',
		'auth_key',
		'created_at',
		'sent_email_count',
		'agent_id',
		'email_sent',
		'registered',
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
  