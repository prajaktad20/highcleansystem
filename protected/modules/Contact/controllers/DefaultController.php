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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','admin','delete','viewsites','addsite'),
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
	public function actionViewSites($contact_id)
	{
		// CgridView Records/page section
		if ( isset( $_GET[ 'pageSize' ] ) )
		{
			Yii::app()->user->setState( 'pageSize', (int) $_GET[ 'pageSize' ] );
			unset( $_GET[ 'pageSize' ] );
		}
		// site model
		$model = $this->loadModel($contact_id);
		CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
		$sites_model=new ContactsSite('search');
		$sites_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ContactsSite']))
			$sites_model->attributes=$_GET['ContactsSite'];

		
		$this->render('view_sites',array(
			'model'=>$this->loadModel($contact_id), // Contact Model
			'sites_model' => $sites_model
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAddSite($contact_id)
	{
		$model=$this->loadModel($contact_id); // contact model
		CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
		$site_model=new ContactsSite; // site model

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ContactsSite']))
		{
			$site_model->attributes=$_POST['ContactsSite'];
			//$site_model->contact_id = $model->id;
			$date = date("Y-m-d H:i:s");
			$site_model->updated_at = $date;
			$model->created_at = $date;
			
			if($site_model->validate()) {
			$site_model->agent_id = $this->agent_id;
				if($site_model->save()) {
						
						// add entry for site contact relation
						$Model_SiteContactRelation = new SiteContactRelation;
						$Model_SiteContactRelation->site_id = $site_model->id;
						$Model_SiteContactRelation->contact_id = $model->id;
						$Model_SiteContactRelation->agent_id = $this->agent_id;
						$Model_SiteContactRelation->save();
					
					$this->redirect(array('admin'));
				}
			}
		}

		$this->render('add_site',array(
			'model'=>$model,
			'site_model'=>$site_model,
		));
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Contact;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Contact']))
		{
			$model->attributes=$_POST['Contact'];
			$date = date("Y-m-d H:i:s");
			$model->updated_at = $date;
			$model->created_at = $date;
			$model->agent_id = $this->agent_id;
			
			if($model->save()) {
				
					$contact_id  = $model->id;
				
					$exist_user_model = User::model()->findByAttributes(
												array(
													'email'=>$model->email
												)
											);
				
					if($exist_user_model == null) {
					// saving contact entry copy in user table as a service client role					
					$user_model = new User;
					$user_model->first_name = $model->first_name;
					$user_model->last_name = $model->surname;
					$user_model->username = $model->email;
					$user_model->password = md5(strtolower($model->first_name).CommonFunctions::random_string(10));
					$user_model->email = $model->email;
					$user_model->role_id = 4;
					$user_model->ip_address = '';
					$user_model->gender = 'UnKnown';
					$user_model->view_jobs = '0';
					$user_model->home_phone = $model->phone;
					$user_model->mobile_phone = $model->mobile;
					$user_model->street = $model->address;
					$user_model->city = $model->suburb;
					$user_model->state_province = $model->state;
					$user_model->zip_code = $model->postcode;
					$user_model->interested_in = 'Cleaning Services';
					$user_model->country_id = 15;
					$user_model->regular_hours = 21.86;
					$user_model->overtime_hours = 30.60;
					$user_model->double_time_hours = 39.35;										
					$user_model->status = '1';
					$user_model->created_at = $model->created_at;
					$user_model->updated_at = $model->updated_at;
					$user_model->agent_id = $this->agent_id;
					if($user_model->save()) {
					$user_id = $user_model->id;					
					
						// keeping relation between contact entry and user entry
						$contact_user = new ContactUserRelation;
						$contact_user->contact_id = $contact_id;
						$contact_user->user_id = $user_id;
						$contact_user->agent_id = $this->agent_id;
						$contact_user->save();
					}
				}
				$this->redirect(array('admin'));
			}
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

		if(isset($_POST['Contact']))
		{
			$model->attributes=$_POST['Contact'];
			$date = date("Y-m-d H:i:s");
			$model->updated_at = $date;
			
			if($model->save()) {
				
				$contact_id  = $model->id;
				$contact_user = ContactUserRelation::model()->findByAttributes(array('contact_id' => $contact_id));
				
				if($contact_user != null) {
						$user_id = $contact_user->user_id;

						$user_model=User::model()->findByPk($user_id);
						if($user_model != null) {
							$user_model->first_name = $model->first_name;
							$user_model->last_name = $model->surname;
							$user_model->email = $model->email;
							$user_model->home_phone = $model->phone;
							$user_model->mobile_phone = $model->mobile;
							$user_model->street = $model->address;
							$user_model->city = $model->suburb;
							$user_model->state_province = $model->state;
							$user_model->zip_code = $model->postcode;
							$user_model->created_at = $model->created_at;
							$user_model->updated_at = $model->updated_at;
							$user_model->save();
						}
				}
				
				$this->redirect(array('admin'));
			}
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
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		
		//delete user
		$ContactUserRelation_model = ContactUserRelation::model()->findByAttributes(
												array(
												'contact_id'=>$model->id
												)
											);
		
		if($ContactUserRelation_model !=null) {
			$user_id = $ContactUserRelation_model->user_id;
			// delete contact user relation
			// $model->id => contact id
			ContactUserRelation::model()->deleteAll( array("condition" =>  "contact_id = ".$model->id ));
			
			// delete user
			User::model()->deleteAll( array("condition" =>  "id = ".$user_id ));
			
		}
		
		$model->delete();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Contact');
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
	
		$model=new Contact('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Contact']))
			$model->attributes=$_GET['Contact'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Contact the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Contact::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Contact $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contact-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
