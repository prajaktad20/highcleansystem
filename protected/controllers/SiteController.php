<?php

class SiteController extends Controller {

    public $layout = '//layouts/column2';
    public $base_url_assets = null;
    public $user_role_base_url = ''; 

    public function init() {
        $this->base_url_assets = CommonFunctions::siteURL(); 
        $this->user_role_base_url = CommonFunctions::getUserBaseUrl('system_owner');
    }

    public function actionJobImages() {

        $id = isset($_GET['jobid']) ? $_GET['jobid'] : 0;
        $qid = isset($_GET['qid']) ? $_GET['qid'] : 0;

        if ($id == 0 || $qid == 0)
            throw new CHttpException(404, 'The requested page does not exist.');


        $model = QuoteJobs::model()->findByPk($id);
		$agent_model = Agents::model()->findByPk($model->agent_id);
		
        if ($model == null)
            throw new CHttpException(404, 'The requested page does not exist.');

        if ($model->quote_id !== $qid)
            throw new CHttpException(404, 'The requested page does not exist.');

        $quote_model = Quotes::model()->findByPk($model->quote_id);

        // before cleaning
        $criteria = new CDbCriteria();
        $criteria->select = "*";
        $criteria->condition = "job_id=" . $id;
        $criteria->order = 'id';
        $job_images = JobImages::model()->findAll($criteria);


        $this->render('job_images_readonly', array(
            'model' => $model,
            'quote_model' => $quote_model,
            'job_images' => $job_images,
			'agent_model' => $agent_model,
        ));
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {

        if (Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->baseUrl . '/?r=site/login');



        if (Yii::app()->user->name == 'admin')
            $this->redirect(Yii::app()->baseUrl . '/?r=Dashboard');


        $this->redirect(Yii::app()->baseUrl . '/?r=site/login');
    }

    
    /**
     * Displays the login page
     */
    public function actionLogin() {

        $this->layout = "login-layout";
        $this->pageTitle = 'High Clean Admin - Login';
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $base = Yii::app()->baseUrl;


                if (Yii::app()->user->profile === 'system_owner') {
                    CommonFunctions::IsAnyInductionDues(Yii::app()->user->id);
                    header("Location: $base?r=Dashboard");
                    exit();
                }

            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->baseUrl . '/?r=site/login');
    }

