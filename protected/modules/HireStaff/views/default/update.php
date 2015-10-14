<?php
/* @var $this HireStaffController */
/* @var $model HireStaff */

$this->breadcrumbs=array(
	'Hire Staff'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List HireStaff', 'url'=>array('index')),
	array('label'=>'Create HireStaff', 'url'=>array('create')),
	array('label'=>'View HireStaff', 'url'=>array('view', 'id'=>$model->id)),
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
                <h2>My Profile</h2>
              </div>
            </div>
			
            <div class="col-md-12">

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

</div>
            <div class="clearfix"></div>
          </div>
        </div>
    </div>