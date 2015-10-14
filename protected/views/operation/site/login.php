<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>




	<div class="row">
		 <div class="input-group mb15">
         <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		<?php echo $form->textField($model,'username',array('class'=>'form-control', 'placeholder'=>'Email Address')); ?>
		</div>
	<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
	<div class="input-group mb15">
         <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		<?php echo $form->passwordField($model,'password',array('class'=>'form-control', 'placeholder'=>'Password')); ?>
		</div>
		<?php echo $form->error($model,'password'); ?>
	</div>



	    
                        <div class="clearfix">
                            <div class="pull-left">
                                <div class="ckbox ckbox-primary mt10">
                                    <a href="<?php echo $this->user_role_base_url; ?>?r=site/reset">Forgot Password</a>
                                </div>
                            </div>
                            <div class="pull-right">                                
								<?php echo CHtml::submitButton('Login',array('class' => 'btn btn-success')); ?>
                            </div>
                        </div> 
	
	


<?php $this->endWidget(); ?>
</div>
