
      <div class="contentpanel">
        <div class="row">
          <div class="col-md-12">
      
	  <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2>My Signed Off Jobs</h2>
              </div>
       </div>
	  
                  <div class="table-responsive">
                    <table class="table table-bordered mb30 quote_table quote_details">
                      <thead>
                        <tr>
                          <th width="8%" class="head">Quote No.</th>
						  <th width="7%"  class="head">Job No.</th>
                           <th width="10%" class="head">Start Date</th>
                          <th width="10%" class="head">End Date</th>
                          <th width="13%"  class="head">Building</th>
                          <th width="15%" class="head">Site</th>
                          <th width="8%"  class="head">Contact</th>
                          <th width="12%"  class="head">Company</th>
                          <th width="7%"  class="head">Paid</th>                        
                          <th width="12%"  class="head">Download</th>
                        </tr>
                      </thead>
                      <tbody>
					  

<?php foreach($signedOffJobs as $job_row) { ?>

<?php


	
		// quote model by job id
		$quote_model = Quotes::model()->findByPk($job_row->quote_id);
		
		// building model
		$building_model = Buildings::model()->findByPk($job_row->building_id);
		
		// site model
		$site_model = ContactsSite::model()->findByPk($quote_model->site_id);
		
		// contact model
		$contact_model = Contact::model()->findByPk($quote_model->contact_id);
		
		// contact model
		$company_model = Company::model()->findByPk($quote_model->company_id);
		

?>                   
						  <tr>
						  
						  <td style="text-align:center;" ><?php echo $job_row->quote_id; ?></td>
						  <td style="text-align:center;" ><?php echo $job_row->id; ?></td>	
                          <td style="text-align:center;" ><?php echo $job_row->job_started_date; ?></td>
						  <td><?php echo $job_row->job_end_date; ?></td>					
                          <td style="text-align:center;" ><?php  echo $building_model->building_name; ?></td>
                          <td style="text-align:center;" ><?php echo $site_model->site_name; ?></td>
						  <td style="text-align:center;" ><?php echo $contact_model->first_name.' '.$contact_model->surname; ?></td>
                          <td style="text-align:center;" ><?php echo $company_model->name; ?></td>
                          <td style="text-align:center;" ><?php echo $job_row->paid; ?></td>
                        
                          <td style="text-align:center;" >
                            
                           

								<?php if($job_row->signed_off == 'Yes') { ?>								
								<?php if($job_row->agent_signed_off_through == '3') { 
								if(!empty($job_row->sign_off_document) && file_exists(Yii::app()->basePath.'/..//uploads/sign_off_document/'.$job_row->sign_off_document)) { ?>
								<a target="_blank" href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/sign_off_document/'.$job_row->sign_off_document; ?>" >Signed off Sheet</a>
								<?php }  ?>
								<?php } else { ?>
                                <a href="<?php echo $this->user_role_base_url.'/?r=Quotes/Job/DownloadSignOffSheet&id='.$job_row->id; ?>" >Signed off Sheet</a>
								<?php } ?>
								<?php } ?>
								
                            
                            
                            </td>
                       </tr>
						
<?php } ?>						
                      </tbody>
                    </table>
                  </div>
	  
	  
            
           
        </div>
      </div>
  
	</div>