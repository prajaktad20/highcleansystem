<?php
/* @var $this ContactController */
/* @var $model Contact */
?>
<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Contact/default/admin">Contacts</a></li>
			  <li>Update Contact Details</li>
            </ul>
            <h4><?php echo CHtml::link(
                Yii::t("Contact.admin", "Manage"),
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
                <h2><?php echo $model->first_name.' '.$model->surname; ?> : Update Contact Details</h2>
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