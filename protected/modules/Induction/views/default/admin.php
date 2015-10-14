<?php
/* @var $this InductionController */
/* @var $model Induction */


?>



<div class="pageheader">
        <div class="media">
          <div class="media-body">
         <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li>Manage Induction Type</li>
            </ul>
<h4>
			 <?php
					  
					  echo CHtml::link(
						Yii::t("Induction.create", "Add New Induction"),
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
                <h2>Induction Management</h2>
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
	'id'=>'induction-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'columns'=>array(
	/*
		'induction_link',
		'document',
		'password',
		'completion_date',
		'induction_number',
		'expiry_date',
		'created_at',
		*/
		
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
				'name' => 'user_id',
				'header' => 'User',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'15%'),
				//'filter' => CHtml::listData(User::model()->findAll(array('order'=>"first_name ASC")), 'id', 'first_name'), // fields from services table
				//'value' => 'User::Model()->FindByPk($data->user_id)->first_name',
				'filter' => false,
				'value' => '$data->getFullName($data->user_id)',
			),			
		
	array(
                'name'=>'site_id',
                'header'=>'Site',
				'filter' => false,
               'headerHtmlOptions'=>array('class'=>'head','width'=>'15%'),
				//'filter' => CHtml::listData(ContactsSite::model()->findAll(array('order'=>"site_name ASC")), 'id', 'site_name'), // fields from country table
				//'value' => 'ContactsSite::Model()->FindByPk($data->site_id)->site_name',
				'value'=>'($data->site_id > 0) ? ContactsSite::Model()->FindByPk($data->site_id)->site_name : "All Sites"',
            ),
			

			array(
                'name'=>'induction_type_id',
                'header'=>'Induction Type',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'15%'),
				'filter' => CHtml::listData(InductionType::model()->findAll(array('order'=>"name ASC")), 'id', 'name'), // fields from country table
				'value' => 'InductionType::Model()->FindByPk($data->induction_type_id)->name',
            ),
				array(
                'name'=>'induction_company_id',
                'header'=>'Induction Company',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'15%'),
				'filter' => CHtml::listData(InductionCompany::model()->findAll(array('order'=>"name ASC")), 'id', 'name'), // fields from country table
				'value' => 'InductionCompany::Model()->FindByPk($data->induction_company_id)->name',
            ),
		
			array(
                        'name'=>'induction_status',
						'headerHtmlOptions'=>array('class'=>'head','width'=>'20%'),
						'filter'=>array('pending'=>'Pending', 'completed'=>'Completed'),		
						'value' => 'ucwords($data->induction_status)',
                    
			),	
		
		
		array(
			'class'=>'CButtonColumn',
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('company-grid',{ data:{pageSize: $(this).val() }})",
			)),	
			'headerHtmlOptions'=>array('width'=>'20%','class'=>'head'),
			'template'=>'{view} | {update} | {delete} | {notify_user}',
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
							
							'notify_user' => array
							(
								'label'=>'Notify User',
								'imageUrl'=>false,
								'click'=>"function(){

									if (confirm('Are you sure, do you want notify user ?')) {
                                    $.fn.yiiGridView.update('induction-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
											$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                            $.fn.yiiGridView.update('induction-grid');
												alert('Mail sent successfully..');
                                              
                                        }
                                    })
									}
                                    return false;
                              }
                     ",
								
								'url' => 'Yii::app()->createUrl("/Induction/default/notify_user",array("id" => $data->primaryKey))',
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
