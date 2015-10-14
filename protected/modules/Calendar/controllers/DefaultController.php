<?php

ini_set('max_execution_time', 0);

class DefaultController extends Controller {

    public $layout = '//layouts/column1';
    public $base_url_assets = null;
    public $current_user_id = 0;
    public $user_roles = array();
    public $user_role_base_url = ''; public $user_dashboard_url = '';
    public $agent_id = '';
    public $where_agent_condition = '';
    public $agent_info = null;    

    public function init() {

        $this->user_roles = array('system_owner', 'state_manager', 'operation_manager', 'agent', 'supervisor', 'site_supervisor', 'staff');

        if (!in_array(Yii::app()->user->name, $this->user_roles))
            throw new CHttpException(404, 'The requested page does not exist.');

        $this->current_user_id = isset(Yii::app()->user->id) ? Yii::app()->user->id : 0;
        if ($this->current_user_id == 0)
            throw new CHttpException(404, 'The requested page does not exist.');

        $this->base_url_assets = CommonFunctions::siteURL();         
	$this->user_role_base_url = CommonFunctions::getUserBaseUrl(Yii::app()->user->name);
		$this->user_dashboard_url = CommonFunctions::getUserDashboardUrl(Yii::app()->user->name);
        $this->agent_id = CommonFunctions::getCurrentpageAgentId(Yii::app()->user->name);
        $this->where_agent_condition = " agent_id = ".$this->agent_id ;
	$this->agent_info = CommonFunctions::getAgentInfo($this->agent_id);

    }

    public function accessRules() {



        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'GetMonthReport', 'DragJob', 'View_inductions', 'updateInduction'),
                'users' => $this->user_roles,
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/css/calendar/js/moment.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/css/calendar/js/fullcalendar.min.js', CClientScript::POS_END);
        $connection = Yii::app()->db;

        
        $user_model = User::model()->findByPk($this->current_user_id);


        $job_status = isset($_REQUEST['job_status']) ? urldecode($_REQUEST['job_status']) : '';
        $approval_status = isset($_REQUEST['approval_status']) ? urldecode($_REQUEST['approval_status']) : '';


        $Criteria = new CDbCriteria();

        if (!empty($approval_status)) {
            $this->where_agent_condition .= " && approval_status = '$approval_status'";
        }
        
        if (!empty($job_status) && $job_status == 'Started')
             $this->where_agent_condition .= " && job_status = 'Started' || job_status = 'Restarted' ";
        else if (!empty($job_status))
            $this->where_agent_condition .= " && job_status = '$job_status'";


        if (in_array(Yii::app()->user->name, array('supervisor', 'site_supervisor', 'staff'))) {
            if ($user_model->view_jobs == '0') {
                $valid_job_ids = CommonFunctions::getValidJobs($user_model, Yii::app()->user->name);
                $Criteria->addInCondition("id", $valid_job_ids);
            }
        }



        $site_ids = array();
        $Criteria->condition = $this->where_agent_condition;
        $all_jobs = QuoteJobs::model()->findAll($Criteria);

        $calender_result = $this->calenderEventsAndValues($all_jobs);
        $calender_events = $calender_result['calender_events'];
        $approved_booked_value = $calender_result['approved_booked_value'];
        $not_approved_booked_value = $calender_result['not_approved_booked_value'];

        $Criteria = new CDbCriteria();
        $Criteria->condition = "user_id = " . $this->current_user_id . " && (induction_status='pending' || CURDATE() > expiry_date)";
        $induction_dues = Induction::model()->findAll($Criteria);

        //echo '<pre>'; print_r($calender_events); echo '</pre>';

