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
            <h4>
<?php
					  
					  echo CHtml::link(
						Yii::t("OperationManager.create", "Add New Operation Manager"),
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
                <h2>Manage Operation Manager</h2>
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
	'id'=>'operation-manager-grid',
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
                'header'=>'Name',
                'headerHtmlOptions'=>array('class'=>'head'),
				'value' => '$data->getFullName()',
            ),

	array(
                'name'=>'email_address',
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

		array(
			'class'=>'CButtonColumn',
			'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 20 => 20, 25 => 25, 50 => 50, 100 => 100, 150 => 150, 200 => 200), array(
				'onchange' => "$.fn.yiiGridView.update('operation-manager-grid',{ data:{pageSize: $(this).val() }})",
            )),
			'headerHtmlOptions'=>array('width'=>'20%','class'=>'head'),
			'template'=>'{operation_manager_login} | {view} | {update} | {delete} | {change_password}',
			'buttons'=>array
						(
							'operation_manager_login' => array
							(
								'label'=>'Login',
								'imageUrl'=>false,
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
                                'url' => 'Yii::app()->createUrl("/OperationManager/default/changepassword",array("id" => $data->primaryKey))',
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
