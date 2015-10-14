<?php

class DefaultController extends Controller
{
	
	public $layout='//layouts/column1';
	public $base_url_assets = null;
        public $user_role_base_url = ''; public $user_dashboard_url = '';
	public $user_id = 0;
	public function init() {

		$current_user_id = isset(Yii::app()->user->id) ? Yii::app()->user->id : 0;
		$this->user_id = $current_user_id;
		
		if($this->user_id === 0)
			throw new CHttpException(404,'The requested page does not exist.');		
		
		
		if(Yii::app()->user->name === 'staff') {
			$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
			
			
			if($id > 0) {
				if($this->user_id != $id)
					throw new CHttpException(404,'The requested page does not exist.');
			}
		}

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
	'actions'=>array('index','view','create','update','admin','delete','MyPersonalDetails','MyProfileUpdate','ChangeMyPassword'),
	'users'=>array('system_owner'),
	),
	array('deny',  // deny all users
	'users'=>array('*'),
	),
	);
	}



	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new SystemOwner;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SystemOwner']))
		{
			$model->attributes=$_POST['SystemOwner'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SystemOwner']))
		{
			$model->attributes=$_POST['SystemOwner'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SystemOwner');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
	
		$model=new SystemOwner('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SystemOwner']))
			$model->attributes=$_GET['SystemOwner'];

		$this->render('admin',array(
			'model'=>$model,
		));
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
						Yii::app()->user->setFlash('success', "Password changed successfully!");
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
	 * @return SystemOwner the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SystemOwner::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SystemOwner $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='system-owner-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
