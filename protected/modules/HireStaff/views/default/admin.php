
<?php
/* @var $this HireStaffController */
/* @var $model HireStaff */

$this->breadcrumbs=array(
	'Hire Staff'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List HireStaff', 'url'=>array('index')),
	array('label'=>'Create HireStaff', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#hire-staff-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);

?>
<div class="pageheader">
    <div class="media">
        <div class="media-body">
            <ul class="breadcrumb">
                <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
                <li><a href="<?php echo $this->user_role_base_url; ?>?r=HireStaff/default/admin">Hire Staff</a></li>
                <li>Manage Hire Staff</li>
            </ul>

            <h4>			
                <?php
                echo CHtml::link(
                        Yii::t("HireStaff.create", "Add New Staff"), array("create"), array("class" => "btn btn-primary pull-right")
                );
                ?>	</h4>

        </div>
    </div>
    <!-- media --> 
</div>

</div><!-- search-form -->
<div class="contentpanel">
    <div class="row">
        <div class="col-md-12 user_section">
            <div class="clearfix"></div>
            <div class="panel panel-default">
                <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>				  
                    <h2>Hire Staff</h2>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <div class="col-md-12 pull-right mb10 pr0" style="text-align:right">
					
					</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'hire-staff-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
    'pagerCssClass' => 'pagination',
	'columns'=>array(
 		array(
                                'name' => 'first_name',
                                'header' => 'First Name',
                                'headerHtmlOptions' => array('class' => 'head')
                            ),


 		array(
                                'name' => 'last_name',
                                'header' => 'Last Name',
                                'headerHtmlOptions' => array('class' => 'head')
                            ),

 		array(
                                'name' => 'email',
                                'header' => 'Email',
                                'headerHtmlOptions' => array('class' => 'head')
                            ),
		array(
                                'name' => 'sent_email_count',
                                'header' => 'Email Count',
                                'headerHtmlOptions' => array('class' => 'head')
                            ),
		
		array(
                                'name' => 'registered',
                                'header' => 'Registered',
								'value' => '($data->registered == "1") ? "Yes" : "No"',
								'filter'=>array('1'=>'Yes', '0'=>'No'), 
                                'headerHtmlOptions' => array('class' => 'head')
                            ),

		/*'auth_key',
		'created_at',
		'sent_email_count',
		'agent_id',
		'email_sent',
		'registered',
		*/
		array(
			'class'=>'CButtonColumn',
			'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 20 => 20, 25 => 25, 50 => 50, 100 => 100, 150 => 150, 200 => 200), array(
				'onchange' => "$.fn.yiiGridView.update('hire-staff-grid',{ data:{pageSize: $(this).val() }})",
            )),
			'headerHtmlOptions' => array('width' => '15%', 'class' => 'head'),
            'template' => '{update}  {view} | {delete} | {notify_user}',
            'buttons' => array(
                        
						'update' => array(
						'label' => 'Edit |',
						//'url'=>'Yii::app()->createUrl("HireStaff/default/update", array("id"=>$data->primaryKey))',
                        'imageUrl' => null,
						'visible'=>'($data->registered == "1") ? false : true',
                        ),
						
						'view' => array(
                        'label' => 'View',
                        'imageUrl' => null,
                        ),
						
                        'delete' => array(
                        'label' => 'Delete',
                        //'visible' => '(Yii::app()->HireStaff->profile=="admin") ? true : false',
                        'imageUrl' => null,
                        ),
						
						'notify_user' => array
							(
								'label'=>'Share Signup Link',
								'imageUrl'=>false,
								'click'=>"function(){

									if (confirm('Are you sure, do you want notify user ?')) {
                                    $.fn.yiiGridView.update('hire-staff-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
											$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                            $.fn.yiiGridView.update('hire-staff-grid');
												alert('Mail sent successfully..');
                                              
                                        }
                                    })
									}
                                    return false;
                              }
                     ",
								
								'url' => 'Yii::app()->createUrl("/HireStaff/default/notify_user",array("id" => $data->primaryKey))',
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
