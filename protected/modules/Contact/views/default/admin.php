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
			  <li>Manage Contacts</li>
            </ul>
            <h4>
<?php
					  
					  echo CHtml::link(
						Yii::t("Contact.create", "Add New Contact"),
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
                <h2>Contacts Management</h2>
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
	'id'=>'contact-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'columns'=>array(
	      		/* array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ), */
	array(
				'name' => 'company_id',
				'header' => 'Company Name',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'20%'),
				'filter' => CHtml::listData(Company::model()->findAll(), 'id', 'name'), // fields from country table
				'value' => 'Company::Model()->FindByPk($data->company_id)->name',
			),
			
			array(
                'name'=>'fullName',
                'header'=>'Full Name',
                'headerHtmlOptions'=>array('class'=>'head','width'=>'10%'),
				'value' => '$data->getFullName()',
            ),
	
			array(
                'name'=>'phone',
                'header'=>'Phone',
                'headerHtmlOptions'=>array('class'=>'head','width'=>'10%'),
            ),
	 
	 array(
                'name'=>'mobile',
                'header'=>'Mobile',
                'headerHtmlOptions'=>array('class'=>'head','width'=>'10%'),
            ),
	 

			array(
                'name'=>'position',
                'header'=>'Position',
                'headerHtmlOptions'=>array('class'=>'head','width'=>'10%'),
            ),
		
		   
			
	      array(
                'name'=>'concatedAddress',
                'header'=>'Address',
                'headerHtmlOptions'=>array('class'=>'head','width'=>'20%'),
				'value' => '$data->getConcatedAddress()',
            ),
	
		
	
		
		/*
		'suburb',
		'state',
		'postcode',
		'phone',
		'mobile',
		'email',
		'position',
		'no_of_sites_managed',
		'created_at',
		'updated_at',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('contact-grid',{ data:{pageSize: $(this).val() }})",
			)),	
			'headerHtmlOptions'=>array('width'=>'19%','class'=>'head'),
			'template'=>'{add_site} | {view_site} | {view} | {update} | {delete}',
			'buttons'=>array
						(
							'add_site' => array
							(
								'label'=>'Add Site',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/Contact/default/AddSite",array("contact_id" => $data->primaryKey))',
							),
							
							'view_site' => array
							(
								'label'=>'View Sites',
								'url' => 'Yii::app()->createUrl("/Contact/default/ViewSites",array("contact_id" => $data->primaryKey))',
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