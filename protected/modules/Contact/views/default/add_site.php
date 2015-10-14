<?php
/* @var $this ContactController */
/* @var $model Contact */

?>
<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Contact/default/admin">Contacts</a></li>
              <li>Add New Site</li>
            </ul>
            <h4><?php echo CHtml::link(
                Yii::t("Contact.admin", "Manage"),
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
                <h2><?php echo Contact::Model()->FindByPk($model->id)->first_name.' '.Contact::Model()->FindByPk($model->id)->surname;  ?> : Add Site</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">

<?php
/* @var $this ContactsSiteController */
/* @var $site_model ContactsSite */
/* @var $form CActiveForm */
?>

<div class="col-md-6 mb20">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contacts-site-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($site_model); ?>


	<div class="form-group">
		<?php echo $form->labelEx($site_model,'site_name',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($site_model,'site_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($site_model,'site_name'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($site_model,'site_id',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($site_model,'site_id',array('class'=>'form-control')); ?>
		<?php echo $form->error($site_model,'site_id'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($site_model,'address',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textArea($site_model,'address',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?>
		<?php echo $form->error($site_model,'address'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($site_model,'suburb',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($site_model,'suburb',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($site_model,'suburb'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($site_model,'state',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($site_model,'state',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($site_model,'state'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($site_model,'postcode',array('class'=>'col-sm-5')); ?>
			<div class="col-sm-7">
		<?php echo $form->textField($site_model,'postcode',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($site_model,'postcode'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($site_model,'phone',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($site_model,'phone',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($site_model,'phone'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($site_model,'mobile',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($site_model,'mobile',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($site_model,'mobile'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($site_model,'email',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($site_model,'email',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($site_model,'email'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($site_model,'site_contact',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($site_model,'site_contact',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($site_model,'site_contact'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($site_model,'site_comments',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($site_model,'site_comments',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($site_model,'site_comments'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($site_model,'how_many_buildings',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($site_model,'how_many_buildings',array('class'=>'form-control')); ?>
		<?php echo $form->error($site_model,'how_many_buildings'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($site_model,'need_induction',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->radioButtonList($site_model,'need_induction',array('1'=>'Yes', '0'=>'No'),array('size'=>17,'maxlength'=>17,'class'=>'')); ?>
		<?php echo $form->error($site_model,'need_induction'); ?>
		</div>
		
	</div>

	

	<div class="row buttons" align="center">
		<?php echo CHtml::submitButton($site_model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
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