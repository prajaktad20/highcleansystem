<?php

class DefaultController extends Controller
{

 public $base_url_assets = null;
 public $layout='//layouts/column1';
 public $user_id = 0;
 public $IsUsingDevice = 0;
 public $user_role_base_url = ''; public $user_dashboard_url = '';
 public $agent_id = '';
 public $agent_info = null;
 public $where_agent_condition = '';

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
		$this->where_agent_condition = " agent_id = ".$this->agent_id ;

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
				'actions'=>array('index','view','admin','delete','create','update','calendar'),
				'users'=>array('system_owner', 'state_manager', 'operation_manager', 'agent','supervisor','site_supervisor'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	public function actionCalendar()
	{
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/css/calendar/js/moment.min.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/css/calendar/js/fullcalendar.min.js', CClientScript::POS_END);
		
		$user_model = User::model()->findByPk($this->user_id);
		
		$Criteria = new CDbCriteria();
		$Criteria->condition = $this->where_agent_condition;
		$Criteria->order = "date";
		$maintenance_objects = Maintenance::model()->findAll($Criteria); 
		$calender_events = array(); $i=0;
		foreach($maintenance_objects as $object) {
		//	echo '<pre>'; print_r($object); echo '</pre>';
			$calender_events[$i]['id'] = $object->id;
			$calender_events[$i]['title'] = $object->equipment.':- '.$object->note;
			$calender_events[$i]['start'] = $object->date;
			$calender_events[$i]['end'] = $object->date;
			$calender_events[$i]['url'] = Yii::app()->getBaseUrl(true). '/index.php?r=Maintenance/default/update&id='.$object->id;
			if($object->status === 'Completed')
			$calender_events[$i]['className'] = 'assignjob';
			else
			$calender_events[$i]['className'] = 'notapprovejob';
			
			$i++;
			
		}
		
		//echo '<pre>'; print_r($calender_events); echo '</pre>';
		$this->render('maintenance_calender',
		array('calender_events' => json_encode($calender_events),)
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Maintenance;
		$model->agent_id = $this->agent_id;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Maintenance']))
		{
			$model->attributes=$_POST['Maintenance'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->id));
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
		$old_file = $model->photo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

			if(isset($_POST['Maintenance']))
		{
		
		$model->attributes=$_POST['Maintenance'];
		$model->equipment= isset($_POST['Maintenance']['equipment']) ? $_POST['Maintenance']['equipment'] : '';
		$model->note= isset($_POST['Maintenance']['note']) ? $_POST['Maintenance']['note'] : '';
		$model->agent_id= $this->agent_id;	
		$rnd = date('YmdHis');
		$uploadedFile=CUploadedFile::getInstance($model,'photo');
		if($uploadedFile) {
			$fileName = "{$rnd}-{$uploadedFile}"; 
			$model->photo = $fileName;
		} else {
			$model->photo = $old_file;
		}
		
			
			if($model->validate())
			{
				if($model->save(false)) {
					
					if(isset($fileName)){

					$save = Yii::app()->basePath.'/../uploads/maintenances/'.$fileName;
					$save_thumb = Yii::app()->basePath.'/../uploads/maintenances/thumb/'.$fileName;
					$uploadedFile->saveAs($save);
						
							$vimage = new resize($save);
							$vimage->resizeImage(126, 117);					
							$vimage->saveImage($save_thumb);
						
						
//deleting previous images
		if(!empty($old_file) && file_exists(Yii::app()->basePath.'/../uploads/maintenances/'.$old_file))
		unlink(Yii::app()->basePath.'/../uploads/maintenances/'.$old_file);
		if(!empty($old_file) && file_exists(Yii::app()->basePath.'/../uploads/maintenances/thumb/'.$old_file))
		unlink(Yii::app()->basePath.'/../uploads/maintenances/thumb/'.$old_file);

		
						
						
					}
				}
				$this->redirect(array('admin','id'=>$model->id));
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
		$model = $this->loadModel($id);
		CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
		if(!empty($model->photo) && file_exists(Yii::app()->basePath.'/../uploads/maintenances/'.$model->photo))
		unlink(Yii::app()->basePath.'/../uploads/maintenances/'.$model->photo);
		if(!empty($model->photo) && file_exists(Yii::app()->basePath.'/../uploads/maintenances/thumb/'.$model->photo))
		unlink(Yii::app()->basePath.'/../uploads/maintenances/thumb/'.$model->photo);

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
		$dataProvider=new CActiveDataProvider('Maintenance');
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
		
		$model=new Maintenance('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Maintenance']))
			$model->attributes=$_GET['Maintenance'];

		
			$model_maintenance=new Maintenance;		
		if(isset($_POST['Maintenance']))
		{
		
		$model_maintenance->attributes=$_POST['Maintenance'];
		$model_maintenance->equipment= isset($_POST['Maintenance']['equipment']) ? $_POST['Maintenance']['equipment'] : '';
		$model_maintenance->note= isset($_POST['Maintenance']['note']) ? $_POST['Maintenance']['note'] : '';
		$model_maintenance->agent_id = $this->agent_id;	
		$rnd = date('YmdHis');
		$uploadedFile=CUploadedFile::getInstance($model_maintenance,'photo');
		if($uploadedFile) {
			$fileName = "{$rnd}-{$uploadedFile}"; 
			$model_maintenance->photo = $fileName;
		} 
		
			
			if($model_maintenance->validate())
			{
				if($model_maintenance->save(false)) {
					
					if(isset($fileName)){
					$save = Yii::app()->basePath.'/../uploads/maintenances/'.$fileName;
					$save_thumb = Yii::app()->basePath.'/../uploads/maintenances/thumb/'.$fileName;
					$uploadedFile->saveAs($save);
						
							$vimage = new resize($save);
							$vimage->resizeImage(126, 117);					
							$vimage->saveImage($save_thumb);
								
						Yii::app()->user->setFlash('success', "Data saved!");
						$this->refresh();
					}
				}
			}
		}
	


		
		$this->render('admin',array(
			'model'=>$model,
			'model_maintenance'=>$model_maintenance,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Maintenance the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Maintenance::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Maintenance $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='maintenance-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
