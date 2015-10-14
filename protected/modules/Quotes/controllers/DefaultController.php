<?php

class DefaultController extends Controller {

	public $base_url_assets = null;
	public $layout = '//layouts/column1';
	public $user_role_base_url = ''; public $user_dashboard_url = '';
	public $agent_id = '';
	public $agent_info = null;
	public $where_agent_condition = '';

    public function init() {
        $this->base_url_assets = CommonFunctions::siteURL();
        $this->user_role_base_url = CommonFunctions::getUserBaseUrl(Yii::app()->user->name);
		$this->user_dashboard_url = CommonFunctions::getUserDashboardUrl(Yii::app()->user->name);

        $this->agent_id = CommonFunctions::getCurrentpageAgentId(Yii::app()->user->name);
	$this->agent_info = CommonFunctions::getAgentInfo($this->agent_id);
        $this->where_agent_condition = " agent_id = ".$this->agent_id ;
        
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

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
		$access_actions = array();
		$admin_access_actions = array('ConfirmBeforeJobStatusChange','index', 'view', 'create', 'update', 'admin', 'delete', 'FindCompaniesContacts', 'FindContactSites', 'FindSiteBuildings', 'changestatustoapprove', 'changestatustodecline', 'MakeCopy', 'BuildingService', 'add_buliding_service', 'update_buliding_service', 'deletequotebuildingservice', 'GetQuoteBuldingColumns', 'GetQuoteBuldingColumnsImage', 'AjaxImageUpload', 'CompleteQuote', 'DeleteQuote', 'DeclineQuoteJob', 'CancelQuoteJob', 'DeleteQuoteJob', 'EditStaffNote', 'GetAllJobQuotes');
		$access_actions = array_merge($access_actions, $admin_access_actions);
     
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => $access_actions,
		'users' => array('system_owner', 'state_manager', 'operation_manager', 'agent', 'supervisor'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

//job id
    public function actionEditStaffNote($id) {
        $model = QuoteJobs::model()->findByPk($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);        
        if (isset($_POST['QuoteJobs'])) {
            $model->attributes = $_POST['QuoteJobs'];
			$model->agent_id = $this->agent_id;
            if ($model->validate()) {
                if ($model->save(false))
                    Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/view&id=' . $model->quote_id);
            }
        }
        $this->render('edit_staff_note', array('model' => $model));
    }

//job id
    public function actionDeclineQuoteJob() {
        $job_id = isset($_POST['job_id']) ? $_POST['job_id'] : 0;
        
        if($job_id == 0) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        $model = QuoteJobs::model()->findByPk($job_id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        
        $model->approval_status = 'Declined';
		$model->agent_id = $this->agent_id;
        $model->save();
        Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/view&id=' . $model->quote_id);
    }

//job id
    public function actionCancelQuoteJob() {
        $job_id = isset($_POST['job_id']) ? $_POST['job_id'] : 0;
        
        if($job_id == 0) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        $model = QuoteJobs::model()->findByPk($job_id);
    
        
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $model->approval_status = 'Cancelled';
		$model->agent_id = $this->agent_id;
        $model->save();
        Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/view&id=' . $model->quote_id);
    }

//job id
    public function actionDeleteQuoteJob() {
        
        $job_id = isset($_POST['job_id']) ? $_POST['job_id'] : 0;
        
        if($job_id == 0) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        $model = QuoteJobs::model()->findByPk($job_id);
    
        
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $existing_job_id = $job_id;

// delete assigned user
        if (isset($existing_job_id) && $existing_job_id > 0) {
            $delete_condition = "job_id=" . $existing_job_id. " && ".$this->where_agent_condition;
            JobSupervisor::model()->deleteAll(array("condition" => $delete_condition));
            JobSiteSupervisor::model()->deleteAll(array("condition" => $delete_condition));
            JobStaff::model()->deleteAll(array("condition" => $delete_condition));
        }


// deleting services under specific job
        $Criteria = new CDbCriteria();
        $Criteria->condition = $delete_condition;
        $model_quote_building_service = QuoteJobServices::model()->findAll($Criteria); // find related buildings by quote id
        foreach ($model_quote_building_service as $Row) {
            $job_service_model = QuoteJobServices::model()->findByPk($Row->id);
            $path = Yii::app()->basePath . '/../uploads/quote-building-service/';

            if (isset($job_service_model->image) && $job_service_model->image != NULL && file_exists($path . $job_service_model->image))
                unlink($path . $job_service_model->image);

            $job_service_model->delete();
        }


        $model->delete();


        Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/view&id=' . $model->quote_id);
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    
    public function actionView($id) {
	// Quote model
        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);

        // find building from source quote
        $Criteria = new CDbCriteria();
        $Criteria->condition = "quote_id = $id && $this->where_agent_condition";
        $Criteria->group = "building_id,job_started_date";
        $QuoteJobs = QuoteJobs::model()->findAll($Criteria); // find related buildings by quote id


        $this->render('view', array(
            'model' => $model,
            'QuoteJobs' => $QuoteJobs,
        ));
    }

        
    public function actionConfirmBeforeJobStatusChange($job_id) {
// Quote model
        $job_id = isset($_GET['job_id']) ? trim($_GET['job_id']) : 0;
        $qjobstatus = isset($_GET['qjobstatus']) ? trim($_GET['qjobstatus']) : '';
        
        if($job_id === 0) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        if(empty($qjobstatus)) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        $job_model = QuoteJobs::model()->findByPk($job_id);
        CommonFunctions::checkValidAgent($job_model->agent_id,$this->agent_id);


        $this->render('change_job_status', array(
            'job_model' => $job_model,
            'qjobstatus' => $qjobstatus
        ));
    }
    
    public function actionGetQuoteBuldingColumns($id) {

        $model = QuoteJobServices::model()->findByPk($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $this->renderPartial('quote_building_service_update', array('model' => $model));
    }

    public function actionGetQuoteBuldingColumnsImage($id) {

        $model = QuoteJobServices::model()->findByPk($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $this->renderPartial('quote_building_service_image', array('model' => $model));
    }

    public function actionGetAllJobQuotes($id) {

        $Criteria = new CDbCriteria();
        $Criteria->condition = "quote_id = $id";
        $Criteria->group = "building_id,job_started_date";
        $model = QuoteJobs::model()->findAll($Criteria); // find related buildings by quote id

        $this->renderPartial('all_job_quotes', array('model' => $model));
    }

    public function actionUpdate_buliding_service() {


        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        if ($id > 0) {
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
            $unit = isset($_POST['unit']) ? $_POST['unit'] : '';

            $notes = isset($_POST['notes']) ? $_POST['notes'] : '';

            $model = QuoteJobServices::model()->findByPk($id);
            $model->service_description = $description;
            $model->quantity = $quantity;
            $model->unit_price_rate = $unit;
            $model->total = $quantity * $unit;
            $model->notes = $notes;  
            $model->save();

            QuoteJobService::UpdateQuoteTotalOnSeviceChange($model->job_id);
        }
    }

    public function actionAdd_buliding_service() {

        $job_id = isset($_POST['job_id']) ? $_POST['job_id'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
        $unit = isset($_POST['unit']) ? $_POST['unit'] : '';

        $notes = isset($_POST['notes']) ? $_POST['notes'] : '';

        $model = new QuoteJobServices;
        $model->job_id = $job_id;
        $model->service_description = $description;
        $model->quantity = $quantity;
        $model->unit_price_rate = $unit;
        $model->total = $quantity * $unit;
        $model->notes = $notes;
        $model->agent_id = $this->agent_id;
        $model->created_at = date("Y-m-d");
		$model->agent_id = $this->agent_id;
        $model->save();

        QuoteJobService::UpdateQuoteTotalOnSeviceChange($model->job_id);
    }

    public function actionDeleteQuoteBuildingService($id) {
        $model = QuoteJobServices::model()->findByPk($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $existing_job_id = $model->job_id;

        $path = Yii::app()->basePath . '/../uploads/quote-building-service/';
        if (isset($model->image) && $model->image != NULL && file_exists($path . $model->image))
            unlink($path . $model->image);
        $model->delete();

        QuoteJobService::UpdateQuoteTotalOnSeviceChange($existing_job_id);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Quotes;
        $site_building_error_msg = '';
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        $site_buildings = isset($_POST['site_buildings']) ? $_POST['site_buildings'] : array();


        if (isset($_POST['Quotes'])) {

            if (count($site_buildings) == 0) {
                $site_building_error_msg = "Please select at least one building";
            }

            $model->attributes = $_POST['Quotes'];
            $date = date("Y-m-d H:i:s");
            $model->updated_at = $date;
            $model->created_at = $date;
            $model->agent_id = $this->agent_id;
            $model->quote_created_user_id = Yii::app()->user->id;

            if ($model->validate() && count($site_buildings) > 0) {
                if ($model->save()) {
                    $temp_quote_id = $model->id;

                    foreach ($site_buildings as $value) {
// delete if already exist by quote id.

                        $model_quote_building_services_temp = new QuoteJobs;
                        $model_quote_building_services_temp->quote_id = $temp_quote_id;
                        $model_quote_building_services_temp->building_id = $value;
                        $model_quote_building_services_temp->original_record = '1';
                        $model_quote_building_services_temp->job_note = Buildings::Model()->FindByPk($value)->job_notes;
                        $model_quote_building_services_temp->created_at = date("Y-m-d");
						$model_quote_building_services_temp->agent_id = $this->agent_id;
                        $model_quote_building_services_temp->save();
                    }

                    Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/BuildingService&qid=' . $model->id);
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'site_building_error_msg' => $site_building_error_msg,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        
        $old_site_id = $model->site_id;

        if ($model === null)
            Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/admin');

        if ($model->status == 'Approved')
            Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/admin');

        $Criteria = new CDbCriteria();
        $Criteria->condition = "quote_id = $id";
        $model_building_service = QuoteJobs::model()->findAll($Criteria); // find related buildings by quote id
// make array of id,name of building from building table by building id
        $building_ids = array();

        foreach ($model_building_service as $building_row) {
            $building_ids[] = $building_row->building_id;
        }


        $site_buildings = isset($_POST['site_buildings']) ? $_POST['site_buildings'] : array();
        $site_building_error_msg = '';

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Quotes'])) {

            if (count($site_buildings) == 0) {
                $site_building_error_msg = "Please select at least one building";
            }


            $model->attributes = $_POST['Quotes'];
            $model->quote_created_user_id = Yii::app()->user->id;
			
            if ($model->validate() && count($site_buildings) > 0) {
                if ($model->save()) {

                    if ($old_site_id != $model->site_id) {
// Delete previous quote building references and its uploaded image too (from table "QuoteJobServices")
// find building from source quote
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "quote_id = $id";
                        $jobs = QuoteJobs::model()->findAll($Criteria); // find related buildings by quote id
                        if (isset($jobs) && count($jobs) > 0) {
                            foreach ($jobs as $row) {

// $row->id is existing job id
                                $existing_job_id = $row->id;

// delete assigned user
                                if (isset($existing_job_id) && $existing_job_id > 0) {
                                    JobSupervisor::model()->deleteAll(array("condition" => "job_id=" . (int) $existing_job_id));
                                    JobSiteSupervisor::model()->deleteAll(array("condition" => "job_id=" . (int) $existing_job_id));
                                    JobStaff::model()->deleteAll(array("condition" => "job_id=" . (int) $existing_job_id));
                                }


// deleting services under specific job
                                $Criteria = new CDbCriteria();
                                $Criteria->condition = "job_id = $existing_job_id";
                                $model_quote_building_service = QuoteJobServices::model()->findAll($Criteria); // find related buildings by quote id
                                foreach ($model_quote_building_service as $Row) {
                                    $job_service_model = QuoteJobServices::model()->findByPk($Row->id);
                                    $path = Yii::app()->basePath . '/../uploads/quote-building-service/';
                                    if (isset($job_service_model->image) && $job_service_model->image != NULL && file_exists($path . $job_service_model->image))
                                        unlink($path . $job_service_model->image);
                                    $job_service_model->delete();
                                }
                            }
                        }


//(from table "QuoteJobs")
                        QuoteJobs::model()->deleteAll(array("condition" => "quote_id=" . (int) $id));


                        $temp_quote_id = $model->id;

                        foreach ($site_buildings as $value) {

                            $model_quote_building_services_temp = new QuoteJobs;
                            $model_quote_building_services_temp->quote_id = $temp_quote_id;
                            $model_quote_building_services_temp->building_id = $value;
                            $model_quote_building_services_temp->original_record = '1';
                            $model_quote_building_services_temp->job_note = Buildings::Model()->FindByPk($value)->job_notes;
                            $model_quote_building_services_temp->created_at = date("Y-m-d");
                            $model_quote_building_services_temp->save();
                        }
                    }

                    $this->redirect(array('BuildingService', 'qid' => $model->id));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
            'building_ids' => $building_ids,
            'site_building_error_msg' => $site_building_error_msg,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
        $model->delete();
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteQuote($id) {

        $quote_model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($quote_model->agent_id,$this->agent_id);
        
// find building from source quote
        $Criteria = new CDbCriteria();
        $Criteria->condition = "quote_id = $id";
        $jobs = QuoteJobs::model()->findAll($Criteria); // find related buildings by quote id
        if (isset($jobs) && count($jobs) > 0) {
            foreach ($jobs as $row) {

// $row->id is existing job id
                $existing_job_id = $row->id;
                $delete_condition = "job_id=" . $existing_job_id. " && agent_id=".$this->agent_id;

// find releated user which was assigned to this user
                if (isset($existing_job_id) && $existing_job_id > 0) {
                    JobSupervisor::model()->deleteAll(array("condition" => $delete_condition));
                    JobSiteSupervisor::model()->deleteAll(array("condition" => $delete_condition));
                    JobStaff::model()->deleteAll(array("condition" => $delete_condition));
                }



// deleting services under specific job
                $Criteria = new CDbCriteria();
                $Criteria->condition = "job_id = $existing_job_id";
                $model_quote_building_service = QuoteJobServices::model()->findAll($Criteria); // find related service by job_id
                foreach ($model_quote_building_service as $Row) {
                    $job_service_model = QuoteJobServices::model()->findByPk($Row->id);
                    $path = Yii::app()->basePath . '/../uploads/quote-building-service/';
                    if (isset($job_service_model->image) && $job_service_model->image != NULL && file_exists($path . $job_service_model->image))
                        unlink($path . $job_service_model->image);
                    $job_service_model->delete();
                }
            }
        }


//(from table "QuoteJobs")
        $delete_quote_condition = "quote_id=" . $id. " && agent_id=".$this->agent_id;
        QuoteJobs::model()->deleteAll(array("condition" => $delete_quote_condition));
        
        
        $quote_model->delete();

        Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/admin');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Quotes');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {

		// CgridView Records/page section
		if ( isset( $_GET[ 'pageSize' ] ) )
		{
			Yii::app()->user->setState( 'pageSize', (int) $_GET[ 'pageSize' ] );
			unset( $_GET[ 'pageSize' ] );
		}

        
        $model = new Quotes('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Quotes']))
            $model->attributes = $_GET['Quotes'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Quotes the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Quotes::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Quotes $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'quotes-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionFindCompaniesContacts() {


        $company_id = $_POST['company_id'];

        $criteria = new CDbCriteria();
        $criteria->select = "id,first_name,surname,mobile";
        $criteria->condition = "company_id =:company_id && $this->where_agent_condition";
        $criteria->params = array(':company_id' => $company_id);
        $criteria->order = 'first_name';
        $loop_options = Contact::model()->findAll($criteria);

        $options = '';
        $options .= '<option value="">--Please select Contact--</option>';

        foreach ($loop_options as $value) {
            $options .= '<option value="' . $value->id . '">' . $value->first_name . ' ' . $value->surname . ' (mobile-' . $value->mobile . ')</option>';
        }
        echo $options;
        exit;
    }

    public function actionFindContactSites() {


        $contact_id = $_POST['contact_id'];

        $site_ids = array();
        $Criteria_sites = new CDbCriteria();
        $Criteria_sites->condition = "contact_id = $contact_id && $this->where_agent_condition";
        $SiteContactRelation_model = SiteContactRelation::model()->findAll($Criteria_sites); // find related buildings by quote id
        foreach ($SiteContactRelation_model as $Row) {
            $site_ids[] = $Row->site_id;
        }


        $criteria = new CDbCriteria();
        $criteria->select = "id,site_name";
        $criteria->addInCondition('id', $site_ids); // in condition$criteria->order = 'site_name';
        $loop_options = ContactsSite::model()->findAll($criteria);

        $options = '';
        $options .= '<option value="">--Please select Site--</option>';

        foreach ($loop_options as $value) {
            $options .= '<option value="' . $value->id . '">' . $value->site_name . '</option>';
        }
        echo $options;
        exit;
    }

    public function actionFindSiteBuildings() {


        $site_id = $_POST['site_id'];

        $criteria = new CDbCriteria();
        $criteria->select = "id,building_name";
        $criteria->condition = "site_id =:site_id && $this->where_agent_condition";
        $criteria->params = array(':site_id' => $site_id);
        $criteria->order = 'building_name';
        $loop_options = Buildings::model()->findAll($criteria);
        $options = '';
        foreach ($loop_options as $value) {
            $options .= '<input type="checkbox" value="' . $value->id . '" name="site_buildings[]">&nbsp;&nbsp;' . $value->building_name . '<br/>';
        }
        echo $options;
        exit;
    }

    public function actionMakeCopy($id) {
        $model = $this->loadModel($id); // record that we want to duplicate
        $model->id = null;
//	$model->status = 'Incomplete';
        $model->created_at = date("Y-m-d");
        $model->status = 'Pending';
        $model->quote_created_user_id = Yii::app()->user->id;
        $model->isNewRecord = true;
		$model->agent_id = $this->agent_id;
        $model->save();

        $new_quote_id = $model->id;
//add buildings
// find building from source quote
        $Criteria = new CDbCriteria();
        $Criteria->condition = "quote_id = $id && original_record='1'";
        $jobs = QuoteJobs::model()->findAll($Criteria); // find related buildings by quote id
        if (isset($jobs) && count($jobs) > 0) {
            foreach ($jobs as $row) {

// save new job with new job, $row->id is existing job id
                $existing_job_id = $row->id;
                $jobs_model = QuoteJobs::model()->findByPk($existing_job_id);
                $jobs_model->id = null;
                $jobs_model->quote_id = $new_quote_id;
                $jobs_model->created_at = date("Y-m-d");
                $jobs_model->approval_status = 'Pending Admin Approval';
                $jobs_model->booked_status = 'Not Booked';
                $jobs_model->job_status = 'NotStarted';
                $jobs_model->paid = 'No';
                $jobs_model->signed_off = 'No';
                $jobs_model->job_started_date = '0000-00-00';
                $jobs_model->job_end_date = '0000-00-00';
                $jobs_model->purchase_order = '';
                $jobs_model->frequency_type = 1;
                $jobs_model->client_signed_off_through = '';
                $jobs_model->client_feedback = '';
                $jobs_model->client_name = '';
                $jobs_model->client_signature = '';
                $jobs_model->sign_off_document = null;
                $jobs_model->client_date = '0000-00-00';
                $jobs_model->client_email = null;
                $jobs_model->staff_required = 0;
                $jobs_model->job_total_working_hour = 0;
                $jobs_model->isNewRecord = true;
				$jobs_model->agent_id = $this->agent_id;
                $jobs_model->save();
                /* echo '<pre>';
                  print_r($jobs_model);
                  echo '</pre>';exit; */
// new job id
                $new_job_id = $jobs_model->id;
                unset($jobs_model);

// save job service with new job id
                $Criteria = new CDbCriteria();
                $Criteria->condition = "job_id = $existing_job_id";
                $BuildingServices = QuoteJobServices::model()->findAll($Criteria); // find related buildings services by quote id
                foreach ($BuildingServices as $job_service) {

                    $jobService_model = QuoteJobServices::model()->findByPk($job_service->id);
                    $jobService_model->id = null;
                    $jobService_model->job_id = $new_job_id;
                    $jobService_model->image = '';
                    $jobService_model->created_at = date("Y-m-d");
                    $jobService_model->isNewRecord = true;
					$jobService_model->agent_id = $this->agent_id;
                    $jobService_model->save();
                }
            }
        }

        return true;
    }

    public function actionChangeStatusToApprove($id) {

        $model = $this->loadModel($id);  // use whatever the correct class name is
        $model->status = 'Approved';
		$model->agent_id = $this->agent_id;
        if ($model->save()) {
// parameters : email_format_id, quote_id
            $this->sendMailWithQuoteSheet(2, $model->id);
        }

        return true;
    }

    public function actionChangeStatusToDecline($id) {
        $model = $this->loadModel($id);  // use whatever the correct class name is
        $model->status = 'Declined';
		$model->agent_id = $this->agent_id;
        if ($model->save()) {
// parameters : email_format_id, quote_id
            $this->sendMailWithQuoteSheet(3, $model->id);
        }
        return true;
    }

    public function actionBuildingService($qid) {


        $model = $this->loadModel($qid);
        if ($model->status == 'Approved')
            Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/admin');



        if (isset($_POST['yt0']) && $_POST['yt0'] == 'Save & Continue') {


            if (isset($_POST['staff_contr'])) {
                foreach ($_POST['staff_contr'] as $key => $value) {

                    $QuoteBuilding_model = QuoteJobs::model()->findByPk($key);
                    $QuoteBuilding_model->si_staff_contractor = $value;
					$QuoteBuilding_model->agent_id = $this->agent_id;
                    $QuoteBuilding_model->save();
                    unset($temp_model);
                    unset($QuoteBuilding_model);
                }
            }


            if (isset($_POST['client'])) {
                foreach ($_POST['client'] as $key => $value) {

                    $QuoteBuilding_model = QuoteJobs::model()->findByPk($key);
                    $QuoteBuilding_model->si_client = $value;
					$QuoteBuilding_model->agent_id = $this->agent_id;
                    $QuoteBuilding_model->save();
                    unset($temp_model);
                    unset($QuoteBuilding_model);
                }
            }



            if (isset($_POST['swms'])) {
                foreach ($_POST['swms'] as $key => $value) {
                    if (is_array($value) && count($value) > 0) {

                        $QuoteBuilding_model = QuoteJobs::model()->findByPk($key);
                        $QuoteBuilding_model->swms_ids = implode(',', $value);
						$QuoteBuilding_model->agent_id = $this->agent_id;
                        $QuoteBuilding_model->save();
                        unset($temp_model);
                        unset($QuoteBuilding_model);
                    }
                }
            }


            if (isset($_POST['tool_types'])) {
                foreach ($_POST['tool_types'] as $key => $value) {
                    if (is_array($value) && count($value) > 0) {
                        $QuoteBuilding_model = QuoteJobs::model()->findByPk($key);
                        $QuoteBuilding_model->tool_types_ids = implode(',', $value);
						$QuoteBuilding_model->agent_id = $this->agent_id;
                        $QuoteBuilding_model->save();
                        unset($temp_model);
                        unset($QuoteBuilding_model);
                    }
                }
            }

            Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/CompleteQuote&qid=' . $qid);
        }



## for initial view		##
        $Criteria = new CDbCriteria();
        $Criteria->condition = "quote_id = $qid";
        $QuoteBuilding_rel_model = QuoteJobs::model()->findAll($Criteria); // find related buildings by quote id

        if ($QuoteBuilding_rel_model === null)
            Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/admin');

        /* 		
          if(count($QuoteBuilding_rel_model) == 0)
          Yii::app()->request->redirect($this->user_role_base_url .'/?r=Quotes/default/update&id='.$qid);
         */
// make array of id,name of building from building table by building id
        $post_values_model = array();
        $building_count = 0;

        foreach ($QuoteBuilding_rel_model as $building_row) {


            $post_values_model[$building_count]['building_id'] = $building_row->building_id;
            $post_values_model[$building_count]['building_name'] = Buildings::Model()->findByPK($building_row->building_id)->building_name;

//$temp_model = QuoteJobs::model()->findByAttributes(array('quote_id' => $qid,'building_id' => $building_row->building_id));
            $QuoteBuilding_model = QuoteJobs::model()->findByPk($building_row['id']);

            $post_values_model[$building_count]['job_id'] = $QuoteBuilding_model->id;
            $post_values_model[$building_count]['si_staff_contractor'] = $QuoteBuilding_model->si_staff_contractor;
            $post_values_model[$building_count]['si_client'] = $QuoteBuilding_model->si_client;


            $post_values_model[$building_count]['swms_ids'] = $QuoteBuilding_model->swms_ids;
            $post_values_model[$building_count]['tool_types_ids'] = $QuoteBuilding_model->tool_types_ids;

            $building_count++;
        }
## for initial view	END	##

        $this->render('quote_building_services', array(
            'post_values_model' => $post_values_model,
        ));
    }

    public function actionCompleteQuote($qid) {


        $model = $this->loadModel($qid);
        if ($model->status == 'Approved')
            Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/admin');


        if ((isset($_POST['yt0']) && $_POST['yt0'] == 'Save Quote') || (isset($_POST['yt1']) && $_POST['yt1'] == 'Generate Quote') && isset($qid) && $qid > 0) {

            if (isset($_POST['discount'])) {
                foreach ($_POST['discount'] as $key => $value) {

                    if (empty($value))
                        $value = 0;
                    $QuoteBuilding_discount_model = QuoteJobs::model()->findByPk($key);
                    $QuoteBuilding_discount_model->discount = $value;
					$QuoteBuilding_discount_model->agent_id = $this->agent_id;
                    $QuoteBuilding_discount_model->save();
                    unset($QuoteBuilding_discount_model);
                }
            }

            if (isset($_POST['week_day_amount'])) {
                foreach ($_POST['week_day_amount'] as $key => $value) {

                    $QuoteBuilding_discount_model = QuoteJobs::model()->findByPk($key);
                    $QuoteBuilding_discount_model->final_total = $value - (($QuoteBuilding_discount_model->discount / 100) * $value);
                    $QuoteBuilding_discount_model->agent_id = $this->agent_id;
					$QuoteBuilding_discount_model->save();
                    unset($QuoteBuilding_discount_model);
                }
            }
            $model = $this->loadModel($qid);
            $model->status = 'pending';
			$model->agent_id = $this->agent_id;
            $model->save();


            if (isset($_POST['yt1']) && $_POST['yt1'] == 'Generate Quote') {
// parameters : email_format_id, quote_id
                $this->sendMailWithQuoteSheet(1, $model->id);
            }

            Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/admin');
        }



## for initial view		##
        $Criteria = new CDbCriteria();
        $Criteria->condition = "quote_id = $qid";
        $QuoteBuilding_rel_model = QuoteJobs::model()->findAll($Criteria); // find related buildings by quote id


        if ($QuoteBuilding_rel_model === null)
            Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/admin');



        if (count($QuoteBuilding_rel_model) == 0)
            Yii::app()->request->redirect($this->user_role_base_url  . '/?r=Quotes/default/update&id=' . $qid);

// make array of id,name of building from building table by building id
        $post_values_model = array();
        $building_count = 0;

        foreach ($QuoteBuilding_rel_model as $building_row) {

            $post_values_model[$building_count]['building_id'] = $building_row->building_id;
            $post_values_model[$building_count]['building_name'] = Buildings::Model()->findByPK($building_row->building_id)->building_name;
            $QuoteBuilding_model = QuoteJobs::model()->findByPk($building_row['id']);


            $post_values_model[$building_count]['id'] = $QuoteBuilding_model->id;
            $post_values_model[$building_count]['quote_id'] = $QuoteBuilding_model->quote_id;

            $post_values_model[$building_count]['si_staff_contractor'] = $QuoteBuilding_model->si_staff_contractor;
            $post_values_model[$building_count]['si_client'] = $QuoteBuilding_model->si_client;

            $post_values_model[$building_count]['swms_ids'] = $QuoteBuilding_model->swms_ids;
            $post_values_model[$building_count]['tool_types_ids'] = $QuoteBuilding_model->tool_types_ids;


            $post_values_model[$building_count]['discount'] = $QuoteBuilding_model->discount;
            $post_values_model[$building_count]['final_total'] = $QuoteBuilding_model->final_total;




// service
            $Criteria = new CDbCriteria();
            $Criteria->condition = "job_id = $building_row->id";
            $BuildingServices = QuoteJobServices::model()->findAll($Criteria); // find related buildings by quote id
            $post_values_model[$building_count]['BuildingServices'] = $BuildingServices;

            $building_count++;
        }
## for initial view	END	##


        $this->render('complete_quote', array(
            'post_values_model' => $post_values_model,
        ));
    }

    public function sendMailWithQuoteSheet($email_format_id, $quote_id) {

        $quote_sheet_pdf_name_array = array();
        $attachment_path = Yii::app()->basePath . '/../uploads/temp/';
        $user_id = Yii::app()->user->id;

        $Criteria = new CDbCriteria();
        $Criteria->condition = "quote_id = " . $quote_id . " && original_record='1'";
        $Criteria->order = 'id desc';
        $jobs = QuoteJobs::model()->findAll($Criteria); // find related buildings by quote id
        if (isset($jobs) && count($jobs) > 0) {
            foreach ($jobs as $job_model) {


                $job_id = $job_model->id;

//Generate QuoteSheet		
// quote model by job id
                $quote_model = Quotes::model()->findByPk($job_model->quote_id);
// echo '<pre>'; print_r($quote_model); echo '</pre>';
// building model
                $building_model = Buildings::model()->findByPk($job_model->building_id);
// echo '<pre>'; print_r($building_model); echo '</pre>';
// site model
                $site_model = ContactsSite::model()->findByPk($quote_model->site_id);
// echo '<pre>'; print_r($site_model); echo '</pre>';
// contact model
                $contact_model = Contact::model()->findByPk($quote_model->contact_id);
// echo '<pre>'; print_r($contact_model); echo '</pre>';
// contact model
                $company_model = Company::model()->findByPk($quote_model->company_id);
// echo '<pre>'; print_r($company_model); echo '</pre>';
// finding service under job
                $Criteria = new CDbCriteria();
                $Criteria->condition = "job_id = " . $job_id;
                $job_services_model = QuoteJobServices::model()->findAll($Criteria);
// echo '<pre>'; print_r($job_services_model); echo '</pre>';		

                $msg = $this->renderPartial('job/job_quote_controller', array(
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



                $footer_text = $this->renderPartial('job/job_quote_controller_footer', array()
                        , true);

                $mpdf->SetHTMLFooter($footer_text);

// $mpdf->showImageErrors = true;

                $quote_sheet_pdf_name = "QuoteSheet-" . $job_model->quote_id . "-" . $job_model->id . "-" . $company_model->name . "-" . $site_model->site_name;
                $quote_sheet_pdf_name = preg_replace('/\s+/', '-', $quote_sheet_pdf_name);
                $quote_sheet_pdf_name = trim(preg_replace('/-+/', '-', $quote_sheet_pdf_name), '-');
                $quote_sheet_pdf_name = $quote_sheet_pdf_name . '.pdf';
                $mpdf->Output($attachment_path . $quote_sheet_pdf_name);
                $quote_sheet_pdf_name_array[] = $quote_sheet_pdf_name;
            }

// echo '<pre>'; print_r($quote_sheet_pdf_name_array); echo '</pre>';							
        }


        if (count($quote_sheet_pdf_name_array) > 0) {
//Sending quote sheet with quote sheet attachments
            EmailFunctionHandle::sendEmail($email_format_id, $quote_id, $user_id, $quote_sheet_pdf_name_array);


// Deleting attachment files
            foreach ($quote_sheet_pdf_name_array as $file) {
                if (!empty($file) && file_exists($attachment_path . $file)) {
                    unlink($attachment_path . $file);
                }
            }
        }
    }

    public function actionAjaxImageUpload() {

        $job_service_id = isset($_POST['job_service_id']) ? $_POST['job_service_id'] : 0;

        $isDataValid = 1;
        if ($job_service_id == 0)
            $isDataValid = 0;

        $path = Yii::app()->basePath . '/../uploads/quote-building-service/';

        $actual_image_name = "";
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST" and $isDataValid) {

            $imagename = $_FILES['photoimg']['name'];
            $size = $_FILES['photoimg']['size'];

            if (strlen($imagename)) {
                $ext = strtolower(CommonFunctions::getExtension($imagename));
                if (in_array($ext, $valid_formats)) {
                    if ($size < (200 * 1024 * 1024)) {
//$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
                        $actual_image_name = $job_service_id . "-" . rand(0, 99999) . "." . $ext;

                        $model = QuoteJobServices::model()->findByPk($job_service_id);

                        /* if(file_exists($path.$actual_image_name))
                          unlink($path.$actual_image_name);
                         */

                        if (isset($model->image) && $model->image != NULL && file_exists($path . $model->image))
                            unlink($path . $model->image);


                        $model->image = $actual_image_name;
						$model->agent_id = $this->agent_id;
                        $model->save();

                        $uploadedfile = $_FILES['photoimg']['tmp_name'];
                        if (move_uploaded_file($uploadedfile, $path . $actual_image_name)) {
//echo "<input type='hidden'  value='".$actual_image_name."' id='actual_image_name' /><br/>";
                            echo "<img  width='100%' src='" . $this->user_role_base_url  . '/uploads/quote-building-service/' . $actual_image_name . "'  class='preview'><br/>";
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

}