    public function actionSignoffjob() {

        $unique_code = isset($_REQUEST['code']) ? $_REQUEST['code'] : '';
        $sign_off_report = '';

        if (empty($unique_code))
            throw new CHttpException(404, 'The requested page does not exist.');

        $JobsignoffRequestsModel = JobsignoffRequests::model()->findByAttributes(
                array(
                    'unique_code' => $unique_code
                )
        );

        if ($JobsignoffRequestsModel === null)
            throw new CHttpException(404, 'The requested page does not exist.');


        //echo '<pre>'; print_r($JobsignoffRequestsModel); echo '</pre>'	;

        $id = $JobsignoffRequestsModel->job_id;


        $model = QuoteJobs::model()->findByPk($id);
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
        $Criteria->condition = "job_id = $id";
        $job_services_model = QuoteJobServices::model()->findAll($Criteria);
        unset($Criteria);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id";
        $supervisor = JobSupervisor::model()->findAll($Criteria);
        unset($Criteria);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id";
        $siteSupervisor = JobSiteSupervisor::model()->findAll($Criteria);
        unset($Criteria);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = $id";
        $staffUser = JobStaff::model()->findAll($Criteria);

        if (isset($_POST['QuoteJobs'])) {
            $model->attributes = $_POST['QuoteJobs'];
            $model->agent_signed_off_through = '1';
            $model->signed_off = 'Yes';
            $agent_signature = isset($_POST['output']) ? $_POST['output'] : '';
            $model->agent_signature = $agent_signature;
            $attachment_path = Yii::app()->basePath . '/../uploads/temp/';

            if (empty($model->agent_date) || $model->agent_date == '0000-00-00')
                $model->agent_date = date('Y-m-d');

            if (empty($model->agent_name)) {
                $model->validate();
                $model->addError('agent_name', 'Client name can not be blank');
            } else if ($model->validate()) {

                if ($model->save(false)) {

                    // removing temporary link, which is used to signoff link
                    JobsignoffRequests::model()->deleteAll(array("condition" => "job_id = " . $id));


                    $job_id = $id;

                    $admin_user_id = 0;
                    $supervisor_model = JobSupervisor::model()->findByAttributes(
                            array(
                                'job_id' => $job_id
                            )
                    );

                    if ($supervisor_model === null)
                        throw new CHttpException(404, 'The requested page does not exist.');

                    $supervisor_id = $supervisor_model->user_id;

                    $site_supervisor_model = JobSiteSupervisor::model()->findByAttributes(
                            array(
                                'job_id' => $job_id
                            )
                    );

                    if ($site_supervisor_model === null)
                        throw new CHttpException(404, 'The requested page does not exist.');

                    $site_supervisor_id = $site_supervisor_model->user_id;

// attachment
                    //creating signature png on pdf if client sign sign exists
                    if (!empty($job_model->agent_signature)) {
                        $valid_json = CommonFunctions::isJson($job_model->agent_signature);
                        if ($valid_json == 1) {
                            $save = Yii::app()->basePath . '/../uploads/temp/' . $id . '.png';
                            $im = CommonFunctions::sigJsonToImage($job_model->agent_signature);
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


                    EmailJobStatusFunction::sendEmail(11, $job_id, $admin_user_id, $supervisor_id, $site_supervisor_id, $sign_off_report);
                    Yii::app()->request->redirect(Yii::app()->getBaseUrl(true) . '/?r=site/SignOffThankyou');
                }
            }
        }

        $this->render('email_sign_off_job', array(
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
            'model' => $model
        ));
    }

    public function actionSignOffThankyou() {
        $this->render('signoff_thankyou');
    }

    public function actionError() {
        $this->render('error');
    }





// reset password functinality

public function actionReset() {
        $model = new PasswordResetRequestForm;
        $msg = null;
        if (isset($_POST['PasswordResetRequestForm'])) {
            $model->attributes = $_POST['PasswordResetRequestForm'];
            if ($model->validate()) {
                $email = $_POST['PasswordResetRequestForm']['email'];
                $data_Model = SystemOwner::model()->findByAttributes(array(), $condition = 'email = :email AND status = :status', $params = array(':email' => $email, ':status' => '1')
                );
                if ($data_Model === NULL) {
                    $model->addError('email', 'No account found with this email address.');
                } else {
                    //send link in a mail to reset a link
                    $msg = 1;
                    //echo '<pre>'; print_r($data_Model); echo '</pre>';
                    $user_id = $data_Model->id;
                    SoEmailResetPwd::sendEmail(12, $user_id);
                }
            }
        }
        $this->render('reset', array(
            'model' => $model,
            'msg' => $msg,
        ));
    }

    public function actionResetaccount() {

        $code = isset($_REQUEST['code']) ? trim($_REQUEST['code']) : '';

        if (empty($code))
            throw new CHttpException(404, 'The requested page does not exist.');

        $code_part = explode('-', $code);

        if (!is_array($code_part)) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }



        if (is_array($code_part) && count($code_part) == 2) {


            $model = new PasswordResetAccountForm;
            $id = $code_part[0];
            $password = $code_part[1];

            $user_model_data = SystemOwner::model()->findByAttributes(array(), $condition = 'id = :id AND password=:password AND status = :status', $params = array(':id' => $id, 'password' => $password, ':status' => '1'));
	//print_r($user_model_data);exit;
            if ($user_model_data === NULL) {
                throw new CHttpException(404, 'The requested page does not exist.');
            } else {

                if (isset($_POST['PasswordResetAccountForm'])) {
                    $model->attributes = $_POST['PasswordResetAccountForm'];
                    if ($model->validate()) {

                        $user_model_data->password = trim(md5($_POST['PasswordResetAccountForm']['password']));

                        if ($user_model_data->save()) {

                            /// mail code
                            $this->redirect(Yii::app()->baseUrl . '/?r=site/ForgotThankyou&reset=1');
                            // header("Location: ".Yii::app()->getBaseUrl(true)."?r=site/login&reset=1");
                            EXIT();
                        }
                    }
                }
            }
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        $this->render('resetaccount', array(
            'model' => $model,
        ));
    }

    public function actionForgotThankyou() {
        $this->render('forgot_thankyou');
    }





}
