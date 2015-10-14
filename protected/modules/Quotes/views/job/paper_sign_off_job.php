<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
			  <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/Job/view&id=<?php echo $model->id; ?>">This Job</a></li>
            </ul>
            <h4>Sign Off Job</h4>
          </div>
        </div>
        <!-- media --> 
</div>
      
      <div class="contentpanel">
	  
	  				
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'buildings-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
		
        <div class="row">
          <div class="col-md-12 quote_section"> 
               <div class="mb20"></div>
                <div class="panel panel-default">
                  <div class="panel-body titlebar">
                    <span class="glyphicon  glyphicon-th"></span>
					<h2>
					Sign Off Job : 3) We have taken signature on paper.
					</h2>
                  </div>
                </div>
		
                <dl class="quotedetaildl col-md-12">
				
				  <?php echo $form->labelEx($model,'client_name',array('class'=> 'col-md-4 clear_lable')); ?>
				  <dd class="col-md-6 mar_top">
				  		<?php echo $form->textField($model,'client_name',array('class'=> 'form-control')); ?>
				  </dd> 
				  <dt class="col-md-4 clear_lable"></dt>				  
                  <dd class="col-md-6">
					<?php echo $form->error($model, 'client_name'); ?>
				  </dd> 
				  
				  
				  
				   
				  
				  <?php echo $form->labelEx($model,'client_date',array('class'=> 'col-md-4 clear_lable')); ?>
				  <dd class="col-md-6 mar_top">
				  		<?php //echo $form->textField($model,'client_date',array('class'=> 'form-control')); ?>
						
						<?php
$this->widget(
    'ext.jui.EJuiDateTimePicker',
    array(
        'model'     => $model,
        'attribute' => 'client_date',
		//'language'=> 'ru',//default Yii::app()->language
        //'mode'    => 'datetime',//'datetime' or 'time' ('datetime' default)
		'mode'    => 'date',
		'htmlOptions' => array(
                    'class' => 'form-control',
                ),
        'options'   => array(
        'dateFormat' => 'yy-mm-dd',
        'showAnim'=>'slideDown',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
        'changeMonth'=>true,
        'changeYear'=>true,
        'yearRange'=>'1930:'.date("Y"),
        //'minDate' => '2000-01-01',      // minimum date
        'maxDate' => date("Y-m-d"),      // maximum date
		
            //'timeFormat' => '',//'hh:mm tt' default
        ),
    )
);
?>
	
						
				  </dd> 
				  <dt class="col-md-4 clear_lable"></dt>				  
                  <dd class="col-md-6 ">
					<?php echo $form->error($model, 'client_date'); ?>
				  </dd> 
				  
				  
				  
				  <?php echo $form->labelEx($model,'client_feedback',array('class'=> 'col-md-4 clear_lable')); ?>
				  <dd class="col-md-6 mar_top">
					<?php echo $form->textArea($model,'client_feedback',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?>
				  </dd> 
				 
				 
				  
				  
				
				  <?php echo $form->labelEx($model,'sign_off_document',array('class'=> 'col-md-4 clear_lable')); ?>
				  <dd class="col-md-6">
					<?php echo CHtml::activeFileField($model, 'sign_off_document',array()); ?>
					<?php echo $form->error($model, 'sign_off_document'); ?>
				  </dd> 
				  
				  <dt class="col-md-4"></dt>				  
                  <dd class="col-md-6">
					  <?php  if(!empty($model->sign_off_document) && file_exists(Yii::app()->basePath.'/..//uploads/sign_off_document/'.$model->sign_off_document)) { ?>
					<a href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/sign_off_document/'.$model->sign_off_document ; ?>" />Sign Off Document</a>						   
				<?php }	?>
					
				  </dd> 
			
			
			  <dt class="col-md-4"></dt>				  
                  <dd class="col-md-6 mar_top">
				<?php echo CHtml::submitButton('Save',array('class'=>'btn btn-primary')); ?> &nbsp; 
				  <a href="<?php echo $this->user_role_base_url.'/?r=Quotes/Job/SignOffView&id='.$model->id; ?>" class="btn btn-primary">Cancel</a> 
			
				  </dd> 
			
			</dl>

                <div class="clearfix"></div>


          </div>
        </div>
		
<?php $this->endWidget(); ?>
		
      </div>
      <!-- contentpanel --> 
   
