<?php if($this->IsUsingDevice) { ?>
<style>
body {
    font-size: 10px;    
}
</style>
<?php } ?>

<style>

.modal-dialog {
margin : 50px auto 30px; !important;	
width: 60%; !important;
height: 70%; !important;
}


span.required {
	color:#ff0000;
	}


</style>


<?php
/* @var $this UserController */
/* @var $user_model User */

?>
<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
               <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li>Personal Licenses and Inductions</li>
            </ul>
          </div>
        </div>
        <!-- media --> 
</div>


      <div class="contentpanel">

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>


	   <div class="row">
          <div class="col-md-12 user_section">
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2>User Short Details</h2>
              </div>
            </div>
            <div class="col-md-12">
			

<div class="table-responsive">
 
<table class="table table-bordered mb30 quote_table">
		<thead>
		<tr>
		<th class="head">User Name</th>
		<th class="head">Role</th>
		<th class="head">Gender</th>
		<th class="head">Date Of Birth</th>
		<!--<th class="head">View Jobs</th>-->
		<th class="head">Phone</th>
		<th class="head">Mobile</th>
		</tr>
		</thead>

		<tbody>
		<tr>
		<td><?php echo $user_model->first_name.' '.$user_model->last_name; ?></td>
		<td><?php echo Group::Model()->FindByPk($user_model->role_id)->role; ?></td>
		<td><?php echo $user_model->gender; ?></td>
		<td><?php echo date("d/m/Y", strtotime($user_model->date_of_birth)); ?></td>
		<td><?php echo $user_model->home_phone; ?></td>
		<td><?php echo $user_model->mobile_phone; ?></td>
		</tr>
		</tbody>
		
</table>

</div>
             
			 <!-- table-responsive --> 
            </div>
			
            <div class="clearfix"></div>
          </div>
       </div>
	   
	             
          
          <div class="row">
          <div class="col-md-12 user_section">
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2>My Licenses</h2>
              </div>
            </div>
            <div class="col-md-12">
			
<button data-toggle="modal" data-target="#myModal"  class="add_new_service btn btn-primary mr5"  onclick="return false;" > Add New License </button>

<div class="table-responsive">
 
<?php

$userLicense=new UserLicenses('search');
$userLicense->unsetAttributes();  // clear any default values
$userLicense->user_id = $user_model->id;;


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$userLicense->search(),
	'summaryText'=>'', 
	'filter'=>null,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'columns'=>array(
	
		array(
			'name'=>'license_type_id',
			'header'=>'License Type',
			'headerHtmlOptions'=>array('class'=>'head'),
			'filter' => CHtml::listData(LicencesType::model()->findAll(), 'id', 'name'), // fields from country table
			'value' => 'LicencesType::Model()->FindByPk($data->license_type_id)->name',
		),

	array(
			'name'=>'license_number',
			'headerHtmlOptions'=>array('class'=>'head'),
		),


	 
		array(
			'name'=>'license_issued_by',
			'headerHtmlOptions'=>array('class'=>'head'),
		),

  
		array(
			'name'=>'license_issued_date',
			'headerHtmlOptions'=>array('class'=>'head'),
			'value'=>'Yii::app()->dateFormatter->format("d/M/y",strtotime($data->license_issued_date))'
		),


	  	array(
			'name'=>'license_expiry_date',
			'headerHtmlOptions'=>array('class'=>'head'),
			'value'=> '($data->license_expiry_date != "0000-00-00") ? Yii::app()->dateFormatter->format("d/M/y",strtotime($data->license_expiry_date)) : ""'
		),


	  
	
	
			array(
			'class'=>'CButtonColumn',
			'header'=>'Action',
			'headerHtmlOptions'=>array('width'=>'25%','class'=>'head'),
			'template'=>' {delete} | {download}',
			
			'buttons'=>array
						(
						
						'delete'	 => array (
							'label'=>'Delete',
							'imageUrl'=>null,
							'url' => 'Yii::app()->createUrl("/User/default/deleteLicense",array("id" => $data->primaryKey))',
						),	
						
	
						'download'	 => array (
							'label'=>'Download',
							'imageUrl'=>null,
							'url' => 'Yii::app()->createUrl("/User/default/DownloadLicense",array("id" => $data->primaryKey))',
						),	
						
	

	

						
						),
			 
			 
		),
	),
)); 

