<?php

class DefaultController extends Controller
{
	
	public $base_url_assets = null;
	public $layout='//layouts/column1';
	public $user_id = 0;
	public $IsUsingDevice = 0;
	public $user_role_base_url = ''; 
	public $user_dashboard_url = '';
	public $agent_id = '';
	public $agent_info = null;

 public function init() {
		
		$current_user_id = isset(Yii::app()->user->id) ? Yii::app()->user->id : 0;
		$this->user_id = $current_user_id;
		
		if($this->user_id === 0)
			throw new CHttpException(404,'The requested page does not exist.');		
		
		$this->base_url_assets = CommonFunctions::siteURL();         
		$this->user_role_base_url = CommonFunctions::getUserBaseUrl(Yii::app()->user->name);
		$this->user_dashboard_url = CommonFunctions::getUserDashboardUrl(Yii::app()->user->name);
		$this->IsUsingDevice = CommonFunctions::IsUsingDevice();
        $this->agent_id = CommonFunctions::getCurrentpageAgentId(Yii::app()->user->name);
		$this->agent_info = CommonFunctions::getAgentInfo($this->agent_id);
                
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
				'actions'=>array('admin','delete','create','update','index','view','Notify_user'),
				'users' => array('system_owner', 'state_manager', 'operation_manager', 'agent', 'supervisor','site_supervisor','staff'),
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
		$model=$this->loadModel($id);
		CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
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
		$model=new HireStaff;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['HireStaff']))
		{
			$model->attributes = $_POST['HireStaff'];
			
			$send_email = isset($_POST['send_email'])? $_POST['send_email'] : '0';
			if($send_email == '1'){
			
				$model->email_sent =  date("Y-m-d H:i:s");
				$model->sent_email_count = 1;
				HireStaffEmail::sendEmail(15,$model->id);
			}
			
			$model->auth_key = CommonFunctions::random_string(32);
			$model->agent_id = $this->agent_id;
			$model->created_at = date("Y-m-d H:i:s");
			
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
		$model = $this->loadModel($id);
		CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['HireStaff']))
		{
			$model->attributes=$_POST['HireStaff'];
			
			$send_email = isset($_POST['send_email'])? $_POST['send_email'] : '0';
			if($send_email == '1'){
			
				$model->email_sent =  date("Y-m-d H:i:s");
				$model->sent_email_count = $model->sent_email_count + 1;
				HireStaffEmail::sendEmail(15,$model->id);
			}
			
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
		$model=$this->loadModel($id);
		CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('HireStaff');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		// CgridView Records/page section
		if ( isset( $_GET[ 'pageSize' ] ) )
		{
			Yii::app()->user->setState( 'pageSize', (int) $_GET[ 'pageSize' ] );
			unset( $_GET[ 'pageSize' ] );
		}
		
		$model=new HireStaff('search');
		$model->unsetAttributes();  // clear any default values
		$model->agent_id = $this->agent_id;
		if(isset($_GET['HireStaff']))
			$model->attributes=$_GET['HireStaff'];
			
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionNotify_user($id)
	{
		$model = $this->loadModel($id);
		HireStaffEmail::sendEmail(15,$model->id);
		return true;
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return HireStaff the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=HireStaff::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param HireStaff $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='hire-staff-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
