<?php
/* @var $this StateManagerController */
/* @var $model StateManager */
/* @var $form CActiveForm */
?>

<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
               <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
			  <li>Change Password</li>
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
              <div class="panel-body titlebar"> <span class="fa fa-pencil"></span>
                <h2>Change Password (<?php echo $state_model->first_name.'&nbsp;'.$state_model->last_name; ?>)</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">


<div class="col-md-12">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'agent-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	
)); ?>


	<?php echo $form->errorSummary($model); ?>
 <div class="col-md-5 mr100">



	<div class="form-group">
		<?php echo $form->labelEx($model,'password',array('class'=>'col-sm-5')); ?>
		 <div class="col-sm-7">
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		
		<?php echo $form->error($model,'password'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'confirm_password',array('class'=>'col-sm-5')); ?>
		 <div class="col-sm-7">
		<?php echo $form->passwordField($model,'confirm_password',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>

		<?php echo $form->error($model,'confirm_password'); ?>
				</div>
	</div>



</div>
	  <div class="col-md-12" >
		<?php echo CHtml::submitButton('Change Password',array('class'=>'btn btn-primary mr5')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


		   </div>
              <!-- table-responsive --> 
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