?>

</div>
				
				
				
			 <!-- table-responsive --> 
            </div>
			
            <div class="clearfix"></div>
          </div>
       </div>
	   
	         <div class="row">
          <div class="col-md-12">
      
	  <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2>Induction Due</h2>
              </div>
       </div>
	  
                  <div class="table-responsive">
                    <table class="table table-bordered mb30 quote_table quote_details">
                      <thead>
                        <tr>
                          <th width="20%" class="head">Induction Company</th>
						  <th width="15%"  class="head">Induction Type</th>
                          <th width="15%" class="head">Site Name</th>
                          <th width="20%" class="head">Induction Link or <br/>document to download</th>
                          <th width="10%"  class="head">Password</th>                 
                          <th width="10%"  class="head">Status</th>                 
                          <th width="10%"  class="head">Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  
<?php		foreach($induction_dues as $due) { ?>

			<tr>
			<td><?php echo InductionCompany::Model()->FindByPk($due->induction_company_id)->name; ?></td>
			<td><?php echo InductionType::Model()->FindByPk($due->induction_type_id)->name; ?></td>
			<td><?php if($due->site_id > 0) { echo ContactsSite::Model()->FindByPk($due->site_id)->site_name; } else { echo 'All Sites'; } ?></td>
			
			<?php if($due->induction_link_document == 1) { ?>
			<td align="center">		<?php if(!empty($due->document) && file_exists(Yii::app()->basePath.'/../uploads/induction/documents/'.$due->document))	{ ?>
		<a  target="_blank" href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/induction/documents/'.$due->document; ?>">Download Document</a>
		<?php } ?>
		</td>
			<?php } else { ?>
			<td  align="center"><a href="<?php echo $due->induction_link; ?>"><?php echo $due->induction_link; ?></a></td>
			<?php } ?>
			
			<td><?php echo $due->password; ?></td>
			<td align="center"><?php echo '<span style="color:#ff0000;">'.$due->induction_status.'<span>'; ?></td>
			
			<td><a href="javascript:void(0);" id="<?php echo $due->id; ?>" onclick="return false;" data-toggle="modal" data-target="#myModalInduction" class="get_induction_details" >Update details</a></td>
			</tr>
			
<?php } ?>				
                      </tbody>
                    </table>
                  </div>
	  
	  
            
           
        </div>
      </div>
  
  

       <div class="row">
          <div class="col-md-12">
      
	  <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2>Completed Induction</h2>
              </div>
       </div>
	  
                  <div class="table-responsive">
                    <table class="table table-bordered mb30 quote_table quote_details">
                      <thead>
                        <tr>
                          <th width="20%" class="head">Induction Company</th>
						  <th width="15%"  class="head">Induction Type</th>
                          <th width="15%" class="head">Site Name</th>
                          <th width="10%" class="head">Completion Date</th>
						  <th width="10%"  class="head">Expiry Date</th>    
                          <th width="10%"  class="head">Induction Number</th> 
                          <th width="10%"  class="head">Download Card</th>
                          <th width="10%"  class="head">Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  
