<?php
/* @var $this TimesheetPayDatesController */
/* @var $model TimesheetPayDates */

?>


     <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
               <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=TimesheetPayDates/default/admin">Timesheet Pay Dates</a></li>
              <li>Manage Timesheet Pay Dates</li>
            </ul>

          </div>
        </div>
        <!-- media --> 
      </div>
      <div class="contentpanel">

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

        <div class="row">
          <div class="col-md-12 user_section">
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2>Timesheet Pay Dates Management</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'timesheet-pay-dates-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->hiddenField($TimesheetPayDates_model,'pay_date',array('readonly'=>true,'size'=>60,'maxlength'=>255,'class'=>'form-control','id'=>'pay_date','value'=>$next_date['pay_date'])); ?>	
    	<?php echo $form->hiddenField($TimesheetPayDates_model,'payment_start_date',array('readonly'=>true,'size'=>60,'maxlength'=>255,'class'=>'form-control','id'=>'payment_start_date','value'=>$next_date['payment_start_date'])); ?>
    	<?php echo $form->hiddenField($TimesheetPayDates_model,'payment_end_date',array('readonly'=>true,'size'=>60,'maxlength'=>255,'class'=>'form-control','id'=>'payment_end_date','value'=>$next_date['payment_end_date'])); ?>
	

	
	<?php echo CHtml::submitButton('Add Next Payment Date',array('class'=>'btn btn-primary mr5')); ?>
	

		<?php $this->endWidget(); ?>	 
<?php 

// CgridView Records/page
$pageSize = Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'timesheet-pay-dates-grid',
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'dataProvider'=>$model->search(),
//	'filter'=>$model,
	'columns'=>array(
	

			
	
	array(
                'name'=>'payment_start_date',
                'header'=>'Payment Start Date',
                'headerHtmlOptions'=>array('width'=>'30%','class'=>'head'),
		'value' => 'date("l, F jS, Y",strtotime($data->payment_start_date))'
            ),
				
	
	array(
                'name'=>'payment_end_date',
                'header'=>'Payment End Date',
                'headerHtmlOptions'=>array('width'=>'30%','class'=>'head'),
		'value' => 'date("l, F jS, Y",strtotime($data->payment_end_date))'
            ),
				
	array(
                'name'=>'pay_date',
                'header'=>'Payment Date',
		'htmlOptions'=>array('style'=>'font-weight:bold;color:#5B9BD5 ;'),
                'headerHtmlOptions'=>array('width'=>'40%','class'=>'head'),
		'value' => 'date("l, F jS, Y",strtotime($data->pay_date))'
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
  
