

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'resetbusiness-account-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	 'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

 <?php //echo $form->errorSummary(array($model)); ?>

<div class="col-md-5">
     


        <div class="control-group">
                      <?php echo $form->labelEx($model,'password', array('class'=>'control-label')); ?>

                    <div class="controls">
                      
                       <?php echo $form->passwordField($model,'password',array('size'=>60,'class'=>'form-control')); ?>
                        <?php echo $form->error($model,'password'); ?>
                    </div>

                </div>

        <div class="control-group">
                      <?php echo $form->labelEx($model,'confirm_password', array('class'=>'control-label')); ?>

                    <div class="controls">
                         <?php echo $form->passwordField($model,'confirm_password',array('size'=>60,'class'=>'form-control')); ?>
                        <?php echo $form->error($model,'confirm_password'); ?>
                    </div>

                </div>

                <div class="clear">&nbsp;</div>

                <div class="control-group total">
                    <div class="control-group buynow">
                        <label class="control-label"></label>
                        <div class="controls">
                            <?php echo CHtml::submitButton( 'Reset Account' , array('class' => 'btn btn-primary')); ?>




                        </div>
                    </div>
                </div>
</div>

 <?php $this->endWidget(); ?>


