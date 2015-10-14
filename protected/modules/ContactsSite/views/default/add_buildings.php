<?php
/* @var $this BuildingsController */
/* @var $model Buildings */

?>
<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=ContactsSite/default/admin">Sites</a></li>
			  <li>Add Building Details</li>
            </ul>

<h4><?php echo CHtml::link(
                Yii::t("ContactsSite.admin", "Manage"),
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
                <h2><?php echo ContactsSite::Model()->FindByPk($model->id)->site_name;  ?> : Add New Building</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">

<?php
/* @var $this BuildingsController */
/* @var $model Buildings */
/* @var $form CActiveForm */
?>
<div class="col-md-12">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'buildings-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($buildings_model); ?>
	
<div class="col-md-5 mr100">

	<div class="form-group">
		<?php echo $form->labelEx($buildings_model,'building_name',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($buildings_model,'building_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($buildings_model,'building_name'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($buildings_model,'building_no',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($buildings_model,'building_no',array('class'=>'form-control')); ?>
		<?php echo $form->error($buildings_model,'building_no'); ?>
		</div>
		
	</div>
	
	
	<div class="form-group">
		<?php echo $form->labelEx($buildings_model,'building_type_id',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->dropDownList($buildings_model, 'building_type_id', CHtml::listData(ListBuildingType::model()->findAll(), 'id', 'name'),array('class'=>'form-control')); ?>
		<?php echo $form->error($buildings_model,'building_type_id'); ?>
		</div>
		
	</div>

	

	<div class="form-group">
		<?php echo $form->labelEx($buildings_model,'water_source_availability',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->checkBox($buildings_model,'water_source_availability',array('size'=>1,'maxlength'=>1,'class'=>'')); ?>
		<?php echo $form->error($buildings_model,'water_source_availability'); ?>
		</div>
		
	</div>
</div>
<div class="col-md-5">
	<div class="form-group">
		<?php echo $form->labelEx($buildings_model,'dist_from_office',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($buildings_model,'dist_from_office',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($buildings_model,'dist_from_office'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($buildings_model,'no_of_floors',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($buildings_model,'no_of_floors',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($buildings_model,'no_of_floors'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($buildings_model,'size_of_building',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($buildings_model,'size_of_building',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($buildings_model,'size_of_building'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($buildings_model,'height_of_building',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($buildings_model,'height_of_building',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($buildings_model,'height_of_building'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($buildings_model,'job_notes',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textArea($buildings_model,'job_notes',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?>
		<?php echo $form->error($buildings_model,'job_notes'); ?>
		</div>
		
	</div>

</div>
	<div class="col-sm-12" align="center">
		<?php echo CHtml::submitButton($buildings_model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
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