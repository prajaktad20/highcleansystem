<div class="modal-header">

          <h3 class="text-center">Login - Service Managment System</h3>
      </div>
      <div class="modal-body">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array(
        'class'=>'form col-md-12 center-block',
    ),
)); ?>

	
	<div class="form-group">
		<?php //echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('class'=>"form-control input-lg", 'placeholder'=>"Username OR Email")); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="form-group">
		<?php //echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('class'=>"form-control input-lg", 'placeholder'=>"Password")); ?>
		<?php echo $form->error($model,'password'); ?>
		
	</div>

	<div class="form-group">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="form-group">
		<?php echo CHtml::submitButton('Login',array('class'=>"btn btn-primary btn-lg btn-block")); ?>
	</div>



	<div class="form-group">
		<div class="pull-left">
			<div class="ckbox ckbox-primary mt10">
			    <a href="<?php echo $this->user_role_base_url; ?>?r=site/reset">Forgot Password</a>
			</div>
		</div>
	</div>

	<div style="clear:both"></div>

<?php $this->endWidget(); ?>

</div>
      <div class="modal-footer">
          
      </div>
