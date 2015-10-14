<style type="text/css">
.contentpanel {
font-size: 12px;    
}

.timesheet_table table tr:nth-child(2n+3){background:#e9eff7;}
.timesheet_table table tr td{border:1px solid #ccc; line-height:26px; padding:0 3px;}
</style>

<div class="pageheader">
<div class="media">
<div class="media-body">
<ul class="breadcrumb">
<li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
<li>Job Profitablity</li>
</ul>
<h4>Job Profitablity</h4>
</div>
</div>
<!-- media --> 
</div>

<?php

	$default_start_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 20, date('Y')));
	$default_last_date = date('Y-m-d');

	$job_from_date = isset($_REQUEST['job_from_date']) ? $_REQUEST['job_from_date'] : $default_start_date;
	$job_to_date = isset($_REQUEST['job_to_date']) ? $_REQUEST['job_to_date'] : $default_last_date;


?>



<div class="contentpanel">


        <div class="row">
          <form action="" method="GET" id="myForm" >     
        <div class="col-md-12">  
			<input type="hidden"  name="r" value="Report/default/job_profitability"/>
            <div class="col-md-3">        
                <input type="text" id="job_from_date" autocomplete="off" name="job_from_date" value="<?php echo $job_from_date; ?>" class="form-control" placeholder="Start Date"/>
            </div>

            <div class="col-md-3">
               <input type="text" id="job_to_date" autocomplete="off" name="job_to_date" value="<?php echo $job_to_date; ?>"  class="form-control" placeholder="End Date"/>
            </div>

            <div class="col-md-3">
                <input type="submit" class="btn btn-primary" value="Search"  />
            </div>


            <div class="col-md-3">
                <?php if( count($job_result) > 0 )  { ?>
		<a href="?r=Report/default/GenerateJobProfitablityReport&<?php echo 'job_from_date='.$job_from_date.'&job_to_date='.$job_to_date ; ?>" >Download Report</a>
		<?php } ?>
            </div>




        </div>    
          </form> 
        </div>

	<?php //echo '<pre>'; print_r($job_result); echo '</pre>'; ?>


	<div class="row">

	<div class="col-md-12"> 

<?php if(count($job_result) > 0) { ?>

<div class="timesheet_table table-responsive">
<table width="100%">
<thead>

<tr class="blue4" style="border:1px solid #ccc;">
<td align="center">Job ID</td>
<td align="center">Last Working Date</td>
<td align="center">Company</td>
<td align="center">Contact</td>
<td align="center">Site Name</td>
<td align="center">Building</td>
<td align="center">Service</td>
<td align="center">Supervisor</td>
<td align="center">Quote Amt</td>
<td align="center">Total Wage</td>
<td align="center">Diff $$</td>
<td align="center">Labour %</td>
</tr>
</thead>

<?php foreach($job_result as $record)  { ?>
<tr>
<td align="center"><a target="_blank" href="?r=Quotes/Job/view&id=<?php echo $record['job_id'] ; ?>"><?php echo $record['job_id'] ; ?></a></td>
<td align="center"><?php echo $record['last_working_date']; ?></td>
<td align="center"><?php echo $record['company_name'] ; ?></td>
<td align="center"><?php echo $record['contact_name'] ; ?></td>
<td align="center"><?php echo $record['site_name'] ; ?></td>
<td align="center"><?php echo $record['building_name'] ; ?></td>
<td align="center"><?php echo $record['service_name'] ; ?></td>
<td align="center"><?php echo $record['supervisor_name'] ; ?></td>
<td align="center"><?php echo '$'.$record['quote_amount'] ; ?></td>
<td align="center"><?php echo '$'.$record['total_wage'] ; ?></td>
<td align="center"><?php echo '$'.$record['diff_value'] ; ?></td>
<td align="center"><?php echo $record['labour_percentage'].'%' ; ?></td>
</tr>
<?php } ?>


</div>
<?php } ?> 

	</div>

	</div>

</div>

<script type="text/javascript">

   $("#job_from_date").datepicker({
                numberOfMonths: 1,
                dateFormat:'yy-mm-dd',
                onSelect: function(selected) {
                  $("#job_to_date").datepicker("option","minDate", selected)
                }
            });
            
            $("#job_to_date").datepicker({ 
                numberOfMonths: 1,
                dateFormat:'yy-mm-dd',
                onSelect: function(selected) {
                   $("#job_from_date").datepicker("option","maxDate", selected)
                }
            });  
            

</script>