<?php		foreach($induction_completed as $completed_due) { ?>

			<tr>
			<td><?php echo InductionCompany::Model()->FindByPk($completed_due->induction_company_id)->name; ?></td>
			<td><?php echo InductionType::Model()->FindByPk($completed_due->induction_type_id)->name; ?></td>
			<td><?php if($completed_due->site_id > 0) { echo ContactsSite::Model()->FindByPk($completed_due->site_id)->site_name; } else { echo 'All sites'; } ?></td>
			<td><?php if($completed_due->completion_date != '0000-00-00') echo Yii::app()->dateFormatter->format("d/M/y",strtotime($completed_due->completion_date)); ?></td>
			
			<td><?php 
			if($completed_due->expiry_date != '0000-00-00') { 
					if( strtotime($completed_due->expiry_date) < strtotime(date('Y-m-d')))
					echo '<span style="color:#ff0000">'.Yii::app()->dateFormatter->format("d/M/y",strtotime($completed_due->expiry_date)).'</span>'; 
					else
					echo Yii::app()->dateFormatter->format("d/M/y",strtotime($completed_due->expiry_date));	
				} 
			?>
			</td>
			
			<td><?php echo $completed_due->induction_number; ?></td>
			
			<td align="center">
			<?php if(!empty($completed_due->induction_card) && file_exists(Yii::app()->basePath.'/../uploads/induction/cards/'.$completed_due->induction_card))	{ ?>
			<a  target="_blank" href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/induction/cards/'.$completed_due->induction_card; ?>">Download Card</a><br/>
			<?php } ?>
			</td>
		
		<td><a href="javascript:void(0);" id="<?php echo $completed_due->id; ?>" onclick="return false;" data-toggle="modal" data-target="#myModalInduction" class="get_induction_details" >Update details</a></td>
			
		</tr>
			
<?php } ?>				
                      </tbody>
                    </table>
                  </div>
	  
	  
            
           
        </div>
      </div>
  

	   
	   
      </div>
      <!-- contentpanel -->
  
  <?php 
				$license_type_options = array();
				$license_type_options[''] = "--License Type--";				
		
				$criteria = new CDbCriteria();
				$criteria->select = "id,name";
				$criteria->order = 'name';
				$loop_contacts = LicencesType::model()->findAll($criteria);
				
				foreach ($loop_contacts as $value)  {			
				$license_type_options[$value->id] =  $value->name; 
				}

?>

<!-- Modal box 1 -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add New License</h4>
      </div>
	  
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-licenses-form1-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
	
)); ?>
	  
	  
      <div class="modal-body">
      <?php echo $form->errorSummary($model); ?>
	    <?php echo $form->hiddenField($model,'user_id',array('class'=>'form-control','value'=>$user_model->id)); ?>      
		<div class="form-group">        
		  <?php echo $form->labelEx($model,'license_type_id',array('class'=>'col-sm-4')); ?>
          <div class="col-sm-8">
		  <?php echo $form->dropDownList($model, 'license_type_id', $license_type_options ,array('class'=>'form-control')); ?>
         </div>
        </div>
		
        <div class="form-group">
		    <?php echo $form->labelEx($model,'license_number',array('class'=>'col-sm-4')); ?>
          <div class="col-sm-8">
		  <?php echo $form->textField($model,'license_number',array('class'=>'form-control')); ?> 
          </div>
        </div>
		
        <div class="form-group">
		<?php echo $form->labelEx($model,'license_issued_by',array('class'=>'col-sm-4')); ?>
          <div class="col-sm-8">
		  <?php echo $form->textField($model,'license_issued_by',array('class'=>'form-control')); ?> 
          </div>
        </div>
		
        <div class="form-group">
          <?php echo $form->labelEx($model,'license_issued_date',array('class'=>'col-sm-4')); ?>
          <div class="col-sm-8">
		   <?php echo $form->textField($model,'license_issued_date',array('id'=>'license_issued_date','class'=>'form-control')); ?>
		</div>
        </div>
		
        <div class="form-group">
          <?php echo $form->labelEx($model,'license_expiry_date',array('class'=>'col-sm-4')); ?>
          <div class="col-sm-8">
		  <?php echo $form->textField($model,'license_expiry_date',array('id'=>'license_expiry_date','class'=>'form-control')); ?>
		 </div>
        </div>
		
        <div class="form-group">
          <?php echo $form->labelEx($model,'license_file',array('class'=>'col-sm-4')); ?>
          <div class="col-sm-8">
		    <?php echo  CHtml::activeFileField($model,'license_file',array('class'=>'form-control')); ?>            
          </div>
        </div>
		
        <div class="form-group">
          <label class="col-sm-4">&nbsp;</label>
          <div class="col-sm-8">
          <?php echo CHtml::submitButton('Save',array('class'=>'btn btn-primary')); ?>
          </div>
        </div>
		
      </div>
   


<?php $this->endWidget(); ?>

   </div>
    <!-- modal-content --> 
  </div>
  <!-- modal-dialog --> 
  
</div>

