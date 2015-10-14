<?php

class DefaultController extends Controller
{

 public $base_url_assets = null;
 public $layout='//layouts/column1';
 public $user_role_base_url = ''; public $user_dashboard_url = '';
 public $agent_id = '';
 public $where_agent_condition = '';
 public $agent_info = null;
 	public function init() {
		$this->base_url_assets = CommonFunctions::siteURL();         
                $this->user_role_base_url = CommonFunctions::getUserBaseUrl(Yii::app()->user->name);
		$this->user_dashboard_url = CommonFunctions::getUserDashboardUrl(Yii::app()->user->name);
                $this->agent_id = CommonFunctions::getCurrentpageAgentId(Yii::app()->user->name);
                $this->where_agent_condition = " agent_id = ".$this->agent_id ;
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
				'actions'=>array('index','view','create','update','admin','delete'),
				'users' => array('system_owner', 'state_manager', 'operation_manager', 'agent', 'supervisor'),
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
	public function actionView($id)	{
            
               $model = $this->loadModel($id);
               CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id); 
                
		$this->render('view',array(
			'model'=> $model,
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
		$dataProvider=new CActiveDataProvider('TimesheetPayDates');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		

		$TimesheetPayDates_model=new TimesheetPayDates;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($TimesheetPayDates_model);

		$connection = Yii::app()->db;
		$query = "SELECT MAX(pay_date) as last_pay_date from hc_timesheet_pay_dates where $this->where_agent_condition";
		$result = $connection->createCommand($query)->queryRow();
                //echo '<pre>'; print_r($result); echo '</pre>';exit;
		
		$next_pay_date = date('Y-m-d', strtotime($result['last_pay_date'].' +14 days'));
		$next_date['pay_date'] = $next_pay_date;
		$next_date['payment_start_date'] = $result['last_pay_date'];
		$next_date['payment_end_date'] = date('Y-m-d', strtotime($next_pay_date.' -1 days'));
		//echo '<pre>'; print_r($next_date); echo '</pre>';
		
		if(isset($_POST['TimesheetPayDates']))		{
                    
			$TimesheetPayDates_model->attributes=$_POST['TimesheetPayDates'];
            $TimesheetPayDates_model->agent_id = $this->agent_id;
			if($TimesheetPayDates_model->save()) {
					Yii::app()->user->setFlash('success', "Successfully added next pay date.");
					$this->refresh();
			}
				
		}




		$model=new TimesheetPayDates('search');
		$model->unsetAttributes();  // clear any default values
                $model->agent_id = $this->agent_id;
		if(isset($_GET['TimesheetPayDates']))
			$model->attributes=$_GET['TimesheetPayDates'];

		$this->render('admin',array(
			'model'=>$model,
			'TimesheetPayDates_model' => $TimesheetPayDates_model,
			'next_date'=>$next_date,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TimesheetPayDates the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TimesheetPayDates::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TimesheetPayDates $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='timesheet-pay-dates-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
