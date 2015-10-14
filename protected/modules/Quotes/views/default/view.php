<div class="pageheader">
    <div class="media">
        <div class="media-body">
            <ul class="breadcrumb">
                <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
                <li><a href="">Quotes</a></li>
                <li>Quote Detail</li>
            </ul>
            <h4>Quote Detail</h4>
        </div>
    </div>
    <!-- media --> 
</div>
<div class="contentpanel">
    <div class="row">
        <div class="col-md-12 quote_section"> 

            <div class="mb20"></div>
            <div class="panel panel-default">
                <div class="panel-body titlebar">
                    <span class="glyphicon  glyphicon-th"></span><h2>Quote Detail</h2>
                </div>
            </div>
            <dl class="quotedetaildl col-md-12">
                <dt class="col-md-6 blue4">Quote No.</dt>
                <dd class="col-md-6 blue4"><?php echo $model->id; ?></dd>

                <dt class="col-md-6 blue1">Date</dt>
                <dd class="col-md-6 blue1"><?php echo date("l, F jS, Y", strtotime($model->quote_date)); ?></dd>

                <dt class="col-md-6 blue2">Company Name</dt>
                <dd class="col-md-6 blue2"><?php echo Company::Model()->FindByPk($model->company_id)->name; ?></dd>

                <dt class="col-md-6 blue1">Contact Name</dt>
                <dd class="col-md-6 blue1"><?php echo Contact::Model()->FindByPk($model->contact_id)->first_name . " " . Contact::Model()->FindByPk($model->contact_id)->surname; ?></dd>

                <dt class="col-md-6 blue2">Site</dt>
                <dd class="col-md-6 blue2"><?php echo ContactsSite::Model()->FindByPk($model->site_id)->site_name; ?></dd>

                <dt class="col-md-6 blue1">Service Req</dt>
                <dd class="col-md-6 blue1"><?php echo Service::Model()->FindByPk($model->service_id)->service_name; ?></dd>                  
            </dl>
            <div class="col-md-12">

                <div class="table-responsive">
                    <table class="table table-bordered mb30 quote_table quote_details">
                        <thead>
                            <tr>
                                <th width="10%" class="head">Start date</th>
                                <th width="7%"  class="head">Job No.</th>
                                <th width="15%"  class="head">Building</th>
                                <th width="8%" class="head">Quote amount</th>
                                <th width="15%" class="head">Approval status</th>
                                <th width="8%"  class="head">Booked status</th>
                                <th width="12%"  class="head">Job status</th>
                                <th width="7%"  class="head">Paid</th>
                                <th width="8%"  class="head">Signed Off</th>
                                <th width="10%"  class="head">Task</th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php foreach ($QuoteJobs as $job_row) { ?>

                                <?php
                                $active_job_row = '';
                                if (isset($_REQUEST['job_id']) && $_REQUEST['job_id'] == $job_row->id)
                                    $active_job_row = "style='background:#FC8B2F;'";
                                ?>

                                <tr <?php echo $active_job_row; ?> >
                                    <td style="text-align:center;" ><?php echo $job_row->job_started_date; ?></td>
                                    <td style="text-align:center;" ><?php echo $job_row->id; ?></td>						
                                    <td style="text-align:center;" ><?php echo Buildings::Model()->FindByPk($job_row->building_id)->building_name; ?></td>
                                    <td style="text-align:center;" ><?php echo "$" . $job_row->final_total; ?></td>
                                    <td style="text-align:center;" ><?php echo $job_row->approval_status; ?></td>
                                    <td style="text-align:center;" ><?php echo $job_row->booked_status; ?></td>
                                    <td style="text-align:center;" ><?php echo $job_row->job_status; ?></td>
                                    <td style="text-align:center;" ><?php echo $job_row->paid; ?></td>
                                    <td style="text-align:center;" ><?php echo $job_row->signed_off; ?></td>
                                    <td style="text-align:center;" ><div class="btn-group mar0">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span> </button>
                                            <ul class="dropdown-menu pull-right" role="menu">

                                                <?php if ($model->status == 'Approved') { ?>
                                                    <li><a href="<?php echo $this->user_role_base_url . '/?r=Quotes/Job/view&id=' . $job_row->id; ?>" >View detail</a></li>
                                                <?php } ?>

                                                <li><a href="<?php echo $this->user_role_base_url . '/?r=Quotes/default/EditStaffNote&id=' . $job_row->id; ?>">Edit staff note</a></li>

                                                <?php if ($model->status == 'Approved') { ?>
                                                    <?php if ($job_row->booked_status == 'Booked') { ?>
                                                        <li><a href="<?php echo $this->user_role_base_url . '/?r=Quotes/Job/RebookJob&id=' . $job_row->id; ?>">Book/Re-Book a Job</a></li>
                                                    <?php } else { ?> 
                                                        <li><a href="<?php echo $this->user_role_base_url . '/?r=Quotes/Job/BookJob&id=' . $job_row->id; ?>">Book/Re-Book a Job</a></li>								
                                                    <?php } ?>								
                                                <?php } ?>


                                                <li><a href="<?php echo $this->user_role_base_url . '/?r=Quotes/default/ConfirmBeforeJobStatusChange&qjobstatus=decline&job_id=' . $job_row->id; ?>">Decline Job</a></li>
                                                <li><a href="<?php echo $this->user_role_base_url . '/?r=Quotes/default/ConfirmBeforeJobStatusChange&qjobstatus=cancel&job_id=' . $job_row->id; ?>">Cancel Job</a></li>
                                                <li><a  href="<?php echo $this->user_role_base_url . '/?r=Quotes/Job/DownloadJobsheet&id=' . $job_row->id; ?>" >Download Jobsheet</a></li>
                                                <li><a  href="<?php echo $this->user_role_base_url . '/?r=Quotes/Job/DownloadSwms&id=' . $job_row->id; ?>">Download SWMS</a></li>
                                                <li><a href="<?php echo $this->user_role_base_url . '/?r=Quotes/Job/DownloadQuote&id=' . $job_row->id; ?>" >Download Quote</a></li>


                                                <?php if ($job_row->signed_off == 'Yes') { ?>								
                                                    <?php
                                                    if ($job_row->client_signed_off_through == '3') {
                                                        if (!empty($job_row->sign_off_document) && file_exists(Yii::app()->basePath . '/..//uploads/sign_off_document/' . $job_row->sign_off_document)) {
                                                            ?>
                                                            <li><a target="_blank" href="<?php echo $this->user_role_base_url . '/uploads/sign_off_document/' . $job_row->sign_off_document; ?>" >Download SignOffSheet</a></li>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <li><a href="<?php echo $this->user_role_base_url . '/?r=Quotes/Job/DownloadSignOffSheet&id=' . $job_row->id; ?>" >Download SignOffSheet</a></li>
                                                    <?php } ?>
    <?php } ?>

                                                <li><a href="<?php echo $this->user_role_base_url . '/?r=Quotes/default/ConfirmBeforeJobStatusChange&qjobstatus=delete&job_id=' . $job_row->id; ?>">Delete Job</a></li>
                                            </ul>
                                        </div></td>
                                </tr>

<?php } ?>						
                        </tbody>
                    </table>
                </div>
                <!-- table-responsive --> 


                <?php foreach ($QuoteJobs as $job_row) { ?>
                        <?php if ($job_row->original_record == '1' && $job_row->booked_status == 'Booked' && $job_row->frequency_type != 1) { ?>
                        <a href="<?php echo $this->user_role_base_url . '/?r=Quotes/Job/AddFrequencyJob&id=' . $job_row->id; ?>" class="btn btn-primary mr5"><?php echo 'Add more frequency of jobs for Building ' . Buildings::Model()->FindByPk($job_row->building_id)->building_name;
                    ;
                            ?></a> <br/> <br/>
    <?php } ?>
<?php } ?>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- contentpanel --> 
