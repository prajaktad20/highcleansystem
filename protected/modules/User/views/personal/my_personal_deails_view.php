<?php
/* @var $this UserController */
/* @var $model User */

?>
<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
               <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li>My Profile</li>
            </ul>
             <h4><a href="<?php echo $this->user_role_base_url; ?>?r=User/personal/MyProfileUpdate" class="btn btn-primary pull-right">Edit</a></h4>
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
                <h2>My Profile</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
              		<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(

//		'Avatar',
		'first_name',
		'last_name',
		'username',
		//'password',
		'email',
		//'role_id',
		
		array(
            'name' => 'User Role',
            'value' => Group::Model()->FindByPk($model->role_id)->role
        ),
		
		//'last_logined',
		//'salt',
		//'ip_address',
		'gender',
		//'date_of_birth',
		
		array(
            'name' => 'Date of Birth',
            'value' => date("l, F jS, Y", strtotime($model->date_of_birth))
        ),
		
		//'view_jobs',
		array(
            'name' => 'View Jobs',
            'value' => $model->view_jobs ? 'Yes' : "No"
        ),
		
		'home_phone',
		'mobile_phone',
		'street',
		'city',
		'state_province',
		//'country_id',
		array(
            'name' => 'Country',
            'value' => Countries::Model()->FindByPk($model->country_id)->country_name
        ),
		'zip_code',
		'interested_in',
		'bank_name',
		'bank_bsb',
		'bank_account'
		//'created_at',
		//'updated_at',
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
  
