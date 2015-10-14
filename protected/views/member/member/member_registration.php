<style>

    .top_wrepp a{display:inline-block; float:left;}
    .top_wrepp span{display:inline-block; float:right; color:#fff;}



    .modal-header .close{margin-top:-9px;}
    .slidesjs-navigation {
        margin-top:3px;
    }

    .slidesjs-previous {
        margin-right: 5px;
        float: left;
        background:#e4e7ea;
        color:#636e7b;
    }
    .btn {
        border-radius: 3px;
        border-width: 0;
        line-height: 21px;
        padding: 8px 15px;
        transition: all 0.2s ease-out 0s;
    }

    .slidesjs-next {

        float:right;
        background:#428bca;
        border-color: #357ebd;
        color: #fff;
    }

    .slidesjs-pagination {
        display: none;

    }
    .slider_heading{
        padding-bottom: 20px;
        text-align:center;
        border-bottom: 2px solid #ccc;
        font-size:20px;
        line-height:34px;
        margin-bottom:15px;
    }

    a.btn {margin-bottom:10px;}
    a{text-decoration:none;}

    .slidesjs-container{height:410px !important; width:100% !important; position:static;   border:1px solid #000; padding:0 10px;}
    .slidesjs-control{top:28px; width:100% !important; min-height:371px !important; height:100% !important;}
    #close_slide_photos {
        position: relative;
        top: -20px;
        right: -71px;
    }    
    .slidesjs-slide{min-height:365px !important; height:90% !important;}

    .slider_wrapper {border-top:1px solid #ccc; margin-top:15px; margin:0 auto; max-width:600px; width:100%;}
    #slides{padding-top:21px;}
    /* For tablets & smart phones */
    @media (max-width: 767px) {

        .slider_wrapper {
            width: auto
        }
    }

    /* For smartphones */
    @media (max-width: 480px) {
        .slider_wrapper {
            width: auto
        }
    }

    /* For smaller displays like laptops */
    @media (min-width: 768px) and (max-width: 979px) {
        .slider_wrapper {
            width: 724px
        }
    }

    /* For larger displays 
    @media (min-width: 1200px) {
      .slider_wrapper {
        max-width: 980px;
                width:100%;
                background:#fff;
                padding:10px;
      }*/
    }
</style>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.slides.min.js'); ?>

<div class="row top_wrepp">
    <div class="col-md-6 col-sm-4 col-xs-6 col-mb-12">
       <!-- <a href="http://highclean.com.au/"><img src="<?php //echo Yii::app()->getBaseUrl(true); ?>/images/logo_new.png"/></a>-->
	   
	   <?php 

            $path = Yii::app()->basePath . '/../uploads/service-agent-logos/thumbs/';
            if (isset($agent_model->logo) && $agent_model->logo != NULL && file_exists($path . $agent_model->logo)) {
                $img_src = Yii::app()->getBaseUrl(true) . '/uploads/service-agent-logos/thumbs/' . $agent_model->logo;
                $left_header_title = '<img src="'.$img_src.'" title="'.$agent_model->business_name.'" style="width:100%"> ';
            } else {
                $left_header_title = '<span style="font-size:16px;">' . $agent_model->business_name . '</span>';               
            } 
     
?>

<a href="http://highclean.com.au/"><?php echo $left_header_title; ?></a>

    </div>
    <div class="col-md-6 col-sm-8 col-xs-6 col-mb-12">
       <!--<span>
            High Clean Pty Ltd<br />
            E: info@highclean.com.au<br />
            A: 1/92 Railway St South, Altona VIC 3018<br />
            T: 03 8398 0804
        </span>-->
		<span>
	<?php
		$complete_address_text = '';

			if(!empty($agent_model->business_name)){
			$complete_address_text .=  $agent_model->business_name.'<br/>';
			}

			$concat_business_address = '';
			
			if(!empty($agent_model->street))
			$concat_business_address .= $agent_model->street.'<br/>';
			
			if(!empty($agent_model->city))
			$concat_business_address .= $agent_model->city;			
			
			if(!empty($agent_model->state_province))
			$concat_business_address .= ', '.$agent_model->state_province;
			
			if(!empty($agent_model->zip_code))
			$concat_business_address .= ' '.$agent_model->zip_code;
			
			if(!empty($agent_model->business_email_address)){
			$complete_address_text .=  'E: <a href="mailto:'.$agent_model->business_email_address.'" target="_blank" style="color:#fff;float:right;">'.$agent_model->business_email_address.'</a>'.'<br/>';
			}
			
			if(!empty($concat_business_address)){
			$complete_address_text .=  'A: '.$concat_business_address.'<br/>';
			}

			if(!empty($agent_model->phone)){
			$complete_address_text .=  'T: '.$agent_model->phone.'<br/>';
			}

		echo $complete_address_text;
?>	
		</span>
		
		
    </div>    
</div>
<div class="pageheader">

    <div class="media">

        <div class="media-body">

            <h4 align="center">Staff Registration</h4>			
			
        </div>

    </div>

    <!-- media --> 

</div>



<div class="contentpanel">


<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<?php 

$group_option = array();

$Criteria = new CDbCriteria();
$Criteria->addInCondition("id",array(3,6));
$loop_group = Group::model()->findAll($Criteria);

foreach ($loop_group as $value)  {			
	$group_option[$value->id] =  $value->role; 
}


?>

<?php echo $form->errorSummary($model); ?>

<div class="col-md-12">

<!--- Main Details left side section ----->
<div class="col-md-5 mr100">
<div class="form-group">		
		<div class="col-sm-12" style="color:#FC8B2F;">
		 <strong>Main Details : </strong>
		</div>		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Upload Photo',array('class'=>'col-sm-5')); ?>
		 <div class="col-sm-7">
		 <?php echo CHtml::activeFileField($model, 'Avatar'); ?>
		</div>
		<?php echo $form->error($model,'Avatar'); ?>
	</div>
	

	<div class="form-group">
		<?php echo $form->labelEx($model,'first_name',array('class'=>'col-sm-5')); ?>
		 <div class="col-sm-7">
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		
		<?php echo $form->error($model,'first_name'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'last_name',array('class'=>'col-sm-5')); ?>
		 <div class="col-sm-7">
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>

		<?php echo $form->error($model,'last_name'); ?>
				</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'username',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'username'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'password',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'password'); ?>
	    </div>

	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'email',array('readonly'=>true,'value'=>$hireStaffModel->email,'size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'email'); ?>
		</div>
		
	</div>

	
	<!--<div class="form-group">
		<?php echo $form->labelEx($model,'role_id',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->dropDownList($model, 'role_id', CHtml::listData(Group::model()->findAll(), 'id', 'role'),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'role_id'); ?>
		</div>		
	</div>-->
	
	
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'gender',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		 <?php echo $form->dropDownList($model, 'gender', array("Male" => "Male", "Female" => "Female", "UnKnown" => "UnKnown"),array('class'=>'form-control')); ?>		
		 <?php echo $form->error($model,'gender'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'date_of_birth',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
	<?php
$this->widget(
    'ext.jui.EJuiDateTimePicker',
    array(
        'model'     => $model,
        'attribute' => 'date_of_birth',
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

<?php echo $form->error($model,'date_of_birth'); ?>
		</div>
		
	</div>


<div class="form-group">
		<?php echo $form->labelEx($model,'street',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'street',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'street'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'city',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'city'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'state_province',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'state_province',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'state_province'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'country_id',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->dropDownList($model, 'country_id', CHtml::listData(Countries::model()->findAll(), 'id', 'country_name'),array('options'=>array('15'=>array('selected'=>'selected')),'class'=>'form-control')); ?>
		<?php echo $form->error($model,'country_id'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'zip_code',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'zip_code',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'zip_code'); ?>
		</div>
		
	</div>




</div>

<!-- Main details right side section --->
<div class="col-md-5">

	
	<div class="form-group">
		<?php echo $form->labelEx($model,'home_phone',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'home_phone',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'home_phone'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'mobile_phone',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'mobile_phone',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'mobile_phone'); ?>
		</div>
	</div>
	
	

	<div class="form-group" >
	<?php echo $form->labelEx($model, 'marital_status',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
	<?php echo $form->dropDownList($model, 'marital_status', array("Single" => "Single", "In Relationship'" => "In Relationship", "Married" => "Married"),array('class'=>'form-control')); ?>		
	<?php echo $form->error($model, 'marital_status'); ?>
	</div>
	</div>


	<div class="form-group" >
	<?php echo $form->labelEx($model, 'australian_citizen',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
	<?php echo $form->dropDownList($model, 'australian_citizen', array("Yes" => "Yes", "No" => "No"),array('class'=>'form-control')); ?>
	<?php echo $form->error($model, 'australian_citizen'); ?>
	</div>
	</div>


	<div class="form-group" >
	<?php echo $form->labelEx($model, 'australian_resident',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
	<?php echo $form->dropDownList($model, 'australian_resident', array("Yes" => "Yes", "No" => "No"),array('class'=>'form-control')); ?>
	<?php echo $form->error($model, 'australian_resident'); ?>
	</div>
	</div>


	<div class="form-group">
		<?php echo $form->labelEx($model,'passport_number',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'passport_number',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'passport_number'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'visa_number',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'visa_number',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'visa_number'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'driving_licence',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'driving_licence',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'driving_licence'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'driving_licence_state',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'driving_licence_state',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'driving_licence_state'); ?>
		</div>		
	</div>


	<div class="form-group">
		<?php echo $form->labelEx($model,'interested_in',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->radioButtonList($model,'interested_in',array('Product Sales'=>'Product Sales', 'Cleaning Services'=>'Cleaning Services'),array('size'=>17,'maxlength'=>17,'class'=>'')); ?>
		<?php echo $form->error($model,'interested_in'); ?>
		</div>
		
	</div>
		

	<?php if(Yii::app()->user->name==='admin') {  ?>
	<div class="form-group">
		<?php echo $form->labelEx($model,'view_jobs',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">		
		<?php echo $form->checkBox($model,'view_jobs',array('size'=>1,'maxlength'=>1,'class'=>'')); ?>
		<?php echo $form->error($model,'view_jobs'); ?>
		</div>
		
	</div>
	<?php  } ?>
	


	<?php if(Yii::app()->user->name == 'admin' || Yii::app()->user->name == 'supervisor' ) { ?>
	<div class="form-group" >
	<?php echo $form->labelEx($model, 'status',array('class'=>'col-sm-5')); ?>
	<div class="col-sm-7">
	<?php echo $form->dropDownList($model, 'status', array("1" => "Active", "0" => "Inactive"),array('class'=>'form-control')); ?>		
	<?php echo $form->error($model, 'status'); ?>
	</div>
	</div>
	<?php } ?>					



</div>

</div>
<br/>
<div class="clear"></div>
<div class="col-md-12">

<!--- Emergency contact details left side section ----->
<div class="col-md-5 mr100">
<div class="form-group">
		<div class="col-sm-12" style="color:#FC8B2F;">
		<strong >Emergency Contact Details : </strong>	
		</div>		
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'em_first_name',array('class'=>'col-sm-5')); ?>
		 <div class="col-sm-7">
		<?php echo $form->textField($model,'em_first_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'em_first_name'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'em_last_name',array('class'=>'col-sm-5')); ?>
		 <div class="col-sm-7">
		<?php echo $form->textField($model,'em_last_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'em_last_name'); ?>
		</div>
	</div>


	<div class="form-group">
		<?php echo $form->labelEx($model,'em_address',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'em_address',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'em_address'); ?>
		</div>
	</div>



	<div class="form-group">
		<?php echo $form->labelEx($model,'em_superb',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'em_superb',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'em_superb'); ?>
		</div>
	</div>



	<div class="form-group">
		<?php echo $form->labelEx($model,'em_state',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'em_state',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'em_state'); ?>
		</div>
	</div>



	<div class="form-group">
		<?php echo $form->labelEx($model,'em_postcode',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'em_postcode',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'em_postcode'); ?>
		</div>
	</div>


	<div class="form-group">
		<?php echo $form->labelEx($model,'em_phone',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'em_phone',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'em_phone'); ?>
		</div>
	</div>


	<div class="form-group">
		<?php echo $form->labelEx($model,'em_mobile',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'em_mobile',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'em_mobile'); ?>
		</div>
	</div>


	<div class="form-group">
		<?php echo $form->labelEx($model,'em_email',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'em_email',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'em_email'); ?>
		</div>
	</div>


	<div class="form-group">
		<?php echo $form->labelEx($model,'em_relationship_with_user',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'em_relationship_with_user',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'em_relationship_with_user'); ?>
		</div>
	</div>
</div>

<!--- Payrole details right side section ----->
<div class="col-md-5">

		<div class="form-group">
		<div class="col-sm-12" style="color:#FC8B2F;">
		<strong>Pay Roll Details : </strong>	
		</div>		
	</div>

<div class="form-group">
		<?php echo $form->labelEx($model,'superannuation_company',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'superannuation_company',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'superannuation_company'); ?>
		</div>
	</div>



<div class="form-group">
		<?php echo $form->labelEx($model,'superannuation_number',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'superannuation_number',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'superannuation_number'); ?>
		</div>
	</div>



<div class="form-group">
		<?php echo $form->labelEx($model,'tax_file_number',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'tax_file_number',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'tax_file_number'); ?>
		</div>
	</div>

<?php if(Yii::app()->user->name == 'admin') { ?>
		
	<div class="form-group">
		<?php echo $form->labelEx($model,'regular_hours',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'regular_hours',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'regular_hours'); ?>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'overtime_hours',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'overtime_hours',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'overtime_hours'); ?>
		</div>
		
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'double_time_hours',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'double_time_hours',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'double_time_hours'); ?>
		</div>
		
	</div>
	<?php } ?>
	


</div>


<div class="col-md-5">

		<div class="form-group">
		<div class="col-sm-12" style="color:#FC8B2F;">
		<strong>Bank Account Details : </strong>	
		</div>		
	</div>

<div class="form-group">
		<?php echo $form->labelEx($model,'bank_name',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'bank_name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'bank_name'); ?>
		</div>
	</div>



<div class="form-group">
		<?php echo $form->labelEx($model,'bank_bsb',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'bank_bsb',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'bank_bsb'); ?>
		</div>
	</div>



<div class="form-group">
		<?php echo $form->labelEx($model,'bank_account',array('class'=>'col-sm-5')); ?>
		<div class="col-sm-7">
		<?php echo $form->textField($model,'bank_account',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'bank_account'); ?>
		</div>
	</div>


</div>

</div>



<div class="col-md-12" align="center">
		<?php echo CHtml::submitButton('Save',array('class'=>'btn btn-primary mr5')); ?>
</div>

<?php $this->endWidget(); ?>


</div>

<!--- Content Panel --->


