<style>

.modal-dialog {
margin : 10px auto 30px; !important;	
width: 80%; !important;
height: 70%; !important;
}

</style>


<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
              <li><a href="<?php echo $this->user_role_base_url.'/?r=Quotes/Job/view&id='.$model->id; ?>">Job</a></li>
              <li>View Induction</li>
            </ul>
			<a href="<?php echo $this->user_role_base_url.'/?r=Quotes/Job/view&id='.$model->id; ?>" class="btn btn-primary pull-right">Back To Job Details</a>
            <h4>View Induction</h4>
			
          </div>
        </div>
        <!-- media --> 
</div>

<?php $path = Yii::app()->basePath.'/../uploads/job_images/thumbs/'; ?>
<div class="contentpanel">

<div class="row">
<div class="col-md-12 quote_section">
      
<div class="panel panel-default">
  <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
	<h2>Job Details</h2>			
  </div>
</div>
      
        <div class="row mb20">
         
          <div class="col-md-12">
            <dl class="quotedetaildl col-md-12 nopadding">
             
			 <dt class="col-md-3">Job No</dt>
             <dd class="col-md-3"><?php echo $model->id; ?></dd>
             
			  <dt class="col-md-3">Contact Name</dt>
              <dd class="col-md-3"><?php echo Contact::Model()->FindByPk($quote_model->contact_id)->first_name." ".Contact::Model()->FindByPk($quote_model->contact_id)->surname; ?></dd>
             
			  <dt class="col-md-3">Quote No</dt>
              <dd class="col-md-3"><?php echo $model->quote_id; ?></dd>
       
			 
			  <dt class="col-md-3">Site</dt>
              <dd class="col-md-3"><?php echo ContactsSite::Model()->FindByPk($quote_model->site_id)->site_name; ?></dd>
      
			  
			  <dt class="col-md-3">Service Req</dt>
              <dd class="col-md-3"><?php echo Service::Model()->FindByPk($quote_model->service_id)->service_name; ?></dd>
             
			  <dt class="col-md-3">Building</dt>
              <dd class="col-md-3"><?php echo Buildings::Model()->FindByPk($model->building_id)->building_name; ?></dd>
      
		  
			  <dt class="col-md-3">Company Name</dt>
              <dd class="col-md-3"><?php echo Company::Model()->FindByPk($quote_model->company_id)->name; ?></dd>
      
		
			  
            </dl>
          </div>

        
        </div>

</div>
</div>	


<div class="row">
<div class="col-md-12 quote_section">
 	

<div class="panel panel-default">
          <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
            <h2>View Induction : { <?php echo 'Site Name : '.ContactsSite::Model()->FindByPk($quote_model->site_id)->site_name; ?> }</h2>			
          </div>
</div>

<div class="col-md-12">		


               <div class="table-responsive">
                    <table class="table table-bordered mb30 quote_table quote_details">
                      <thead>
                        <tr>
                          <th width="20%" class="head">User Name</th>
                          <th width="20%" class="head">Induction Company</th>
						  <th width="15%"  class="head">Induction Type</th>
                        <!--  <th width="15%" class="head">Site Name</th>-->
                          <th width="10%" class="head">Completion Date</th>
						  <th width="10%"  class="head">Expiry Date</th>    
                          <th width="10%"  class="head">Induction Number</th> 
                          <th width="10%"  class="head">Download Card</th>
                         
                        </tr>
                      </thead>
                      <tbody>
					  
<?php		foreach($induction_user as $induction_user_record) { ?>

			<tr>
			<td><?php echo $induction_user_record['user_full_name']; ?></td>
			
			<?php if($induction_user_record['induction_company_id'] != 'n/a'; ) { ?>
			<td><?php echo InductionCompany::Model()->FindByPk($induction_user_record['induction_company_id'])->name; ?></td>
			<?php }  else { ?>
			<td><?php echo 'n/a';; ?></td>
			<?php } ?>
			
			<?php if($induction_user_record['induction_type_id'] != 'n/a'; ) { ?>
			<td><?php echo InductionType::Model()->FindByPk($induction_user_record['induction_type_id'])->name; ?></td>
			<?php }   else { ?>
			<td><?php echo 'n/a';; ?></td>
			<?php } ?>
	
			<?php if($induction_user_record['completion_date'] != 'n/a'; && $induction_user_record['completion_date'] != '0000-00-00' ) { ?>
			<td><?php echo Yii::app()->dateFormatter->format("d/M/y",strtotime($induction_user_record['completion_date'])); ?></td>
			<?php }  else { ?>
			<td><?php echo 'n/a';; ?></td>
			<?php } ?>
			
			<?php if($induction_user_record['expiry_date'] != 'n/a';  && $induction_user_record['expiry_date'] != '0000-00-00' ) { ?>
			<td><?php echo Yii::app()->dateFormatter->format("d/M/y",strtotime($induction_user_record['expiry_date'])); ?></td>
			<?php }   else { ?>
			<td><?php echo 'n/a';; ?></td>
			<?php } ?>
			
			<?php if($induction_user_record['induction_number'] != 'n/a'; ) { ?>
			<td><?php echo $induction_user_record['induction_number']; ?></td>
			<?php }  else { ?>
			<td><?php echo 'n/a';; ?></td>
			<?php } ?>
			
			<?php if($induction_user_record['induction_number'] != 'n/a'; ) { ?>
			<td align="center">
			<?php if(!empty($induction_user_record['induction_card']) && file_exists(Yii::app()->basePath.'/../uploads/induction/cards/'.$induction_user_record['induction_card']))	{ ?>
			<a  target="_blank" href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/induction/cards/'.$induction_user_record['induction_card']; ?>">Download Card</a><br/>
			<?php } ?>
			</td>
			<?php } else { ?>
			<td><?php echo 'n/a';; ?></td>
			<?php } ?>
			
		</tr>
			
<?php } ?>				
                      </tbody>
                    </table>
                  </div>
	  
	  
      

</div>
  
	

</div> 
</div>

<br/>
<br/>


</div>
<!--- Content Panel --->



 
