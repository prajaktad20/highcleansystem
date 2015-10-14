<?php

class MemberController extends Controller {

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
            
		
	}


    public function actionRegistration() {
	
		if(isset($_GET['code']) && isset($_GET['service_agent_id']))
		{
		$staff_code = $_GET['code'];
		$agent_id = $_GET['service_agent_id'];
		
		$separate_code = explode("-",$staff_code);
		
		$staff_id = $separate_code[0];
		$staff_auth_key = $separate_code[1];
		$hireStaffModel = HireStaff::model()->findByPk($staff_id);
		
		if($hireStaffModel->auth_key != $staff_auth_key)
		throw new CHttpException(404,'The requested page does not exist.');
		
		if($hireStaffModel->agent_id != $agent_id)
		throw new CHttpException(404,'The requested page does not exist.');
		
		if($hireStaffModel->registered == '1') {
		 echo 'Seems to be, you are already registered.'; exit;
		}
		
		$agent_model=Agents::model()->findByPk($agent_id);
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->email = $hireStaffModel->email;
			$rnd = rand(0,99999);  // generate random number between 0-99999
			$uploadedFile=CUploadedFile::getInstance($model,'Avatar');
			if($uploadedFile) {
                        $fileName = "{$rnd}-{$uploadedFile}"; 
			$model->Avatar = $fileName;
			} else {
			$model->Avatar = "{$rnd}";
			}
			
			$date = date("Y-m-d H:i:s");
			$model->updated_at = $date;
			$model->created_at = $date;
			$model->agent_id = 1; //$this->agent_id;
            $model->role = 3;
			  if ($model->validate()) {
                    		$model->password = md5(trim($_POST['User']['password']));

				if($model->save(false)) {
				
				// update registered value to 1
				$hireStaffModel->registered = '1';
				$hireStaffModel->save();
				
				if(isset($fileName)){
					$save = Yii::app()->basePath.'/../uploads/users-profile-images/'.$fileName;
					$uploadedFile->saveAs($save);
					
					$vimage = new resize($save);
					$vimage->resizeImage(126, 117);
					$save_thumb = Yii::app()->basePath . '/../uploads/users-profile-images/thumbs/' . $model->Avatar;
					$vimage->saveImage($save_thumb);
					}
					$inserted_id = $model->id;
					HireStaffEmail::sendEmailToStaff(16,$inserted_id);
					HireStaffEmail::sendEmailToAgent(17,$inserted_id);
					
					$this->redirect(array('thankyou'));
					
				}
			}
		}
		
        $this->render('member_registration',array(
			'model'=>$model,
			'agent_model'=>$agent_model,
			'hireStaffModel'=>$hireStaffModel,
		));
		
		}
		else
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
    }

	
	public function actionThankyou(){
		$this->render('thankyou');
	}


}
