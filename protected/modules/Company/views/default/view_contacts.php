<?php
/* @var $this CompanyController */
/* @var $model Company */
$pageSize = Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

?>

  <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i></a></li>
			  <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Company/default/admin">Companies</a></li>
              <li>View Contacts</li>
              </ul>
<h4><?php echo CHtml::link(
                Yii::t("Company.admin", "Manage"),
                array("admin"),
                array("class"=>"btn btn-primary pull-right")
 ); ?>
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
                <h2><?php echo $model->name; ?> : View Contact Details</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">


	<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contact-grid',
	'dataProvider'=>$contact_model->search(),
	'filter'=>$contact_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'columns'=>array(

			
			array(
                'name'=>'fullName',
                'header'=>'Full Name',
                'headerHtmlOptions'=>array('class'=>'head'),
				'value' => '$data->getFullName()',
            ),
	
			array(
                'name'=>'phone',
                'header'=>'Phone',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
	 
	 array(
                'name'=>'mobile',
                'header'=>'Mobile',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
	 

			array(
                'name'=>'position',
                'header'=>'Position',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
		
		      array(
                'name'=>'concatedAddress',
                'header'=>'Address',
                'headerHtmlOptions'=>array('class'=>'head'),
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
			//'header'=>'Actions',
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('contact-grid',{ data:{pageSize: $(this).val() }})",
			)),
			'headerHtmlOptions'=>array('width'=>'150','class'=>'head'),
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
								'url' => 'Yii::app()->createUrl("/Contact/default/view",array("id" => $data->primaryKey))',
							),
							
							'update' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/Contact/default/update",array("id" => $data->primaryKey))',
							),
							
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/Contact/default/delete",array("id" => $data->primaryKey))',
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
