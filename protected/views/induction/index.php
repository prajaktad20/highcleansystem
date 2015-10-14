<style>

.top_wrepp a{display:inline-block; float:left;}
.top_wrepp span{display:inline-block; float:right; color:#fff;}

</style>

<div class="row top_wrepp">
	<div class="col-md-6 col-sm-4 col-xs-6 col-mb-12">
		<a href="http://highclean.com.au/"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/logo_new.png"/></a>
    </div>
    <div class="col-md-6 col-sm-8 col-xs-6 col-mb-12">
    	<span>
            High Clean Pty Ltd<br />
            E: info@highclean.com.au<br />
            A: 1/92 Railway St South, Altona VIC 3018<br />
            T: 03 8398 0804
        </span>
    </div>    
</div>
<div class="pageheader">

        <div class="media">

          <div class="media-body">

            <h4 align="center">Induction</h4>			

          </div>

        </div>

        <!-- media --> 

</div>



<div class="contentpanel">

<div class="row">

<div class="col-md-12">

	
	 <div class="row mb20">

       

			<dt class="col-md-6 blue4">User Name</dt>

              <dd class="col-md-6 blue4"><?php echo $user_model->first_name.' '.$user_model->last_name; ?></dd>

     </div>    
	
</div>
	
</div>

	
<div class="row">	
	
	<?php if(count($user_inductions) > 0) { ?>
	   <div class="table-responsive">
                    <table class="table table-bordered mb30 quote_table quote_details">
                      <thead>
                        <tr>
                          <th width="20%" class="head">Induction Company</th>
						  <th width="20%"  class="head">Induction Type</th>
                          <th width="20%" class="head">Site Name</th>
                          <th width="10%" class="head">Completion Date</th>
						  <th width="10%"  class="head">Expiry Date</th>    
                          <th width="10%"  class="head">Induction Number</th> 
                          <th width="10%"  class="head">Download Card</th>                        
                        </tr>
                      </thead>
                     
					  
<?php		foreach($user_inductions as $single_induction) { ?>

			<tr>
			<td><?php echo InductionCompany::Model()->FindByPk($single_induction->induction_company_id)->name; ?></td>
			<td><?php echo InductionType::Model()->FindByPk($single_induction->induction_type_id)->name; ?></td>
			<td><?php if($single_induction->site_id > 0) { echo ContactsSite::Model()->FindByPk($single_induction->site_id)->site_name; } else { echo 'All sites'; } ?></td>
			<td><?php if($single_induction->completion_date != '0000-00-00') echo Yii::app()->dateFormatter->format("d/M/y",strtotime($single_induction->completion_date)); ?></td>
			
			<td><?php 
			if($single_induction->expiry_date != '0000-00-00') { 
					if( strtotime($single_induction->expiry_date) < strtotime(date('Y-m-d')))
					echo '<span style="color:#ff0000">'.Yii::app()->dateFormatter->format("d/M/y",strtotime($single_induction->expiry_date)).'</span>'; 
					else
					echo Yii::app()->dateFormatter->format("d/M/y",strtotime($single_induction->expiry_date));	
				} 
			?>
			</td>
			
			<td><?php echo $single_induction->induction_number; ?></td>
			
			<td align="center">
			<?php if(!empty($single_induction->induction_card) && file_exists(Yii::app()->basePath.'/../uploads/induction/cards/'.$single_induction->induction_card))	{ ?>
			<a  target="_blank" href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/induction/cards/'.$single_induction->induction_card; ?>">Download Card</a><br/>
			<?php } ?>
			</td>
			
		</tr>
			
<?php } ?>				
                    
                    </table>
                  </div>
<?php } else { ?>
<strong>No Induction Found.</strong>
<?php } ?>
	  	
	
</div>			
	
</div>	


