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
              <li>View Company Details</li>
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
                <h2><?php echo $model->name; ?> : View Company Details</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'name',
		'office_address',
		'office_suburb',
		'mailing_address',
		'mailing_suburb',
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
		//'status',
	),
)); ?>
</div>
              <!-- table-responsive --> 
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
