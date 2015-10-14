<?php

class PersonalController extends Controller {
	
	public $layout='//layouts/column1';
	public $base_url_assets = null;
        public $user_role_base_url = ''; public $user_dashboard_url = '';
        public $user_id = 0;

        public function init() {
        
        $current_user_id = isset(Yii::app()->user->id) ? Yii::app()->user->id : 0;
        $this->user_id = $current_user_id;

            if($this->user_id === 0)
                    throw new CHttpException(404,'The requested page does not exist.');	

		$this->base_url_assets = CommonFunctions::siteURL();         
		$this->user_role_base_url = CommonFunctions::getUserBaseUrl(Yii::app()->user->name);
		$this->user_dashboard_url = CommonFunctions::getUserDashboardUrl(Yii::app()->user->name);

	}

	/**
	* @return array action filters
	*/
	public function filters()
	{
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
	public function accessRules()
	{
	return array(
	array('allow', // allow admin user to perform 'admin' and 'delete' actions
	'actions'=>array('MyPersonalDetails','ChangeMyPassword','MyProfileUpdate','LogoutAgentPanel'),
	'users'=>array('system_owner'),
	),
	array('deny',  // deny all users
	'users'=>array('*'),
	),
	);
	}


	public function actionLogoutAgentPanel() {
		Yii::app()->user->setState('agent_id','');
		Yii::app()->request->redirect($this->user_dashboard_url);
	}

	public function actionMyPersonalDetails() {
		$model = $this->loadModel($this->user_id);
		$this->render('my_personal_deails_view',array(
		'model' => $model
		));
	}

	public function actionChangeMyPassword() {
		
		$model = new ChangePasswordForm;
		
		if(isset($_POST['ChangePasswordForm']))
		{
			$model->attributes=$_POST['ChangePasswordForm'];	
			
			if ($model->validate()) {
				$user_model=$this->loadModel($this->user_id);
				$user_model->password = md5(trim($model->password));

					if($user_model->save())
						Yii::app()->user->setFlash('success', "Password changed successfully!");
						$this->refresh();
					}	
			}

		$this->render('change_password',array(
			'model'=>$model,
		)); 
	}

	public function actionMyProfileUpdate() {
		
		$model = $this->loadModel($this->user_id);
		
		if(isset($_POST['SystemOwner']))
		{
					$model->attributes=$_POST['SystemOwner'];						
								
					
					if($model->save()) {
                                        
                                            	Yii::app()->user->setFlash('success', "Profile updated successfully!");
						$this->refresh();
					}	
					
		}			
				
				$this->render('my_personal_deails_edit',array(
				'model' => $model
				));		
	}
		
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Agent the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=  SystemOwner::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


}
