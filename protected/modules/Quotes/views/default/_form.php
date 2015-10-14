<?php
/* @var $this QuotesController */
/* @var $model Quotes */
/* @var $form CActiveForm */
?>

<div class="col-md-12">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'quotes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->
	<?php echo $form->errorSummary($model); ?>
	
	 <div class="table-responsive">
                <table class="table table-bordered mb30 create_quote_table">
                  <tbody>

   
        <tr>
                      <th><?php echo $form->labelEx($model,'service_id',array('class'=>'col-sm-5')); ?></th>
                      <td>
					  <div class="createselect mr30">
					<?php echo $form->dropDownList($model, 'service_id', CHtml::listData(Service::model()->findAll(), 'id', 'service_name'),array('class'=>'form-control')); ?>
                          <?php echo $form->error($model,'service_id'); ?>
                      </div>

					  </td>
						
                    </tr>
				  
		
                
		

<?php 

	$companies_options = array();
	$companies_options[''] = "--Please select Company--";
	
		
				$criteria = new CDbCriteria();
				$criteria->select = "id,name";
                                $criteria->condition = $this->where_agent_condition;
				$criteria->order = 'name';                                
				$loop_contacts = Company::model()->findAll($criteria);
				
				foreach ($loop_contacts as $value)  {			
				$companies_options[$value->id] =  $value->name; 
				}


?>					

				  
				  
                    <tr>
                      <th><span><?php echo $form->labelEx($model,'company_id',array('class'=>'col-sm-5')); ?></th>
                      <td>
					  <div class="createselect mr30">
					<?php echo $form->dropDownList($model, 'company_id', $companies_options ,array('onchange' => 'return FindCompaniesContacts(this.value);','class'=>'form-control')); ?>
                          <?php echo $form->error($model,'company_id'); ?>
                      </div>
                      <a target="_blank" href="<?php echo $this->user_role_base_url; ?>?r=Company/default/create" title="Create new company">Create new company</a>
					  </td>
						
                    </tr>
					


<?php 

	$contacts_options = array();
	$contacts_options[''] = "--Please select Contact--";
	
	if(isset($model->company_id) && !empty($model->company_id)) { 
				$selected_company_id = $model->company_id;
				
				$criteria = new CDbCriteria();
				$criteria->select = "id,first_name,surname,mobile";
				$criteria->condition = "company_id =:company_id && $this->where_agent_condition";
				$criteria->params = array(':company_id' => $selected_company_id);
				$criteria->order = 'first_name';
				$loop_contacts = Contact::model()->findAll($criteria);
				
				foreach ($loop_contacts as $value)  {			
				$contacts_options[$value->id] =  $value->first_name.' '.$value->surname.' (mobile-'.$value->mobile.')'; 
				}

	}


?>					
					
                    <tr>
                      <th><?php echo $form->labelEx($model,'contact_id',array('class'=>'col-sm-5')); ?></th>
                      <td>
					  	<div class="createselect mr30">
					  
<?php echo $form->dropDownList($model, 'contact_id',$contacts_options,array('onchange' => 'return FindContactSites(this.value);','class'=>'form-control','id' => 'company_contacts') ); ?>						  
                      <?php echo $form->error($model,'contact_id'); ?>
                      </div>
                      <a target="_blank" href="<?php echo $this->user_role_base_url; ?>?r=Contact/default/create" title="Create new contact">Create new contact</a>
                      </td>
                      
					</tr>
                    
<?php



	$sites_options = array();
	$sites_options[''] = "--Please select Site--";
	
	
		if(isset($model->contact_id) && !empty($model->site_id)) { 
				$selected_contact_id = $model->contact_id;
				
		$site_ids = array();
		$Criteria_sites = new CDbCriteria();
		$Criteria_sites->condition = "contact_id = $selected_contact_id && $this->where_agent_condition";
		$SiteContactRelation_model = SiteContactRelation::model()->findAll($Criteria_sites); // find related buildings by quote id
		foreach($SiteContactRelation_model as $Row) {
		$site_ids[] = $Row->site_id;
		}
		
		
        $criteria = new CDbCriteria();
        $criteria->select = "id,site_name";
        $criteria->addInCondition('id', $site_ids); // in condition$criteria->order = 'site_name';
        $loop_sites = ContactsSite::model()->findAll($criteria);


				foreach ($loop_sites as $value)  {			
				$sites_options[$value->id] =  $value->site_name; 
				}

	}

	

?>					
					
					<tr>
                      <th><?php echo $form->labelEx($model,'site_id',array('class'=>'col-sm-5')); ?></th>
                      <td>
					  	<div class="createselect mr30">
