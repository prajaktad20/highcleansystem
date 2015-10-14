<?php
/* @var $this CompanyController */
/* @var $model Company */

?>
<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i></a></li>
			  <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Company/default/admin">Companies</a></li>
              <li>Manage Companies</li>
            </ul>
            <h4>
			 <?php
					  
					  echo CHtml::link(
						Yii::t("Company.create", "Add New Company"),
						array("create"),
						array("class"=>"btn btn-primary pull-right")
					);
					  
?></h4>
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
                <h2>Companies Management</h2>
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
	'id'=>'company-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'columns'=>array(
	
	      /*  array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ),
			 */	
		array(
                'name'=>'name',
                'header'=>'Company Name',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'20%'),
            ),
		
	array(
                'name'=>'abn',
                'header'=>'ABN',
                'headerHtmlOptions'=>array('class'=>'head','width'=>'10%'),
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
                'name'=>'fax',
                'header'=>'Fax',
                'headerHtmlOptions'=>array('class'=>'head','width'=>'10%'),
            ),
				/* array(
                'name'=>'email',
                'header'=>'Email',
                'headerHtmlOptions'=>array('class'=>'head'),
            ), */
				array(
                'name'=>'website',
                'header'=>'Website',
                'headerHtmlOptions'=>array('class'=>'head','width'=>'15%'),
            ),
	
		
		/*
		'abn',
		'phone',
		'mobile',
		'fax',
		'email',
		'website',
		'number_of_site',
		'office_state',
		'office_postcode',
		'mailing_state',
		'mailing_postcode',
		'created_at',
		'updated_at',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('company-grid',{ data:{pageSize: $(this).val() }})",
			)),	
			'headerHtmlOptions'=>array('width'=>'24%','class'=>'head'),
			'template'=>'{create_quote} | {add_contact} | {view_contacts} | {view} | {update} | {delete}',
			'buttons'=>array
						(
							'create_quote' => array
							(
								'label'=>'Create Quote',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/Company/default/AddQuote",array("company_id" => $data->primaryKey))',
							),
							
							'add_contact' => array
							(
								'label'=>'Add Contact',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/Company/default/AddContact",array("company_id" => $data->primaryKey))',
							),
							
							'view_contacts' => array
							(
								'label'=>'View Contacts',
								'url' => 'Yii::app()->createUrl("/Company/default/ViewContacts",array("company_id" => $data->primaryKey))',
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

