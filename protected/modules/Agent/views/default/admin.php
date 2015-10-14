<?php
/* @var $this AgentController */
/* @var $model Agent */


?>


<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
         	 <li>Manage Service Agent</li>
            </ul>
            <h4>
<?php
					  echo CHtml::link(
						Yii::t("Agent.create", "Add New Service Agent"),
						array("create"),
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
                <h2>Manage Service Agent</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
			   <div class="col-md-12 pull-right mb10 pr0" style="text-align:right">

</div>
<?php
$pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'business-partner-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'columns'=>array(

	 array(
                'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'5%',
                                'class'=>'head'
                        )
                ), 
array(
	        'name'=>'fullName',
                'header'=>'Client',
                'headerHtmlOptions'=>array('class'=>'head'),
				'value' => '$data->getFullName()',
            ),

	array(
                'name'=>'business_name',
                'header'=>'Business',
				'headerHtmlOptions'=>array(
                                'class'=>'head'
                        )				
            ),
	array(
                'name'=>'business_email_address',
                'header'=>'Email',
				'headerHtmlOptions'=>array(
                                'class'=>'head'
                        )				
            ),
array(
	        'name'=>'concatedAddress',
                'header'=>'Address',
                'headerHtmlOptions'=>array('class'=>'head'),
		'value' => '$data->getConcatedAddress()',
            ),

	array(
                'name'=>'phone',
                'header'=>'Phone',
				'headerHtmlOptions'=>array(
                                'class'=>'head'
                        )				
            ),

	array(
                'name'=>'mobile',
                'header'=>'Mobile',
				'headerHtmlOptions'=>array(
                                'class'=>'head'
                        )				
            ),

		/*'agent_first_name',
		'agent_last_name',
		'business_name',
		'logo',
		'business_url_code',
		
		'auth_key',
		'business_email_address',
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
		*/
		array(
			'class'=>'CButtonColumn',
			'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 20 => 20, 25 => 25, 50 => 50, 100 => 100, 150 => 150, 200 => 200), array(
				'onchange' => "$.fn.yiiGridView.update('business-partner-grid',{ data:{pageSize: $(this).val() }})",
            )),
			'headerHtmlOptions'=>array('width'=>'20%','class'=>'head'),
			'template'=>'{agent_login} | {view} | {update} | {delete} | {change_password}',
			'buttons'=>array
						(

							'agent_login' => array
							(
								'label'=>'Login',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/AgentDashboard/default/index",array("referred_agent_id" => $data->primaryKey))',
							),
	
							'view' => array
							(
								'label'=>'View',
								'imageUrl'=>false,
							),
							
							'update' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
							),
							
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
							),
							
							'change_password' => array
                            (
								'label' => 'Change Password',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("/Agent/default/changepassword",array("id" => $data->primaryKey))',
                            ),
							
					),
		),
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
