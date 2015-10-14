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
             <h4><a href="<?php echo $this->user_role_base_url; ?>?r=StateManager/personal/MyProfileUpdate" class="btn btn-primary pull-right">Edit</a></h4>
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


		'id',
		'first_name',
		'last_name',
		
		
		'email_address',
		
		
		'phone',
		'mobile',
		
		'street',
		'city',
		'state_province',
		'zip_code',
		

            array(
            'name' => 'Status',
            'value' => $model->status ? 'Active' : "Inactive"
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
  
