<?php

class DefaultController extends Controller {

    public $layout = '//layouts/column1';
    public $base_url_assets = null;
    public $current_user_id = 0;
    public $user_role_base_url = ''; public $user_dashboard_url = '';
    public $agent_id = '';
    public $where_agent_condition = '';
    public $agent_info = null;

    public function init() {

        $this->base_url_assets = CommonFunctions::siteURL();         
        $this->user_role_base_url = CommonFunctions::getUserBaseUrl(Yii::app()->user->name);
		$this->user_dashboard_url = CommonFunctions::getUserDashboardUrl(Yii::app()->user->name);
        $this->current_user_id = isset(Yii::app()->user->id) ? Yii::app()->user->id : 0;
        $this->agent_id = CommonFunctions::getCurrentpageAgentId(Yii::app()->user->name);
        $this->where_agent_condition = " agent_id = ".$this->agent_id ;
	$this->agent_info = CommonFunctions::getAgentInfo($this->agent_id);
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('SaveUserTimes', 'index', 'CreateExcel'),
                'users' => array('system_owner', 'state_manager', 'operation_manager', 'agent', 'supervisor'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        Yii::app()->clientScript->registerCssFile($this->base_url_assets . '/css/jquery.notifyBar.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.notifyBar.js', CClientScript::POS_END);

        $connection = Yii::app()->db;

        $pay_date = isset($_REQUEST['pay_date']) ? $_REQUEST['pay_date'] : '';
        $selected_user_id = isset($_REQUEST['selected_user_id']) ? $_REQUEST['selected_user_id'] : 0;
        $current_date = date("Y-m-d");

        $pay_dates = array();
        $working_job_ids = array();
        $working_user_ids = array();
        $job_working_model = NULL;
        $workers_model = NULL;
        $selected_user = NULL;
        $approved_form_model = NULL;
        $right_side_data = array();
        $available_dates = array();
        $right_side_result = array();
        $timeDropdown = array();
        $summaryResult = array();
        $final_calculation_model = array();
        $current_date = date('Y-m-d');
        $selected_pay_date_model = null;
        $TimesheetApprovedStatusModel = null;
        $date_frequency = array();
	$add_new_row_model = null;
		
        for ($h = 0; $h < 24; $h++) {
            for ($m = 0; $m < 60; $m = $m + 15) {
                $hour_text = strlen($h) > 1 ? $h : '0' . $h;
                $min_text = strlen($m) > 1 ? $m : '0' . $m;
                $timeDropdown[] = $hour_text . ':' . $min_text;
            }
        }


        $pay_dates_criteria = new CDbCriteria();
        $pay_dates_criteria->condition = $this->where_agent_condition;
        $pay_dates_model = TimesheetPayDates::model()->findAll($pay_dates_criteria);

        foreach ($pay_dates_model as $row) {
            $temp_date = explode('-', $row->pay_date);
            $pay_date_temp = (int) $temp_date[2];
            $pay_date_temp .= '-' . (int) $temp_date[1];
            $pay_date_temp .= '-' . (int) $temp_date[0];
            $pay_dates[] = $pay_date_temp;
        }

        if (!empty($pay_date)) {

            $selected_pay_date_model = TimesheetPayDates::model()->findByAttributes(
                    array(
                        'pay_date' => $pay_date,
                        'agent_id' => $this->agent_id,
                    )
            );



            if (count($selected_pay_date_model) == 0)
                throw new CHttpException(404, 'The requested page does not exist.');

            $final_calculation_model = TimesheetApprovedStatus::model()->findAllByAttributes(
                    array(
                        'pay_date_id' => $selected_pay_date_model->id,
                        'status' => '1',
                        'agent_id' => $this->agent_id,
                    )
            );



            if ($selected_pay_date_model->payment_start_date > $current_date) {
                echo 'you have to wait until ' . $selected_pay_date_model->payment_start_date;
                exit;
            }
            //$current_date = date('Y-m-d', strtotime(date('Y-m-d').' -5 days'));	
            $last_payment_end_date = $selected_pay_date_model->payment_end_date;
            if ($current_date <= $selected_pay_date_model->payment_end_date) {
                $last_payment_end_date = $current_date;
            }

            $interval_days = CommonFunctions::getIntervalDays($selected_pay_date_model->payment_start_date, $last_payment_end_date);
            $next_date = $selected_pay_date_model->payment_start_date;
            $available_dates[] = $next_date;
            for ($i = 0; $i < $interval_days; $i++) {
                $next_date = date('Y-m-d', strtotime($next_date . ' +1 days'));
                $available_dates[] = $next_date;
            }

            $Criteria = new CDbCriteria();
            $Criteria->condition = "$this->where_agent_condition AND working_date between '$selected_pay_date_model->payment_start_date' AND '$last_payment_end_date'";
            $Criteria->order = "working_date";
            $job_working_model = JobWorking::model()->findAll($Criteria);

            if (count($job_working_model) === 0) {
                echo 'No jobs found between ' . date("d/m/Y", strtotime($selected_pay_date_model->payment_start_date)) . ' AND ' . date("d/m/Y", strtotime($last_payment_end_date)) . '. Please use SJA to get automatically populate result on timesheet page';
                exit;
            }
            //echo '<pre>'; print_r($job_working_model); echo '</pre>';exit;							

            foreach ($job_working_model as $job_working_row) {
                if (!in_array($job_working_row->job_id, $working_job_ids)) {
                    $working_job_ids[] = $job_working_row->job_id;
                }
            }

            if (count($working_job_ids) === 0) {
                echo 'Please allocate staff for available dates for your selected payment date';
                exit;
            }
						
            // Left side active staff for selected pay date
            $Criteria4 = new CDbCriteria();
            $Criteria4->condition = "$this->where_agent_condition && status='1' && role_id IN (3,5,6) && first_name!='New Staff'";
            $Criteria4->order = "first_name";
            $workers_model = User::model()->findAll($Criteria4);

            // selected user
            if ($selected_user_id > 0) {
                $selected_user = User::model()->findByPk($selected_user_id);
            } else if ($workers_model !== NULL && count($workers_model) > 0) {
                $selected_user = $workers_model[0];
            }


            if ($selected_user === NULL)
                throw new CHttpException(404, 'The requested page does not exist.');


            $TimesheetApprovedStatusModel = TimesheetApprovedStatus::model()->findByAttributes(
                    array(
                        'pay_date_id' => $selected_pay_date_model->id,
                        'user_id' => $selected_user->id,
                        'agent_id' => $this->agent_id,
                    )
            );


/**********Repopulate timesheet dates************/			
$populate_date_from = isset($_REQUEST['populate_date_from']) ? $_REQUEST['populate_date_from'] : '';
if(! empty($populate_date_from)) {
$r = $_REQUEST['r'];
$selected_user_id = $selected_user->id;
//echo '<pre>'; print_r($available_dates); echo '</pre>';exit;
	if(count($available_dates) > 0 && in_array($populate_date_from,$available_dates)) {
                $delete_condition = "$this->where_agent_condition && pay_date_id = " . $selected_pay_date_model->id . " and user_id =" .$selected_user_id." and working_date >= '".$populate_date_from."' and working_date < '".$selected_pay_date_model->pay_date."'";
		TimesheetPayDatesUser::model()->deleteAll(array("condition" => $delete_condition));
		Yii::app()->request->redirect(Yii::app()->getBaseUrl(true).'/?r='.$r.'&selected_user_id='.$selected_user_id.'&pay_date='.$selected_pay_date_model->pay_date);
	}
}
			
/***********************/
// approve timesheet
            if (isset($TimesheetApprovedStatusModel->id)) {
                $TimesheetApprovedStatus_primary_id = $TimesheetApprovedStatusModel->id;
                $approved_form_model = TimesheetApprovedStatus::model()->findByPk($TimesheetApprovedStatus_primary_id);
                if (isset($_POST['TimesheetApprovedStatus'])) {
                    $approved_form_model->attributes = $_POST['TimesheetApprovedStatus'];
                    $approved_form_model->approved_date = date("Y-m-d H:i:s");

                    $query = "SELECT SUM(total_hours) as TH, SUM(regular_hours) as RH, SUM(overtime_hours) as OH, SUM(double_time_hours) as DTH from hc_timesheet_pay_dates_user where $this->where_agent_condition AND user_id=" . $selected_user->id . " AND pay_date_id=" . $selected_pay_date_model->id;
                    $summaryResult = $connection->createCommand($query)->queryRow();

                    $approved_form_model->total_hours = round($summaryResult['TH'],2);
                    $approved_form_model->regular_hours = round($summaryResult['RH'],2);
                    $approved_form_model->overtime_hours = round($summaryResult['OH'],2);
                    $approved_form_model->double_time_hours = round($summaryResult['DTH'],2);

                    $reg_rate_per_hr = round($selected_user->regular_hours, 2);
                    $ot_rate_per_hr = round($selected_user->overtime_hours, 2);
                    $dt_rate_per_hr = round($selected_user->double_time_hours, 2);

                    $approved_form_model->reg_rate_per_hr = $reg_rate_per_hr;
                    $approved_form_model->ot_rate_per_hr = $ot_rate_per_hr;
                    $approved_form_model->dt_rate_per_hr = $dt_rate_per_hr;
                    $approved_form_model->agent_id = $this->agent_id;

                    $total_wage = ($reg_rate_per_hr * round($summaryResult['RH'], 2)) + ($ot_rate_per_hr * round($summaryResult['OH'], 2)) + ($dt_rate_per_hr * round($summaryResult['DTH'], 2));
                    $approved_form_model->total_wage = round($total_wage, 2);

                    if($approved_form_model->save()) {
                        Yii::app()->user->setFlash('success','Successfully approved timesheet for the user : '.$selected_user->first_name);
                        $this->refresh();
                    }
                }
            } else if ($TimesheetApprovedStatusModel === null) {
                $NewTimesheetApprovedStatusModel = new TimesheetApprovedStatus;
                $NewTimesheetApprovedStatusModel->pay_date_id = $selected_pay_date_model->id;
                $NewTimesheetApprovedStatusModel->user_id = $selected_user->id;
                $NewTimesheetApprovedStatusModel->reg_rate_per_hr = $selected_user->regular_hours;
                $NewTimesheetApprovedStatusModel->ot_rate_per_hr = $selected_user->overtime_hours;
                $NewTimesheetApprovedStatusModel->dt_rate_per_hr = $selected_user->double_time_hours;
                $NewTimesheetApprovedStatusModel->agent_id = $this->agent_id;
                $NewTimesheetApprovedStatusModel->status = '0';
                if ($NewTimesheetApprovedStatusModel->save()) {
                    $TimesheetApprovedStatus_primary_id = $NewTimesheetApprovedStatusModel->id;
                    $approved_form_model = TimesheetApprovedStatus::model()->findByPk($TimesheetApprovedStatus_primary_id);

                    $TimesheetApprovedStatusModel = TimesheetApprovedStatus::model()->findByAttributes(
                            array(
                                'pay_date_id' => $selected_pay_date_model->id,
                                'user_id' => $selected_user->id,
                            )
                    );
                }
            }
/********************/


            $Criteria7 = new CDbCriteria();
            $select_condition = "$this->where_agent_condition AND user_id=" . $selected_user->id . " AND pay_date_id=" . $selected_pay_date_model->id;
            $Criteria7->condition = "user_id=" . $selected_user->id . " AND pay_date_id=" . $selected_pay_date_model->id;
            $Criteria7->order = "working_date";
            $right_side_result = TimesheetPayDatesUser::model()->findAll($Criteria7);

            // right side data
// For selected Worker				
// if some data already present timesheet table for selected worker, below code block will execute
            if (count($right_side_result) > 0) {
                $count_records = count($right_side_result);

                if ($count_records == 1) {
                    $last_inserted_record_working_date = $selected_pay_date_model->payment_start_date;
                } else if ($count_records > 0 && isset($right_side_result[$count_records - 1]->working_date)) {
                    $last_inserted_record_working_date = $right_side_result[$count_records - 1]->working_date;
                }

                if (isset($last_inserted_record_working_date) && $last_inserted_record_working_date > $selected_pay_date_model->payment_start_date) {
                    $available_dates = array();

                    if ($current_date > $selected_pay_date_model->payment_end_date)
                        $payment_last_date = $selected_pay_date_model->payment_end_date;
                    else
                        $payment_last_date = $current_date;

                    $interval_days = CommonFunctions::getIntervalDays($last_inserted_record_working_date, $payment_last_date);
                    if ($interval_days > 0 && $interval_days <= 14) {
                        $next_date = $last_inserted_record_working_date;
                        for ($i = 0; $i < $interval_days; $i++) {
                            $next_date = date('Y-m-d', strtotime($next_date . ' +1 days'));
                            $available_dates[] = $next_date;
                        }
                    }
                }

                //	if(date('Y-m-d') > $selected_pay_date_model->payment_end_date)
                //	$available_dates = array();
            }

            if (count($available_dates) > 14)
                throw new CHttpException(404, 'The requested page does not exist.');


            if (count($available_dates) > 0) {

                foreach ($available_dates as $single_date) {

                    $Criteria5 = new CDbCriteria();
                    $Criteria5->condition = "$this->where_agent_condition AND user_id=" . $selected_user->id . " AND job_date='" . $single_date . "'";
                    $Criteria5->order = "day_night";
                    $SSmodel = JobSiteSupervisor::model()->findAll($Criteria5);
                    if ($SSmodel !== NULL && count($SSmodel) > 0) {
                        $result = $this->getUserWorkingDateInfo($SSmodel);
                        if (count($result) > 1) {
                            foreach ($result as $tempResult) {
                                $right_side_data[$single_date][] = $tempResult;
                            }
                        } else {
                            $right_side_data[$single_date][] = $result[0];
                        }
                    }
                    //echo '<pre>'; print_r($SSmodel); echo '</pre>';

                    $Criteria6 = new CDbCriteria();
                    $Criteria6->condition = "$this->where_agent_condition AND user_id=" . $selected_user->id . " AND job_date='" . $single_date . "'";
                    $Criteria6->order = "day_night";
                    $STmodel = JobStaff::model()->findAll($Criteria6);
                    if ($STmodel !== NULL && count($STmodel) > 0) {
                        $result = $this->getUserWorkingDateInfo($STmodel);
                        if (count($result) > 1) {
                            foreach ($result as $tempResult) {
                                $right_side_data[$single_date][] = $tempResult;
                            }
                        } else {
                            $right_side_data[$single_date][] = $result[0];
                        }
                    }
                    //echo '<pre>'; print_r($STmodel); echo '</pre>';

                    if (!isset($right_side_data[$single_date])) {
                        $right_side_data[$single_date] = $this->getUserWorkingDateInfoBlank($single_date);
                    }
                }
            }


// supervisor

            $Criterias5 = new CDbCriteria();
            $Criterias5->condition = "$this->where_agent_condition AND user_id=" . $selected_user->id;
            $Criterias5->addInCondition("job_id", $working_job_ids);
            $Smodel = JobSupervisor::model()->findAll($Criterias5);


            if (count($Smodel) > 0) {
                $selected_supervisor_job_ids = array();
                foreach ($Smodel as $tempRecord) {
                    $selected_supervisor_job_ids[] = $tempRecord->job_id;
                }
                if (count($selected_supervisor_job_ids) > 0) {
                    $Criteria9 = new CDbCriteria();
                    $Criteria9->addInCondition("job_id", $selected_supervisor_job_ids);
                    $Criteria9->order = "working_date";
                    $job_working_supervisor_model = JobWorking::model()->findAll($Criteria9);
                    $SResult = $this->getUserWorkingDateInfoSuperVisor($job_working_supervisor_model);
                }
            }


            /******************** */
            // inserting records
            if ($TimesheetApprovedStatusModel->status === '0')
                $this->insertWorkerPayDateTimes($right_side_data, $selected_user, $selected_pay_date_model, $available_dates);
            /******************* */

//echo '<pre>'; print_r($available_dates); echo '</pre>';


/*****Adding new row******/

$add_new_row_model = new TimesheetPayDatesUser;
$add_new_row_model->day_night = 'NIGHT';
if (isset($_POST['TimesheetPayDatesUser'])) {
$add_new_row_model->attributes = $_POST['TimesheetPayDatesUser'];
$working_date = $_POST['TimesheetPayDatesUser']['working_date'];
$job_id = empty($_POST['TimesheetPayDatesUser']['job_id']) ? 0 : $_POST['TimesheetPayDatesUser']['job_id'];

if(empty($working_date)) {
	echo 'working date must select.'; exit;
}

if($job_id >0) {
$job_model = QuoteJobs::model()->findByPk($job_id);
	if($job_model === null) {
				Yii::app()->user->setFlash('warning','Your entered job_id not exist.');
				$this->refresh(); exit;
	}
}
	                

$check_duplicate_query = "SELECT * FROM hc_timesheet_pay_dates_user WHERE $this->where_agent_condition AND user_id = $selected_user->id && job_id = $job_id && pay_date_id=$selected_pay_date_model->id && working_date = '" . $working_date . "' && day_night = '" . $add_new_row_model->day_night . "'";
$temp_Result = $connection->createCommand($check_duplicate_query)->queryRow();


$check_jobs_perday_query = "SELECT * FROM hc_timesheet_pay_dates_user WHERE  $this->where_agent_condition AND user_id = $selected_user->id && pay_date_id=$selected_pay_date_model->id && working_date = '" . $working_date . "'";
$temp_Result_jobperday = $connection->createCommand($check_jobs_perday_query)->queryAll();
if(count($temp_Result_jobperday) >= 3) {
		Yii::app()->user->setFlash('warning','You can add max 3 shifts in a day.');
		$this->refresh(); exit;	
}


//			echo '<pre>'; print_r($temp_Result_jobperday); echo '</pre>'; exit;
			if (!isset($temp_Result['id'])) {


			    $add_new_row_model->user_id = $selected_user->id;
			    $add_new_row_model->pay_date_id = $selected_pay_date_model->id;
			    $add_new_row_model->working_date = $working_date;
			    $add_new_row_model->formatted_working_date = date("d/m/Y", strtotime($working_date));
			    $add_new_row_model->day = date('l', strtotime($working_date));
			    $add_new_row_model->work_start_time = '00:00';
			    $add_new_row_model->work_end_time = '00:00';
			    $add_new_row_model->total_hours = 0.00;
			    $add_new_row_model->regular_hours = 0.00;
			    $add_new_row_model->overtime_hours = 0.00;
			    $add_new_row_model->double_time_hours = 0.00;
			    $add_new_row_model->job_id = $job_id;
			    $add_new_row_model->job_location = '';
			    $add_new_row_model->service_name = '';
                            $add_new_row_model->agent_id = $this->agent_id;



				if($add_new_row_model->save()){
				Yii::app()->user->setFlash('success','New row added successfully.');
				$this->refresh();		
				}
		} else {
				Yii::app()->user->setFlash('warning','Duplicate row.');
				$this->refresh();	
		}
}
/***********/








            $Criteria8 = new CDbCriteria();
            $Criteria8->condition = "$this->where_agent_condition AND user_id=" . $selected_user->id . " AND pay_date_id=" . $selected_pay_date_model->id;
            $Criteria8->order = "working_date";
            $right_side_result = TimesheetPayDatesUser::model()->findAll($Criteria8);

            $query = "SELECT SUM(total_hours) as TH, SUM(regular_hours) as RH, SUM(overtime_hours) as OH, SUM(double_time_hours) as DTH from hc_timesheet_pay_dates_user where $this->where_agent_condition AND user_id=" . $selected_user->id . " AND pay_date_id=" . $selected_pay_date_model->id;
            $summaryResult = $connection->createCommand($query)->queryRow();
            //echo '<pre>'; print_r($summaryResult); echo '</pre>';

            $date_frequency_temp = array();
            foreach ($right_side_result as $record) {
                $date_frequency_temp[] = $record->working_date;
            }

            if (count($date_frequency_temp) === 0) {
                echo 'No record found for selected user.';
                exit;
            }

            $date_frequency = array_count_values($date_frequency_temp);
            //echo '<pre>'; print_r($date_frequency); echo '</pre>';
        } // submitting form ends....








        $this->render('timesheet', array(
            'selected_pay_date_model' => $selected_pay_date_model, // selected pay date model
            'pay_dates' => $pay_dates, // jquery enables dates
            'selected_user' => $selected_user, // selected active worker
            'workers_model' => $workers_model, // left side data
            'right_side_data' => $right_side_data, // right side data
            'right_side_result' => $right_side_result,
            'summaryResult' => $summaryResult, // right bottom of table
            'timeDropdown' => $timeDropdown,
            'approved_form_model' => $approved_form_model,
            'final_calculation_model' => $final_calculation_model,
            'date_frequency' => $date_frequency,
            'TimesheetApprovedStatusModel' => $TimesheetApprovedStatusModel,
            'add_new_row_model' => $add_new_row_model
                )
        );
    }

    public function removeAdminFromActiveStaff($working_user_ids) {

        // find admins
        $admin_model = User::model()->findAllByAttributes(
                array(
                    'role_id' => 1,
                )
        );
        $array_admin_ids = array();
        foreach ($admin_model as $row_admins) {
            $array_admin_ids[] = $row_admins->id;
        }
        /*         * ************* */
        // remove admin from active staff dropdown
        $working_user_ids = array_diff($working_user_ids, $array_admin_ids);
        $working_user_ids = array_unique($working_user_ids);
        $working_user_ids = array_values($working_user_ids);

        return $working_user_ids;
    }

    public function insertWorkerPayDateTimes($right_side_data, $selected_user, $selected_pay_date_model, $available_dates) {

        $connection = Yii::app()->db;

        foreach ($right_side_data as $key => $working_date) {
            foreach ($working_date as $record) {

                if ($record['job_id'] == 0 && !in_array($selected_user->role_id, array(3, 6)) && isset($SResult[$record['working_date']])) {

                    foreach ($SResult[$record['working_date']] as $Srecord) {

                        $job_id = $Srecord['job_id'];
                        $check_duplicate_query = "SELECT * FROM hc_timesheet_pay_dates_user WHERE user_id = $selected_user->id && job_id = $job_id && pay_date_id=$selected_pay_date_model->id && working_date = '" . $Srecord['working_date'] . "' && day_night = '" . $Srecord['day_night'] . "'";
                        $temp_Result = $connection->createCommand($check_duplicate_query)->queryRow();


                        if (!isset($temp_Result['id']) && in_array($Srecord['working_date'], $available_dates)) {

                            if ($Srecord['working_date'] > $selected_pay_date_model->payment_end_date)
                                break;

                            $timesheetPayDateUserModel = new TimesheetPayDatesUser;
                            $timesheetPayDateUserModel->user_id = $selected_user->id;
                            $timesheetPayDateUserModel->pay_date_id = $selected_pay_date_model->id;
                            $timesheetPayDateUserModel->working_date = $Srecord['working_date'];
                            $timesheetPayDateUserModel->formatted_working_date = $Srecord['formatted_working_date'];
                            $timesheetPayDateUserModel->day = $Srecord['day'];
                            $timesheetPayDateUserModel->day_night = $Srecord['day_night'];
                            $timesheetPayDateUserModel->work_start_time = '00:00';
                            $timesheetPayDateUserModel->work_end_time = '00:00';
                            $timesheetPayDateUserModel->total_hours = 0.00;
                            $timesheetPayDateUserModel->regular_hours = 0.00;
                            $timesheetPayDateUserModel->overtime_hours = 0.00;
                            $timesheetPayDateUserModel->double_time_hours = 0.00;
                            $timesheetPayDateUserModel->job_id = $Srecord['job_id'];
                            $timesheetPayDateUserModel->job_location = $Srecord['site_name'];
                            $timesheetPayDateUserModel->service_name = $Srecord['service_name'];
                            $timesheetPayDateUserModel->agent_id = $this->agent_id;
                            $timesheetPayDateUserModel->save();
                        }
                    }
                } else {

                    $job_id = $record['job_id'];
                    $check_duplicate_query = "SELECT * FROM hc_timesheet_pay_dates_user WHERE user_id = $selected_user->id && job_id = $job_id && pay_date_id=$selected_pay_date_model->id && working_date = '" . $record['working_date'] . "' && day_night = '" . $record['day_night'] . "'";
                    $temp_Result = $connection->createCommand($check_duplicate_query)->queryRow();


                    if (!isset($temp_Result['id']) && in_array($record['working_date'], $available_dates)) {


                        if ($record['working_date'] > $selected_pay_date_model->payment_end_date)
                            break;


                        $timesheetPayDateUserModel = new TimesheetPayDatesUser;
                        $timesheetPayDateUserModel->user_id = $selected_user->id;
                        $timesheetPayDateUserModel->pay_date_id = $selected_pay_date_model->id;
                        $timesheetPayDateUserModel->working_date = $record['working_date'];
                        $timesheetPayDateUserModel->formatted_working_date = $record['formatted_working_date'];
                        $timesheetPayDateUserModel->day = $record['day'];
                        $timesheetPayDateUserModel->day_night = $record['day_night'];
                        $timesheetPayDateUserModel->work_start_time = '00:00';
                        $timesheetPayDateUserModel->work_end_time = '00:00';
                        $timesheetPayDateUserModel->total_hours = 0.00;
                        $timesheetPayDateUserModel->regular_hours = 0.00;
                        $timesheetPayDateUserModel->overtime_hours = 0.00;
                        $timesheetPayDateUserModel->double_time_hours = 0.00;
                        $timesheetPayDateUserModel->job_id = $record['job_id'];
                        $timesheetPayDateUserModel->job_location = $record['site_name'];
                        $timesheetPayDateUserModel->service_name = $record['service_name'];
                        $timesheetPayDateUserModel->agent_id = $this->agent_id;
                        $timesheetPayDateUserModel->save();
                    }
                }
            }
        }
    }

    public function getUserWorkingDateInfoSuperVisor($model) {

        $result = array();

        foreach ($model as $record) {



            $job_id = $record->job_id;
            $right_side_data['job_id'] = $job_id;
            $right_side_data['working_date'] = $record->working_date;
            $right_side_data['formatted_working_date'] = date("d/m/Y", strtotime($record->working_date));
            $right_side_data['day'] = date('l', strtotime($record->working_date));
            $right_side_data['day_night'] = $record->day_night;

            // job_model
            $job_model = QuoteJobs::model()->findByPk($job_id);
            // quote_model
            $quote_model = Quotes::model()->findByPk($job_model->quote_id);
            // site model
            $site_model = ContactsSite::model()->findByPk($quote_model->site_id);
            // service model
            $service_model = Service::model()->findByPk($quote_model->service_id);

            $right_side_data['site_name'] = $site_model->site_name;
            $right_side_data['service_name'] = $service_model->service_name;
            $result[$record->working_date][] = $right_side_data;
        }

        return $result;
    }

    public function getUserWorkingDateInfo($model) {
        $i = 0;
        foreach ($model as $record) {

            $job_id = $record->job_id;
            $right_side_data[$i]['job_id'] = $job_id;
            $right_side_data[$i]['working_date'] = $record->job_date;
            $right_side_data[$i]['formatted_working_date'] = date("d/m/Y", strtotime($record->job_date));
            $right_side_data[$i]['day'] = date('l', strtotime($record->job_date));
            $right_side_data[$i]['day_night'] = $record->day_night;

            // job_model
            $job_model = QuoteJobs::model()->findByPk($job_id);
            // quote_model
            $quote_model = Quotes::model()->findByPk($job_model->quote_id);
            // site model
            $site_model = ContactsSite::model()->findByPk($quote_model->site_id);
            // service model
            $service_model = Service::model()->findByPk($quote_model->service_id);

            $right_side_data[$i]['site_name'] = $site_model->site_name;
            $right_side_data[$i]['service_name'] = $service_model->service_name;
            $i++;
        }

        return $right_side_data;
    }

    public function getUserWorkingDateInfoBlank($working_date) {
        $i = 0;

        $right_side_data[$i]['job_id'] = 0;
        $right_side_data[$i]['working_date'] = $working_date;
        $right_side_data[$i]['formatted_working_date'] = date("d/m/Y", strtotime($working_date));
        $right_side_data[$i]['day'] = date('l', strtotime($working_date));
        $right_side_data[$i]['day_night'] = 'DAY';
        $right_side_data[$i]['site_name'] = '';
        $right_side_data[$i]['service_name'] = '';

        return $right_side_data;
    }

  
    public function actionSaveUserTimes() {

        $record_primary_id = isset($_REQUEST['record_primary_id']) ? $_REQUEST['record_primary_id'] : 0;
        $job_location = isset($_REQUEST['job_location']) ? $_REQUEST['job_location'] : '';
        $service_name = isset($_REQUEST['service_name']) ? $_REQUEST['service_name'] : '';
        $work_start_time = isset($_REQUEST['work_start_time']) ? $_REQUEST['work_start_time'] : '';
        $work_end_time = isset($_REQUEST['work_end_time']) ? $_REQUEST['work_end_time'] : '';
        $total_hours = isset($_REQUEST['total_hours']) ? $_REQUEST['total_hours'] : '';
        $regular_hours = isset($_REQUEST['regular_hours']) ? $_REQUEST['regular_hours'] : '';
        $overtime_hours = isset($_REQUEST['overtime_hours']) ? $_REQUEST['overtime_hours'] : '';
        $double_time_hours = isset($_REQUEST['double_time_hours']) ? $_REQUEST['double_time_hours'] : '';

        if ($record_primary_id > 0) {
            $model = TimesheetPayDatesUser::model()->findByPk($record_primary_id);
            $model->job_location = $job_location;
            $model->service_name = $service_name;
            $model->work_start_time = $work_start_time;
            $model->work_end_time = $work_end_time;
            $model->total_hours = $total_hours;
            $model->regular_hours = $regular_hours;
            $model->overtime_hours = $overtime_hours;
            $model->double_time_hours = $double_time_hours;
            $model->agent_id = $this->agent_id;
            $model->saved_status = '1';
            if ($model->save()) {

                $connection = Yii::app()->db;
                $query = "SELECT SUM(total_hours) as TH, SUM(regular_hours) as RH, SUM(overtime_hours) as OH, SUM(double_time_hours) as DTH from hc_timesheet_pay_dates_user where $this->where_agent_condition AND user_id=" . $model->user_id . " AND pay_date_id=" . $model->pay_date_id;
                $summaryResult = $connection->createCommand($query)->queryRow();
                echo json_encode($summaryResult);
                exit;
            }
        }
    }

    public function actionCreateExcel() {
        $connection = Yii::app()->db;
        $pay_date_id = isset($_REQUEST['pay_date_id']) ? $_REQUEST['pay_date_id'] : 0;

        if ($pay_date_id == 0)
            return;


        $pay_date_model = TimesheetPayDates::model()->findByPk($pay_date_id);

        if ($pay_date_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        //echo '<pre>'; print_r($pay_date_model); echo '</pre>';

        $final_calculation_model = TimesheetApprovedStatus::model()->findAllByAttributes(
                array(
                    'pay_date_id' => $pay_date_id,
                    'status' => '1',
                )
        );

        if (count($final_calculation_model) == 0)
            return;

        $sheets = array();

        foreach ($final_calculation_model as $staff_worker) {

            $select_fields = "job_id, user_id, saved_status, pay_date_id, working_date, formatted_working_date, day, day_night, job_location, service_name, ";
            $select_fields .= "work_start_time, work_end_time, SUM(total_hours) as total_hours, SUM(regular_hours) as regular_hours, SUM(overtime_hours) as overtime_hours, SUM(double_time_hours) as double_time_hours ";
            $query_calculation = "SELECT $select_fields from hc_timesheet_pay_dates_user where saved_status= '1' AND user_id=" . $staff_worker->user_id . " AND pay_date_id=" . $staff_worker->pay_date_id . " group by working_date";
            $summaryResult = $connection->createCommand($query_calculation)->queryAll();
            $sheets[$staff_worker->user_id] = $summaryResult;
        }

        Yii::import('ext.phpexcel.XPHPExcel');

        $objPHPExcel = XPHPExcel::createPHPExcel();
        $objPHPExcel->getProperties()->setCreator("Mikhil Kotak")
                ->setLastModifiedBy("Mikhil Kotak")
                ->setTitle("Time sheet")
                ->setSubject("Time sheet")
                ->setDescription("Pay date.")
                ->setKeywords("Time Sheet")
                ->setCategory("Time sheet");

        $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri')
                ->setSize(11);

        $sheet_count = 0;

        foreach ($sheets as $user_id => $TimesheetPayDatesUserRecord) {

            if (count($TimesheetPayDatesUserRecord) > 0) {
                $selected_user = User::model()->findByPk($user_id);

                $calculation_model = TimesheetApprovedStatus::model()->findByAttributes(
                        array(
                            'pay_date_id' => $pay_date_id,
                            'user_id' => $selected_user->id,
                            'status' => '1',
                        )
                );

                $objPHPExcel->setActiveSheetIndex($sheet_count)->mergeCells('B1:J1');
                $objPHPExcel->setActiveSheetIndex($sheet_count)->mergeCells('B2:J2');

                $objPHPExcel->setActiveSheetIndex($sheet_count)
                        ->setCellValue('B1', 'HIGH CLEAN FORTNIGHTLY TIME SHEET');
                $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setName('Calibri Light')->setBold(true)->setSize(18);


                $objPHPExcel->setActiveSheetIndex($sheet_count)->mergeCells('B3:J3');
                $objPHPExcel->setActiveSheetIndex($sheet_count)
                        ->setCellValue('B3', 'Pay Date = ' . date("d/m/Y", strtotime($pay_date_model->pay_date)));
                $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true)->setSize(11);

                $objPHPExcel->setActiveSheetIndex($sheet_count)->mergeCells('B4:J4');
                $objPHPExcel->setActiveSheetIndex($sheet_count)
                        ->setCellValue('B4', 'Staff Name = ' . $selected_user->first_name . ' ' . $selected_user->last_name);
                $objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true)->setSize(11);

                $start_index = 6;


                $objPHPExcel->setActiveSheetIndex($sheet_count)
                        ->setCellValue('B' . $start_index, 'Day')
                        ->setCellValue('C' . $start_index, 'Date')
                        ->setCellValue('D' . $start_index, 'Total Hours')
                        ->setCellValue('E' . $start_index, 'Rate')
                        ->setCellValue('F' . $start_index, 'Regular Hours')
                        ->setCellValue('G' . $start_index, 'Rate')
                        ->setCellValue('H' . $start_index, 'OT Hours')
                        ->setCellValue('I' . $start_index, 'Rate')
                        ->setCellValue('J' . $start_index, 'DT hours')
                        ->setCellValue('K' . $start_index, 'Total Wage');

                $objPHPExcel->getActiveSheet()->getStyle('B' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('D' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('E' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('F' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('G' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('I' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('K' . $start_index)->getFont()->setBold(true)->setSize(11);

//values						
                foreach ($TimesheetPayDatesUserRecord as $time_record) {
                    $start_index++;

                    $excel_day = $time_record['day'];
                    $objPHPExcel->setActiveSheetIndex($sheet_count)
                            ->setCellValue('B' . $start_index, $excel_day);
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $start_index)->getNumberFormat()->setFormatCode('0.00');

                    $excel_date = $time_record['formatted_working_date'];
                    $objPHPExcel->setActiveSheetIndex($sheet_count)
                            ->setCellValue('C' . $start_index, $excel_date);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $start_index)->getNumberFormat()->setFormatCode('0.00');

// regular_hours			
                    $reg_rate_per_hr = $calculation_model->reg_rate_per_hr;
                    $objPHPExcel->setActiveSheetIndex($sheet_count)
                            ->setCellValue('E' . $start_index, $reg_rate_per_hr);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $start_index)->getNumberFormat()->setFormatCode('0.00');

                    $regular_hours = $time_record['regular_hours'];
                    $objPHPExcel->setActiveSheetIndex($sheet_count)
                            ->setCellValue('F' . $start_index, $regular_hours);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $start_index)->getNumberFormat()->setFormatCode('0.00');

// overtime_hours			
                    $ot_rate_per_hr = $calculation_model->ot_rate_per_hr;
                    $objPHPExcel->setActiveSheetIndex($sheet_count)
                            ->setCellValue('G' . $start_index, $ot_rate_per_hr);
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $start_index)->getNumberFormat()->setFormatCode('0.00');

                    $overtime_hours = $time_record['overtime_hours'];
                    $objPHPExcel->setActiveSheetIndex($sheet_count)
                            ->setCellValue('H' . $start_index, $overtime_hours);
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $start_index)->getNumberFormat()->setFormatCode('0.00');

// double_time_hours			
                    $dt_rate_per_hr = $calculation_model->dt_rate_per_hr;
                    $objPHPExcel->setActiveSheetIndex($sheet_count)
                            ->setCellValue('I' . $start_index, $dt_rate_per_hr);
                    $objPHPExcel->getActiveSheet()->getStyle('I' . $start_index)->getNumberFormat()->setFormatCode('0.00');

                    $double_time_hours = $time_record['double_time_hours'];
                    $objPHPExcel->setActiveSheetIndex($sheet_count)
                            ->setCellValue('J' . $start_index, $double_time_hours);
                    $objPHPExcel->getActiveSheet()->getStyle('J' . $start_index)->getNumberFormat()->setFormatCode('0.00');


// total_hours	
                    $total_hours = $time_record['total_hours'];
                    $total_hours_excel = '=SUM(F' . $start_index . ',H' . $start_index . ',J' . $start_index . ')';
                    $objPHPExcel->setActiveSheetIndex($sheet_count)
                            ->setCellValue('D' . $start_index, $total_hours_excel);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $start_index)->getNumberFormat()->setFormatCode('0.00');

// total_wages	
                    $total_wages_excel = '=SUM(E' . $start_index . '*F' . $start_index . ',G' . $start_index . '*H' . $start_index . ',I' . $start_index . '*J' . $start_index . ')';
                    $objPHPExcel->setActiveSheetIndex($sheet_count)
                            ->setCellValue('K' . $start_index, $total_wages_excel);
                    $objPHPExcel->getActiveSheet()->getStyle('K' . $start_index)->getNumberFormat()->setFormatCode('0.00');
                }

                $start_index++;
                $last_cell_index = $start_index - 1;
// grand total
                $objPHPExcel->setActiveSheetIndex($sheet_count)->mergeCells('B' . $start_index . ':C' . $start_index);
                $objPHPExcel->setActiveSheetIndex($sheet_count)
                        ->setCellValue('B' . $start_index, 'Grand Total');
                $objPHPExcel->getActiveSheet()->getStyle('B' . $start_index)->getFont()->setBold(true)->setSize(11);



// total regular_hours
                $objPHPExcel->setActiveSheetIndex($sheet_count)
                        ->setCellValue('F' . $start_index, '=SUM(F7:F' . $last_cell_index . ')');
                $objPHPExcel->getActiveSheet()->getStyle('F' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('F' . $start_index)->getNumberFormat()->setFormatCode('0.00');



// total overtime_hours
                $objPHPExcel->setActiveSheetIndex($sheet_count)
                        ->setCellValue('H' . $start_index, '=SUM(H7:H' . $last_cell_index . ')');
                $objPHPExcel->getActiveSheet()->getStyle('H' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $start_index)->getNumberFormat()->setFormatCode('0.00');

// total double_time_hours
                $objPHPExcel->setActiveSheetIndex($sheet_count)
                        ->setCellValue('J' . $start_index, '=SUM(J7:J' . $last_cell_index . ')');
                $objPHPExcel->getActiveSheet()->getStyle('J' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $start_index)->getNumberFormat()->setFormatCode('0.00');

// grand total hours
                $objPHPExcel->setActiveSheetIndex($sheet_count)
                        ->setCellValue('D' . $start_index, '=SUM(D7:D' . $last_cell_index . ')');
                $objPHPExcel->getActiveSheet()->getStyle('D' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('D' . $start_index)->getNumberFormat()->setFormatCode('0.00');

// grand total wage
                $objPHPExcel->setActiveSheetIndex($sheet_count)
                        ->setCellValue('K' . $start_index, '=SUM(K7:K' . $last_cell_index . ')');
                $objPHPExcel->getActiveSheet()->getStyle('K' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('K' . $start_index)->getNumberFormat()->setFormatCode('0.00');


// Auto size cell
                //$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);


// Rename worksheet
                $sheet_name = $selected_user->first_name . ' ' . strtoupper($selected_user->last_name[0]);
                $objPHPExcel->getActiveSheet()->setTitle($sheet_name);


                $sheet_count++;
                if ($sheet_count < count($sheets)) {
                    $objWorksheet = new PHPExcel_Worksheet($objPHPExcel);
                    $objPHPExcel->addSheet($objWorksheet);
                }
            }
        }


        // Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        $file_name = "timesheet-" . date("d-m-Y", strtotime($pay_date_model->pay_date)) . ".xls";
        header('Content-Disposition: attachment;filename="' . $file_name . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
        $objWriter->save('php://output');
        Yii::app()->end();
    }

}
