<?php
/* @var $this BuildingsController */
/* @var $model Buildings */

?>
<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Contact/default/admin">Contacts</a></li>
			  <li>View site Details</li>
			  </ul>
            <h4>
<?php echo CHtml::link(
                Yii::t("ContactsSite.admin", "Manage"),
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
            <!--<div class="mb20"></div>
            <div class="col-md-6">
              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="col-sm-5">Enter some keywords to search building</label>
                  <div class="col-sm-7">
                    <input type="text" name="account_name" value="" class="form-control" />
                  </div>
                </div>
                
                
                <div class="form-group">
                  <label class="col-sm-5"></label>
                  <div class="col-sm-7">
                    <button class="btn btn-primary mr5">Search</button>
                  </div>
                </div>
                
              </form>
            </div>-->
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2><?php echo Contact::Model()->FindByPk($model->id)->first_name.' '.Contact::Model()->FindByPk($model->id)->surname;  ?> : View Site Details </h2>
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
	'id'=>'contacts-site-grid',
	'dataProvider'=>$sites_model->search(),
	'filter'=>$sites_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'columns'=>array(
	 		

				
	        array(
                'name'=>'site_name',
                'header'=>'Site Name',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
			
	
	
			   array(
                'name'=>'site_id',
                'header'=>'Site ID/No.',
                'headerHtmlOptions'=>array('class'=>'head'),
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
                'name'=>'concatedAddress',
                'header'=>'Address',
                'headerHtmlOptions'=>array('class'=>'head'),
				'value' => '$data->getConcatedAddress()',
            ),
	
		
	
		
		/*
		'state',
		'postcode',
		'phone',
		'mobile',
		'email',
		'site_contact',
		'site_comments',
		'how_many_buildings',
		'created_at',
		'updated_at',
		'need_induction',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('contacts-site-grid',{ data:{pageSize: $(this).val() }})",
			)),	
			'headerHtmlOptions'=>array('width'=>'250','class'=>'head'),
			'template'=>'{add_buildings} | {view_buildings} | {change_contact} | {view} | {update} | {delete}',
			'buttons'=>array
						(
							'add_buildings' => array
							(
								'label'=>'Add Building',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ContactsSite/default/AddBuilding",array("site_id" => $data->primaryKey))',
							),
							
							'view_buildings' => array
							(
								'label'=>'View Buildings',
								'url' => 'Yii::app()->createUrl("/ContactsSite/default/ViewBuildings",array("site_id" => $data->primaryKey))',
							),
							
						
							'change_contact' => array
							(
								'label'=>'Change Contact',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ContactsSite/default/ChangeContact",array("id" => $data->primaryKey))',
							),
							
							
							'view' => array
							(
								'label'=>'View',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ContactsSite/default/view",array("id" => $data->primaryKey))',
							),
							
							'update' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/ContactsSite/default/update",array("id" => $data->primaryKey))',
							),
			
							
							'delete' => array
							(
							
							
							'click'=>"function(){

					if (confirm('If you delete this site, all quotes,buildings under this site will be deleted permanantly.')) {
                                    $.fn.yiiGridView.update('contacts-site-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                              $('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
 
                                              $.fn.yiiGridView.update('contacts-site-grid');
                                        }
                                    })
									}
                                    return false;
                              }
							",
							
								'url' => 'Yii::app()->createUrl("/ContactsSite/default/delete",array("id" => $data->primaryKey))',
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
