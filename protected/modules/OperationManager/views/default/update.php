<?php
/* @var $this OperationManagerController */
/* @var $model OperationManager */


?>

<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
         	 <li>Manage Operation Manager</li>
            </ul>
         <h4><?php echo CHtml::link(
                Yii::t("OperationManager.admin", "Manage"),
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
                <h2>Update Operation Manager</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
			   <div class="col-md-12 pull-right mb10 pr0" style="text-align:right">

</div>

<?php $this->renderPartial('_update_form', array('model'=>$model)); ?>


</div>
              <!-- table-responsive --> 
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
