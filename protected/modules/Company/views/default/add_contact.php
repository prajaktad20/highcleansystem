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
              <li>Add New Contact</li>
            </ul>
            <h4><?php echo CHtml::link(
                Yii::t("Company.admin", "Manage"),
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
                <h2><?php echo Company::Model()->FindByPk($model->id)->name;  ?> : Add New Contact</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">

<?php
/* @var $this ContactController */
/* @var $model Contact */
/* @var $form CActiveForm */
?>

<div class="col-sm-7">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($contact_model); ?>


	<div class="form-group">
		<?php echo $form->labelEx($contact_model,'first_name',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($contact_model,'first_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($contact_model,'first_name'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($contact_model,'surname',array('class'=>'col-sm-5')); ?>
			<div class="col-sm-7">
		<?php echo $form->textField($contact_model,'surname',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($contact_model,'surname'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($contact_model,'address',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textArea($contact_model,'address',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?>
		<?php echo $form->error($contact_model,'address'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($contact_model,'suburb',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($contact_model,'suburb',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($contact_model,'suburb'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($contact_model,'state',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($contact_model,'state',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($contact_model,'state'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($contact_model,'postcode',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($contact_model,'postcode',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($contact_model,'postcode'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($contact_model,'phone',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($contact_model,'phone',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($contact_model,'phone'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($contact_model,'mobile',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($contact_model,'mobile',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($contact_model,'mobile'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($contact_model,'email',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($contact_model,'email',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($contact_model,'email'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($contact_model,'position',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($contact_model,'position',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($contact_model,'position'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($contact_model,'no_of_sites_managed',array('class'=>'col-sm-5')); ?>
			<div class="col-sm-7">
		<?php echo $form->textField($contact_model,'no_of_sites_managed',array('class'=>'form-control')); ?>
		<?php echo $form->error($contact_model,'no_of_sites_managed'); ?>
	    </div>
		
	</div>

	<div class="row buttons" align="center">
		<?php echo CHtml::submitButton($contact_model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
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