<?php
/* @var $this GroupController */
/* @var $model Group */

?>

        <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
                 <li><a href="<?php echo $this->user_role_base_url; ?>?r=User/default/admin">Users</a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Group/default/admin">Groups</a></li>
              <li>View Group Details</li>
            </ul>
            <h4><?php echo CHtml::link(
                Yii::t("Group.admin", "Manage"),
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
            <div class="mb20"></div>
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2>View Group Details</h2>
              </div>
            </div>
            <div class="col-md-12">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'role',
		'role_val',
		
	),
)); ?>


           </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
     

