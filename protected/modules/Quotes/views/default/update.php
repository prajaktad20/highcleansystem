<?php
/* @var $this QuotesController */
/* @var $model Quotes */

?>
<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
			  <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
			  <li>Update Quote Details</li>
            </ul>
            <h4><?php echo CHtml::link(
                Yii::t("Quotes.admin", "Manage"),
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
                <h2>Edit Quote</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">


<?php $this->renderPartial('_update_form', array('model'=>$model,'building_ids'=>$building_ids,'site_building_error_msg'=>$site_building_error_msg)); ?>
</div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