        $this->render('index', array(
            'calender_events' => json_encode($calender_events),
            'job_status' => $job_status,
            'approval_status' => $approval_status,
            'approved_booked_value' => $approved_booked_value,
            'not_approved_booked_value' => $not_approved_booked_value,
            'induction_dues' => $induction_dues,
                )
        );
    }

    public function calenderEventsAndValues($all_jobs) {

        // to show timing on bar from job_working table
        $job_working_model = JobWorking::model()->findAll();
        $job_working_timing = array();
        foreach ($job_working_model as $row) {
            if (!empty($row->site_time)) {
                $job_working_timing[$row->job_id][$row->working_date][$row->day_night]['yard_time'] = $row->working_date . 'T' . date("H:i:s", strtotime($row->yard_time));
                $job_working_timing[$row->job_id][$row->working_date][$row->day_night]['site_time'] = $row->working_date . 'T' . date("H:i:s", strtotime($row->site_time));
                $job_working_timing[$row->job_id][$row->working_date][$row->day_night]['finish_time'] = $row->working_date . 'T' . date("H:i:s", strtotime($row->finish_time));
            }
        }

        //echo '<pre>'; print_r($job_working_timing); echo '</pre>';


        $calender_events = array();
        $i = 0;
        $approved_booked_value = 0;
        $not_approved_booked_value = 0;
        foreach ($all_jobs as $job) {

            if ($job->booked_status == 'Booked' && $job->approval_status == 'Approved By Admin')
                $approved_booked_value = $approved_booked_value + $job->final_total;

            if ($job->booked_status == 'Booked' && $job->approval_status == 'Pending Admin Approval')
                $not_approved_booked_value = $not_approved_booked_value + $job->final_total;

            // quote model by job id
            $quote_model = Quotes::model()->findByPk($job->quote_id);

            if ($quote_model !== null) {

                $calender_events[$i]['id'] = $job->id;

                // building model
                $building_model = Buildings::model()->findByPk($job->building_id);

                // site model
                $site_model = ContactsSite::model()->findByPk($quote_model->site_id);
                $site_ids[] = $site_model->id;

                if (in_array(Yii::app()->user->name, array('system_owner', 'state_manager', 'operation_manager', 'agent'))) {
                    $title = '(' . $job->id . ')- $' . $job->final_total . '-' . $site_model->site_name . '-' . $building_model->building_name;
                } else {
                    $title = '(' . $job->id . ')-' . $site_model->site_name . '-' . $building_model->building_name;
                }
                
                $title = str_replace("'", "", $title);
                $calender_events[$i]['title'] = $title;


                $calender_events[$i]['start'] = $job->job_started_date . 'T' . $job->job_started_time;
                $calender_events[$i]['end'] = $job->job_end_date . 'T' . $job->job_end_time;

                if (isset($job_working_timing[$job->id][$job->job_started_date]['NIGHT'])) {
                    $calender_events[$i]['start'] = $job_working_timing[$job->id][$job->job_started_date]['NIGHT']['yard_time'];
                }

                if (isset($job_working_timing[$job->id][$job->job_started_date]['DAY'])) {
                    $calender_events[$i]['start'] = $job_working_timing[$job->id][$job->job_started_date]['DAY']['yard_time'];
                }

                if (isset($job_working_timing[$job->id][$job->job_end_date]['DAY'])) {
                    $calender_events[$i]['end'] = $job_working_timing[$job->id][$job->job_end_date]['DAY']['finish_time'];
                }

                if (isset($job_working_timing[$job->id][$job->job_end_date]['NIGHT'])) {
                    $calender_events[$i]['end'] = $job_working_timing[$job->id][$job->job_end_date]['NIGHT']['finish_time'];
                }


                $calender_events[$i]['url'] = $this->user_role_base_url . '/?r=Quotes/Job/view&id=' . $job->id;

                if ($job->approval_status == 'Pending Admin Approval') {
                    $calender_events[$i]['className'] = "notapprovejob";
                } else if ($job->approval_status == 'Approved By Admin' && $job->job_status == 'NotStarted') {

                    if ($job->booked_status == 'Booked') {
                        $job_id = $job->id;
                        //check staff allocation			
                        $staff_model = JobStaff::model()->findByAttributes(
                                array(
                                    'job_id' => $job_id
                                )
                        );

                        if ($staff_model != null) {
                            $calender_events[$i]['className'] = "approvejob_staff";
                        } else {

                            //check site supervisor allocation if failed staff allocation			
                            $site_supervisor_model = JobSiteSupervisor::model()->findByAttributes(
                                    array(
                                        'job_id' => $job_id
                                    )
                            );

                            if ($site_supervisor_model != null) {
                                $calender_events[$i]['className'] = "approvejob_site_supervisor";
                            } else {

                                //check supervisor allocation if failed site supervisor		
                                $supervisor_model_model = JobSupervisor::model()->findByAttributes(
                                        array(
                                            'job_id' => $job_id
                                        )
                                );

                                if ($supervisor_model_model != null) {
                                    $calender_events[$i]['className'] = "approvejob_supervisor";
                                } else {
                                    $calender_events[$i]['className'] = "approvejob";
                                }
                            }
                        }
                    } else {
                        $calender_events[$i]['className'] = "approvejob";
                    }
                } else if ($job->job_status == 'Started' || $job->job_status == 'Restarted') {
                    $calender_events[$i]['className'] = "assignjob";
                } else if ($job->job_status == 'Paused') {
                    $calender_events[$i]['className'] = "pausedjob";
                } else if ($job->signed_off == 'Yes') {
                    $calender_events[$i]['className'] = "signoff_completedjob";
                } else if ($job->job_status == 'Completed') {
                    $calender_events[$i]['className'] = "completedjob";
                }

                $i++;
            }
        }

        $result = array(
            'approved_booked_value' => $approved_booked_value,
            'not_approved_booked_value' => $not_approved_booked_value,
            'calender_events' => $calender_events
        );

        return $result;
    }

    public function actionUpdateInduction($id) {
        
        $model = Induction::model()->findByPk($id);  
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);    
        $old_induction_card = $model->induction_card;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Induction'])) {
            $model->attributes = $_POST['Induction'];


            $_POST['Induction']['induction_card'] = $model->induction_card;
            $rnd = rand(0, 99999);  // generate random number between 0-99999			
            $uploadedFile2 = CUploadedFile::getInstance($model, 'induction_card');
            if ($uploadedFile2) {
                $induction_card_file = "{$rnd}-{$uploadedFile2}";
                $model->induction_card = $induction_card_file;
            } else {
                $model->induction_card = $old_induction_card;
            }

            if ($model->save()) {


                if (isset($induction_card_file)) {
                    $save = Yii::app()->basePath . '/../uploads/induction/cards/' . $induction_card_file;
                    $uploadedFile2->saveAs($save);
                    if (!empty($old_induction_card) && file_exists(Yii::app()->basePath . '/../uploads/induction/cards/' . $old_induction_card))
                        unlink(Yii::app()->basePath . '/../uploads/induction/cards/' . $old_induction_card);
                }

                $this->redirect(array('view_inductions', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionView_inductions() {


        
        $user_model = User::model()->findByPk($this->current_user_id);

        if ($this->current_user_id == 0)
            Yii::app()->request->redirect(Yii::app()->getBaseUrl(true) . '/?r=site/login');

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/css/calendar/js/moment.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/css/calendar/js/fullcalendar.min.js', CClientScript::POS_END);


        $Criteria = new CDbCriteria();
        $Criteria->condition = "induction_status ='pending' && user_id = $this->current_user_id && agent_id= $this->agent_id ";
        $induction_dues = Induction::model()->findAll($Criteria);



        $Criteria = new CDbCriteria();
        $Criteria->condition = "induction_status ='completed' && user_id = $this->current_user_id && agent_id= $this->agent_id ";
        $induction_completed = Induction::model()->findAll($Criteria);


        //echo '<pre>'; print_r($induction_dues); echo '</pre>';

        $this->render('view_inductions', array(
            'induction_dues' => $induction_dues,
            'induction_completed' => $induction_completed,
                )
        );
    }

    public function actionGetMonthReport() {
        $month_value_string = '';
        $connection = Yii::app()->db;
        $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $month_year = explode(' ', $title);

        if (count($month_year) == 2) {
            $selectd_month = date('m', strtotime($month_year[0]));
            ;
            $selectd_year = $month_year[1];


            $query = "SELECT IFNULL(SUM(final_total),0) as approved_booked_value FROM {{quote_jobs}}
	WHERE $this->where_agent_condition AND approval_status='Approved By Admin' AND booked_status='Booked' AND YEAR(job_started_date) = " . $selectd_year . " AND MONTH(job_started_date) = " . $selectd_month;
            $result = $connection->createCommand($query)->queryRow();
            $approved_booked_value = $result['approved_booked_value'];

            //$month_value_string = "<div style='clear:both;'></div><div style='margin-left:-0px;margin-bottom:-5x;text-align:center;'>";
            //$month_value_string .= "<p><strong>Approved Booked : $".$approved_booked_value."</strong><br/>";

            $month_value_string .= "<strong>Booked-Approved : $" . $approved_booked_value . "</strong><br/>";

            $query = "SELECT IFNULL(SUM(final_total),0) as not_approved_booked_value FROM {{quote_jobs}}
	WHERE $this->where_agent_condition AND approval_status='Pending Admin Approval' AND booked_status='Booked' AND YEAR(job_started_date) = " . $selectd_year . " AND MONTH(job_started_date) = " . $selectd_month;
            $result = $connection->createCommand($query)->queryRow();
            $not_approved_booked_value = $result['not_approved_booked_value'];

            $month_value_string .= "<strong>Booked-Not Approved  : $" . $not_approved_booked_value . "</strong>";

            //$month_value_string .= "<strong>Approved Not Booked : $".$not_approved_booked_value."</strong></p>";
            //$month_value_string .= "</div>";

            echo $month_value_string;
            exit;
        } else {
            echo '';
            exit;
        }
    }

    public function actionDragJob() {


        //print_r($_post);
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $move_date = isset($_REQUEST['move_date']) ? $_REQUEST['move_date'] : '';

        if ($id > 0) {
            $model = QuoteJobs::model()->findByPk($id);
            CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);        
            
            if($model->job_status === 'NotStarted') {
                
            $interval_days = CommonFunctions::getIntervalDays($model->job_started_date, $model->job_end_date);
            $model->job_started_date = $move_date;
            $model->job_end_date = date('Y-m-d', strtotime($move_date . ' +' . $interval_days . ' days'));
            if ($model->save()) {
                $delete_condition = "job_id=" . $id. " && agent_id=".$this->agent_id;
                JobStaff::model()->deleteAll(array("condition" =>   $delete_condition ));
                JobSiteSupervisor::model()->deleteAll(array("condition" => $delete_condition ));
            }
            
            }
            
        }
    }

}
