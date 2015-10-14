<?php
/* @var $this InductionController */
/* @var $model Induction */

?>


<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i></a></li>
			  <li><a href="<?php echo $this->user_role_base_url; ?>?r=User/default/admin">Users</a></li>
              <li>View Induction</li>
            </ul>
            <h4><?php echo CHtml::link(
                Yii::t("Induction.admin", "Manage"),
                array("admin"),
                array("class"=>"btn btn-primary pull-right")
 ); ?></h4>
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
                <h2>View Induction</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		array(
            'name' => 'User',
            'value' => User::Model()->FindByPk($model->user_id)->first_name.' '.User::Model()->FindByPk($model->user_id)->last_name
        ),
		
		array(
            'name' => 'Site Name',
            'value' => ($model->site_id) ? ContactsSite::Model()->FindByPk($model->site_id)->site_name : "All Sites"
        ),
		
		array(
            'name' => 'Induction Type',
            'value' => InductionType::Model()->FindByPk($model->induction_type_id)->name
        ),
		
		array(
            'name' => 'Induction Company',
            'value' => InductionCompany::Model()->FindByPk($model->induction_company_id)->name
        ),
		
		//'induction_link_document',
		
		'induction_link',
		'document',
		'password',
		'completion_date',
		'induction_number',
		'expiry_date',
		'created_at',
	),
)); ?>

			  
			  
	</div>
              <!-- table-responsive --> 
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
	  