<!-- Modal box 1 --> 





<?php if(isset($_POST['UserLicenses']) && ! Yii::app()->user->hasFlash('success') || count($model->errors) > 0) { ?>
<script type="text/javascript">
jQuery('#myModal').modal('show');
</script>
<?php } ?>


<script type="text/javascript">
  

   $(document).ready(function(){

	
   
    $("#license_issued_date").datepicker({
		dateFormat:'yy-mm-dd',
       // minDate: 0,
        maxDate: "+1000D",
        numberOfMonths: 1,
    });
	
    $("#license_expiry_date").datepicker({ 
		dateFormat:'yy-mm-dd',
        minDate: 0,
        maxDate:"+1000D",
        numberOfMonths: 1,       
    });  

	
	
});


</script>




  <!-- Modal myModalInduction -->
<div class="modal fade" id="myModalInduction" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Update Induction</h4>
      </div>
      <div class="modal-body">
               
   <form method='post' action="" enctype='multipart/form-data'>
	
	
	<input type="hidden" id="induction_id" name="induction_id"/>

	<div class="form-group">
		<label class='col-sm-4'>Induction Number</label>
		<div class="col-sm-7">
		<input type="textField" id="induction_number" name="induction_number" class="form-control" size="60" maxlength="255"/>
		</div>
	</div>

	
	<div class="form-group">
		<label class='col-sm-4'>Induction Card</label>
		<div class="col-sm-7">
		<input type="file" id="induction_card"  name="induction_card" class="form-control" size="60" maxlength="255"/>
		</div>
	</div>


	<div class="form-group">
		<label class='col-sm-4'>Completion Date</label>
		<div class="col-sm-7">
		<input type="textField" id="completion_date"  name="completion_date" class="form-control" size="60" maxlength="255"/>
		</div>
	</div>



	<div class="form-group">
		<label class='col-sm-4'>Expiry Date</label>
		<div class="col-sm-7">
		<input type="textField" id="expiry_date"  name="expiry_date" class="form-control" size="60" maxlength="255"/>
		</div>
	</div>


	
	<div class="form-group">
		<label class='col-sm-4'>Induction Status</label>
		<div class="col-sm-7" >
		<select name="induction_status" id="induction_status" class="form-control" >
		<option value="pending">Pending</option>
		<option value="completed">Completed</option>
		</select>
		</div>
	</div>

	

	<div class="form-group">
	<label class='col-sm-4'></label>
		<div class="col-sm-7">	
		<input type="submit" value="Update Induction" name="update_induction" class="btn btn-primary"/>
		</div>
	</div>
  
  
</form>
   
   
   
      </div>
    </div>
    <!-- modal-content --> 
  </div>
  <!-- modal-dialog --> 
  
</div>

  
  <script type="text/javascript">
  	jQuery(document).ready(function(){
	

    $("#completion_date").datepicker({
		dateFormat:'yy-mm-dd',
       // minDate: 0,
        maxDate: "+1000D",
        numberOfMonths: 1,
    });
	
    $("#expiry_date").datepicker({ 
		dateFormat:'yy-mm-dd',
        minDate: 0,
        maxDate:"+1000D",
        numberOfMonths: 1,       
    });  
	
							jQuery(".get_induction_details").click(function(){							
							
							var induction_id = jQuery(this).attr("id");
							var post_data = 'induction_id='+induction_id;
							
									jQuery.ajax(
											{
											url : '/?r=Induction/default/GetInductionDetails',
											type: "POST",
											data : post_data,
											success:function(data, textStatus, jqXHR){
												
												mydata = JSON.parse(data);
												
												jQuery("input#induction_id").val(mydata.induction_id);														
												jQuery("input#induction_number").val(mydata.induction_number);														
												jQuery("input#completion_date").val(mydata.completion_date);														
												jQuery("input#expiry_date").val(mydata.expiry_date);
												jQuery("input#induction_card").after(mydata.induction_card);														
												document.getElementById("induction_status").value = mydata.induction_status;												
												
												 
											},
											error: function(jqXHR, textStatus, errorThrown)
												{}
									});
									
						
								}); 
								
					}); 
			
  </script>
  
  

			
