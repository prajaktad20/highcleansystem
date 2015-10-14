<?php
/* @var $this SystemOwnerController */
/* @var $model SystemOwner */


?>

<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
         	 <li>Manage System Owner</li>
            </ul>
            <h4>
<?php
					  
					  echo CHtml::link(
						Yii::t("SystemOwner.create", "Add New System Owner"),
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
                <h2>Manage System Owner</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
			   <div class="col-md-12 pull-right mb10 pr0" style="text-align:right">

</div>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'system-owner-grid',
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
                'name'=>'first_name',
                'header'=>'First Name',
				'headerHtmlOptions'=>array(
                                'class'=>'head'
                        )				
            ),
	
	array(
                'name'=>'last_name',
                'header'=>'Last Name',
				'headerHtmlOptions'=>array(
                                'class'=>'head'
                        )				
            ),
	
	array(
                'name'=>'username',
                'header'=>'Vinayak',
				'headerHtmlOptions'=>array(
                                'class'=>'head'
                        )				
            ),
	
	array(
                'name'=>'email',
                'header'=>'Email',
				'headerHtmlOptions'=>array(
                                'class'=>'head'
                        )				
            ),

		array(
			'class'=>'CButtonColumn',
			'headerHtmlOptions'=>array('width'=>'20%','class'=>'head'),
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
)); ?>

</div>
              <!-- table-responsive --> 
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
