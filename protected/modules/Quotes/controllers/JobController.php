<?php

class JobController extends Controller {

	public $base_url_assets = null;
	public $role_for_job = null;
	public $layout = '//layouts/column1';
	public $IsUsingDevice = 0;
	public $user_role_base_url = ''; public $user_dashboard_url = '';
	public $agent_id = '';
	public $agent_info = null;
	public $where_agent_condition = '';

    public function init() {

        $this->base_url_assets = CommonFunctions::siteURL();
        $this->user_role_base_url = CommonFunctions::getUserBaseUrl(Yii::app()->user->name);
		$this->user_dashboard_url = CommonFunctions::getUserDashboardUrl(Yii::app()->user->name);
        $this->IsUsingDevice = CommonFunctions::IsUsingDevice();

        $this->agent_id = CommonFunctions::getCurrentpageAgentId(Yii::app()->user->name);
	$this->agent_info = CommonFunctions::getAgentInfo($this->agent_id);
        $this->where_agent_condition = " agent_id = " . $this->agent_id;
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {

        $current_user_id = isset(Yii::app()->user->id) ? Yii::app()->user->id : 0;
        if ($current_user_id == 0)
            Yii::app()->request->redirect($this->user_role_base_url . '/?r=site/login');

        $user_model = User::model()->findByPk($current_user_id);

        $user_access_actions = array();

        /******************************* ADMIN START ************************************ */
        if (in_array(Yii::app()->user->name,array('agent','system_owner', 'state_manager', 'operation_manager'))) {
            $user_access_actions = QuoteJobService::GetAccessActions('agent');
            $user_access_actions = array_merge($user_access_actions, $user_access_actions);
        } else {

            if (in_array(Yii::app()->user->name, array('supervisor', 'site_supervisor', 'staff'))) {
                $job_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $valid_job_ids = array();

                /*                 * **************************** STAFF START ************************************ */


                $valid_jobs_model = JobStaff::model()->findAll(array("condition" => "user_id=" .  $current_user_id));
                foreach ($valid_jobs_model as $allocated_staff_details) {
                    $valid_job_ids[] = $allocated_staff_details->job_id;
                }

                if (in_array($job_id, $valid_job_ids)) {

                    if (Yii::app()->user->name === 'supervisor') {
                        $this->role_for_job = 'supervisor';
                        $user_access_actions = QuoteJobService::GetAccessActions('supervisor');
                        $user_access_actions = array_merge($user_access_actions, $user_access_actions);
                    } else if (Yii::app()->user->name === 'site_supervisor') {
                        $this->role_for_job = 'site_supervisor';
                        $user_access_actions = QuoteJobService::GetAccessActions('site_supervisor');
                        $user_access_actions = array_merge($user_access_actions, $user_access_actions);
                    } else {
                        $this->role_for_job = 'staff';
                        $user_access_actions = QuoteJobService::GetAccessActions('staff');
                        $user_access_actions = array_merge($user_access_actions, $user_access_actions);
                    }
                }

                /*                 * ****************************** SITE SUPERVISOR START ************************************ */


                if ($this->role_for_job == null) {
                    if (Yii::app()->user->name === 'supervisor') {
                        $this->role_for_job = 'supervisor';
                        $user_access_actions = QuoteJobService::GetAccessActions('supervisor');
                        $user_access_actions = array_merge($user_access_actions, $user_access_actions);
                    } else {

                        $valid_jobs_model = JobSiteSupervisor::model()->findAll(array("condition" => "user_id=" .  $current_user_id));
                        foreach ($valid_jobs_model as $allocated_staff_details) {
                            $valid_job_ids[] = $allocated_staff_details->job_id;
                        }

                        if (in_array($job_id, $valid_job_ids)) {
                            $this->role_for_job = 'site_supervisor';
                            $user_access_actions = QuoteJobService::GetAccessActions('site_supervisor');
                            $user_access_actions = array_merge($user_access_actions, $user_access_actions);
                        }
                    }
                }



                /*                 * ****************************** SUPERVISOR START ************************************ */


                if ($this->role_for_job == null) {
                    $this->role_for_job = 'supervisor';
                    if ($user_model->view_jobs == '0') {

                        $valid_jobs_model = JobSupervisor::model()->findAll(array("condition" => "user_id=" .  $current_user_id));

                        foreach ($valid_jobs_model as $allocated_staff_details) {
                            $valid_job_ids[] = $allocated_staff_details->job_id;
                        }


                        if (in_array($job_id, $valid_job_ids)) {
                            $user_access_actions = QuoteJobService::GetAccessActions('supervisor');
                            $user_access_actions = array_merge($user_access_actions, $user_access_actions);
                        }
                    } else {

                        $user_access_actions = QuoteJobService::GetAccessActions('supervisor');
                        $user_access_actions = array_merge($user_access_actions, $user_access_actions);
                    }
                }



                if ($this->role_for_job == null) {
                    $this->role_for_job = 'service_client';
                    $user_access_actions = QuoteJobService::GetAccessActions('service_client');
                }
            }
        }


        if (count($user_access_actions) == 0) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        //echo '<pre>'; print_r($user_access_actions); echo '</pre>';exit;
        
        return array(
            array('allow', // allow admin user to perform 'agent' and 'delete' actions
                'actions' => $user_access_actions,
                'users' => array('system_owner', 'state_manager', 'operation_manager', 'agent', 'supervisor', 'site_supervisor', 'staff'),
            ),
            array('allow', // allow admin user to perform 'agent' and 'delete' actions
                'actions' => array('DownloadSignOffSheet'),
                'users' => array('service_client'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionSwmsSign($id) {

        $auto_user_id = isset($_POST['auto_user_id']) ? $_POST['auto_user_id'] : 0;
        $json_signature = isset($_POST['output']) ? $_POST['output'] : '';
        $save_signature = isset($_POST['save_signature']) ? $_POST['save_signature'] : '';
        $user_role_type = isset($_POST['user_role_type']) ? $_POST['user_role_type'] : '';
        $date_on_signed = isset($_POST['date_on_signed']) ? $_POST['date_on_signed'] : date('Y-m-d');

        // adding new member	 
        $extra_member_model = new JobExtraMember;
        if (isset($_POST['JobExtraMember'])) {
            $extra_member_model->attributes = $_POST['JobExtraMember'];
            $extra_member_model->agent_id = $this->agent_id;
            if ($extra_member_model->save()) {
                Yii::app()->user->setFlash('success', "Added new member successfully");
                $this->refresh();
            }
        }


        // saving signature
        if ($save_signature === 'Save Signature' && $auto_user_id > 0 && !empty($json_signature)) {

            if ($user_role_type === 'Supervisor') {
                $user_model = JobSupervisor::model()->findByPk($auto_user_id);
                $user_model->signature = $json_signature;
                $user_model->date_on_signed = $date_on_signed;
                $user_model->agent_id = $this->agent_id;
                if ($user_model->save()) {
                    Yii::app()->user->setFlash('success', "Signature updated successfully");
                    $this->refresh();
                }
            } else if ($user_role_type === 'Site Supervisor') {
                $user_model = JobSiteSupervisor::model()->findByPk($auto_user_id);
                $user_model->signature = $json_signature;
                $user_model->date_on_signed = $date_on_signed;
                $user_model->agent_id = $this->agent_id;
                if ($user_model->save()) {

                    Yii::app()->db
                            ->createCommand("UPDATE hc_job_site_supervisor SET signature = '" . $json_signature . "' , date_on_signed = '" . $date_on_signed . "' WHERE job_id=" . $id . " && user_id=" . $user_model->user_id)
                            ->execute();

                    Yii::app()->db
                            ->createCommand("UPDATE hc_job_staff SET signature = '" . $json_signature . "' , date_on_signed = '" . $date_on_signed . "' WHERE job_id=" . $id . " && user_id=" . $user_model->user_id)
                            ->execute();


                    Yii::app()->user->setFlash('success', "Signature updated successfully");
                    $this->refresh();
                }
            } else if ($user_role_type === 'Staff') {
                $user_model = JobStaff::model()->findByPk($auto_user_id);
                $user_model->signature = $json_signature;
                $user_model->date_on_signed = $date_on_signed;
                $user_model->agent_id = $this->agent_id;
                if ($user_model->save()) {

                    Yii::app()->db
                            ->createCommand("UPDATE hc_job_site_supervisor SET signature = '" . $json_signature . "' , date_on_signed = '" . $date_on_signed . "' WHERE job_id=" . $id . " && user_id=" . $user_model->user_id)
                            ->execute();

                    Yii::app()->db
                            ->createCommand("UPDATE hc_job_staff SET signature = '" . $json_signature . "' , date_on_signed = '" . $date_on_signed . "' WHERE job_id=" . $id . " && user_id=" . $user_model->user_id)
                            ->execute();

                    Yii::app()->user->setFlash('success', "Signature updated successfully");
                    $this->refresh();
                }
            } else if ($user_role_type === 'extra_member') {
                $user_model = JobExtraMember::model()->findByPk($auto_user_id);
                $user_model->signature = $json_signature;
                $user_model->date_on_signed = $date_on_signed;
                $user_model->agent_id = $this->agent_id;
                if ($user_model->save()) {
                    Yii::app()->user->setFlash('success', "Signature updated successfully");
                    $this->refresh();
                }
            }
        }

        // $id i.e. $job_id
        // job model
        $job_model = $this->loadModel($id);


        // quote model by job id
        $quote_model = Quotes::model()->findByPk($job_model->quote_id);

        // service model
        $service_model = Service::model()->findByPk($quote_model->service_id);

        // building model
        $building_model = Buildings::model()->findByPk($job_model->building_id);

        // site model
        $site_model = ContactsSite::model()->findByPk($quote_model->site_id);

        // contact model
        $contact_model = Contact::model()->findByPk($quote_model->contact_id);

        // contact model
        $company_model = Company::model()->findByPk($quote_model->company_id);

        // finding service under job
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $job_services_model = QuoteJobServices::model()->findAll($Criteria);
        unset($Criteria);


        $job_all_users = array();
        $signed_users = array();
        $user = 0;
        $signature_empty_count = 0;
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $supervisor = JobSupervisor::model()->findAll($Criteria);
        unset($Criteria);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $siteSupervisor = JobSiteSupervisor::model()->findAll($Criteria);
        $unique_signaure_user = array();
        foreach ($siteSupervisor as $single_user) {

            if (!in_array($single_user->user_id, $unique_signaure_user)) {
                $working_supervisor_array[] = ucwords($single_user->name);
                $signed_users[$user]['auto_user_id'] = $single_user->id;
                $signed_users[$user]['Position'] = 'Site Supervisor';
                $signed_users[$user]['Name'] = $single_user->name;
                $signed_users[$user]['Mobile'] = $single_user->mobile;
                $signed_users[$user]['signature'] = $single_user->signature;
                if (empty($single_user->signature))
                    $signature_empty_count++;
                $signed_users[$user]['date_on_signed'] = $single_user->date_on_signed;
                $user++;

                $unique_signaure_user[] = $single_user->user_id;
            }
        }
        unset($Criteria);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $staffUser = JobStaff::model()->findAll($Criteria);
        foreach ($staffUser as $single_user) {

            if (!in_array($single_user->user_id, $unique_signaure_user)) {
                $job_all_users[] = ucwords($single_user->name);
                $signed_users[$user]['auto_user_id'] = $single_user->id;
                $signed_users[$user]['Position'] = 'Staff';
                $signed_users[$user]['Name'] = $single_user->name;
                $signed_users[$user]['Mobile'] = $single_user->mobile;
                $signed_users[$user]['signature'] = $single_user->signature;
                if (empty($single_user->signature))
                    $signature_empty_count++;
                $signed_users[$user]['date_on_signed'] = $single_user->date_on_signed;
                $user++;

                $unique_signaure_user[] = $single_user->user_id;
            }
        }

        //extra members
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $staffUser = JobExtraMember::model()->findAll($Criteria);
        foreach ($staffUser as $single_user) {
            $job_all_users[] = ucwords($single_user->name);

            $signed_users[$user]['auto_user_id'] = $single_user->id;
            $signed_users[$user]['Position'] = 'extra_member';
            $signed_users[$user]['Name'] = ucwords($single_user->name);
            $signed_users[$user]['Mobile'] = '';
            $signed_users[$user]['signature'] = $single_user->signature;
            if (empty($single_user->signature))
                $signature_empty_count++;
            $signed_users[$user]['date_on_signed'] = $single_user->date_on_signed;
            $user++;
        }

        $work_group_user_names = '';
        if (count($job_all_users) > 0)
            $work_group_user_names = implode(', ', $job_all_users);

        $swms = array();
        $swms_ids = explode(',', $job_model->swms_ids);




        // locking signature process
        if (isset($_POST['QuoteJobs'])) {

            $total_users = count($signed_users);
            $user_signed_count = $total_users - $signature_empty_count;

            if ($user_signed_count > 0) {
                $job_model->attributes = $_POST['QuoteJobs'];
                $job_model->agent_id = $this->agent_id;
                if ($job_model->save()) {

                    if ($signature_empty_count == 0) {
                        Yii::app()->user->setFlash('success', "Signature locked successfully");
                        $this->refresh();
                    } else {
                        Yii::app()->user->setFlash('warning', "Signature locked successfully but not everybody signed");
                        $this->refresh();
                    }
                }
            } else {
                Yii::app()->user->setFlash('danger', "At least one user need to sign");
                $this->refresh();
            }
        }

        $working_supervisor = '';
        if (isset($working_supervisor_array) && is_array($working_supervisor_array) && count($working_supervisor_array)) {
            $working_supervisor_array = array_unique($working_supervisor_array);
            $working_supervisor = implode(', ', $working_supervisor_array);
        }

        $this->render('swms_sign', array(
            'job_model' => $job_model,
            'quote_model' => $quote_model,
            'building_model' => $building_model,
            'site_model' => $site_model,
            'contact_model' => $contact_model,
            'company_model' => $company_model,
            'job_services_model' => $job_services_model,
            'service_model' => $service_model,
            'supervisor' => $supervisor,
            'siteSupervisor' => $siteSupervisor,
            'staffUser' => $staffUser,
            'swms_ids' => $swms_ids,
            'work_group_user_names' => $work_group_user_names,
            'signed_users' => $signed_users,
            'working_supervisor' => $working_supervisor,
            'extra_member_model' => $extra_member_model
        ));
    }

    public function actionUpdate_extra_scope() {
        
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $extra_scope_of_work = isset($_POST['extra_scope_of_work']) ? $_POST['extra_scope_of_work'] : '';
        if ($id > 0) {
            $model = $this->loadModel($id);
            $model->extra_scope_of_work = $extra_scope_of_work;
            if ($model->save())
                echo '1';
            exit;
        }
    }

    public function actionViewSiteInduction($id) {

        $job_id = $id;
        $model = $this->loadModel($job_id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $quote_model = Quotes::model()->findByPk($model->quote_id);
        // site model
        $site_model = ContactsSite::model()->findByPk($quote_model->site_id);

        $user_ids = array();

        $supervisor_model = JobSupervisor::model()->findByAttributes(
                array(
                     'job_id' => $job_id, 'agent_id' => $this->agent_id,
                )
        );

        $user_ids[] = $supervisor_model->user_id;
        $site_supervisor_model = JobSiteSupervisor::model()->findByAttributes(
                array(
                     'job_id' => $job_id, 'agent_id' => $this->agent_id,
                )
        );
        $user_ids[] = $site_supervisor_model->user_id;

        $staff_model = JobStaff::model()->findAllByAttributes(
                array(
                     'job_id' => $job_id, 'agent_id' => $this->agent_id,
                )
        );
        foreach ($staff_model as $staff_member) {
            $user_ids[] = $staff_member->user_id;
        }

        //echo '<pre>'; print_r($user_ids); echo '</pre>';			

        $induction_user = array();
        $site_id = $site_model->id;
        $i = 0;
        foreach ($user_ids as $user_id) {

            $site_induction_model = Induction::model()->findByAttributes(
                    array(
                        'user_id' => $user_id,
                        'site_id' => $site_id
                    )
            );

            $user_model = User::model()->findByPk($user_id);

            $induction_user[$i]['user_full_name'] = $user_model->first_name . ' ' . $user_model->last_name;
            $induction_user[$i]['id'] = 0; // induction id
            $induction_user[$i]['user_id'] = $user_id;
            $induction_user[$i]['site_id'] = $site_id;
            $induction_user[$i]['induction_type_id'] = 'n/a';
            $induction_user[$i]['induction_company_id'] = 'n/a';
            $induction_user[$i]['induction_link_document'] = 'n/a';
            $induction_user[$i]['induction_link'] = 'n/a';
            $induction_user[$i]['document'] = 'n/a';
            $induction_user[$i]['password'] = 'n/a';
            $induction_user[$i]['completion_date'] = 'n/a';
            $induction_user[$i]['induction_status'] = 'n/a';
            $induction_user[$i]['induction_number'] = 'n/a';
            $induction_user[$i]['induction_card'] = 'n/a';
            $induction_user[$i]['expiry_date'] = 'n/a';

            if ($site_induction_model != null) {

                $induction_user[$i]['id'] = $site_induction_model->id;
                $induction_user[$i]['user_id'] = $site_induction_model->user_id;
                $induction_user[$i]['site_id'] = $site_induction_model->site_id;
                $induction_user[$i]['induction_type_id'] = $site_induction_model->induction_type_id;
                $induction_user[$i]['induction_company_id'] = $site_induction_model->induction_company_id;
                $induction_user[$i]['induction_link_document'] = $site_induction_model->induction_link_document;
                $induction_user[$i]['induction_link'] = $site_induction_model->induction_link;
                $induction_user[$i]['document'] = $site_induction_model->document;
                $induction_user[$i]['password'] = $site_induction_model->password;
                $induction_user[$i]['completion_date'] = $site_induction_model->completion_date;
                $induction_user[$i]['induction_status'] = $site_induction_model->induction_status;
                $induction_user[$i]['induction_number'] = $site_induction_model->induction_number;
                $induction_user[$i]['induction_card'] = $site_induction_model->induction_card;
                $induction_user[$i]['expiry_date'] = $site_induction_model->expiry_date;
            }

            $site_induction_model = null;
            $user_model = null;
            $i++;
        }


        $this->render('view_site_induction', array(
            'model' => $model,
            'quote_model' => $quote_model,
            'site_model' => $site_model,
            'induction_user' => $induction_user,
        ));
    }

    public function actionView($id) {

        // reply sms service 
        $reply_sms_button = isset($_POST['reply_sms_button']) ? $_POST['reply_sms_button'] : '';
        if ($reply_sms_button === 'R-SMS') {
            SmsService::read_sms();
            $this->refresh();
        }


        $view_file_name = null;

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/view_job_details.js', CClientScript::POS_END);

        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $job_model = $model;

        // quote model by job id
        $quote_model = Quotes::model()->findByPk($job_model->quote_id);

        // updating site contact
        if (isset($_POST['Quotes'])) {

            $quote_model->attributes = $_POST['Quotes'];
            $quote_model->agent_id = $this->agent_id;
            if ($quote_model->save(false)) {
                $this->refresh();
            }
        }



        // building model
        $building_model = Buildings::model()->findByPk($job_model->building_id);

        // site model
        $site_model = ContactsSite::model()->findByPk($quote_model->site_id);

        // contact model
        $contact_model = Contact::model()->findByPk($quote_model->contact_id);

        // contact model
        $company_model = Company::model()->findByPk($quote_model->company_id);

        // Send sms service 
        $send_sms_button = isset($_REQUEST['send_sms_button']) ? $_REQUEST['send_sms_button'] : '';
        if ($send_sms_button === 'S-SMS') {
            $ys = isset($_REQUEST['ys']) ? $_REQUEST['ys'] : array();
            $sent_sms = isset($_REQUEST['sent_sms']) ? $_REQUEST['sent_sms'] : array();
            //echo '<pre>'; print_r($_POST); echo '</pre>';
            if (count($sent_sms) > 0) {
                SmsService::send_sms($sent_sms, $ys, $site_model);
            }
        }


        // finding service under job
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $job_services_model = QuoteJobServices::model()->findAll($Criteria);
        unset($Criteria);

        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $supervisor = JobSupervisor::model()->findAll($Criteria);
        unset($Criteria);

        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $Criteria->order = "job_date, day_night asc";
        $siteSupervisor = JobSiteSupervisor::model()->findAll($Criteria);
        unset($Criteria);

        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $Criteria->order = "job_date, day_night asc";
        $staffUser = JobStaff::model()->findAll($Criteria);

        $induction_available_user = array();
        $induction_company_id = 0;
        if ($site_model->need_induction === '1') {
            $induction_company_id = $site_model->induction_company_id;

            $Criteria = new CDbCriteria();
            $Criteria->select = ' distinct(user_id)';
            $Criteria->condition = "induction_company_id=$induction_company_id";
            $SiteInduction = Induction::model()->findAll($Criteria);

            foreach ($SiteInduction as $single_user) {
                $induction_available_user[] = $single_user->user_id;
            }
        }

        $Criteria = new CDbCriteria();
        $Criteria->select = ' distinct(user_id)';
        $UserLicenses = UserLicenses::model()->findAll($Criteria);
        $license_available_user = array();
        foreach ($UserLicenses as $single_user) {
            $license_available_user[] = $single_user->user_id;
        }


        $job_all_users = array();
        foreach ($siteSupervisor as $single_user) {



            $temp_job_all_users = array();
            $temp_job_all_users['auto_id'] = $single_user->id;
            $temp_job_all_users['user_id'] = $single_user->user_id;
            $temp_job_all_users['Position'] = 'SS';
            $temp_job_all_users['Name'] = $single_user->name;
            $temp_job_all_users['Mobile'] = $single_user->mobile;
            $view_induction_link = '<a href="' . $this->base_url_assets. '/?r=induction/index&user_id=' . $single_user->user_id . '&induction_company_id=' . $induction_company_id . '" target="_blank" >View Induction</a>';
            if (!in_array($single_user->user_id, $induction_available_user)) {
                $view_induction_link = '';
            }
            $temp_job_all_users['Induction'] = $view_induction_link;
            $view_licences_link = '<a href="' . $this->base_url_assets. '/?r=licences/index&user_id=' . $single_user->user_id . '" target="_blank" >View Licence</a>';
            if (!in_array($single_user->user_id, $license_available_user)) {
                $view_licences_link = '';
            }
            $temp_job_all_users['Licences'] = $view_licences_link;
            $formated_date = date("d-m-Y", strtotime($single_user->job_date));
            $temp_job_all_users['working_date'] = $formated_date;
            $temp_job_all_users['working_day_night'] = $single_user->day_night;
            $jw_place_to_come = '';
            $time_at_place = '';
            $temp_job_all_users['working_time'] = 'N/A';
            $temp_job_all_users['yard_start_time'] = 'N/A';
            $temp_job_all_users['site_start_time'] = 'N/A';


            // message fields
            $temp_job_all_users['msg_sms_service_used'] = $single_user->msg_sms_service_used;
            $temp_job_all_users['msg_id'] = $single_user->msg_id;
            $temp_job_all_users['msg_sent_status'] = $single_user->msg_sent_status;
            $temp_job_all_users['msg_replied_status'] = $single_user->msg_replied_status;
            $temp_job_all_users['msg_sent_date_time	'] = $single_user->msg_sent_date_time;
            $temp_job_all_users['msg_replied_when'] = $single_user->msg_replied_when;
            $temp_job_all_users['msg_sent_text'] = $single_user->msg_sent_text;
            $temp_job_all_users['msg_replied_text'] = $single_user->msg_replied_text;


            $Criteria = new CDbCriteria();
            $Criteria->condition = "job_id=" . $id . " && working_date='" . $single_user->job_date . "'" . " && day_night='" . $single_user->day_night . "'";
            $job_working_model_exist = JobWorking::model()->find($Criteria);

            if ($job_working_model_exist !== NULL) {

                $temp_job_all_users['yard_start_time'] = $job_working_model_exist->yard_time;
                $temp_job_all_users['site_start_time'] = $job_working_model_exist->site_time;

                if ($job_working_model_exist->site_time === $job_working_model_exist->yard_time) {
                    $jw_place_to_come = 'SITE';
                    $time_at_place = $job_working_model_exist->site_time;
                } else {
                    $jw_place_to_come = 'YARD';
                    $time_at_place = $job_working_model_exist->yard_time;
                }
            }

            if ($single_user->place_to_come == 'UNKNOWN')
                $temp_job_all_users['place_to_come'] = $jw_place_to_come;
            else
                $temp_job_all_users['place_to_come'] = $single_user->place_to_come;

            $temp_job_all_users['working_time'] = $time_at_place;

            $job_all_users[$formated_date . '_' . $single_user->day_night][] = $temp_job_all_users;
        }

        foreach ($staffUser as $single_user) {
            $temp_job_all_users = array();
            $temp_job_all_users['auto_id'] = $single_user->id;
            $temp_job_all_users['user_id'] = $single_user->user_id;
            $temp_job_all_users['Position'] = 'ST';
            $temp_job_all_users['Name'] = $single_user->name;
            $temp_job_all_users['Mobile'] = $single_user->mobile;
            $view_induction_link = '<a href="' . $this->base_url_assets. '/?r=induction/index&user_id=' . $single_user->user_id . '&induction_company_id=' . $induction_company_id . '" target="_blank" >View Induction</a>';
            if (!in_array($single_user->user_id, $induction_available_user)) {
                $view_induction_link = '';
            }
            $temp_job_all_users['Induction'] = $view_induction_link;
            $view_licences_link = '<a href="' . $this->base_url_assets. '/?r=licences/index&user_id=' . $single_user->user_id . '" target="_blank" >View Licence</a>';
            if (!in_array($single_user->user_id, $license_available_user)) {
                $view_licences_link = '';
            }
            $temp_job_all_users['Licences'] = $view_licences_link;
            $formated_date = date("d-m-Y", strtotime($single_user->job_date));
            $temp_job_all_users['working_date'] = $formated_date;
            $temp_job_all_users['working_day_night'] = $single_user->day_night;
            $jw_place_to_come = '';
            $time_at_place = '';
            $temp_job_all_users['working_time'] = 'N/A';
            $temp_job_all_users['yard_start_time'] = 'N/A';
            $temp_job_all_users['site_start_time'] = 'N/A';

            // message fields
            $temp_job_all_users['msg_sms_service_used'] = $single_user->msg_sms_service_used;
            $temp_job_all_users['msg_id'] = $single_user->msg_id;
            $temp_job_all_users['msg_sent_status'] = $single_user->msg_sent_status;
            $temp_job_all_users['msg_replied_status'] = $single_user->msg_replied_status;
            $temp_job_all_users['msg_sent_date_time	'] = $single_user->msg_sent_date_time;
            $temp_job_all_users['msg_replied_when'] = $single_user->msg_replied_when;
            $temp_job_all_users['msg_sent_text'] = $single_user->msg_sent_text;
            $temp_job_all_users['msg_replied_text'] = $single_user->msg_replied_text;



            $Criteria = new CDbCriteria();
            $Criteria->condition = "job_id=" . $id . " && working_date='" . $single_user->job_date . "'" . " && day_night='" . $single_user->day_night . "'";
            $job_working_model_exist = JobWorking::model()->find($Criteria);


            if ($job_working_model_exist !== NULL) {

                $temp_job_all_users['yard_start_time'] = $job_working_model_exist->yard_time;
                $temp_job_all_users['site_start_time'] = $job_working_model_exist->site_time;

                if ($job_working_model_exist->site_time === $job_working_model_exist->yard_time) {
                    $jw_place_to_come = 'SITE';
                    $time_at_place = $job_working_model_exist->site_time;
                } else {
                    $jw_place_to_come = 'YARD';
                    $time_at_place = $job_working_model_exist->yard_time;
                }
            }
            if ($single_user->place_to_come == 'UNKNOWN')
                $temp_job_all_users['place_to_come'] = $jw_place_to_come;
            else
                $temp_job_all_users['place_to_come'] = $single_user->place_to_come;

            $temp_job_all_users['working_time'] = $time_at_place;


            $job_all_users[$formated_date . '_' . $single_user->day_night][] = $temp_job_all_users;
        }


        //echo '<pre>'; print_r($job_all_users); echo '</pre>'; exit;

        $interval_days = CommonFunctions::getIntervalDays($model->job_started_date, $model->job_end_date);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id =" . $id;
        $BuildingServices = QuoteJobServices::model()->findAll($Criteria);

        // pick up van , on site, finish on site
        $times = array();
        $times['pick_up_van_time_date'] = '&nbsp';
        $times['site_time_date'] = '&nbsp';
        $times['finish_time_date'] = '&nbsp';

        if (!empty($job_model->job_started_time)) {
            $times['pick_up_van_time_date'] = $job_model->job_started_time . ' on ' . date("d-m-Y", strtotime($job_model->job_started_date));
            $times['site_time_date'] = $job_model->job_started_time . ' on ' . date("d-m-Y", strtotime($job_model->job_started_date));
        }

        if (!empty($job_model->job_end_time))
            $times['finish_time_date'] = $job_model->job_end_time . ' on ' . date("d-m-Y", strtotime($job_model->job_end_date));


        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = " . $id;
        $job_working_model = JobWorking::model()->findAll($Criteria);

        $job_working_timing = array();
        foreach ($job_working_model as $row) {
            if (!empty($row->site_time)) {
                $job_working_timing[$row->job_id][$row->working_date][$row->day_night]['yard_time'] = $row->yard_time . ' on ' . date("d-m-Y", strtotime($row->working_date));
                $job_working_timing[$row->job_id][$row->working_date][$row->day_night]['site_time'] = $row->site_time . ' on ' . date("d-m-Y", strtotime($row->working_date));
                $job_working_timing[$row->job_id][$row->working_date][$row->day_night]['finish_time'] = $row->finish_time . ' on ' . date("d-m-Y", strtotime($row->working_date));
            }
        }

        if (isset($job_working_timing[$id][$job_model->job_started_date]['NIGHT'])) {
            $times['pick_up_van_time_date'] = $job_working_timing[$id][$job_model->job_started_date]['NIGHT']['yard_time'];
            $times['site_time_date'] = $job_working_timing[$id][$job_model->job_started_date]['NIGHT']['site_time'];
        }

        if (isset($job_working_timing[$id][$job_model->job_started_date]['DAY'])) {
            $times['pick_up_van_time_date'] = $job_working_timing[$id][$job_model->job_started_date]['DAY']['yard_time'];
            $times['site_time_date'] = $job_working_timing[$id][$job_model->job_started_date]['DAY']['site_time'];
        }

        if (isset($job_working_timing[$id][$job_model->job_end_date]['DAY'])) {
            $times['finish_time_date'] = $job_working_timing[$id][$job_model->job_end_date]['DAY']['finish_time'];
        }

        if (isset($job_working_timing[$id][$job_model->job_end_date]['NIGHT'])) {
            $times['finish_time_date'] = $job_working_timing[$id][$job_model->job_end_date]['NIGHT']['finish_time'];
        }


        // tool types
        $all_tools = ListToolsType::Model()->findAll();
        $tool_ids = explode(',', $job_model->tool_types_ids);

        //echo '<pre>'; print_r($all_tools); echo '</pre>';  

        $tool_type_html_text = '<table width="100%">';
        $total_available_tool_types = count($all_tools);
        $i = 0;

        foreach ($all_tools as $value) {

            if ($i == 0 || $i % 2 == 0)
                $tool_type_html_text .= '<tr>';

            if (in_array($value->id, $tool_ids))
                $tool_type_html_text .= '<td width="33%"><input checked="checked" class="chk"  type="checkbox" value="' . $value->id . '" />&nbsp;&nbsp;&nbsp;' . $value->name . '</td>';
            else
                $tool_type_html_text .= '<td  width="33%"><input class="chk"  type="checkbox" value="' . $value->id . '" />&nbsp;&nbsp;&nbsp;' . $value->name . '</td>';

            if ($i > 0 && (($i + 1) % 2 == 0 || ($i + 1) == $total_available_tool_types))
                $tool_type_html_text .= '</tr>';

            $i++;
        }
        $tool_type_html_text .= '</table>';


        if (in_array(Yii::app()->user->name,array('system_owner', 'state_manager', 'operation_manager'))) {
            $view_file_name = 'view_job_details';
        } else if (Yii::app()->user->name === 'staff') {
            $view_file_name = 'view_job_details_staff';
        } else if (Yii::app()->user->name === 'site_supervisor') {
            $view_file_name = 'view_job_details_site_supervisor';
        } else if (Yii::app()->user->name === 'supervisor') {
            $view_file_name = 'view_job_details_supervisor';
        }

        if ($view_file_name == null)
            throw new CHttpException(404, 'The requested page does not exist.');





        $this->render($view_file_name, array(
            'model' => $model,
            'quote_model' => $quote_model,
            'BuildingServices' => $BuildingServices,
            'interval_days' => $interval_days,
            'job_model' => $job_model,
            'quote_model' => $quote_model,
            'building_model' => $building_model,
            'site_model' => $site_model,
            'contact_model' => $contact_model,
            'company_model' => $company_model,
            'job_services_model' => $job_services_model,
            'supervisor' => $supervisor,
            'siteSupervisor' => $siteSupervisor,
            'staffUser' => $staffUser,
            'job_all_users' => $job_all_users,
            'times' => $times,
            'tool_type_html_text' => $tool_type_html_text
        ));
    }

    public function actionAjaxJobImageAfterUpload() {

        $job_image_id = isset($_POST['job_image_id']) ? $_POST['job_image_id'] : 0;

        $isDataValid = 1;
        if ($job_image_id == 0)
            $isDataValid = 0;

        $path = Yii::app()->basePath . '/../uploads/job_images/';
        $thumb_path = Yii::app()->basePath . '/../uploads/job_images/thumbs/';

        $actual_image_name = "";
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST" and $isDataValid) {

            $imagename = $_FILES['photoimg_after']['name'];
            $size = $_FILES['photoimg_after']['size'];

            if (strlen($imagename)) {
                $ext = strtolower(CommonFunctions::getExtension($imagename));
                if (in_array($ext, $valid_formats)) {
                    if ($size < (200 * 1024 * 1024)) {

                        $actual_image_name = $job_image_id . "-after-" . rand(0, 99999) . "." . $ext;

                        $model = JobImages::model()->findByPk($job_image_id);


                        if (isset($model->photo_after) && $model->photo_after != NULL && file_exists($path . $model->photo_after))
                            unlink($path . $model->photo_after);

                        if (isset($model->photo_after) && $model->photo_after != NULL && file_exists($thumb_path . $model->photo_after))
                            unlink($thumb_path . $model->photo_after);

                        $model->photo_after = $actual_image_name;
                        $model->agent_id = $this->agent_id;
                        $model->save();

                        $uploadedfile = $_FILES['photoimg_after']['tmp_name'];
                        if (move_uploaded_file($uploadedfile, $path . $actual_image_name)) {
                            $vimage = new resize($path . $actual_image_name);
                            $vimage->resizeImage(200, 200);
                            $save_thumb = $thumb_path . $actual_image_name;
                            $vimage->saveImage($save_thumb);

                            echo "<img  width='100%' src='" . $this->user_role_base_url . '/uploads/job_images/thumbs/' . $actual_image_name . "'  class='preview'><br/>";
                        } else
                            echo "Fail upload folder with read access.";
                    } else
                        echo "Image file size max 1 MB";
                } else
                    echo "Invalid file format..";
            } else
                echo "Please select image..!";
            exit;
        }
    }

    public function actionAjaxJobImageBeforeUpload() {

        $job_image_id = isset($_POST['job_image_id']) ? $_POST['job_image_id'] : 0;

        $isDataValid = 1;
        if ($job_image_id == 0)
            $isDataValid = 0;

        $path = Yii::app()->basePath . '/../uploads/job_images/';
        $thumb_path = Yii::app()->basePath . '/../uploads/job_images/thumbs/';
        $actual_image_name = "";
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST" and $isDataValid) {

            $imagename = $_FILES['photoimg']['name'];
            $size = $_FILES['photoimg']['size'];

            if (strlen($imagename)) {
                $ext = strtolower(CommonFunctions::getExtension($imagename));
                if (in_array($ext, $valid_formats)) {
                    if ($size < (200 * 1024 * 1024)) {

                        $actual_image_name = $job_image_id . "-before-" . rand(0, 99999) . "." . $ext;

                        $model = JobImages::model()->findByPk($job_image_id);


                        if (isset($model->photo_before) && $model->photo_before != NULL && file_exists($path . $model->photo_before))
                            unlink($path . $model->photo_before);

                        if (isset($model->photo_before) && $model->photo_before != NULL && file_exists($thumb_path . $model->photo_before))
                            unlink($thumb_path . $model->photo_before);

                        $model->photo_before = $actual_image_name;
                        $model->agent_id = $this->agent_id;
                        $model->save();

                        $uploadedfile = $_FILES['photoimg']['tmp_name'];
                        if (move_uploaded_file($uploadedfile, $path . $actual_image_name)) {

                            $vimage = new resize($path . $actual_image_name);
                            $vimage->resizeImage(200, 200);
                            $save_thumb = $thumb_path . $actual_image_name;
                            $vimage->saveImage($save_thumb);

                            echo "<img  width='100%' src='" . $this->user_role_base_url . '/uploads/job_images/thumbs/' . $actual_image_name . "'  class='preview'><br/>";
                        } else
                            echo "Fail upload folder with read access.";
                    } else
                        echo "Image file size max 1 MB";
                } else
                    echo "Invalid file format..";
            } else
                echo "Please select image..!";
            exit;
        }
    }

    public function actionGetJobImageDataColumns($job_image_id) {

        $model = JobImages::model()->findByPk($job_image_id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $this->renderPartial('job_image_data_update', array('model' => $model));
    }

    public function actionGetJobImageDataColumnsImage($job_image_id) {

        $model = JobImages::model()->findByPk($job_image_id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $this->renderPartial('job_image_data_image', array('model' => $model));
    }

    public function actionJobImages($id) {

        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/blueimp-gallery.min.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.blueimp-gallery.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-image-gallery.min.js', CClientScript::POS_END);

        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);

        if ($model == null) {
            echo 'test';
            exit;
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $job_id = $model->id;


        if (isset($_POST['QuoteJobs'])) {

            $model->attributes = $_POST['QuoteJobs'];

            if ($model->validate()) {
                if ($model->save(false)) {


                    $supervisor_model = JobSupervisor::model()->findByAttributes(
                            array(
                                 'job_id' => $job_id, 'agent_id' => $this->agent_id,
                            )
                    );

                    if ($supervisor_model === null)
                        throw new CHttpException(404, 'The requested page does not exist.');

                    $supervisor_id = $supervisor_model->user_id;

                    $site_supervisor_model = JobSiteSupervisor::model()->findByAttributes(
                            array(
                                 'job_id' => $job_id, 'agent_id' => $this->agent_id,
                            )
                    );

                    if ($site_supervisor_model === null)
                        throw new CHttpException(404, 'The requested page does not exist.');

                    $site_supervisor_id = $site_supervisor_model->user_id;


                    if ($supervisor_id > 0 && $site_supervisor_id > 0) {
                        JobEmailNotification::sendEmail(14, $job_id, $supervisor_id, $site_supervisor_id);
                        Yii::app()->user->setFlash('success', "Job report successfully shared to email address $model->client_email!");
                    } else {
                        Yii::app()->user->setFlash('success', "Email not sent.Make sure, you allocated supervisor and site supervisor to this job.");
                    }

                    $this->refresh();
                }
            }
        }


        $quote_model = Quotes::model()->findByPk($model->quote_id);

        // before cleaning
        $criteria = new CDbCriteria();
        $criteria->select = "*";
        $criteria->condition = "job_id=" . $id;
        $criteria->order = 'id';
        $job_images = JobImages::model()->findAll($criteria);




        $this->render('job_images', array(
            'model' => $model,
            'quote_model' => $quote_model,
            'job_images' => $job_images
        ));
    }

    public function actionUpdate_JobImageData() {

        $job_image_id = isset($_POST['job_image_id']) ? $_POST['job_image_id'] : 0;
        if ($job_image_id > 0) {
            $area = isset($_POST['area']) ? $_POST['area'] : '';
            $note = isset($_POST['note']) ? $_POST['note'] : '';

            $model = JobImages::model()->findByPk($job_image_id);
            $model->area = $area;
            $model->note = $note;
            $model->agent_id = $this->agent_id;
            $model->save();
        }
    }

    public function actionAdd_JobImageData() {

        //$job_image_id = isset($_POST['job_image_id']) ? $_POST['job_image_id'] : '';
        $id = isset($_POST['id']) ? $_POST['id'] : ''; // job_id
        $area = isset($_POST['area']) ? $_POST['area'] : '';
        $note = isset($_POST['note']) ? $_POST['note'] : '';

        $model = new JobImages;
        $model->job_id = $id;
        $model->area = $area;
        $model->note = $note;
        $model->agent_id = $this->agent_id;
        $model->date_added = date("Y-m-d");
        $model->save();
    }

    public function actionDeleteJobImageRecord($job_image_id) {
        
        $model = JobImages::model()->findByPk($job_image_id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $existing_job_id = $model->job_id;

        $path = Yii::app()->basePath . '/../uploads/job_images/';
        $thumb_path = Yii::app()->basePath . '/../uploads/job_images/thumbs/';

        if (isset($model->photo_before) && $model->photo_before != NULL && file_exists($path . $model->photo_before))
            unlink($path . $model->photo_before);
        if (isset($model->photo_before) && $model->photo_before != NULL && file_exists($thumb_path . $model->photo_before))
            unlink($thumb_path . $model->photo_before);

        if (isset($model->photo_after) && $model->photo_after != NULL && file_exists($path . $model->photo_after))
            unlink($path . $model->photo_after);
        if (isset($model->photo_after) && $model->photo_after != NULL && file_exists($thumb_path . $model->photo_after))
            unlink($thumb_path . $model->photo_after);

        $model->delete();
    }

    public function actionBuildingDocuments($id) {

        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $quote_model = Quotes::model()->findByPk($model->quote_id);

        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/blueimp-gallery.min.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style-demo-cerculer-image-slider.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.blueimp-gallery.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-image-gallery.min.js', CClientScript::POS_END);

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.easing-1.3.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mousewheel-3.1.12.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.jcarousellite.js', CClientScript::POS_END);



        // building photos
        $criteria = new CDbCriteria();
        $criteria->select = "id,photo";
        $criteria->condition = "building_id=".$model->building_id." && ".$this->where_agent_condition;
        $criteria->order = 'id desc';
        $building_images = BuildingImages::model()->findAll($criteria);

        // building documents
        $criteria = new CDbCriteria();
        $criteria->select = "id,doc";
        $criteria->condition = "building_id=" . $model->building_id." && ".$this->where_agent_condition;
        $criteria->order = 'id';
        $building_documents = BuildingDocuments::model()->findAll($criteria);

        /* echo '<pre>';
          print_r($_FILES);
          echo '</pre>'; */

        if (isset($_POST['yt0']) && $_POST['yt0'] == 'Save Building Documents') {
            // uploading multiple building documents
            if (isset($_FILES["documents"]["tmp_name"]) && count($_FILES["documents"]["tmp_name"]) > 0) {

                foreach ($_FILES["documents"]["tmp_name"] as $tmp_name_key => $tmp_name_value) {


                    if (isset($_FILES["documents"]["tmp_name"][$tmp_name_key]) && $_FILES["documents"]["tmp_name"][$tmp_name_key] != "") {

                        $source = $_FILES["documents"]["tmp_name"][$tmp_name_key];
                        $destination_path = Yii::app()->basePath . '/../uploads/building_documents/';
                        $filename = date("dmYHms") . "_" . $_FILES["documents"]["name"][$tmp_name_key];
                        if (move_uploaded_file($source, $destination_path . $filename)) {

                            $building_id = $model->building_id;
                            $building_doc_model = new BuildingDocuments;
                            $building_doc_model->building_id = $building_id;
                            $building_doc_model->doc = $filename;
                            $building_doc_model->agent_id = $this->agent_id;
                            $building_doc_model->date_added = date("Y-m-d");
                            $building_doc_model->save();
                        }
                    }
                }

                Yii::app()->request->redirect($this->user_role_base_url . '/?r=Quotes/Job/BuildingDocuments&id=' . $model->id);
            }
        }


        if (isset($_POST['yt1']) && $_POST['yt1'] == 'Save Building Photos') {
            // uploading multiple building images
            if (isset($_FILES["images"]["tmp_name"]) && count($_FILES["images"]["tmp_name"]) > 0) {

                foreach ($_FILES["images"]["tmp_name"] as $tmp_name_key => $tmp_name_value) {


                    if (isset($_FILES["images"]["tmp_name"][$tmp_name_key]) && $_FILES["images"]["tmp_name"][$tmp_name_key] != "") {

                        $source = $_FILES["images"]["tmp_name"][$tmp_name_key];
                        $destination_path = Yii::app()->basePath . '/../uploads/building_images/';
                        $destination_thumbs_path = Yii::app()->basePath . '/../uploads/building_images/thumbs/';
                        $filename = date("dmYHms") . "_" . $_FILES["images"]["name"][$tmp_name_key];
                        if (move_uploaded_file($source, $destination_path . $filename)) {

                            //create thumb
                            $vimage = new resize($destination_path . $filename);
                            //$vimage->resizeImage(300, 225);
                            $vimage->resizeImage(150, 100);
                            $vimage->saveImage($destination_thumbs_path . $filename);

                            $building_id = $model->building_id;
                            $builiding_image_model = new BuildingImages;
                            $builiding_image_model->building_id = $building_id;
                            $builiding_image_model->photo = $filename;
                            $builiding_image_model->date_added = date("Y-m-d");
                            $builiding_image_model->agent_id = $this->agent_id;
                            $builiding_image_model->save();
                        }
                    }
                }
                Yii::app()->request->redirect($this->user_role_base_url . '/?r=Quotes/Job/BuildingDocuments&id=' . $model->id);
            }
        }



        $this->render('building_documents', array(
            'model' => $model,
            'quote_model' => $quote_model,
            'building_images' => $building_images,
            'building_documents' => $building_documents,
        ));
    }

    # $id i.e. job_id

    public function actionDownloadJobBeforeAfterReport($id) {

        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        // quote model by job id
        $quote_model = Quotes::model()->findByPk($model->quote_id);

        // site model
        $site_model = ContactsSite::model()->findByPk($quote_model->site_id);

        // service model
        $service_model = Service::model()->findByPk($quote_model->service_id);


        // before cleaning
        $criteria = new CDbCriteria();
        $criteria->select = "*";
        $criteria->condition = "job_id=" . $id;
        $criteria->order = 'id';
        $job_images = JobImages::model()->findAll($criteria);

        $mpdf = new mPDF('', // mode - default ''
                'A4-L', // format - A4, for example, default ''
                10, // font size - default 0
                '', // default font family
                12.7, // margin_left
                12.7, // margin right
                5, // margin top
                12.7, // margin bottom
                8, // margin header
                8, // margin footer
                'L');

        $msg = $this->renderPartial('job_cleaning_report', array(
            'site_model' => $site_model,
            'service_model' => $service_model,
            'job_images' => $job_images,
                )
                , true);

        //$mpdf->SetHeader($store_name);
        $mpdf->debug = true;
        $mpdf->mirrorMargins = 1;
        $mpdf->use_kwt = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($msg);


        // $mpdf->showImageErrors = true;
        $pdf_name = "Job-" . $id . "-" . $site_model->site_name . ' - ' . $service_model->service_name . "Cleaning-Report";
        $pdf_name = preg_replace('/\s+/', '-', $pdf_name);
        $pdf_name = trim(preg_replace('/-+/', '-', $pdf_name), '-');
        $mpdf->Output($pdf_name . '.pdf', 'D');
    }

    # $id i.e. job_id

    public function actionDownloadQuote($id) {


        // $id i.e. $job_id
        // job model
        $job_model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($job_model->agent_id,$this->agent_id);
        // quote model by job id
        $quote_model = Quotes::model()->findByPk($job_model->quote_id);

        // building model
        $building_model = Buildings::model()->findByPk($job_model->building_id);

        // site model
        $site_model = ContactsSite::model()->findByPk($quote_model->site_id);

        // contact model
        $contact_model = Contact::model()->findByPk($quote_model->contact_id);

        // contact model
        $company_model = Company::model()->findByPk($quote_model->company_id);

        // finding service under job
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $job_services_model = QuoteJobServices::model()->findAll($Criteria);


        $msg = $this->renderPartial('job_quote_controller', array(
            'job_model' => $job_model,
            'quote_model' => $quote_model,
            'building_model' => $building_model,
            'site_model' => $site_model,
            'contact_model' => $contact_model,
            'company_model' => $company_model,
            'job_services_model' => $job_services_model,
                )
                , true);


        $mpdf = new mPDF('', // mode - default ''
                '', // format - A4, for example, default ''
                10, // font size - default 0
                '', // default font family
                12.7, // margin_left
                12.7, // margin right
                5, // margin top
                12.7, // margin bottom
                8, // margin header
                8, // margin footer
                'L');
        //$mpdf->SetHeader($store_name);
        $mpdf->debug = true;
        $mpdf->mirrorMargins = 1;
        $mpdf->use_kwt = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($msg);



        $footer_text = $this->renderPartial('job_quote_controller_footer', array()
                , true);

        $mpdf->SetHTMLFooter($footer_text);

        // $mpdf->showImageErrors = true;
        $pdf_name = "QuoteSheet-" . $job_model->quote_id . "-" . $job_model->id . "-" . $company_model->name . "-" . $site_model->site_name;
        $pdf_name = preg_replace('/\s+/', '-', $pdf_name);
        $pdf_name = trim(preg_replace('/-+/', '-', $pdf_name), '-');
        $mpdf->Output($pdf_name . '.pdf', 'D');
    }

    # $id i.e. job_id

    public function actionDownloadJobsheet($id) {


        // job model
        $job_model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($job_model->agent_id,$this->agent_id);

        // quote model by job id
        $quote_model = Quotes::model()->findByPk($job_model->quote_id);

        // building model
        $building_model = Buildings::model()->findByPk($job_model->building_id);

        // site model
        $site_model = ContactsSite::model()->findByPk($quote_model->site_id);

        // contact model
        $contact_model = Contact::model()->findByPk($quote_model->contact_id);

        // contact model
        $company_model = Company::model()->findByPk($quote_model->company_id);

        // finding service under job
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $job_services_model = QuoteJobServices::model()->findAll($Criteria);



        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $supervisor = JobSupervisor::model()->findAll($Criteria);

        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $siteSupervisor = JobSiteSupervisor::model()->findAll($Criteria);

        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $staffUser = JobStaff::model()->findAll($Criteria);

        $induction_company_id = 0;
        $induction_available_user = array();
        if ($site_model->need_induction === '1') {
            $induction_company_id = $site_model->induction_company_id;

            $Criteria = new CDbCriteria();
            $Criteria->select = ' distinct(user_id)';
            $Criteria->condition = "induction_company_id=$induction_company_id";
            $SiteInduction = Induction::model()->findAll($Criteria);

            foreach ($SiteInduction as $single_user) {
                $induction_available_user[] = $single_user->user_id;
            }
        }


        $Criteria = new CDbCriteria();
        $Criteria->select = ' distinct(user_id)';
        $UserLicenses = UserLicenses::model()->findAll($Criteria);
        $license_available_user = array();
        foreach ($UserLicenses as $single_user) {
            $license_available_user[] = $single_user->user_id;
        }


        $job_all_users = array();
        foreach ($supervisor as $single_user) {
            $temp_job_all_users = array();
            $temp_job_all_users['user_id'] = $single_user->user_id;
            $temp_job_all_users['Position'] = 'Supervisor';
            $temp_job_all_users['Name'] = $single_user->name;
            $temp_job_all_users['Mobile'] = $single_user->mobile;
            $view_induction_link = '<a href="' . $this->base_url_assets. '/?r=induction/index&user_id=' . $single_user->user_id . '&induction_company_id=' . $induction_company_id . '" target="_blank" >View Induction</a>';
            if (!in_array($single_user->user_id, $induction_available_user)) {
                $view_induction_link = '';
            }
            $temp_job_all_users['Induction'] = $view_induction_link;
            $view_licences_link = '<a href="' . $this->base_url_assets. '/?r=licences/index&user_id=' . $single_user->user_id . '" target="_blank" >View Licence</a>';
            if (!in_array($single_user->user_id, $license_available_user)) {
                $view_licences_link = '';
            }
            $temp_job_all_users['Licences'] = $view_licences_link;
            $temp_job_all_users['working_date'] = '';
            $temp_job_all_users['working_day_night'] = '';
            $temp_job_all_users['working_time'] = '';
            $temp_job_all_users['place_to_come'] = '';
            $temp_job_all_users['working_time'] = '';
            $job_all_users[$job_model->job_started_date . '_DAY'][] = $temp_job_all_users;
        }



        foreach ($siteSupervisor as $single_user) {

            $temp_job_all_users = array();
            $temp_job_all_users['user_id'] = $single_user->user_id;
            $temp_job_all_users['Position'] = 'Site Supervisor';
            $temp_job_all_users['Name'] = $single_user->name;
            $temp_job_all_users['Mobile'] = $single_user->mobile;
            $view_induction_link = '<a href="' . $this->base_url_assets. '/?r=induction/index&user_id=' . $single_user->user_id . '&induction_company_id=' . $induction_company_id . '" target="_blank" >View Induction</a>';
            if (!in_array($single_user->user_id, $induction_available_user)) {
                $view_induction_link = '';
            }
            $temp_job_all_users['Induction'] = $view_induction_link;
            $view_licences_link = '<a href="' . $this->base_url_assets. '/?r=licences/index&user_id=' . $single_user->user_id . '" target="_blank" >View Licence</a>';
            if (!in_array($single_user->user_id, $license_available_user)) {
                $view_licences_link = '';
            }
            $temp_job_all_users['Licences'] = $view_licences_link;
            $formated_date = date("d-m-Y", strtotime($single_user->job_date));
            $temp_job_all_users['working_date'] = $formated_date;
            $temp_job_all_users['working_day_night'] = $single_user->day_night;
            $place_to_come = '';
            $time_at_place = '';
            $temp_job_all_users['working_time'] = '';


            $Criteria = new CDbCriteria();
            $Criteria->condition = "job_id=" . $id . " && working_date='" . $single_user->job_date . "'" . " && day_night='" . $single_user->day_night . "'";
            $job_working_model_exist = JobWorking::model()->find($Criteria);

            if ($job_working_model_exist !== NULL) {

                if ($job_working_model_exist->site_time === $job_working_model_exist->yard_time) {
                    $place_to_come = 'SITE';
                    $time_at_place = $job_working_model_exist->site_time;
                } else {
                    $place_to_come = 'YARD';
                    $time_at_place = $job_working_model_exist->yard_time;
                }
            }
            $temp_job_all_users['place_to_come'] = $place_to_come;
            $temp_job_all_users['working_time'] = $time_at_place;

            $job_all_users[$formated_date . '_' . $single_user->day_night][] = $temp_job_all_users;
        }

        foreach ($staffUser as $single_user) {
            $temp_job_all_users = array();
            $temp_job_all_users['user_id'] = $single_user->user_id;
            $temp_job_all_users['Position'] = 'Staff';
            $temp_job_all_users['Name'] = $single_user->name;
            $temp_job_all_users['Mobile'] = $single_user->mobile;
            $view_induction_link = '<a href="' . $this->base_url_assets. '/?r=induction/index&user_id=' . $single_user->user_id . '&induction_company_id=' . $induction_company_id . '" target="_blank" >View Induction</a>';
            if (!in_array($single_user->user_id, $induction_available_user)) {
                $view_induction_link = '';
            }
            $temp_job_all_users['Induction'] = $view_induction_link;
            $view_licences_link = '<a href="' . $this->base_url_assets. '/?r=licences/index&user_id=' . $single_user->user_id . '" target="_blank" >View Licence</a>';
            if (!in_array($single_user->user_id, $license_available_user)) {
                $view_licences_link = '';
            }
            $temp_job_all_users['Licences'] = $view_licences_link;
            $formated_date = date("d-m-Y", strtotime($single_user->job_date));
            $temp_job_all_users['working_date'] = $formated_date;
            $temp_job_all_users['working_day_night'] = $single_user->day_night;
            $place_to_come = '';
            $time_at_place = '';
            $temp_job_all_users['working_time'] = '';


            $Criteria = new CDbCriteria();
            $Criteria->condition = "job_id=" . $id . " && working_date='" . $single_user->job_date . "'" . " && day_night='" . $single_user->day_night . "'";
            $job_working_model_exist = JobWorking::model()->find($Criteria);


            if ($job_working_model_exist !== NULL) {

                if ($job_working_model_exist->site_time === $job_working_model_exist->yard_time) {
                    $place_to_come = 'SITE';
                    $time_at_place = $job_working_model_exist->site_time;
                } else {
                    $place_to_come = 'YARD';
                    $time_at_place = $job_working_model_exist->yard_time;
                }
            }
            $temp_job_all_users['place_to_come'] = $place_to_come;
            $temp_job_all_users['working_time'] = $time_at_place;
            $job_all_users[$formated_date . '_' . $single_user->day_night][] = $temp_job_all_users;
        }





        // pick up van , on site, finish on site
        $times = array();
        $times['pick_up_van_time_date'] = '&nbsp';
        $times['site_time_date'] = '&nbsp';
        $times['finish_time_date'] = '&nbsp';

        if (!empty($job_model->job_started_time)) {
            $times['pick_up_van_time_date'] = $job_model->job_started_time . ' on ' . date("d-m-Y", strtotime($job_model->job_started_date));
            $times['site_time_date'] = $job_model->job_started_time . ' on ' . date("d-m-Y", strtotime($job_model->job_started_date));
        }

        if (!empty($job_model->job_end_time))
            $times['finish_time_date'] = $job_model->job_end_time . ' on ' . date("d-m-Y", strtotime($job_model->job_end_date));

        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = " . $id;
        $job_working_model = JobWorking::model()->findAll($Criteria);

        $job_working_timing = array();
        foreach ($job_working_model as $row) {
            if (!empty($row->site_time)) {
                $job_working_timing[$row->job_id][$row->working_date][$row->day_night]['yard_time'] = $row->yard_time . ' on ' . date("d-m-Y", strtotime($row->working_date));
                $job_working_timing[$row->job_id][$row->working_date][$row->day_night]['site_time'] = $row->site_time . ' on ' . date("d-m-Y", strtotime($row->working_date));
                $job_working_timing[$row->job_id][$row->working_date][$row->day_night]['finish_time'] = $row->finish_time . ' on ' . date("d-m-Y", strtotime($row->working_date));
            }
        }

        if (isset($job_working_timing[$id][$job_model->job_started_date]['NIGHT'])) {
            $times['pick_up_van_time_date'] = $job_working_timing[$id][$job_model->job_started_date]['NIGHT']['yard_time'];
            $times['site_time_date'] = $job_working_timing[$id][$job_model->job_started_date]['NIGHT']['site_time'];
        }

        if (isset($job_working_timing[$id][$job_model->job_started_date]['DAY'])) {
            $times['pick_up_van_time_date'] = $job_working_timing[$id][$job_model->job_started_date]['DAY']['yard_time'];
            $times['site_time_date'] = $job_working_timing[$id][$job_model->job_started_date]['DAY']['site_time'];
        }

        if (isset($job_working_timing[$id][$job_model->job_end_date]['DAY'])) {
            $times['finish_time_date'] = $job_working_timing[$id][$job_model->job_end_date]['DAY']['finish_time'];
        }

        if (isset($job_working_timing[$id][$job_model->job_end_date]['NIGHT'])) {
            $times['finish_time_date'] = $job_working_timing[$id][$job_model->job_end_date]['NIGHT']['finish_time'];
        }


        $msg = $this->renderPartial('job_sheet_controller', array(
            'job_model' => $job_model,
            'quote_model' => $quote_model,
            'building_model' => $building_model,
            'site_model' => $site_model,
            'contact_model' => $contact_model,
            'company_model' => $company_model,
            'job_services_model' => $job_services_model,
            'supervisor' => $supervisor,
            'siteSupervisor' => $siteSupervisor,
            'staffUser' => $staffUser,
            'job_all_users' => $job_all_users,
            'times' => $times,
                )
                , true);

        $mpdf = new mPDF('', // mode - default ''
                '', // format - A4, for example, default ''
                10, // font size - default 0
                '', // default font family
                12.7, // margin_left
                12.7, // margin right
                5, // margin top
                12.7, // margin bottom
                8, // margin header
                8, // margin footer
                'L');
        //$mpdf->SetHeader($store_name);
        $mpdf->debug = true;
        $mpdf->mirrorMargins = 1;
        $mpdf->use_kwt = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($msg);
        //--------------------2nd page -------------------
        /*  $mpdf->AddPage();
          $msg2 = $this->renderPartial('job_sheet_controller2', array(
          'job_model' => $job_model,
          'job_services_model' => $job_services_model,
          )
          , true);

          $mpdf->WriteHTML($msg2); */
        //--------------------3rd page -------------------
        // check first if this job having images

        $path = Yii::app()->basePath . '/../uploads/quote-building-service/';
        $image_count = 0;
        foreach ($job_services_model as $service_row) {
            if (isset($service_row->image) && $service_row->image != NULL && file_exists($path . $service_row->image)) {
                $image_count++;
            }
        }
        if ($image_count > 0) {
            $mpdf->AddPage();
            $msg3 = $this->renderPartial('job_sheet_controller3', array(
                'job_services_model' => $job_services_model,
                    )
                    , true);
            $mpdf->WriteHTML($msg3);
        }


        // $mpdf->showImageErrors = true;
        $pdf_name = "JobSheet-" . $job_model->quote_id . "-" . $job_model->id . "-" . $company_model->name . "-" . $site_model->site_name;
        $pdf_name = preg_replace('/\s+/', '-', $pdf_name);
        $pdf_name = trim(preg_replace('/-+/', '-', $pdf_name), '-');
        $mpdf->Output($pdf_name . '.pdf', 'D');
    }

    # $id i.e. job_id

    public function actionDownloadSignOffSheet($id) {


        // job model
        $job_model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($job_model->agent_id,$this->agent_id);
        
        //creating signature png on pdf if client sign sign exists
        if (!empty($job_model->client_signature)) {
            $valid_json = CommonFunctions::isJson($job_model->client_signature);
            if ($valid_json == 1) {
                $save = Yii::app()->basePath . '/../uploads/temp/' . $id . '.png';
                $im = CommonFunctions::sigJsonToImage($job_model->client_signature);
                imagepng($im, $save, 0, NULL);
            }
        }


        // quote model by job id
        $quote_model = Quotes::model()->findByPk($job_model->quote_id);

        // building model
        $building_model = Buildings::model()->findByPk($job_model->building_id);

        // site model
        $site_model = ContactsSite::model()->findByPk($quote_model->site_id);

        // contact model
        $contact_model = Contact::model()->findByPk($quote_model->contact_id);

        // contact model
        $company_model = Company::model()->findByPk($quote_model->company_id);

        // finding service under job
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $job_services_model = QuoteJobServices::model()->findAll($Criteria);
        unset($Criteria);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $supervisor = JobSupervisor::model()->findAll($Criteria);
        unset($Criteria);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $siteSupervisor = JobSiteSupervisor::model()->findAll($Criteria);
        unset($Criteria);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $staffUser = JobStaff::model()->findAll($Criteria);


        $msg = $this->renderPartial('sign_off_sheet_pdf', array(
            'job_model' => $job_model,
            'quote_model' => $quote_model,
            'building_model' => $building_model,
            'site_model' => $site_model,
            'contact_model' => $contact_model,
            'company_model' => $company_model,
            'job_services_model' => $job_services_model,
            'supervisor' => $supervisor,
            'siteSupervisor' => $siteSupervisor,
            'staffUser' => $staffUser,
                )
                , true);

        $mpdf = new mPDF('', // mode - default ''
                '', // format - A4, for example, default ''
                10, // font size - default 0
                '', // default font family
                12.7, // margin_left
                12.7, // margin right
                5, // margin top
                12.7, // margin bottom
                8, // margin header
                8, // margin footer
                'L');
        //$mpdf->SetHeader($store_name);
        $mpdf->debug = true;
        $mpdf->mirrorMargins = 1;
        $mpdf->use_kwt = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($msg);
        $pdf_name = "SignOffsheet-" . $id . "-" . $company_model->name . "-" . $site_model->site_name;
        $pdf_name = preg_replace('/\s+/', '-', $pdf_name);
        $pdf_name = trim(preg_replace('/-+/', '-', $pdf_name), '-');
        $mpdf->Output($pdf_name . '.pdf', 'D');

        if (isset($save) && !empty($save) && file_exists($png_path_file)) {
            unlink($save);
        }
    }

    # $id i.e. job_id

    public function actionDownloadSwms($id) {


        // $id i.e. $job_id
        // job model
        $job_model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($job_model->agent_id,$this->agent_id);

        // quote model by job id
        $quote_model = Quotes::model()->findByPk($job_model->quote_id);

        // service model
        $service_model = Service::model()->findByPk($quote_model->service_id);

        // building model
        $building_model = Buildings::model()->findByPk($job_model->building_id);

        // site model
        $site_model = ContactsSite::model()->findByPk($quote_model->site_id);

        // contact model
        $contact_model = Contact::model()->findByPk($quote_model->contact_id);

        // contact model
        $company_model = Company::model()->findByPk($quote_model->company_id);

        // finding service under job
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $job_services_model = QuoteJobServices::model()->findAll($Criteria);
        unset($Criteria);




        $job_all_users = array();
        $signed_users = array();
        $user = 0;
        $signature_empty_count = 0;
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $supervisor = JobSupervisor::model()->findAll($Criteria);
        unset($Criteria);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $siteSupervisor = JobSiteSupervisor::model()->findAll($Criteria);
        $unique_signaure_user = array();
        foreach ($siteSupervisor as $single_user) {

            if (!in_array($single_user->user_id, $unique_signaure_user)) {
                $working_supervisor_array[] = ucwords($single_user->name);
                $signed_users[$user]['auto_user_id'] = $single_user->id;
                $signed_users[$user]['Position'] = 'Site Supervisor';
                $signed_users[$user]['Name'] = $single_user->name;
                $signed_users[$user]['Mobile'] = $single_user->mobile;
                $signed_users[$user]['signature'] = $single_user->signature;
                if (empty($single_user->signature))
                    $signature_empty_count++;
                $signed_users[$user]['date_on_signed'] = '0000-00-00';

                if ($job_model->swms_signature_lock == '1') {
                    $signed_users[$user]['date_on_signed'] = $single_user->date_on_signed;
                    if (!empty($single_user->signature) && $single_user->signature != NULL) {
                        $valid_json = CommonFunctions::isJson($single_user->signature);
                        if ($valid_json == 1) {
                            $save = Yii::app()->basePath . '/../uploads/temp/user-' . $single_user->id . '.png';
                            $im = CommonFunctions::sigJsonToImage($single_user->signature);
                            imagepng($im, $save, 0, NULL);
                        }
                    }
                }
                $user++;

                $unique_signaure_user[] = $single_user->user_id;
            }
        }
        unset($Criteria);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $staffUser = JobStaff::model()->findAll($Criteria);
        foreach ($staffUser as $single_user) {

            if (!in_array($single_user->user_id, $unique_signaure_user)) {
                $job_all_users[] = ucwords($single_user->name);
                $signed_users[$user]['auto_user_id'] = $single_user->id;
                $signed_users[$user]['Position'] = 'Staff';
                $signed_users[$user]['Name'] = $single_user->name;
                $signed_users[$user]['Mobile'] = $single_user->mobile;
                $signed_users[$user]['signature'] = $single_user->signature;
                if (empty($single_user->signature))
                    $signature_empty_count++;
                $signed_users[$user]['date_on_signed'] = '0000-00-00';

                if ($job_model->swms_signature_lock == '1') {
                    $signed_users[$user]['date_on_signed'] = $single_user->date_on_signed;
                    if (!empty($single_user->signature) && $single_user->signature != NULL) {
                        $valid_json = CommonFunctions::isJson($single_user->signature);
                        if ($valid_json == 1) {
                            $save = Yii::app()->basePath . '/../uploads/temp/user-' . $single_user->id . '.png';
                            $im = CommonFunctions::sigJsonToImage($single_user->signature);
                            imagepng($im, $save, 0, NULL);
                        }
                    }
                }

                $user++;

                $unique_signaure_user[] = $single_user->user_id;
            }
        }

        //extra members
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $staffUser = JobExtraMember::model()->findAll($Criteria);
        foreach ($staffUser as $single_user) {
            $job_all_users[] = ucwords($single_user->name);

            $signed_users[$user]['auto_user_id'] = $single_user->id;
            $signed_users[$user]['Position'] = 'extra_member';
            $signed_users[$user]['Name'] = ucwords($single_user->name);
            $signed_users[$user]['Mobile'] = '';
            $signed_users[$user]['signature'] = $single_user->signature;
            if (empty($single_user->signature))
                $signature_empty_count++;
            $signed_users[$user]['date_on_signed'] = '0000-00-00';

            if ($job_model->swms_signature_lock == '1') {
                $signed_users[$user]['date_on_signed'] = $single_user->date_on_signed;
                if (!empty($single_user->signature) && $single_user->signature != NULL) {
                    $valid_json = CommonFunctions::isJson($single_user->signature);
                    if ($valid_json == 1) {
                        $save = Yii::app()->basePath . '/../uploads/temp/user-' . $single_user->id . '.png';
                        $im = CommonFunctions::sigJsonToImage($single_user->signature);
                        imagepng($im, $save, 0, NULL);
                    }
                }
            }


            $user++;
        }

        $work_group_user_names = '';
        if (count($job_all_users) > 0)
            $work_group_user_names = implode(', ', $job_all_users);

        $swms = array();
        $swms_ids = explode(',', $job_model->swms_ids);
        $working_supervisor = '';
        if (isset($working_supervisor_array) && is_array($working_supervisor_array) && count($working_supervisor_array) > 0) {
            $working_supervisor_array = array_unique($working_supervisor_array);
            $working_supervisor = implode(', ', $working_supervisor_array);
        }



        $risk_initails_options = array();

        $criteria = new CDbCriteria();
        $criteria->select = "id,name";
        $criteria->order = 'name';
        $loop_risk_initails_types = RiskLevel::model()->findAll($criteria);
        foreach ($loop_risk_initails_types as $value) {
            $risk_initails_options[$value->id] = $value->name;
        }

        $msg = $this->renderPartial('job_swms_controller', array(
            'job_model' => $job_model,
            'quote_model' => $quote_model,
            'building_model' => $building_model,
            'site_model' => $site_model,
            'contact_model' => $contact_model,
            'company_model' => $company_model,
            'job_services_model' => $job_services_model,
            'service_model' => $service_model,
            'supervisor' => $supervisor,
            'siteSupervisor' => $siteSupervisor,
            'staffUser' => $staffUser,
            'swms_ids' => $swms_ids,
            'work_group_user_names' => $work_group_user_names,
            'signed_users' => $signed_users,
            'working_supervisor' => $working_supervisor
                )
                , true);



        $mpdf = new mPDF('', // mode - default ''
                'A4-L', // format - A4, for example, default ''
                10, // font size - default 0
                '', // default font family
                12.7, // margin_left
                12.7, // margin right
                10, // margin top
                12.7, // margin bottom
                8, // margin header
                8, // margin footer
                'L');
        //$mpdf->setFooter('{PAGENO}');

        $mpdf->SetHTMLFooter('
	<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;"><tr>
	<td width="33%">&nbsp;</td>
	<td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
	<td width="33%" style="text-align: right; ">Safe Work Method Statement</td>
	</tr></table>
	');

        $mpdf->debug = true;
        $mpdf->mirrorMargins = 1;
        $mpdf->use_kwt = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $msg = preg_replace('/[^(\x20-\x7F)]*/', '', $msg);
        $mpdf->WriteHTML($msg);



        //2nd page, content item

        foreach ($swms_ids as $swms_id) {
            $swms_model = Swms::Model()->FindByPk($swms_id);
            //swms tasks
            $Criteria = new CDbCriteria();
            $Criteria->condition = "swms_id = " . $swms_id . " && status = '1'";
            $Criteria->order = 'task_sort_order';
            $task_model = SwmsTask::model()->findAll($Criteria);
            $main_result = array();

            $item_count = 1;
            foreach ($task_model as $task_model_object) {
                // find hazards/consequences 
                $Criteria2 = new CDbCriteria();
                $Criteria2->condition = "task_id = " . $task_model_object->id . " && status = '1'";
                $Criteria2->order = 'hrd_consq_sort_order';
                $hazards_consequences_model = SwmsHzrdsConsqs::model()->findAll($Criteria2);

                foreach($hazards_consequences_model as $hazards_consequences_model_object) {

		$initial_risk_text = $risk_initails_options[$hazards_consequences_model_object->risk];
		$residual_risk_text = $risk_initails_options[$hazards_consequences_model_object->residual_risk];
		
                
                $main_result[$item_count-1]['item_count'] = $item_count;
                $main_result[$item_count-1]['item_task'] = $task_model_object->task;				
                $hazards_consqs = '';
                if(! empty($hazards_consequences_model_object->hazards)) { 
                    $hazards_consqs .=  '<strong>Hazard : </strong><br/>'.$hazards_consequences_model_object->hazards.'<br/><br/>';
                }                    
                if(! empty($hazards_consequences_model_object->consequences)) { 
                    $hazards_consqs .=  '<strong>Consequences : </strong><br/>'.$hazards_consequences_model_object->consequences;
                }                   
                
                $main_result[$item_count-1]['hazards_consqs'] = $hazards_consqs;
                $main_result[$item_count-1]['initial_risk_text'] = $initial_risk_text;
                $main_result[$item_count-1]['control_measures'] = html_entity_decode($hazards_consequences_model_object->control_measures);
                $main_result[$item_count-1]['residual_risk_text'] = $residual_risk_text;
                $main_result[$item_count-1]['person_responsible'] = $hazards_consequences_model_object->person_responsible;
                
				$item_count++; 
		}	
		
		
            }

            if (count($main_result) > 0) {
                $pages_result = array_chunk($main_result, 6);
                foreach ($pages_result as $page_result) {
                    $mpdf->AddPage();
                    $msg2 = $this->renderPartial('job_swms_controller2', array(
                        'swms_model' => $swms_model,
                        'page_result' => $page_result
                            )
                            , true);
                    $msg2 = preg_replace('/[^(\x20-\x7F)]*/', '', $msg2);
                    $mpdf->WriteHTML($msg2);
                }
            }
        }


        //3rd page, footer
        $mpdf->AddPage();

        $msg3 = $this->renderPartial('job_swms_controller3', array(
            'job_model' => $job_model,
            'quote_model' => $quote_model,
            'building_model' => $building_model,
            'site_model' => $site_model,
            'contact_model' => $contact_model,
            'company_model' => $company_model,
            'job_services_model' => $job_services_model,
            'service_model' => $service_model,
            'supervisor' => $supervisor,
            'siteSupervisor' => $siteSupervisor,
            'staffUser' => $staffUser,
            'swms_ids' => $swms_ids,
            'work_group_user_names' => $work_group_user_names,
            'signed_users' => $signed_users,
            'working_supervisor' => $working_supervisor
                )
                , true);

        $mpdf->WriteHTML($msg3);


        $pdf_name = "SWMS-" . $id . "-" . $company_model->name . "-" . $site_model->site_name;
        $pdf_name = preg_replace('/\s+/', '-', $pdf_name);
        $pdf_name = trim(preg_replace('/-+/', '-', $pdf_name), '-');
        $mpdf->Output($pdf_name . '.pdf', 'D');
    }

    public function actionDelete_sepervisor($s_id) {
        $model = $this->loadModelSuperViser($s_id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('agent'));
    }

    public function actionDelete_site_sepervisor($ss_id) {
        $model = $this->loadModelSiteSuperViser($ss_id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $model->delete();
        
        
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('agent'));
    }

    public function actionDelete_staff_user($job_id, $job_date) {
        $delete_condition = "job_id = " . $job_id . " and job_date ='" . $job_date . "' && $this->where_agent_condition";
        JobStaff::model()->deleteAll(array("condition" => $delete_condition));
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('agent'));
    }

    public function loadModelSuperViser($id) {
        $model = JobSupervisor::model()->findByPk($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelSiteSuperViser($id) {
        $model = JobSiteSupervisor::model()->findByPk($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelStaff($id) {
        $model = JobStaff::model()->findByPk($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionDelete_job_supervisor() {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        if ($id > 0) {
            $delete_condition = "job_id= $id && $this->where_agent_condition";
            JobSupervisor::model()->deleteAll(array("condition" => $delete_condition));
        }
    }

    public function actionAssign_supervisor() {

        $job_id = isset($_POST['id']) ? $_POST['id'] : 0;
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;


        if ($job_id > 0 && $user_id > 0) {


            $job_model = $this->loadModel($job_id);
            CommonFunctions::checkValidAgent($job_model->agent_id,$this->agent_id);
            
            if ($job_model->approval_status != 'Approved By Admin' || $job_model->booked_status != 'Booked') {
                echo 'invalid';
                exit;
            } else {
                $Criteria = new CDbCriteria();
                $Criteria->condition = "job_id = " . $job_id . " and user_id =" . $user_id;
                $model = JobSupervisor::model()->find($Criteria);


                if (!isset($model->id)) {
                    $delete_condition = "job_id= $job_id && $this->where_agent_condition";
                    JobSupervisor::model()->deleteAll(array("condition" => $delete_condition));

                    $user_model = User::model()->findByPk($user_id);

                    $model = new JobSupervisor;
                    $model->job_id = $job_id;
                    $model->user_id = $user_id;
                    $model->name = $user_model->first_name . ' ' . $user_model->last_name;
                    $model->email = $user_model->email;
                    $model->phone = $user_model->home_phone;
                    $model->mobile = $user_model->mobile_phone;
                    $model->agent_id = $this->agent_id;
                    if ($model->save()) {
                        $logined_user_id = Yii::app()->user->id;
                        $supervisor_id = $user_id;
                        EmailFunctionHandle::sendEmail_JOB_ALLOCATION(4, $job_id, $logined_user_id, $supervisor_id, 0, 0);
                        echo '1';
                        exit;
                    }
                } else {
                    echo '0';
                    exit;  // This user already assigned
                }
            }
        }
    }

    public function actionAssign_site_supervisor() {

        $job_id = isset($_POST['id']) ? $_POST['id'] : 0;
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;
        $day_night = isset($_POST['day_night']) ? $_POST['day_night'] : 'DAY';
        $job_date = isset($_POST['job_date']) ? $_POST['job_date'] : '0000-00-00';

        if ($job_id > 0 && $user_id > 0) {
            $job_model = $this->loadModel($job_id);

            $supervisor_model = JobSupervisor::model()->findByAttributes(
                    array(
                         'job_id' => $job_id, 'agent_id' => $this->agent_id,
                    )
            );

            $Criteria = new CDbCriteria();
            $Criteria->condition = "job_id = " . $job_id . " and user_id =" . $user_id;
            $model = JobSiteSupervisor::model()->find($Criteria);

            if ($job_model->approval_status != 'Approved By Admin' || $job_model->booked_status != 'Booked') {
                echo 'invalid';
                exit;
            } else if ($supervisor_model === null) {
                echo 'assign_supervisor';
                exit;
            } else {
                
                $delete_condition = "job_id=" .  $job_id . " && job_date='" . $job_date . "'" . " && day_night='" . $day_night . "' && $this->where_agent_condition";
                JobSiteSupervisor::model()->deleteAll(array("condition" => $delete_condition));

                $user_model = User::model()->findByPk($user_id);
                $model = new JobSiteSupervisor;
                $model->job_id = $job_id;
                $model->user_id = $user_id;
                $model->day_night = $day_night;
                $model->job_date = $job_date;
                $model->name = $user_model->first_name . ' ' . $user_model->last_name;
                $model->email = $user_model->email;
                $model->phone = $user_model->home_phone;
                $model->mobile = $user_model->mobile_phone;
                $model->agent_id  = $this->agent_id;
                if ($model->save()) {
                    $logined_user_id = Yii::app()->user->id;
                    $supervisor_id = $supervisor_model->user_id;
                    $site_supervisor_id = $user_id;
                    EmailFunctionHandle::sendEmail_JOB_ALLOCATION(5, $job_id, $logined_user_id, $supervisor_id, $site_supervisor_id, 0);
                    echo '1';
                    exit;
                }
            }
        }
    }

    public function actionAssign_staff() {


        $job_id = isset($_POST['id']) ? $_POST['id'] : 0;
        $user_id = isset($_POST['user_id']) ? rtrim($_POST['user_id'], "_") : 0;
        $day_night = isset($_POST['day_night']) ? $_POST['day_night'] : 'DAY';
        $job_date = isset($_POST['job_date']) ? $_POST['job_date'] : '0000-00-00';
        $user_ids_list = explode('_', $user_id);
        $connection = Yii::app()->db;
        if ($job_id > 0 && $user_id > 0 && !empty($job_date)) {
            $job_model = $this->loadModel($job_id);



            $supervisor_model = JobSupervisor::model()->findByAttributes(
                    array(
                         'job_id' => $job_id, 'agent_id' => $this->agent_id,
                    )
            );

            $site_supervisor_model = JobSiteSupervisor::model()->findByAttributes(
                    array(
                         'job_id' => $job_id, 'agent_id' => $this->agent_id,
                    )
            );




            if ($job_model->approval_status != 'Approved By Admin' || $job_model->booked_status != 'Booked') {
                echo 'invalid';
                exit;
            } else if ($supervisor_model === null) {
                echo 'assign_supervisor';
                exit;
            } else if ($site_supervisor_model === null) {
                echo 'assign_site_supervisor';
                exit;
            } else {

                $query = "select * from hc_job_staff where job_id=" . $job_id . " && job_date='" . $job_date . "'  && day_night='" . $day_night . "' && name like 'New Staff%'";
                $check_dummy_staff_exist = $connection->createCommand($query)->queryAll();

                // find previous staff
                $Criteria = new CDbCriteria();
                $Criteria->condition = "job_id=" .  $job_id . " && job_date='" . $job_date . "'" . " && day_night='" . $day_night . "'";
                $previous_staff = JobStaff::model()->findAll($Criteria);

                $previous_user_ids = array();
                foreach ($previous_staff as $row_staff) {
                    $previous_user_ids[] = $row_staff->user_id;
                }

                $delete_user_ids = array_diff($previous_user_ids, $user_ids_list);

                if (count($delete_user_ids)) {
                    $delete_condition = "job_id=" .  $job_id . " && job_date='" . $job_date . "'" . " && day_night='" . $day_night . "' && $this->where_agent_condition";
                    $Criteria2 = new CDbCriteria();
                    $Criteria2->condition = $delete_condition;
                    $Criteria2->addInCondition("user_id", $delete_user_ids);
                    JobStaff::model()->deleteAll($Criteria2);
                }

                foreach ($user_ids_list as $user_id) {

                    if (!in_array($user_id, $previous_user_ids)) {

                        $user_model = User::model()->findByPk($user_id);
                        $model = new JobStaff;
                        $model->job_id = $job_id;
                        $model->user_id = $user_id;
                        $model->day_night = $day_night;
                        $model->job_date = $job_date;
                        $model->name = $user_model->first_name . ' ' . $user_model->last_name;
                        $model->email = $user_model->email;
                        $model->phone = $user_model->home_phone;
                        $model->mobile = $user_model->mobile_phone;
                        $model->job_date = $job_date;
                        $model->agent_id = $this->agent_id;
                        $model->save();
                    }
                }

                // sort staffs
                // check need to check or not form submit
                $i = 0;
                if (count($check_dummy_staff_exist) > 0) {
                    $query = "select id,first_name,last_name from hc_user where first_name like 'New Staff%' order by id";
                    $dummy_user_staff = $connection->createCommand($query)->queryAll();

                    //echo '<pre>'; print_r($dummy_user_staff); echo '</pre>';

                    $query = "select * from hc_job_staff where job_date='" . $job_date . "' && name like 'New Staff%' order by id";
                    $assigned_dummy_staff = $connection->createCommand($query)->queryAll();

                    if (count($assigned_dummy_staff) > 0) {

                        foreach ($assigned_dummy_staff as $staff) {

                            $model = JobStaff::model()->findByPk($staff['id']);
                            if (isset($dummy_user_staff[$i]['id'])) {
                                $model->user_id = $dummy_user_staff[$i]['id'];
                                $model->name = $dummy_user_staff[$i]['first_name'] . ' ' . $dummy_user_staff[$i]['last_name'];
                                $model->agent_id = $this->agent_id;
                            }
                            if ($model->save())
                                $i++;
                        }
                    }
                    if ($i > 0)
                        echo 'submit_main_form';
                    exit;
                }



                echo '1';
                exit;
            }
        }
    }

    public function loadModel($id) {
        $model = QuoteJobs::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionUpload($id, $cleaning_status) {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $folder = 'uploads/job_images/'; // folder for uploaded files
        $allowedExtensions = array("jpg", "jpeg", "gif", "png");
        $sizeLimit = 10 * 1024 * 1024; // maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
        $fileName = $result['filename']; //GETTING FILE NAME


        $vimage = new resize($folder . $result['filename']);
        $vimage->resizeImage(300, 225);
        $save_thumb = 'uploads/job_images/thumbs/' . $fileName;
        $vimage->saveImage($save_thumb);



        $model = new JobImages;
        $model->job_id = $id;
        $model->photo = $fileName;
        $model->cleaning_status = $cleaning_status;
        $model->date_added = date("Y-m-d");
        $model->agent_id = $this->agent_id;
        $model->save();


        echo $return; // it's array
    }

    public function actionGetImageSrcByServiceId() {
        $job_service_id = isset($_POST['job_service_id']) ? $_POST['job_service_id'] : 0;
        $model = QuoteJobServices::model()->findByPk($job_service_id);

        $path = Yii::app()->basePath . '/../uploads/quote-building-service/';
        if (isset($model->image) && $model->image != NULL && file_exists($path . $model->image)) {
            $image_url = $this->user_role_base_url . "/uploads/quote-building-service/" . $model->image;
            echo "<img  width='100%' src='" . $image_url . "' />";
            exit;
        } else {
            echo '';
            exit;
        }
    }

    // $id i.e. job_id	
    public function actionRebookJob($id) {
        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        
        $interval_days = CommonFunctions::getIntervalDays($model->job_started_date, $model->job_end_date);

        $previous_date = array();

        $next_date = $model->job_started_date;
        $previous_date[] = $next_date;
        for ($i = 0; $i < $interval_days; $i++) {
            $next_date = date('Y-m-d', strtotime($next_date . ' +1 days'));
            $previous_date[] = $next_date;
        }


        //echo '<pre>'; print_r($previous_date); echo '</pre>'; 

        $afterRebookRedirectLink = $this->user_role_base_url . '/?r=Quotes/default/view&id=' . $model->quote_id;
        if (isset($_REQUEST['from_job_details']) && $_REQUEST['from_job_details'] == 'yes')
            $afterRebookRedirectLink = $this->user_role_base_url . '/?r=Quotes/Job/view&id=' . $model->id;


        $deleteJobStaff = '';
        $job_started_date = isset($_POST['QuoteJobs']['job_started_date']) ? $_POST['QuoteJobs']['job_started_date'] : '';
        $job_end_date = isset($_POST['QuoteJobs']['job_end_date']) ? $_POST['QuoteJobs']['job_end_date'] : '';

        $new_dates = array();

        $next_date = $job_started_date;
        $new_dates[] = $next_date;
        $interval_days = CommonFunctions::getIntervalDays($job_started_date, $job_end_date);
        for ($i = 0; $i < $interval_days; $i++) {
            $next_date = date('Y-m-d', strtotime($next_date . ' +1 days'));
            $new_dates[] = $next_date;
        }

        if ($job_started_date != $model->job_started_date)
            $deleteJobStaff = 'yes';
        else if ($job_end_date != $model->job_end_date)
            $deleteJobStaff = 'yes';


        if (isset($_POST['QuoteJobs'])) {

            $model->attributes = $_POST['QuoteJobs'];


            $model->job_started_time = date("H:i:s", strtotime($_POST['QuoteJobs']['job_started_time']));
            $model->job_end_time = date("H:i:s", strtotime($_POST['QuoteJobs']['job_end_time']));
            $model->agent_id = $this->agent_id;

            if ($model->validate()) {
                if ($model->save(false)) {

                    if ($deleteJobStaff == 'yes') { // if dates are changed for job then only delete assigned staff members from table
                        foreach ($previous_date as $job_date) {
                            if (!in_array($job_date, $new_dates)) {
                                $delete_condition = "job_id=" .  $model->id . " && job_date='" . $job_date . "' && $this->where_agent_condition";
                                JobStaff::model()->deleteAll(array("condition" => $delete_condition));
                                JobSiteSupervisor::model()->deleteAll(array("condition" => $delete_condition));
                                $delete_working_condition = "job_id=" .  $model->id . " && working_date='" . $job_date . "' && $this->where_agent_condition";
                                JobWorking::model()->deleteAll(array("condition" => $delete_working_condition));
                            }
                        }
                    }
                    $logined_user_id = Yii::app()->user->id;
                    $job_id = $model->id;
                    $supervisor_model = JobSupervisor::model()->findByAttributes(
                            array(
                                 'job_id' => $job_id, 'agent_id' => $this->agent_id,
                            )
                    );

                    if ($supervisor_model != NULL)
                        $supervisor_id = $supervisor_model->user_id;
                    else
                        $supervisor_id = $logined_user_id;

                    EmailFunctionHandle::sendEmail_JOB_ALLOCATION(7, $job_id, $logined_user_id, $supervisor_id, 0, 0);

                    Yii::app()->request->redirect($afterRebookRedirectLink);
                }
            }
        }

        $this->render('rebook_job', array('model' => $model));
    }

    // $id i.e. job_id	
    public function actionSpotSignOff($id) {

        $attachment_path = Yii::app()->basePath . '/../uploads/temp/';
        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);




        // sending signoff sheet to admin
        $job_model = $model;


        // quote model by job id
        $quote_model = Quotes::model()->findByPk($model->quote_id);

        // building model
        $building_model = Buildings::model()->findByPk($model->building_id);

        // site model
        $site_model = ContactsSite::model()->findByPk($quote_model->site_id);

        // contact model
        $contact_model = Contact::model()->findByPk($quote_model->contact_id);

        // contact model
        $company_model = Company::model()->findByPk($quote_model->company_id);

        // finding service under job
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $job_services_model = QuoteJobServices::model()->findAll($Criteria);
        unset($Criteria);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $supervisor = JobSupervisor::model()->findAll($Criteria);
        unset($Criteria);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $siteSupervisor = JobSiteSupervisor::model()->findAll($Criteria);
        unset($Criteria);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id && $this->where_agent_condition";
        $staffUser = JobStaff::model()->findAll($Criteria);


        if ($model->job_status == 'Completed') {

            if (isset($_POST['QuoteJobs'])) {
                $model->attributes = $_POST['QuoteJobs'];
                $model->client_signed_off_through = '2';
                $model->signed_off = 'Yes';
                $client_signature = isset($_POST['output']) ? $_POST['output'] : '';
                $model->client_signature = $client_signature;
                $model->agent_id = $this->agent_id;
        
                if (empty($model->client_name)) {
                    $model->validate();
                    $model->addError('agent_name', 'Client name can not be blank');
                } else if (empty($model->client_date) || $model->client_date == '0000-00-00') {
                    $model->validate();
                    $model->addError('agent_date', 'Client Date can not be blank');
                } else if ($model->validate()) {
                    if ($model->save(false)) {



                        $job_id = $id;

                        $logined_user_id = 0;
                        $supervisor_model = JobSupervisor::model()->findByAttributes(
                                array(
                                     'job_id' => $job_id, 'agent_id' => $this->agent_id,
                                )
                        );

                        if ($supervisor_model === null)
                            throw new CHttpException(404, 'The requested page does not exist.');

                        $supervisor_id = $supervisor_model->user_id;

                        $site_supervisor_model = JobSiteSupervisor::model()->findByAttributes(
                                array(
                                     'job_id' => $job_id, 'agent_id' => $this->agent_id,
                                )
                        );

                        if ($site_supervisor_model === null)
                            throw new CHttpException(404, 'The requested page does not exist.');


                        // attachment
                        //creating signature png on pdf if client sign sign exists
                        if (!empty($job_model->client_signature)) {
                            $valid_json = CommonFunctions::isJson($job_model->client_signature);
                            if ($valid_json == 1) {
                                $save = $attachment_path . $id . '.png';
                                $im = CommonFunctions::sigJsonToImage($job_model->client_signature);
                                imagepng($im, $save, 0, NULL);
                            }
                        }



                        $msg = $this->renderPartial('sign_off_sheet_pdf', array(
                            'job_model' => $job_model,
                            'quote_model' => $quote_model,
                            'building_model' => $building_model,
                            'site_model' => $site_model,
                            'contact_model' => $contact_model,
                            'company_model' => $company_model,
                            'job_services_model' => $job_services_model,
                            'supervisor' => $supervisor,
                            'siteSupervisor' => $siteSupervisor,
                            'staffUser' => $staffUser,
                                )
                                , true);

                        $mpdf = new mPDF('', // mode - default ''
                                '', // format - A4, for example, default ''
                                10, // font size - default 0
                                '', // default font family
                                12.7, // margin_left
                                12.7, // margin right
                                20, // margin top
                                12.7, // margin bottom
                                8, // margin header
                                8, // margin footer
                                'L');
                        //$mpdf->SetHeader($store_name);
                        $mpdf->debug = true;
                        $mpdf->mirrorMargins = 1;
                        $mpdf->use_kwt = true;
                        $mpdf->SetDisplayMode('fullpage');
                        $mpdf->list_indent_first_level = 0;
                        $mpdf->WriteHTML($msg);


                        // $mpdf->showImageErrors = true;

                        $sign_off_report = "SignOffsheet-" . $id . "-" . $company_model->name . "-" . $site_model->site_name;
                        $sign_off_report = preg_replace('/\s+/', '-', $sign_off_report);
                        $sign_off_report = trim(preg_replace('/-+/', '-', $sign_off_report), '-');
                        $sign_off_report = $sign_off_report . '.pdf';
                        $mpdf->Output($attachment_path . $sign_off_report);


                        EmailJobStatusFunction::sendEmail(11, $job_id, $logined_user_id, $supervisor_id, $site_supervisor_id, $sign_off_report);





                        Yii::app()->request->redirect($this->user_role_base_url . '/?r=Quotes/Job/SignOffView&id=' . $model->id);
                    }
                }
            }

            $this->render('spot_sign_off_job', array('job_model' => $job_model,
                'quote_model' => $quote_model,
                'building_model' => $building_model,
                'site_model' => $site_model,
                'contact_model' => $contact_model,
                'company_model' => $company_model,
                'job_services_model' => $job_services_model,
                'supervisor' => $supervisor,
                'siteSupervisor' => $siteSupervisor,
                'staffUser' => $staffUser, 'model' => $model));
        } else {
            $this->render('not_complete_job_message', array('model' => $model));
        }
    }

    // $id i.e. job_id	
    public function actionSendSignOffEmail($id) {
        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        
        $job_id = $model->id;
        $job_cleaning_report = '';
        $attachment_path = Yii::app()->basePath . '/../uploads/temp/';
        if ($model->job_status == 'Completed') {
            if (isset($_POST['QuoteJobs'])) {

                $model->attributes = $_POST['QuoteJobs'];
                $model->client_signed_off_through = '';
                $model->agent_id = $this->agent_id;

                if (empty($model->client_name)) {
                    $model->validate();
                    $model->addError('agent_name', 'Client name can not be blank');
                } else if (empty($model->client_email)) {
                    $model->validate();
                    $model->addError('agent_email', 'Client email address can not be blank');
                } else if (empty($model->job_completed_date) || $model->job_completed_date == '0000-00-00') {
                    $model->validate();
                    $model->addError('job_completed_date', 'Job Completed Date can not be blank');
                } else if ($model->validate()) {

                    JobsignoffRequests::model()->deleteAll(array("condition" => "job_id = " . $job_id));

                    if ($model->save(false)) {

                        $signOffModel = new JobsignoffRequests;
                        $signOffModel->job_id = $model->id;
                        $unique_code = rand(0, 99999);
                        $signOffModel->unique_code = $model->id . '-' . $unique_code;
                        $signOffModel->sent_date_time = date("Y-m-d H:i:s");
                        $signOffModel->agent_id = $this->agent_id;

                        if ($signOffModel->save()) {

                            $job_cleaning_report = '';
                            $logined_user_id = Yii::app()->user->id;
                            $supervisor_model = JobSupervisor::model()->findByAttributes(
                                    array(
                                         'job_id' => $job_id, 'agent_id' => $this->agent_id,
                                    )
                            );

                            if ($supervisor_model === null)
                                throw new CHttpException(404, 'The requested page does not exist.');

                            $supervisor_id = $supervisor_model->user_id;

                            $site_supervisor_model = JobSiteSupervisor::model()->findByAttributes(
                                    array(
                                         'job_id' => $job_id, 'agent_id' => $this->agent_id,
                                    )
                            );

                            if ($site_supervisor_model === null)
                                throw new CHttpException(404, 'The requested page does not exist.');


                            $site_supervisor_id = $site_supervisor_model->user_id;

                            if ($model->job_status == 'Completed') {
                                EmailJobStatusFunction::sendEmail(10, $job_id, $logined_user_id, $supervisor_id, $site_supervisor_id, $job_cleaning_report);
                            }

                            Yii::app()->request->redirect($this->user_role_base_url . '/?r=Quotes/Job/SignOffView&id=' . $model->id . '&email_sign_off=yes');
                        }
                    }
                }
            }

            $this->render('send_sign_off_mail', array('model' => $model));
        } else {
            $this->render('not_complete_job_message', array('model' => $model));
        }
    }

    // $id i.e. job_id	
    public function actionPaperSignOff($id) {
        $attachment_path = Yii::app()->basePath . '/../uploads/temp/';

        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        
        $job_id = $model->id;
        $old_file = $model->sign_off_document;


        if ($model->job_status == 'Completed') {
            if (isset($_POST['QuoteJobs'])) {

                $model->attributes = $_POST['QuoteJobs'];
                $model->client_signed_off_through = '3';
                $model->signed_off = 'Yes';
                $model->job_completed_date = $model->client_date;
                $model->agent_id = $this->agent_id;

                $_POST['QuoteJobs']['sign_off_document'] = $model->sign_off_document;
                $rnd = rand(0, 99999);  // generate random number between 0-99999			
                $uploadedFile = CUploadedFile::getInstance($model, 'sign_off_document');

                if ($uploadedFile) {
                    $fileName = "{$rnd}-{$uploadedFile}";
                    $model->sign_off_document = $fileName;
                }

                if (empty($model->client_name)) {
                    $model->validate();
                    $model->addError('agent_name', 'Client name can not be blank');
                } else if (empty($model->client_date) || $model->client_date == '0000-00-00') {
                    $model->validate();
                    $model->addError('agent_date', 'Client Date can not be blank');
                } else if (empty($model->sign_off_document)) {
                    $model->validate();
                    $model->addError('sign_off_document', 'Please upload Sign Off Document.');
                } else if ($model->validate()) {
                    if ($model->save(false)) {

                        if (isset($fileName)) {
                            $save = Yii::app()->basePath . '/../uploads/sign_off_document/' . $fileName;
                            $uploadedFile->saveAs($save); // updloaded original document
                            sleep(1);
                            copy($save, $attachment_path . $fileName);
                            $sign_off_report = $fileName;


                            //delete previous document					
                            if (!empty($old_file) && file_exists(Yii::app()->basePath . '/../sign_off_document/' . $old_file))
                                unlink(Yii::app()->basePath . '/../uploads/sign_off_document/' . $old_file);
                        }


                        $logined_user_id = 0;
                        $supervisor_model = JobSupervisor::model()->findByAttributes(
                                array(
                                     'job_id' => $job_id, 'agent_id' => $this->agent_id,
                                )
                        );

                        if ($supervisor_model === null)
                            throw new CHttpException(404, 'The requested page does not exist.');

                        $supervisor_id = $supervisor_model->user_id;

                        $site_supervisor_model = JobSiteSupervisor::model()->findByAttributes(
                                array(
                                     'job_id' => $job_id, 'agent_id' => $this->agent_id,
                                )
                        );

                        if ($site_supervisor_model === null)
                            throw new CHttpException(404, 'The requested page does not exist.');

                        $site_supervisor_id = $site_supervisor_model->user_id;




                        // sending signOff sheet to info email address																			
                        EmailJobStatusFunction::sendEmail(11, $job_id, $logined_user_id, $supervisor_id, $site_supervisor_id, $sign_off_report);

                        Yii::app()->request->redirect($this->user_role_base_url . '/?r=Quotes/Job/SignOffView&id=' . $model->id);
                    }
                }
            }

            $this->render('paper_sign_off_job', array('model' => $model));
        } else {
            $this->render('not_complete_job_message', array('model' => $model));
        }
    }

    // $id i.e. job_id	
    public function actionAddPurchaseOrder($id) {
        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);

        $afterRebookRedirectLink = $this->user_role_base_url . '/?r=Quotes/default/view&id=' . $model->quote_id;
        if (isset($_REQUEST['from_job_details']) && $_REQUEST['from_job_details'] == 'yes')
            $afterRebookRedirectLink = $this->user_role_base_url . '/?r=Quotes/Job/view&id=' . $model->id;


        if (isset($_POST['QuoteJobs'])) {

            $model->attributes = $_POST['QuoteJobs'];
            $model->agent_id = $this->agent_id;
            if ($model->validate()) {
                if ($model->save(false)) {

                    Yii::app()->request->redirect($afterRebookRedirectLink);
                }
            }
        }

        $this->render('job_purchase_order', array('model' => $model));
    }

    // $id i.e. job_id	
    public function actionSignOffView($id) {
        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        
        $this->render('sign_off_view', array('model' => $model));
    }

    public function actionAddFrequencyJob($id) {

        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        
        // find last job related this quote and building				
        $last_job_model = QuoteJobs::model()->findByAttributes(
                array(
            'quote_id' => $model->quote_id,
            'building_id' => $model->building_id
                ), array('order' => 'id DESC')
        );

        $number_of_jobs = isset($_POST['number_of_jobs']) ? $_POST['number_of_jobs'] : 0;

        if (isset($_POST['yt0']) && $_POST['yt0'] == 'Save') {

            if (empty($number_of_jobs))
                $number_of_jobs = 0;

            if ($number_of_jobs == 0)
                Yii::app()->user->setFlash('input_zero', "Please enter valid input, number should be greater than zero!");

            if ($number_of_jobs >= 100)
                Yii::app()->user->setFlash('input_hundred', "Please enter valid input, number should be less than or equal to hundred!");


            if ($number_of_jobs > 0 && $number_of_jobs <= 100) {

                $frequency_type = $model->frequency_type;
                $interval_days = CommonFunctions::getIntervalDays($model->job_started_date, $model->job_end_date);
                $staff_required = $model->staff_required;

                $period_start_date = $last_job_model->job_started_date; // max date of job "job_started_date" related this quote
                $temp_period_start_date = $period_start_date;

                $frequency_model = FrequencyType::model()->findByPk($frequency_type);

                for ($i = 0; $i < $number_of_jobs; $i++) {
                    $period_end_date = date('Y-m-d', strtotime($temp_period_start_date . ' ' . $frequency_model->value));
                    $temp_period_start_date = $period_end_date;
                }

                $period_end_date = date('Y-m-d', strtotime($period_end_date . ' + ' . $interval_days . ' days'));
                QuoteJobService::addFrequencyJobs($model->id, $period_start_date, $period_end_date, $frequency_type, $interval_days, $staff_required, $this->agent_id);
                Yii::app()->request->redirect($this->user_role_base_url . '/?r=Quotes/default/view&id=' . $model->quote_id);
            }
        }

        $this->render('add_frequency_job', array('model' => $model));
    }

    // $id i.e. job_id	
    public function actionBookJob($id) {
        
            $model = $this->loadModel($id);
            CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);

        if ($model->booked_status == 'Booked')
            Yii::app()->request->redirect($this->user_role_base_url . '/?r=Quotes/Job/RebookJob&id=' . $model->id);

        if (isset($_POST['QuoteJobs'])) {
            $model->attributes = $_POST['QuoteJobs'];
            $model->booked_status = 'Booked';

            $staff_required = isset($_POST['QuoteJobs']['staff_required']) ? $_POST['QuoteJobs']['staff_required'] : 0;
            $frequency_type = isset($_POST['QuoteJobs']['frequency_type']) ? $_POST['QuoteJobs']['frequency_type'] : 0;
            $job_started_date = isset($_POST['QuoteJobs']['job_started_date']) ? $_POST['QuoteJobs']['job_started_date'] : '';
            $job_end_date = isset($_POST['QuoteJobs']['job_end_date']) ? $_POST['QuoteJobs']['job_end_date'] : '';
            $period_start_date = isset($_POST['period_start_date']) ? $_POST['period_start_date'] : '';
            $period_end_date = isset($_POST['period_end_date']) ? $_POST['period_end_date'] : '';

            $model->job_started_time = date("H:i:s", strtotime($_POST['QuoteJobs']['job_started_time']));
            $model->job_end_time = date("H:i:s", strtotime($_POST['QuoteJobs']['job_end_time']));
            $model->agent_id = $this->agent_id;



            if ($model->validate()) {

                if (empty($job_started_date) || $job_started_date == '0000-00-00') {
                    Yii::app()->user->setFlash('job_started_date', "Please select job start date.");
                } else  if (empty($job_end_date) || $job_end_date == '0000-00-00') {
                    Yii::app()->user->setFlash('job_end_date', "Please select job end date.");
                } else {

                    if ($frequency_type != 1 && !empty($period_start_date) && !empty($period_end_date)) {
                        if ($period_start_date <= $job_started_date)
                            $period_start_date = $job_started_date;
                        $interval_days = CommonFunctions::getIntervalDays($job_started_date, $job_end_date);
                        QuoteJobService::addFrequencyJobs($model->id, $period_start_date, $period_end_date, $frequency_type, $interval_days, $staff_required, $this->agent_id);
                    }

                    if ($model->save(false)) {

                        $logined_user_id = Yii::app()->user->id;
                        $job_id = $model->id;
                        $supervisor_model = JobSupervisor::model()->findByAttributes(
                                array(
                                    'job_id' => $job_id,                                    
                                    'agent_id' => $this->agent_id,
                                )
                        );

                        if ($supervisor_model != NULL) {
                            $supervisor_id = $supervisor_model->user_id;
                        } else {
                            $supervisor_id = $logined_user_id;
                        }
                        
                        EmailFunctionHandle::sendEmail_JOB_ALLOCATION(7, $job_id, $logined_user_id, $supervisor_id, 0, 0);
                        Yii::app()->request->redirect($this->user_role_base_url . '/?r=Quotes/default/view&id=' . $model->quote_id);
                        
                    }
                }
            }
        }

        $this->render('book_job', array('model' => $model));
    }

    public function actionGet_job_note() {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        if ($id > 0) {
            $model = $this->loadModel($id);
            CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
            
            echo $model->job_note;
            exit;
        }
    }

    public function actionGet_purchase_order() {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        if ($id > 0) {
            $model = $this->loadModel($id);
            CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
            
            echo $model->purchase_order;
            exit;
        }
    }

    public function actionUpdate_tool_types() {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $tool_type_ids = isset($_POST['tool_type_ids']) ? rtrim($_POST['tool_type_ids'], "_") : 0;
        $tool_type_ids_str = str_replace('_', ',', $tool_type_ids);


        if ($id > 0 && $tool_type_ids != 0) {
            $model = $this->loadModel($id);
            CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
            $model->tool_types_ids = $tool_type_ids_str;
            $model->agent_id = $this->agent_id;
            if ($model->save())
                echo '1';
            exit;
        }
    }

    public function actionUpdate_job_note() {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $job_note = isset($_POST['job_note']) ? $_POST['job_note'] : '';
        if ($id > 0) {
            $model = $this->loadModel($id);
            CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
            
            $model->job_note = $job_note;
            $model->agent_id = $this->agent_id;
            if ($model->save())
                echo '1';
            exit;
        }
    }

    public function actionUpdate_purchase_order() {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $purchase_order = isset($_POST['purchase_order']) ? $_POST['purchase_order'] : '';
        if ($id > 0) {
            $model = $this->loadModel($id);
            CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
            
            $model->purchase_order = $purchase_order;
            if ($model->save())
                echo '1';
            exit;
        }
    }

    public function actionUpdate_job_total_working_hour() {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $job_total_working_hour = isset($_POST['job_total_working_hour']) ? $_POST['job_total_working_hour'] : '';
        if ($id > 0) {
            $model = $this->loadModel($id);
            $model->job_total_working_hour = $job_total_working_hour;
            if ($model->save())
                echo '1';
            exit;
        }
    }

    public function actionUpdate_job_parameters_value() {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $staff_required = isset($_POST['staff_required']) ? $_POST['staff_required'] : '';
        $job_total_working_hour = isset($_POST['job_total_working_hour']) ? $_POST['job_total_working_hour'] : '';
        if ($id > 0) {
            $model = $this->loadModel($id);
            CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
            
            $model->staff_required = $staff_required;
            $model->job_total_working_hour = $job_total_working_hour;
            if ($model->save())
                echo '1';
            exit;
        }
    }

    public function actionChange_job_status() {

        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $job_status = isset($_POST['job_status']) ? $_POST['job_status'] : '';
        if ($id > 0) {

            $supervisor_count = JobSupervisor::Model()->countByAttributes(array(
                'job_id' => $id,  'agent_id' => $this->agent_id,
            ));

            if ($supervisor_count == 0) {
                echo 'assign_supervisor';
                exit;
            }

            $site_supervisor_count = JobSiteSupervisor::Model()->countByAttributes(array(
                'job_id' => $id,  'agent_id' => $this->agent_id,
            ));


            if ($site_supervisor_count == 0) {
                echo 'assign_site_supervisor';
                exit;
            }

            $staff_count = JobStaff::Model()->countByAttributes(array(
                'job_id' => $id,  'agent_id' => $this->agent_id,
            ));


            if ($staff_count == 0) {
                echo 'assign_staff';
                exit;
            }

            $model = $this->loadModel($id);
            $model->job_status = $job_status;

            if ($job_status == 'Completed')
                $model->job_completed_date = date('Y-m-d');


            if ($model->save()) {
                $job_id = $id;

                $logined_user_id = Yii::app()->user->id;
                $supervisor_model = JobSupervisor::model()->findByAttributes(
                        array(
                             'job_id' => $job_id, 'agent_id' => $this->agent_id,
                        )
                );

                $supervisor_id = $supervisor_model->user_id;

                $site_supervisor_model = JobSiteSupervisor::model()->findByAttributes(
                        array(
                             'job_id' => $job_id, 'agent_id' => $this->agent_id,
                        )
                );

                $site_supervisor_id = $site_supervisor_model->user_id;

                if ($job_status == 'Started') {
                    EmailJobStatusFunction::sendEmail(8, $job_id, $logined_user_id, $supervisor_id, $site_supervisor_id, '');
                } else if ($job_status == 'Completed') {
                    EmailJobStatusFunction::sendEmail(9, $job_id, $logined_user_id, $supervisor_id, $site_supervisor_id, '');
                }


                echo '1';
                exit;
            }
        }
    }

    public function actionApprove_job() {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        if ($id > 0) {
            $model = $this->loadModel($id);
            CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
            
            $model->approval_status = 'Approved By Admin';
            $today = date('Y-m-d');
            $model->approval_status_date = $today;
            if ($model->save())
                echo '1';
            exit;
        }
    }

    public function actionUpdateJob($id) {

        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);


        if (isset($_POST['QuoteJobs'])) {
            $model->attributes = $_POST['QuoteJobs'];
            $model->swms_ids = implode(',', $_POST['swms']);
            $model->tool_types_ids = implode(',', $_POST['tool_types']);
            if ($model->save())
                Yii::app()->request->redirect($this->user_role_base_url . '/?r=Quotes/Job/updatejoblast&id=' . $model->id);
        }

        $this->render('update_job_page1', array('model' => $model));
    }

    public function actionUpdateJobLast($id) {

        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);

        if (isset($_POST['QuoteJobs'])) {
            $model->attributes = $_POST['QuoteJobs'];
            $model->discount = $_POST['QuoteJobs']['discount'];
            $connection = Yii::app()->db;
            $sql = "SELECT sum(`total`) as sum_of_job_serices FROM `hc_quote_job_services` WHERE `job_id`=" . $model->id;
            $sResult = $connection->createCommand($sql)->queryRow();
            $sum_of_job_serices = $sResult['sum_of_job_serices'];
            $model->final_total = $sum_of_job_serices - (($model->discount / 100) * $sum_of_job_serices);

            if ($model->save())
                Yii::app()->request->redirect($this->user_role_base_url . '/?r=Quotes/Job/view&id=' . $model->id);
        }

        //job_service_model
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = " . $model->id;
        $job_service_model = QuoteJobServices::model()->findAll($Criteria);


        $this->render('update_job_page2', array(
            'model' => $model,
            'job_service_model' => $job_service_model
                )
        );
    }

}
