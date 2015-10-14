<?php

class DefaultController extends Controller
{

 public $base_url_assets = null;
 public $layout='//layouts/column1';
public $user_role_base_url = ''; public $user_dashboard_url = '';

 	public function init() {
		$this->base_url_assets = CommonFunctions::siteURL();         $this->user_role_base_url = CommonFunctions::getUserBaseUrl(Yii::app()->user->name);
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
				'actions'=>array('FindSwmsTask','index','view','create','update','admin','delete'),
				'users' => array('system_owner', 'state_manager', 'operation_manager', 'agent', 'supervisor'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionFindSwmsTask() {
	
	     $swms_id = $_POST['swms_id'];

        $criteria = new CDbCriteria();
        $criteria->select = "id,task,task_sort_order";
        $criteria->condition = "swms_id =:swms_id";
        $criteria->params = array(':swms_id' => $swms_id);
        $criteria->order = 'task_sort_order';
        $loop_options = SwmsTask::model()->findAll($criteria);

        $options = '';
        $options .= '<option value="">--Please select Task--</option>';

        foreach ($loop_options as $value) {
            $options .= '<option value="' . $value->id . '">'. $value->task.' ('.$value->task_sort_order.')</option>';
        }
        echo $options;
        exit;
		
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
		$model=new SwmsHzrdsConsqs;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SwmsHzrdsConsqs']))
		{
			$model->attributes=$_POST['SwmsHzrdsConsqs'];
			if($model->save())
				$this->redirect(array('admin'));
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

		if(isset($_POST['SwmsHzrdsConsqs']))
		{
			$model->attributes=$_POST['SwmsHzrdsConsqs'];
			if($model->save())
				$this->redirect(array('admin'));
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
		$dataProvider=new CActiveDataProvider('SwmsHzrdsConsqs');
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
		
		$model=new SwmsHzrdsConsqs('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SwmsHzrdsConsqs']))
			$model->attributes=$_GET['SwmsHzrdsConsqs'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SwmsHzrdsConsqs the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SwmsHzrdsConsqs::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SwmsHzrdsConsqs $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='swms-hzrds-consqs-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
