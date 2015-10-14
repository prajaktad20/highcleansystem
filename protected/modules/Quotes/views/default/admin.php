<?php

/* @var $this QuotesController */
/* @var $model Quotes */

$pageSize = Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

?>
      <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
             <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
			 <li>Manage Quotes</li>
            </ul>
            <h4> <?php
					  
					  echo CHtml::link(
						Yii::t("Quotes.create", "Create New Quote"),
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
                <h2>Quotes Management</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
			   <div class="col-md-12 pull-right mb10 pr0" style="text-align:right">
			  
</div>
<?php 

Yii::import('zii.widgets.jui.CJuiInputWidget');
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'quotes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	 'afterAjaxUpdate' => 'reinstallDatePicker', //call function to reinstall date picker 
	'columns'=>array(
 
		array(
			 'name'=>'id',
			 'header'=>'Quote No.',
			 'headerHtmlOptions'=>array('width'=> "10%",'class'=>'head'),			
		),
		
	 array(
                'name'=>'quote_date',
                'header'=>'Date',
                'headerHtmlOptions'=>array('width'=> "10%",'class'=>'head'),
				'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model' => $model,
							'attribute' => 'quote_date',
							'options'=>array(
							'dateFormat'=>'yy-mm-dd',
							'changeYear'=>'true',
							'changeMonth'=>'true',
							'showAnim' =>'fadeIn',
							'yearRange'=>'2000:'.(date('Y')+10),
							),
							'htmlOptions'=>array(
							'id'=>'date',
							
							),

							),
							true),
				//'value' => 'date("l, F jS, Y", strtotime($data->quote_date))'
            ),

		array(
		'name' => 'contact_id',
		'header' => 'Contact Name',
		'headerHtmlOptions'=>array('class'=>'head'),
		'filter' => CHtml::listData(Contact::model()->findAll(array('order'=>"first_name ASC")), 'id', function($model){ return $model->first_name . " " . $model->surname; }), // fields from country table
		'value' => 'Contact::Model()->FindByPk($data->contact_id)->first_name." ".Contact::Model()->FindByPk($data->contact_id)->surname',
	),
			
		array(
                'name'=>'site_id',
                'header'=>'Site',
                'headerHtmlOptions'=>array('class'=>'head'),
				'filter' => CHtml::listData(ContactsSite::model()->findAll(array('order'=>"site_name ASC")), 'id', 'site_name'), // fields from country table
				'value' => 'ContactsSite::Model()->FindByPk($data->site_id)->site_name',
            ),
			
	 		array(
                'name'=>'Building',
                'header'=>'Building',
                'headerHtmlOptions'=>array('class'=>'head'),
				'filter' => false,				
				'value' => '$data->getBuilding($data->primaryKey)',
            ),	 


	array(
				'name' => 'service_id',
				'header' => 'Required Service',
				'headerHtmlOptions'=>array('class'=>'head'),
				'filter' => CHtml::listData(Service::model()->findAll(array('order'=>"service_name ASC")), 'id', 'service_name'), // fields from services table
				'value' => 'Service::Model()->FindByPk($data->service_id)->service_name',
			),
			

			 
	 array(
                'name'=>'status',
                'header'=>'Status',
				'filter' => array('Pending'=>'Pending','Completed'=>'Completed','Incomplete'=>'Incomplete','Approve'=>'Approve','Decline'=>'Decline'),
                'headerHtmlOptions'=>array('class'=>'head'),
				
            ),
		

			

	
			
		array(
			'class'=>'CButtonColumn',
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('quotes-grid',{ data:{pageSize: $(this).val() }})",
			)),	
			'headerHtmlOptions'=>array('width'=>'20%','class'=>'head'),
			'template'=>'{view} {make_copy} | {download_quote}  {approve}  {decline} | {delete} {update}',
			'buttons'=>array
						(
							'view' => array
							(
								'label'=>'Detail',
								'imageUrl'=>false,
							),
							'make_copy' => array
							(
								'label'=>'| Make Copy',
								'imageUrl'=>false,
								//'visible'=>'($data->status == "Approved") ? false : true',
								
		'click'=>"function(){

									if (confirm('Are you want to Make Copy?')) {
                                    $.fn.yiiGridView.update('quotes-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                              $('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
 
                                              $.fn.yiiGridView.update('quotes-grid');
                                        }
                                    })
									}
                                    return false;
                              }
                     ",

	'url' => 'Yii::app()->createUrl("/Quotes/default/makecopy",array("id" => $data->primaryKey))',
								
							),
							'download_quote' => array
							(
								'label'=>'Download Quote',
								'imageUrl'=>false,															
				 				'url' => 'Yii::app()->createUrl("/Quotes/default/GetAllJobQuotes",array("id" => $data->primaryKey))',
								'click' => 'function(e) {
                                      $("#ajaxModal").remove();
                                      e.preventDefault();
                                      var $this = $(this)
                                        , $remote = $this.data("remote") || $this.attr("href")
                                        , $modal = $("<div class=\'modal\' id=\'ajaxModal\'><div class=\'modal-body\'><h5 align=\'center\'> <img src=\'' . Yii::app()->request->baseUrl . '/images/ajax-loader.gif\'>&nbsp;  Please Wait .. </h5></div></div>");
                                      $("body").append($modal);
                                      $modal.modal({backdrop: "static", keyboard: false});
                                      $modal.load($remote);
                                    }',
							'options' => array('data-toggle' => 'ajaxModal','style' => 'padding:4px;'),
								
							),
							
							
							'approve' => array
							(
								'label'=>'| Approve',
								'imageUrl'=>false,
								'visible'=>'($data->status == "Approved" || $data->status == "Declined" || $data->status == "Incomplete") ? false : true',

								
									

'click'=>"function(){

									if (confirm('Are you want to change status to Approve ?')) {
                                    $.fn.yiiGridView.update('quotes-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                              $('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
 
                                              $.fn.yiiGridView.update('quotes-grid');
                                        }
                                    })
									}
                                    return false;
                              }
                     ",

	'url' => 'Yii::app()->createUrl("/Quotes/default/changestatustoapprove",array("id" => $data->primaryKey))',
		
								
								
								
							),
							
							'decline' => array
							(
								'label'=>'| Decline',
								'imageUrl'=>false,
								'visible'=>'($data->status == "Approved" || $data->status == "Declined") ? false : true',
								
'click'=>"function(){

									if (confirm('Are you want to change status to Decline ?')) {
                                    $.fn.yiiGridView.update('quotes-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                              $('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
 
                                              $.fn.yiiGridView.update('quotes-grid');
                                        }
                                    })
									}
                                    return false;
                              }
                     ",

	'url' => 'Yii::app()->createUrl("/Quotes/default/changestatustodecline",array("id" => $data->primaryKey))',
		
								
							),
							'update' => array
							(
								'label'=>'| Edit',
								'visible'=>'($data->status == "Approved") ? false : true',								
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

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    jQuery('#date').datepicker({
        changeMonth: true,
        changeYear: true,
		dateFormat: 'yy-mm-dd',
    });
}
");

?>
</div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->

	  
	  
