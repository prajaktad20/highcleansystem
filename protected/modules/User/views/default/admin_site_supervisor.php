<?php
/* @var $this UserController */
/* @var $model User */

?>


     <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=User/default/admin">Users</a></li>
              <li>Manage Users</li>
            </ul>
<?php if(Yii::app()->user->name == 'admin') {    ?>         
<h4>			
 <?php
					  
					  echo CHtml::link(
						Yii::t("User.create", "Add New User"),
						array("create"),
						array("class"=>"btn btn-primary pull-right")
						
						
					);
					  
?>	</h4>
<?php } ?>
          </div>
        </div>
        <!-- media --> 
      </div>
      <div class="contentpanel">
        <div class="row">
          <div class="col-md-12 user_section">
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2>My Account</h2>
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
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'summaryText'=>'', 
	'enablePagination' => false,
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
                'name'=>'username',
                'header'=>'Username',
                'headerHtmlOptions'=>array('class'=>'head'),
            ), 
				array(
                'name'=>'fullName',
                'header'=>'Full Name',
                'headerHtmlOptions'=>array('class'=>'head'),
				'value' => '$data->getFullName()',
            ),
	
		
	   array(
			'name' => 'role_id',
			'header' => 'Group',
			'headerHtmlOptions'=>array('class'=>'head'),
			'filter' => CHtml::listData(Group::model()->findAll(), 'id', 'role'), // fields from country table
			'value' => 'Group::Model()->FindByPk($data->role_id)->role',
		),

	   array(
			'name' => 'status',
			'headerHtmlOptions'=>array('class'=>'head'),
			'filter' => array('1'=>'Active','0'=>'InActive'),
			'value' => '$data->status ? "Active" : "Inactive"'
			
		),
	
	
	   array(
			'name' => 'view_jobs',
			'headerHtmlOptions'=>array('class'=>'head'),
			'filter' => array('1'=>'Yes','0'=>'No'),
			'value' => '$data->view_jobs ? "Yes" : "No"'
			
		),
	
	
	array(
                'name'=>'email',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
			

	array(
                'name'=>'mobile_phone',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
			

	
	array(
                'name'=>'driving_licence',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
			

	array(
                'name'=>'driving_licence_state',
                'headerHtmlOptions'=>array('class'=>'head'),
            ),
			



		
	array(
			'class'=>'CButtonColumn',
			'header' => 'Action',
			'headerHtmlOptions'=>array('class'=>'head'),
			'template'=>'{update} | {change_password} | {view_licenses} {delete}',
			
	'buttons'=>array
	(
						
	'view_licenses'	 => array (
		'label'=>'License/Induction',
		'imageUrl'=>null,
		'url' => 'Yii::app()->createUrl("/User/default/ViewLicenseInduction",array("selected_user_id" => $data->primaryKey))',
	),	
	

	 
		'update' => array
		(
			'label'=>'Edit',
			'imageUrl'=>null,
		),
		
		'change_password' => array
		(
			'label'=>'Change Password',
			'imageUrl'=>null,
			'url' => 'Yii::app()->createUrl("/User/default/changepassword",array("id" => $data->primaryKey))',
		),
		
		
		'delete' => array
		(
			'label'=>'| Delete',
			'visible'=>'(Yii::app()->user->profile=="admin") ? true : false',
			'imageUrl'=>null,
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
  
