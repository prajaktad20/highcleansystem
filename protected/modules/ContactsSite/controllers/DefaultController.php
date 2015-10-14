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
				'actions'=>array('index','view','create','update','admin','delete','changecontact','viewbuildings','addbuilding'),
				'users'=>array('system_owner', 'state_manager', 'operation_manager', 'agent'),
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
		$model = $this->loadModel($id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	 
	public function actionViewBuildings($site_id)
	{
		// CgridView Records/page section
		if ( isset( $_GET[ 'pageSize' ] ) )
		{
			Yii::app()->user->setState( 'pageSize', (int) $_GET[ 'pageSize' ] );
			unset( $_GET[ 'pageSize' ] );
		}
		
		$model = $this->loadModel($site_id);
        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
		$buildings_model=new Buildings('search');
		$buildings_model->unsetAttributes();  // clear any default values
		if(isset($_GET['Buildings']))
			$buildings_model->attributes=$_GET['Buildings'];

		$this->render('view_buildings',array(
			'model'=>$this->loadModel($site_id), // Site Model
			'buildings_model'=>$buildings_model, // Site Model
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ContactsSite;
		$contact_ids_error_msg = '';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ContactsSite']))
		{
			$model->attributes=$_POST['ContactsSite'];
			$date = date("Y-m-d H:i:s");
			$model->updated_at = $date;
			$model->created_at = $date;
			$model->agent_id = $this->agent_id;
			
			if($_POST['ContactsSite']['need_induction'] == '0')
			$model->induction_company_id = 0;
		
			$contact_ids = isset($_POST['contact_ids']) ? $_POST['contact_ids'] : 0;
			
			if($model->validate() && $contact_ids > 0) {
			
			if($model->save()) {
			
						//keeping relation between site and contact
						$Model_SiteContactRelation = new SiteContactRelation;
						$Model_SiteContactRelation->site_id = $model->id;
						$Model_SiteContactRelation->contact_id = $contact_ids;
						$Model_SiteContactRelation->agent_id = $this->agent_id;
						$Model_SiteContactRelation->save();
					
				
					$this->redirect(array('admin'));
				}
			}	
		}

		$this->render('create',array(
			'model'=>$model,
			'contact_ids_error_msg' => $contact_ids_error_msg,
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
		$contact_ids_error_msg = '';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
/* 
		$Criteria = new CDbCriteria();
		$Criteria->condition = "site_id = "$model->id;
		$last_selected_contact_ids_model = SiteContactRelation::model()->findAll($Criteria); // find related buildings by quote id
		foreach($last_selected_contact_ids_model as $Row) {
		$last_selected_contact_ids[] = $Row->contact_id;
		}
		 */
		$siteContact_model = SiteContactRelation::model()->findByAttributes(array('site_id' =>$model->id));
		$last_selected_contact_id =  $siteContact_model->contact_id;
		
		if(isset($_POST['ContactsSite']))
		{
			$model->attributes=$_POST['ContactsSite'];
			$date = date("Y-m-d H:i:s");
			$model->updated_at = $date;
			
			if($_POST['ContactsSite']['need_induction'] == '0')
			$model->induction_company_id = 0;
		
			$contact_ids = isset($_POST['contact_ids']) ? $_POST['contact_ids'] : 0;
			
					if($model->validate() && $contact_ids > 0) {
						if($model->save()) {
						//delete previous contact references
						SiteContactRelation::model()->deleteAll(array("condition" => "site_id=".(int)$model->id));				
					
						//keeping relation between site and contact
						$Model_SiteContactRelation = new SiteContactRelation;
						$Model_SiteContactRelation->site_id = $model->id;
						$Model_SiteContactRelation->contact_id = $contact_ids;
						$Model_SiteContactRelation->save();
					
				
					$this->redirect(array('admin'));
					}
				}	
		}

		$this->render('update',array(
			'model'=>$model,
			'contact_ids_error_msg' => $contact_ids_error_msg,
			'last_selected_contact_id' => $last_selected_contact_id,
		));
	}

	
	
	
		/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAddBuilding($site_id)
	{
		$model=$this->loadModel($site_id); // site model
		CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
		
		$buildings_model=new Buildings; // buildings_model

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Buildings']))
		{
			$buildings_model->attributes=$_POST['Buildings'];
			$buildings_model->site_id = $model->id;
			$date = date("Y-m-d H:i:s");
			$buildings_model->updated_at = $date;
			$buildings_model->created_at = $date;
			$buildings_model->agent_id = $this->agent_id;
			if($buildings_model->save())
				$this->redirect(array('admin'));
		}

		$this->render('add_buildings',array(
			'model'=>$model,
			'buildings_model'=>$buildings_model,
		));
	}

	
	
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionChangeContact($id)
	{
		$model=$this->loadModel($id);

		$contact_ids_error_msg = '';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// to make checked last selected contacts
		$last_selected_contact_ids = array();
		$Criteria = new CDbCriteria();
		$Criteria->condition = "site_id = $model->id";
		$last_selected_contact_ids_model = SiteContactRelation::model()->findAll($Criteria); // find related buildings by quote id
		foreach($last_selected_contact_ids_model as $Row) {
		$last_selected_contact_ids[] = $Row->contact_id;
		}
		
		
		if(isset($_POST['contact_ids']))
		{
			
			$date = date("Y-m-d H:i:s");
			$model->updated_at = $date;
			$model->agent_id = $this->agent_id;
			
			$contact_ids = isset($_POST['contact_ids']) ? $_POST['contact_ids'] : array();
			if(count($contact_ids) == 0) {
			$contact_ids_error_msg = "<div class='errorMessage'>Please select at least one contact.</div>";
			}
			if($model->validate() && count($contact_ids) > 0) {
			
			if($model->save()) {
			//delete previous contact references
			SiteContactRelation::model()->deleteAll(array("condition" => "site_id=".(int)$model->id));				
			
				foreach($contact_ids as $value) {
					$Model_SiteContactRelation = new SiteContactRelation;
					$Model_SiteContactRelation->site_id = $model->id;
					$Model_SiteContactRelation->contact_id = $value;
					$Model_SiteContactRelation->agent_id = $this->agent_id;
					$Model_SiteContactRelation->save();
				
				}
				$this->redirect(array('admin'));
				}
			}	
		}

		$this->render('change_contact',array(
			'model'=>$model,
			'contact_ids_error_msg' => $contact_ids_error_msg,
			'last_selected_contact_ids' => $last_selected_contact_ids,
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
		
		// $id means site table auto increment id
		// find all building ids of releated this site.		
		$building_under_site = Buildings::model()->findAllByAttributes(array('site_id' => $id));
		
		foreach($building_under_site as $building_row) {		
		// deleted buidling related quotes
	 	Quotes::model()->deleteAll(array("condition" => "building_id=".(int)$building_row->id));		
		}
		
		// delete all buildings 
		Buildings::model()->deleteAll(array("condition" => "site_id=".(int)$id));		
		CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
		//delete site
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
		$dataProvider=new CActiveDataProvider('ContactsSite');
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
		
		$model=new ContactsSite('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ContactsSite']))
			$model->attributes=$_GET['ContactsSite'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ContactsSite the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ContactsSite::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ContactsSite $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contacts-site-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
