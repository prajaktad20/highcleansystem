<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Calendar/default/View_inductions" >View Inductions</a></li>
            </ul>
         			
			<h4><?php echo CHtml::link(
                Yii::t("Calender.index", "Manage"),
                array("index"),
                array("class"=>"btn btn-primary pull-right")
 ); ?></h4>
			
          </div>
        </div>
        <!-- media --> 
      </div> 

			  



      <div class="contentpanel">
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
			<td><?php if($due->site_id > 0) echo ContactsSite::Model()->FindByPk($due->site_id)->site_name; ?></td>
			
			<?php if($due->induction_link_document == 1) { ?>
			<td align="center">		<?php if(!empty($due->document) && file_exists(Yii::app()->basePath.'/../uploads/induction/documents/'.$due->document))	{ ?>
		<a  target="_blank" href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/induction/documents/'.$due->document; ?>">Download Document</a>
		<?php } ?>
		</td>
			<?php } else { ?>
			<td  align="center"><a href="<?php echo $due->induction_link; ?>"><?php echo $due->induction_link; ?></a></td>
			<?php } ?>
			
			<td><?php echo $due->password; ?></td>
			<td><?php echo $due->induction_status; ?></td>
			
			<td><a href="<?php echo $this->user_role_base_url.'/?r=Calendar/default/updateInduction&id='. $due->id; ?>" >Update details</a></td>
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
			<td><?php if($completed_due->site_id > 0) echo ContactsSite::Model()->FindByPk($completed_due->site_id)->site_name; ?></td>
			<td><?php echo Yii::app()->dateFormatter->format("d/M/y",strtotime($completed_due->completion_date)); ?></td>
			<td><?php echo Yii::app()->dateFormatter->format("d/M/y",strtotime($completed_due->expiry_date)); ?></td>
			<td><?php echo $completed_due->induction_number; ?></td>
			
			<td align="center">
			<?php if(!empty($completed_due->induction_card) && file_exists(Yii::app()->basePath.'/../uploads/induction/cards/'.$completed_due->induction_card))	{ ?>
			<a  target="_blank" href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/induction/cards/'.$completed_due->induction_card; ?>">Download Card</a><br/>
			<?php } ?>
			</td>
		
			<td align="center">
			<a href="<?php echo $this->user_role_base_url.'/?r=Calendar/default/updateInduction&id='. $completed_due->id; ?>" >Update details</a>
			</td>
			
		</tr>
			
<?php } ?>				
                      </tbody>
                    </table>
                  </div>
	  
	  
            
           
        </div>
      </div>
  
	</div>
      <!-- contentpanel -->
           
