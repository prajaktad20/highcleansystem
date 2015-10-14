<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i></a></li>            
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=setting/default/admin">Settings</a></li>
			  <li>Manage Settings</li>
            </ul>
            <h4>
<?php
					  
					  echo CHtml::link(
						Yii::t("Settings.create", "Add New Setting"),
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
                <h2>Settings Management</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
			   <div class="col-md-12 pull-right mb10 pr0" style="text-align:right">

</div>


<?php 



// CgridView Records/page
$pageSize = Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'buildings-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'columns'=>array(
		 array(
                'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'10%',
                                'class'=>'head'
                        )
                ), 
				
		array(
                'name'=>'meta_key',
				'headerHtmlOptions'=>array(
                                'width'=>'25%',
                                'class'=>'head'
                        )				
            ),
					
		array(
                'name'=>'meta_value',
				'headerHtmlOptions'=>array(
                                'width'=>'25%',
                                'class'=>'head'
                        )				
            ),		
			
		array(
                'name'=>'note',
				'headerHtmlOptions'=>array(
                                'width'=>'25%',
                                'class'=>'head'
                        )				
            ),
		
	//'meta_key',
	//'meta_value',
	
		array(
			'class'=>'CButtonColumn',
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('buildings-grid',{ data:{pageSize: $(this).val() }})",
			)),	
			'headerHtmlOptions'=>array('width'=>'15%','class'=>'head'),
			'template'=>'{view} | {update} | {delete}',
			'buttons'=>array
						(
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
							
					),
			 
			 
		),
	),
)); 


?>


</div>
              <!-- table-responsive --> 
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
