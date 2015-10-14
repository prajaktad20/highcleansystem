<?php

/* @var $this QuotesController */
/* @var $model Quotes */

?>
<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
			  <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
			  <li>Change Job Status</li>
            </ul>
            <h4>


<?php echo CHtml::link('Manage Quote Jobs',array('view','id'=>$job_model->quote_id), array("class"=>"btn btn-primary pull-right")); ?>

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
<?php 


$lable_name = '';
$action_name = ''; 

switch($qjobstatus) {

	case 'decline' : $lable_name = 'Decline Job'; $action_name = 'DeclineQuoteJob';  break;
	case 'cancel' : $lable_name = 'Cancel Job'; $action_name = 'CancelQuoteJob'; break;
	case 'delete' : $lable_name = 'Delete Job'; $action_name = 'DeleteQuoteJob';  break;
	case 'default' : throw new CHttpException(404, 'The requested page does not exist.'); break;

}

$actino_url = $this->user_role_base_url . '/?r=Quotes/default/'.$action_name.'&job_id=' . $job_model->id;

?>

                <h2><?php echo $lable_name.' - '.$job_model->id; ?></h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">

<form method="POST" action="<?php echo $actino_url; ?>">
<input type="hidden" name="job_id" value="<?php echo $job_model->id; ?>">
<?php echo "Are you sure ? You want to $lable_name - $job_model->id"; ?>. &nbsp;&nbsp;&nbsp; <input type="submit" class="btn btn-danger" value="<?php echo $lable_name; ?>">
</form>

</div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
