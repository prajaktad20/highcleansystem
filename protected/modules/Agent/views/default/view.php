<?php
/* @var $this AgentController */
/* @var $model Agent */


?>


<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
         	 <li>View Service Agent</li>
            </ul>
            <h4>
<?php
					  
					  echo CHtml::link(
						Yii::t("Agent.admin", "Manage"),
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
                <h2>View Service Agent</h2>
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
		'business_name',
		'agent_first_name',
		'agent_last_name',
		'business_email_address',

		'street',
		'city',		
		'state_province',
		'zip_code',

		'phone',
		'mobile',		
		'fax',
		'abn',
		'website',
            array(
            'name' => 'Status',
            'value' => $model->status ? 'Active' : "Inactive"
        ),


		
		
		'ip_address',	
		'last_logined',		
		'added_date',
	),
)); ?>


</div>
              <!-- table-responsive --> 
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
