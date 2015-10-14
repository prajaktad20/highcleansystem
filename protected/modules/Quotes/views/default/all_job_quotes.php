<div class="modal-dialog">
  
  
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Download Quotes</h4>
      </div>
      <div class="modal-body">
  
 <?php
foreach($model as $job) {
//echo '<pre>'; print_r($job); echo '</pre>'; ?>
			
<a href="<?php echo $this->user_role_base_url.'/?r=Quotes/Job/DownloadQuote&id='.$job->id; ?>" >
<?php echo " QuoteNo-$job->quote_id( jobNo-$job->id ) "; ?>
</a>			<br/>
			
<?php }  ?>
  
      </div>
    </div>
    <!-- modal-content --> 
  
</div>
