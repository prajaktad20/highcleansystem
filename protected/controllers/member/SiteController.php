<?php

class SiteController extends Controller {

    public $layout = '//layouts/column2';
    public $base_url_assets = null;
    public $user_role_base_url = ''; 

    public function init() {
        $this->base_url_assets = CommonFunctions::siteURL(); 
        $this->user_role_base_url = CommonFunctions::getUserBaseUrl('supervisor');
    }

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
            
		if(Yii::app()->user->isGuest)
                    $this->redirect(Yii::app()->baseUrl.'/member?r=site/login');



                 if(Yii::app()->user->name =='agent'  )
                             $this->redirect(Yii::app()->baseUrl.'/member?r=MemberDashboard');


                 $this->redirect(Yii::app()->baseUrl.'/member?r=site/login');

            
		
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
                $error = Yii::app()->errorHandler->error;

             
                 if (Yii::app()->errorHandler->error['code'] == 403){
                    $base = Yii::app()->baseUrl;
		    header("Location: $base");
		    exit();

                 }
                 
                 if (Yii::app()->errorHandler->error['code'] == 404){
                    $base = Yii::app()->baseUrl;
		    header("Location: $base");
		    exit();

                     }


	}



	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{	
		
		$Criteria = new CDbCriteria();
		$Criteria->condition = "status ='1'";
		$Criteria->order = "business_name";
		$agent_model = Agents::model()->findAll($Criteria);

		$agent_list = array();
		foreach($agent_model as $client) {
			$agent_list[$client->id] = $client->business_name;
		}
		$this->layout="login-layout";
		 
		$model=new MemberLoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['MemberLoginForm']))
		{  
			$model->attributes=$_POST['MemberLoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
                            	$base = Yii::app()->baseUrl;
			
				header("Location: $base/member?r=MemberDashboard");
				exit();
			
                              
                                     
                                     }
		}
		// display the login form
		$this->render('login',array('model'=>$model,'agent_list' => $agent_list));
	}

	


	/**
	 * Logs out the current user and redirect to homepage.
	 */
	 
	public function actionLogout()
	{
              Yii::app()->user->logout();
              $this->redirect(Yii::app()->baseUrl.'/member');
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
                    MemberEmailResetPwd::sendEmail(12, $user_id);
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

            $user_model_data = User::model()->findByAttributes(array(), $condition = 'id = :id AND password=:password AND status = :status', $params = array(':id' => $id, 'password' => $password, ':status' => '1'));
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
                            $this->redirect(Yii::app()->baseUrl . '/member?r=site/ForgotThankyou&reset=1');
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
