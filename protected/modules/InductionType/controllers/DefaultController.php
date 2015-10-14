<?php

class DefaultController extends Controller
{

	
	public $layout='//layouts/column1';
	public $base_url_assets = null;
        public $user_role_base_url = ''; 
        public $user_dashboard_url = '';

        public function init() {
         
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
				'actions'=>array('getInductionType','updateInductionType','addNewInductionType','index','view','create','update','admin','delete'),
				'users'=>array('system_owner', 'state_manager', 'operation_manager', 'agent','supervisor','site_supervisor','staff'),
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

	public function actionAddNewInductionType() {
		$InductionTypeName = isset($_POST['InductionTypeName']) ? $_POST['InductionTypeName'] : '';
		
		if(empty($InductionTypeName))
			throw new CHttpException(404,'The requested page does not exist.');
		
		$model = InductionType::model()->findByAttributes(array('name'=>$InductionTypeName));
		if(isset($model->id) && $model->id > 0) {
			echo 'already_exist'; exit;
		}
		
		$model=new InductionType;
		$model->name = $InductionTypeName;
		$model->save();
			
	}
	
	
	public function actionGetInductionType() {
			$id = isset($_GET['id']) ? $_GET['id'] : 0;
			$model=$this->loadModel($id);
			$this->renderPartial('induction_type_update',array('model'=>$model));
	}
		
	public function actionUpdateInductionType() {
		
			$id = isset($_POST['induction_type_id']) ? $_POST['induction_type_id'] : 0;
			$InductionTypeName = isset($_POST['edit_InductionTypeName']) ? $_POST['edit_InductionTypeName'] : '';
			
			if(empty($InductionTypeName) || $id == 0)
				throw new CHttpException(404,'The requested page does not exist.');
			
			$Criteria = new CDbCriteria();
			$Criteria->condition = "name = '$InductionTypeName' && id!=".$id;
			$existModel = InductionType::model()->find($Criteria); 
			
			if($existModel !== NULL) {
				echo 'already_exist'; exit;
			}
			
			$model=$this->loadModel($id);
			$model->name = $InductionTypeName;
			$model->save();
			
	}
	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new InductionType;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['InductionType']))
		{
			$model->attributes=$_POST['InductionType'];
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

		if(isset($_POST['InductionType']))
		{
			$model->attributes=$_POST['InductionType'];
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
		$dataProvider=new CActiveDataProvider('InductionType');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
	
		$model=new InductionType('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['InductionType']))
			$model->attributes=$_GET['InductionType'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return InductionType the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=InductionType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param InductionType $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='licences-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
