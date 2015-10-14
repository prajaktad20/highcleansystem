<?php
/* @var $this HireStaffController */
/* @var $model HireStaff */

$this->breadcrumbs=array(
	'Hire Staff'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List HireStaff', 'url'=>array('index')),
	array('label'=>'Manage HireStaff', 'url'=>array('admin')),
);
?>

<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
               <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=HireStaff/default/admin">Staff</a></li>
              <li>Add staff details</li>
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
              <div class="panel-body titlebar"> <span class="fa fa-pencil"></span>
                <h2>Add New Staff</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
				<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		   </div>
              <!-- table-responsive --> 
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
