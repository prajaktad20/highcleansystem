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
                
	}/**
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
				'actions'=>array('admin','delete','create','update','index','view','changestatus','changepassword','ViewLicenseInduction','DeleteLicense','DownloadLicense'),
				'users' => array('system_owner', 'state_manager', 'operation_manager', 'agent', 'supervisor','site_supervisor'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionMyLicencesInductions() {
				
		$Criteria = new CDbCriteria();		
		$Criteria->condition = "user_id = ".$this->user_id;
		$Criteria->order = "license_expiry_date";
		$user_licences = UserLicenses::model()->findAll($Criteria);
		$induction_model->agent_id = $this->agent_id;

		if(isset($_POST['update_induction']) && $_POST['update_induction'] === 'Update Induction') {
			$induction_id = isset($_POST['induction_id']) ? $_POST['induction_id'] : 0;
			$induction_number = isset($_POST['induction_number']) ? $_POST['induction_number'] : '';
			$completion_date = isset($_POST['completion_date']) ? $_POST['completion_date'] : '0000-00-00';
			$expiry_date = isset($_POST['expiry_date']) ? $_POST['expiry_date'] :  '0000-00-00';
			$induction_status = isset($_POST['induction_status']) ? $_POST['induction_status'] : 'pending';
			
			if($induction_id > 0) { 
				$induction_model=Induction::model()->findByPk($induction_id);
				$induction_model->induction_number = $induction_number;
				$induction_model->completion_date = $completion_date;
				$induction_model->expiry_date = $expiry_date;
				$induction_model->induction_status = $induction_status;
				
				
				if(isset($_FILES["induction_card"]["tmp_name"]) && !empty($_FILES["induction_card"]["tmp_name"])) {
						$newfilename_induction_card = date("YmdHis").'-'.$_FILES["induction_card"]["name"];
							if(move_uploaded_file($_FILES["induction_card"]["tmp_name"], Yii::app()->basePath.'/../uploads/induction/cards/'. $newfilename_induction_card)) {
								$induction_model->induction_card = $newfilename_induction_card;								
							}
					}
				
				$induction_model->save();
			}
			
			$this->refresh();
		}
		
		
		$model=new UserLicenses;	
		$model->agent_id = $this->agent_id;
		if(isset($_POST['UserLicenses']))
		{
		
		$model->attributes=$_POST['UserLicenses'];
		$model->license_expiry_date= isset($_POST['UserLicenses']['license_expiry_date']) ? $_POST['UserLicenses']['license_expiry_date'] : '0000-00-00';
			
		$rnd = $_POST['UserLicenses']['user_id']."-".rand(0,99999);  // generate random number between 0-99999
		$uploadedFile=CUploadedFile::getInstance($model,'license_file');
		if($uploadedFile) {
			$fileName = "{$rnd}-{$uploadedFile}"; 
			$model->license_file = $fileName;
		} 
		
			
			if($model->validate())
			{
				if($model->save(false)) {
					
					if(isset($fileName)){
					$save = Yii::app()->basePath.'/../uploads/users-licenses/'.$fileName;
					$uploadedFile->saveAs($save);
									
						$license_model = LicencesType::model()->findByPk($model->license_type_id); 
						Yii::app()->user->setFlash('success', "Data saved!");
						$this->refresh();
					}
				}
			}
		}
		
		
	
		$Criteria = new CDbCriteria();		
		$Criteria->condition = "induction_status ='pending' && user_id = ".$this->user_id;
		$induction_dues = Induction::model()->findAll($Criteria);
		

		
		$Criteria = new CDbCriteria();		
		$Criteria->condition = "induction_status ='completed' && user_id = ".$this->user_id;
		$induction_completed = Induction::model()->findAll($Criteria);
		
		
		
		$this->render('my_licences_inductions',array(
			'user_model'=>$this->loadModel($this->user_id),
			'model'=>$model, // license model
			'induction_dues' => $induction_dues,
			'induction_completed' => $induction_completed,			
			
		));
	
		
		
	}
	


	// license id
	public function actionDownloadLicense($id) {
		
		$model = $this->loadUserLicenseModel($id);			
		if(file_exists(Yii::app()->basePath.'/../uploads/users-licenses/'.$model->license_file)) {
		 $this->redirect(Yii::app()->getBaseUrl(true).'/uploads/users-licenses/'.$model->license_file);
		}
	}
	
	public function actionViewLicenseInduction($selected_user_id) {

		$model=$this->loadModel($selected_user_id);
		CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
		$selected_user_id = isset($_GET['selected_user_id']) ? $_GET['selected_user_id'] : 0;
		$model->agent_id = $this->agent_id;
		if($selected_user_id === 0)
			throw new CHttpException(404,'The requested page does not exist.');

		$Criteria = new CDbCriteria();		
		$Criteria->condition = "user_id = ".$selected_user_id;
		$Criteria->order = "license_expiry_date";
		$user_licences = UserLicenses::model()->findAll($Criteria);

		if(isset($_POST['update_induction']) && $_POST['update_induction'] === 'Update Induction') {
			$induction_id = isset($_POST['induction_id']) ? $_POST['induction_id'] : 0;
			$induction_number = isset($_POST['induction_number']) ? $_POST['induction_number'] : '';
			$completion_date = isset($_POST['completion_date']) ? $_POST['completion_date'] : '0000-00-00';
			$expiry_date = isset($_POST['expiry_date']) ? $_POST['expiry_date'] :  '0000-00-00';
			$induction_status = isset($_POST['induction_status']) ? $_POST['induction_status'] : 'pending';
			
			if($induction_id > 0) { 
				$induction_model=Induction::model()->findByPk($induction_id);
				$induction_model->induction_number = $induction_number;
				$induction_model->completion_date = $completion_date;
				$induction_model->expiry_date = $expiry_date;
				$induction_model->induction_status = $induction_status;
				
				
				if(isset($_FILES["induction_card"]["tmp_name"]) && !empty($_FILES["induction_card"]["tmp_name"])) {
						$newfilename_induction_card = date("YmdHis").'-'.$_FILES["induction_card"]["name"];
							if(move_uploaded_file($_FILES["induction_card"]["tmp_name"], Yii::app()->basePath.'/../uploads/induction/cards/'. $newfilename_induction_card)) {
								$induction_model->induction_card = $newfilename_induction_card;								
							}
					}
				
				$induction_model->save();
			}
			
			$this->refresh();
		}
		
		
		$model=new UserLicenses;	
		$model->agent_id = $this->agent_id;
		if(isset($_POST['UserLicenses']))
		{
		
		$model->attributes=$_POST['UserLicenses'];
		$model->license_expiry_date= isset($_POST['UserLicenses']['license_expiry_date']) ? $_POST['UserLicenses']['license_expiry_date'] : '0000-00-00';
			
		$rnd = $_POST['UserLicenses']['user_id']."-".rand(0,99999);  // generate random number between 0-99999
		$uploadedFile=CUploadedFile::getInstance($model,'license_file');
		if($uploadedFile) {
			$fileName = "{$rnd}-{$uploadedFile}"; 
			$model->license_file = $fileName;
		} 
		
			
			if($model->validate())
			{
				if($model->save(false)) {
					
					if(isset($fileName)){
					$save = Yii::app()->basePath.'/../uploads/users-licenses/'.$fileName;
					$uploadedFile->saveAs($save);
 

   					$highcleansysystem = new HighCleanSystem();

$s3 = new S3('AKIAI54I7KXX67EABPCQ', 'V9PYx6MYC2IjBzxxSAOmHaFzL7Vj9hodHQdjT7wL');
$bucketName = 'highcleansystem';
$s3->putObjectFile($save, $bucketName, 'users-licenses/'.$fileName, S3::ACL_PUBLIC_READ);
echo 'https://s3-ap-southeast-2.amazonaws.com/highcleansystem/users-licenses/'.$fileName;
exit;

									
						$license_model = LicencesType::model()->findByPk($model->license_type_id); 
						Yii::app()->user->setFlash('success', "Data saved!");
						$this->refresh();
					}
				}
			}
		}
		
		
	
		$Criteria = new CDbCriteria();		
		$Criteria->condition = "induction_status ='pending' && user_id = ".$selected_user_id;
		$induction_dues = Induction::model()->findAll($Criteria);
		

		
		$Criteria = new CDbCriteria();		
		$Criteria->condition = "induction_status ='completed' && user_id = ".$selected_user_id;
		$induction_completed = Induction::model()->findAll($Criteria);
		
		
		
		$this->render('view_user_licenses',array(
			'user_model'=>$this->loadModel($selected_user_id),
			'model'=>$model, // license model
			'induction_dues' => $induction_dues,
			'induction_completed' => $induction_completed,			
			
		));
	
	
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
		$model=new User;

	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$rnd = rand(0,99999);  // generate random number between 0-99999
			$uploadedFile=CUploadedFile::getInstance($model,'Avatar');
			if($uploadedFile) {
                        $fileName = "{$rnd}-{$uploadedFile}"; 
			$model->Avatar = $fileName;
			} else {
			$model->Avatar = "{$rnd}";
			}
			
			$date = date("Y-m-d H:i:s");
			$model->updated_at = $date;
			$model->created_at = $date;
			$model->agent_id = $this->agent_id;
            
			  if ($model->validate()) {
                    		$model->password = md5(trim($_POST['User']['password']));

				if($model->save()) {
				if(isset($fileName)){
					$save = Yii::app()->basePath.'/../uploads/users-profile-images/'.$fileName;
					$uploadedFile->saveAs($save);
					
					$vimage = new resize($save);
					$vimage->resizeImage(126, 117);
					$save_thumb = Yii::app()->basePath . '/../uploads/users-profile-images/thumbs/' . $model->Avatar;
					$vimage->saveImage($save_thumb);
					}
					$this->redirect(array('admin'));
				}
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
	{	$form_view = '';
		
		$model=$this->loadModel($id);
		CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
		$old_file = $model->Avatar;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		if(Yii::app()->user->name === 'staff' || Yii::app()->user->name === 'site_supervisor') 
		$form_view = 'update_account';
		else
		$form_view = 'update';	
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->Avatar = $old_file;	
			$date = date("Y-m-d H:i:s");
			$model->updated_at = $date;
			$model->agent_id = $this->agent_id;
                        
			
			$rnd = rand(0,99999);  // generate random number between 0-99999			
			$uploadedFile=CUploadedFile::getInstance($model,'Avatar');
			
			if($uploadedFile) {
                        $fileName = "{$rnd}-{$uploadedFile}"; 
			$model->Avatar = $fileName;
			} 
			
			if($model->save()) {
			
                   
                    if(isset($fileName)){
					$save = Yii::app()->basePath.'/../uploads/users-profile-images/'.$fileName;
					$save_thumb = Yii::app()->basePath . '/../uploads/users-profile-images/thumbs/' . $fileName;
					
					$uploadedFile->saveAs($save); // updloaded original image
					// convert original image to thumb 
					$vimage = new resize($save);
					$vimage->resizeImage(126, 117);					
					$vimage->saveImage($save_thumb);
					
					//delete previous image
					// $uploadedFile->saveAs(Yii::app()->basePath.'/../uploads/users-profile-images/'.$model->Avatar);
				    if(!empty($old_file) && file_exists(Yii::app()->basePath.'/../uploads/users-profile-images/'.$old_file))
				    unlink(Yii::app()->basePath.'/../uploads/users-profile-images/'.$old_file);	
					
					
					if(!empty($old_file) && file_exists(Yii::app()->basePath.'/../uploads/users-profile-images/thumbs/'.$old_file))
					unlink(Yii::app()->basePath.'/../uploads/users-profile-images/thumbs/'.$old_file);
					
					
					}
					
				Yii::app()->user->setFlash('success', "Profile updated successfully!");
				$this->refresh();
				
			}	
		}

		$this->render($form_view,array(
			'model'=>$model,
		));
	}

	/**
	 * Updates status a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionChangeStatus($id)
	{
	$model = $this->loadModel($id);  // use whatever the correct class name is
	if($model->status == '1')
    $model->status = '0';
	else
	$model->status = '1';
	
    $model->save();
    return true;


	}

	public function actionChangePassword($id)
	{
		$user_model=$this->loadModel($id);
		CommonFunctions::checkValidAgent($user_model->agent_id,$this->agent_id);
		$model = new ChangePasswordForm;
		
		if(isset($_POST['ChangePasswordForm']))
		{
			$model->attributes=$_POST['ChangePasswordForm'];	
			
			if ($model->validate()) {
				$user_model->password = md5(trim($model->password));

					if($user_model->save())
						Yii::app()->user->setFlash('success', "Password changed successfully!");
						$this->refresh();
					}	
			}

		$this->render('change_password',array(
			'model'=>$model,
			'user_model'=>$user_model,
		)); 
	}

	public function loadUserLicenseModel($id)
	{
		$model = UserLicenses::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionDeleteLicense($id) {
			
		$model = $this->loadUserLicenseModel($id);			
		if(file_exists(Yii::app()->basePath.'/../uploads/users-licenses/'.$model->license_file))
		unlink(Yii::app()->basePath.'/../uploads/users-licenses/'.$model->license_file);
		$model->delete();
	}/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		
		
		$model=$this->loadModel($id);
		
		if(!empty($model->Avatar) && file_exists(Yii::app()->basePath.'/../uploads/users-profile-images/'.$model->Avatar))
		unlink(Yii::app()->basePath.'/../uploads/users-profile-images/'.$model->Avatar);	
		
		
		if(!empty($model->Avatar) && file_exists(Yii::app()->basePath.'/../uploads/users-profile-images/thumbs/'.$model->Avatar))
		unlink(Yii::app()->basePath.'/../uploads/users-profile-images/thumbs/'.$model->Avatar);
		
		
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		
		// delete contact user relation
		ContactUserRelation::model()->deleteAll( array("condition" =>  "user_id = ".$model->id ));
		
		$model->delete();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
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
		
        $model=new User('search');
		$model->unsetAttributes();  // clear any default values
		
			
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
