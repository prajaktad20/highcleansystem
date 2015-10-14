<?php

class DefaultController extends Controller
{
	public $layout='//layouts/column1';
	public $base_url_assets = null;
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
	'actions'=>array('index','view','create','update','admin','delete','BuildingDocuments'),
	'users'=>array('system_owner', 'state_manager', 'operation_manager', 'agent'),
	),
	array('deny',  // deny all users
	'users'=>array('*'),
	),
	);
	}

	public function actionBuildingDocuments($id) {

	$model = $this->loadModel($id);
	CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/blueimp-gallery.min.css');
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.blueimp-gallery.min.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-image-gallery.min.js', CClientScript::POS_END);



	// building photos
	$criteria = new CDbCriteria();
	$criteria->select = "id,photo";
	$criteria->condition = "building_id=".$id;
	$criteria->order = 'id desc';
	$building_images = BuildingImages::model()->findAll($criteria);

	// building documents
	$criteria = new CDbCriteria();
	$criteria->select = "id,doc";
	$criteria->condition = "building_id=".$id;
	$criteria->order = 'id';
	$building_documents = BuildingDocuments::model()->findAll($criteria);

	/* echo '<pre>';
	print_r($_FILES);
	echo '</pre>'; */

	if( isset($_POST['yt0']) && $_POST['yt0'] == 'Save Building Documents' ) {		
	// uploading multiple building documents
	if (isset($_FILES["documents"]["tmp_name"]) && count($_FILES["documents"]["tmp_name"]) > 0) {

	foreach ($_FILES["documents"]["tmp_name"] as $tmp_name_key => $tmp_name_value) {


	if (isset($_FILES["documents"]["tmp_name"][$tmp_name_key]) && $_FILES["documents"]["tmp_name"][$tmp_name_key] != "") {

	$source = $_FILES["documents"]["tmp_name"][$tmp_name_key];                                    
	$destination_path = Yii::app()->basePath.'/../uploads/building_documents/';										
	$filename = date("dmYHms") . "_" . $_FILES["documents"]["name"][$tmp_name_key];
	if (move_uploaded_file($source, $destination_path.$filename)) {

	$building_id = $id;
	$building_doc_model = new BuildingDocuments;
	$building_doc_model->building_id = $building_id;
	$building_doc_model->doc = $filename;
	$building_doc_model->date_added = date("Y-m-d");
	$building_doc_model->agent_id = $this->agent_id;
	$building_doc_model->save();



	}

	}			

	}

	//Yii::app()->request->redirect(Yii::app()->getBaseUrl(true) . '/?r=Buildings/default/BuildingDocuments&id='.$id);
	$this->refresh();
	}
	} 


	if( isset($_POST['yt1']) && $_POST['yt1'] == 'Save Building Photos' ) {		
	// uploading multiple building images
	if (isset($_FILES["images"]["tmp_name"]) && count($_FILES["images"]["tmp_name"]) > 0) {

	foreach ($_FILES["images"]["tmp_name"] as $tmp_name_key => $tmp_name_value) {


	if (isset($_FILES["images"]["tmp_name"][$tmp_name_key]) && $_FILES["images"]["tmp_name"][$tmp_name_key] != "") {

	$source = $_FILES["images"]["tmp_name"][$tmp_name_key];                                    
	$destination_path = Yii::app()->basePath.'/../uploads/building_images/';
	$destination_thumbs_path = Yii::app()->basePath.'/../uploads/building_images/thumbs/';
	$filename = date("dmYHms") . "_" . $_FILES["images"]["name"][$tmp_name_key];
	if (move_uploaded_file($source, $destination_path.$filename)) {

	//create thumb
	$vimage = new resize($destination_path.$filename);
	//$vimage->resizeImage(300, 225);
	$vimage->resizeImage(150, 100);
	$vimage->saveImage($destination_thumbs_path.$filename);

	$building_id = $id;
	$builiding_image_model = new BuildingImages;
	$builiding_image_model->building_id = $building_id;
	$builiding_image_model->photo = $filename;
	$builiding_image_model->date_added = date("Y-m-d");
	$builiding_image_model->agent_id = $this->agent_id;
	$builiding_image_model->save();


	}

	}			

	}
	//Yii::app()->request->redirect(Yii::app()->getBaseUrl(true) . '/?r=Buildings/default/BuildingDocuments&id='.$id);
	$this->refresh();
	}
	}



	$this->render('building_documents',array(
	'model'=>$model,
	'building_images'=>$building_images,
	'building_documents'=>$building_documents,
	));

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
	$model=new Buildings;
	$model->agent_id = $this->agent_id;
	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if(isset($_POST['Buildings']))
	{
	$model->attributes=$_POST['Buildings'];
	$date = date("Y-m-d H:i:s");
	$model->updated_at = $date;
	$model->created_at = $date;
	
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
	CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if(isset($_POST['Buildings']))
	{
	$model->attributes=$_POST['Buildings'];
	$date = date("Y-m-d H:i:s");
	$model->updated_at = $date;


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
	$model = $this->loadModel($id);
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
	$dataProvider=new CActiveDataProvider('Buildings');
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
		
	$model=new Buildings('search');
	$model->unsetAttributes();  // clear any default values
	if(isset($_GET['Buildings']))
	$model->attributes=$_GET['Buildings'];

	$this->render('admin',array(
	'model'=>$model,
	));
	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer $id the ID of the model to be loaded
	* @return Buildings the loaded model
	* @throws CHttpException
	*/
	public function loadModel($id)
	{
	$model=Buildings::model()->findByPk($id);
	if($model===null)
	throw new CHttpException(404,'The requested page does not exist.');
	return $model;
	}

	/**
	* Performs the AJAX validation.
	* @param Buildings $model the model to be validated
	*/
	protected function performAjaxValidation($model)
	{
	if(isset($_POST['ajax']) && $_POST['ajax']==='buildings-form')
	{
	echo CActiveForm::validate($model);
	Yii::app()->end();
	}
	}
}
