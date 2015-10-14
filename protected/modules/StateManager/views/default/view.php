<?php
/* @var $this StateManagerController */
/* @var $model StateManager */
?>

<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
         	 <li>View State Manager</li>
            </ul>
            <h4>
<?php
					  
					  echo CHtml::link(
						Yii::t("StateManager.admin", "Manage"),
						array("admin"),
						array("class"=>"btn btn-primary pull-right")
					);
					  
?>	
			
			</h4>
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
                <h2>View State Manager</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
			   <div class="col-md-12 pull-right mb10 pr0" style="text-align:right">

</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'last_name',
		'url_code',
		'auth_key',
		'email_address',
		'password',
		'ip_address',
		'phone',
		'mobile',
		'last_logined',
		'street',
		'city',
		'state_province',
		'zip_code',
		'added_date',
		

            array(
            'name' => 'Status',
            'value' => $model->status ? 'Active' : "Inactive"
        ),

	),
)); ?>


<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
         	 <li>View State Manager</li>
            </ul>
            <h4>
<?php
					  
					  echo CHtml::link(
						Yii::t("StateManager.admin", "Manage"),
						array("admin"),
						array("class"=>"btn btn-primary pull-right")
					);
					  
?>	
			
			</h4>
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
                <h2>View State Manager</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
			   <div class="col-md-12 pull-right mb10 pr0" style="text-align:right">

</div>
