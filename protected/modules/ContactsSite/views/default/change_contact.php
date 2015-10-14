<?php
/* @var $this ContactsSiteController */
/* @var $model ContactsSite */

?>
 <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=ContactsSite/default/admin">Sites</a></li>
			  <li>Change Contact</li>
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
                <h2><?php echo $model->site_name; ?> : Change Contact</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">

<?php
/* @var $this ContactsSiteController */
/* @var $model ContactsSite */
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

	<?php echo $form->errorSummary($model); ?>

	
<?php


				
				$criteria = new CDbCriteria();
				$criteria->select = "id,first_name,surname,mobile";
				$criteria->order = 'first_name';
				$loop_contacts = Contact::model()->findAll($criteria);
				
				foreach ($loop_contacts as $value)  {			
				$contacts_options[$value->id] =  $value->first_name.' '.$value->surname.' (mobile-'.$value->mobile.')'; 
				}




?>
	
	
	<div class="form-group">
		<strong class="col-sm-5">Change Contacts</strong>
		<div class="col-sm-7">
		<?php
		
		foreach($contacts_options as $key=>$value) { ?>
		<input <?php if(isset($last_selected_contact_ids) && count($last_selected_contact_ids) > 0 && in_array($key,$last_selected_contact_ids)) echo 'checked'; ?> type="checkbox" name="contact_ids[]" value="<?php echo $key; ?>">&nbsp;&nbsp;<?php echo $value; ?><br/>
		<?php }
		
		?>
		
	<?php
	if(isset($contact_ids_error_msg) && !empty($contact_ids_error_msg)) echo $contact_ids_error_msg;
	?>
		</div>
		
	</div>


	<div class="row buttons" align="center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
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