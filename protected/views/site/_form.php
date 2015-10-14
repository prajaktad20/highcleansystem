
<section class="container">
<div class="chekout_form contactus_form">
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'business-sign-up-checkouto-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	 'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

 <?php //echo $form->errorSummary(array($model)); ?>

<div class="col-md-5">
  <h2 class="contact">Password reset request</h2>
 
      <?php if(isset ($msg) &&  $msg!=null) {

    
     if($msg==1)
     echo "<div class='alert alert-success'>Well done! We have sent a password reset link to your mail. Please click on the reset link to create a new password.</div>" ;
     if($msg==2)
     echo "<div class='alert alert-danger'>Your temporary code has expired. You will need to resubmit the password reset request</div>" ;
          } ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'email', array('class'=>'control-label')); ?>
                    <div class="controls">
                    <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
                        <?php echo $form->error($model,'email'); ?>
                    </div>
                </div>

     <div class="clear">&nbsp;</div>

                <div class="control-group total">
                    <div class="control-group buynow">
                        <label class="control-label"></label>
                        <div class="controls">
                         <?php echo CHtml::submitButton('Request', array('class' => 'btn btn-primary')); ?>
                        </div>
                    </div>
                </div>
</div>

 <?php $this->endWidget(); ?>
 
</div><!-- form -->
</div>
</section>

