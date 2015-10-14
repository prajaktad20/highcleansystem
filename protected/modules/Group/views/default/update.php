<?php
/* @var $this GroupController */
/* @var $model Group */

?>

        <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="">Users</a></li>
              <li>Groups</li>
              <li>Manage Groups</li>
            </ul>
            <h4>Manage Groups <?php echo CHtml::link(
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
                <h2>Groups Management</h2>
              </div>
            </div>
            <div class="col-md-12">
			
<?php $this->renderPartial('_form', array('model'=>$model)); ?>

				</div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
     