<?php echo $form->dropDownList($model, 'site_id',$sites_options,array('onchange' => 'return FindSiteBuildings(this.value);','class'=>'form-control','id' => 'contact_sites') ); ?>						  
                      <?php echo $form->error($model,'site_id'); ?>
                      </div>
                      <a target="_blank" href="<?php echo $this->user_role_base_url; ?>?r=ContactsSite/default/create" title="Create new site">Create new site</a>
                      </td>
 </tr>
                   


<?php		if(isset($model->site_id) && !empty($model->site_id)) { 
				$selected_site_id = $model->site_id;
				
				$criteria = new CDbCriteria();
				$criteria->select = "id,building_name";
				$criteria->condition = "site_id =:site_id && $this->where_agent_condition";
				$criteria->params = array(':site_id' => $selected_site_id);
				$criteria->order = 'building_name';
				$loop_builings = Buildings::model()->findAll($criteria);
				$site_buildings = isset($_POST['site_buildings']) ? $_POST['site_buildings'] : array();
				$buildings_options='';
				
         foreach ($loop_builings as $value) {
	
			if(in_array($value->id,$site_buildings))
			$checked_yes = 'checked';
			else
			$checked_yes = '';
			
			
            $buildings_options .= '<input '.$checked_yes.' id="building_id'.$value->id.'" type="checkbox" value="'.$value->id.'" name="site_buildings[]">&nbsp;&nbsp;' . $value->building_name.'<br/>';
           }

	}

	

?>					
                      
	  
                   
                    <tr>
                      <th><label> Select Buildings<span class="required"></span></label></th>
                      <td>
					  	<div class="createselect mr30" id="site_buildings">                   	
						<?php if(isset($buildings_options)) echo $buildings_options; ?>							
						 </div>						
                         <a target="_blank" href="<?php echo $this->user_role_base_url; ?>?r=Buildings/default/create" title="Create new building">Create new building</a>
						 
 <?php if(isset($site_building_error_msg) && ! empty($site_building_error_msg))
		echo "<br/><div class='errorMessage'>".$site_building_error_msg.'</div>';
 ?>
						 
                        </td>
						
                    </tr>
                   
		

		
		

			

         <tr>
                      <th><?php echo $form->labelEx($model,'quote_date',array('class'=>'col-sm-5')); ?></th>
                      <td>
                      <div class="createselect mr30">
                      	

<?php
$this->widget(
    'ext.jui.EJuiDateTimePicker',
    array(
        'model'     => $model,
        'attribute' => 'quote_date',
		'mode'    => 'date',
		'htmlOptions' => array(
                    'class' => 'form-control',
                ),
        'options'   => array(
        'dateFormat' => 'yy-mm-dd',
        'showAnim'=>'fadeIn',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
        'changeMonth'=>true,
        'changeYear'=>true,
        'yearRange'=> date("Y").':'.(date("Y")+5),
        'minDate' => date("Y-m-d", strtotime("-1 month",  strtotime(date("Y-m-d")))),   
       
        ),
    )
);
?>						
						
                       <?php echo $form->error($model,'quote_date'); ?>
                       </div>
                      </td>
					 
         </tr>

				
                    <tr>
                      <td colspan="2" align="center"><!--<a href="#" class="btn btn-primary">Continue</a> or <a href="javascript:history.back()" class="btn">Back</a>-->
                        
                        <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
	</div>

                       
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- table-responsive --> 
			  



<?php $this->endWidget(); ?>

</div><!-- form -->


<script type="text/javascript" >

function FindCompaniesContacts(company_id) {

  $("#company_contacts").html('<option value="">--Please select Contact--</options>');
  $("#contact_sites").html('<option value="">--Please select Site--</options>');
  $("#site_buildings").html('');
  
      $.ajax(
                {
                    url: "?r=Quotes/default/FindCompaniesContacts",
					type : 'post',
					data:'company_id='+company_id,
                    dataType: "html",
                    success: function (data)
                    {
						$("#company_contacts").html(data);
                    }

               });



}

function FindContactSites(contact_id) {

	$("#contact_sites").html('<option value="">--Please select Site--</options>');
	$("#site_buildings").html('');
    
  $.ajax(
                {
                    url: "?r=Quotes/default/FindContactSites",
					type : 'post',
					data:'contact_id='+contact_id,
                    dataType: "html",
                    success: function (data)
                    {
						$("#contact_sites").html(data);
                    }

               });



}




function FindSiteBuildings(site_id) {

 
 $("#site_buildings").html('');
 
      $.ajax(
                {
                    url: "?r=Quotes/default/FindSiteBuildings",
					type : 'post',
					data:'site_id='+site_id,
                    dataType: "html",
                    success: function (data)
                    {
						$("#site_buildings").html(data);
                    }

               });



}



</script>