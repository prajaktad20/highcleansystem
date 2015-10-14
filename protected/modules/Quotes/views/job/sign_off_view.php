<div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
			  <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/Job/view&id=<?php echo $model->id; ?>">This Job</a></li>
            </ul>
			<a href="<?php echo $this->user_role_base_url.'/?r=Quotes/Job/view&id='.$model->id; ?>" class="btn btn-primary pull-right">Back To Job Details</a>
            <h4>Sign Off Job</h4>
          </div>
        </div>
        <!-- media --> 
</div>
      
<div class="contentpanel">
	  
  <div class="row">
          <div class="col-md-12 quote_section"> 
		  
                <div class="panel panel-default">
                  <div class="panel-body titlebar">
                    <span class="glyphicon  glyphicon-th"></span><h2>Choose Below one way to sign off job</h2>
                  </div>
                </div>
				
				
<?php if(isset($_REQUEST['email_sign_off']) && $_REQUEST['email_sign_off'] == 'yes') { ?>
    <div class="alert alert-success">
        <strong>Success!</strong> you have successfully sent email notification to Client.<br/>
    </div>
<?php } ?>	
	
<?php if($model->signed_off == 'Yes') { ?>
    <div class="alert alert-info">
        You signed off this job via below green coloured background option.
    </div>
<?php } ?>	

<?php $choosed_way = 'style="background-color:#00ff00";'; ?>
				
				<div style="font-size:16px;" class="col-md-12">
				
				<div <?php if($model->signed_off == 'Yes' && $model->client_signed_off_through == '1') echo $choosed_way; ?> >
				<strong>1) Send email to client to sign off job. </strong> &nbsp;&nbsp;&nbsp;  
				<a  href="<?php echo $this->user_role_base_url; ?>?r=Quotes/Job/SendSignOffEmail&id=<?php echo $model->id; ?>">Send Email</a> 
				<div style="clear:both;"></div>
				</div><br/>
				
				<div <?php if($model->signed_off == 'Yes' && $model->client_signed_off_through == '2') echo $choosed_way; ?> >
				<strong>2) Take signature on the spot through hand held devices. </strong> &nbsp;&nbsp;&nbsp;  
				<a  href="<?php echo $this->user_role_base_url; ?>?r=Quotes/Job/SpotSignOff&id=<?php echo $model->id; ?>">Take Signature</a>  
				<div style="clear:both;"></div>
				</div><br/>
				
				
				<div <?php if($model->signed_off == 'Yes' && $model->client_signed_off_through == '3') echo $choosed_way; ?> >
				<strong>3) We have taken signature on paper. </strong>  &nbsp;&nbsp;&nbsp; 
				<a  href="<?php echo $this->user_role_base_url; ?>?r=Quotes/Job/PaperSignOff&id=<?php echo $model->id; ?>">Update Sign Off Status</a> 
				<div style="clear:both;"></div>
				</div>
				
				</div>
				
		  </div>		
  </div>		

</div>
		