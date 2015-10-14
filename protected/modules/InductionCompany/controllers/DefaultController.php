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
				'actions'=>array('getInductionCompany','updateInductionCompany','addNewInductionCompany','index','view','create','update','admin','delete'),
				'users'=>array('system_owner', 'state_manager', 'operation_manager'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionAddNewInductionCompany() {
		$InductionCompanyName = isset($_POST['InductionCompanyName']) ? $_POST['InductionCompanyName'] : '';
		$single_induction = isset($_POST['single_induction']) ? $_POST['single_induction'] : '0';
		
		if(empty($InductionCompanyName))
			throw new CHttpException(404,'The requested page does not exist.');
		
		$model = InductionCompany::model()->findByAttributes(array('name'=>$InductionCompanyName));
		if(isset($model->id) && $model->id > 0) {
			echo 'already_exist'; exit;
		}
		
		$model=new InductionCompany;
		$model->name = $InductionCompanyName;
		$model->single_induction = $single_induction;
		$model->save();
			
	}
	
	
	public function actionGetInductionCompany() {
			$id = isset($_GET['id']) ? $_GET['id'] : 0;
			$model=$this->loadModel($id);
			$this->renderPartial('induction_company_update',array('model'=>$model));
	}
		
	public function actionUpdateInductionCompany() {
		
			$id = isset($_POST['induction_company_id']) ? $_POST['induction_company_id'] : 0;
			$InductionCompanyName = isset($_POST['edit_InductionCompanyName']) ? $_POST['edit_InductionCompanyName'] : '';
			$single_induction = isset($_POST['edit_single_induction']) ? $_POST['edit_single_induction'] : '0';
			
			if(empty($InductionCompanyName) || $id == 0)
				throw new CHttpException(404,'The requested page does not exist.');
			
			$Criteria = new CDbCriteria();
			$Criteria->condition = "name = '$InductionCompanyName' && id!=".$id;
			$existModel = InductionCompany::model()->find($Criteria); 
			
			if($existModel !== NULL) {
				echo 'already_exist'; exit;
			}
			
			
			$model=$this->loadModel($id);
			$model->name = $InductionCompanyName;
			$model->single_induction = $single_induction;
			$model->save();
			
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
		$model=new InductionCompany;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['InductionCompany']))
		{
			$model->attributes=$_POST['InductionCompany'];
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

		if(isset($_POST['InductionCompany']))
		{
			$model->attributes=$_POST['InductionCompany'];
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
		$dataProvider=new CActiveDataProvider('InductionCompany');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		
		$model=new InductionCompany('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['InductionCompany']))
			$model->attributes=$_GET['InductionCompany'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return InductionCompany the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=InductionCompany::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param InductionCompany $model the model to be validated
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
