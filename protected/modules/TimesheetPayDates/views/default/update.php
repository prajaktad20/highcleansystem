<?php
/* @var $this TimesheetPayDatesController */
/* @var $model TimesheetPayDates */
?>

<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
               <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=TimesheetPayDates/default/admin">Timesheet Pay Dates</a></li>
              <li>Update Pay Date</li>
            </ul>
            <h4><?php echo CHtml::link(
                Yii::t("TimesheetPayDates.admin", "Manage"),
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
              <div class="panel-body titlebar"> <span class="fa fa-pencil"></span>
                <h2>Update Pay Date</h2>
              </div>
            </div>
            
<?php $this->renderPartial('_update_form', array('model'=>$model)); ?>

            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
