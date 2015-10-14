<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>


<?php
/* @var $this SystemOwnerController */
/* @var $model SystemOwner */


?>

<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
         	 <li>Manage System Owner</li>
            </ul>
         <h4><?php echo CHtml::link(
                Yii::t("SystemOwner.MyPersonalDetails", "Manage"),
                array("MyPersonalDetails"),
                array("class"=>"btn btn-primary pull-right")
 ); ?></h4>
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
          <div class="col-md-12 quote_section">        
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2>Update System Owner</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
			   <div class="col-md-12 pull-right mb10 pr0" style="text-align:right">

</div>


 <div class="contentpanel">
        <div class="row">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'system-owner-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'first_name',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
		<?php echo $form->textField($model,'first_name',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>	</div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'last_name',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
		<?php echo $form->textField($model,'last_name',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>	</div>

	<div class="form-group" >
		<?php echo $form->labelEx($model,'username',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
		<?php echo $form->textField($model,'username',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>	</div>


	<div class="form-group" >
		<?php echo $form->labelEx($model,'email',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
		<?php echo $form->textField($model,'email',array('size'=>60,'class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>	</div>

	<div class="form-group" >
	<?php echo $form->labelEx($model, 'status',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
	<?php echo $form->dropDownList($model, 'status', array("1" => "Active", "0" => "Inactive"),array('class'=>'form-control')); ?>		
	<?php echo $form->error($model, 'status'); ?>
	</div>
	</div>

<div class="col-md-12" align="center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary mr5')); ?>
		<a href="<?php echo $this->user_role_base_url.'/?r=SystemOwner/default/admin'; ?>" class="btn btn-primary">Cancel</a> 
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

</div></div>


</div>
              <!-- table-responsive --> 
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
