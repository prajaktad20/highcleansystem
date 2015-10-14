<?php
/* @var $this ServiceController */
/* @var $model Service */

?>


		
<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li>Manage Services</li>
            </ul>
            <h4>Manage Services <?php echo CHtml::link(
                Yii::t("Service.admin", "Manage"),
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
                <h2>View Service</h2>
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
      <!-- contentpanel -->