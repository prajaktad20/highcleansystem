<?php

class PersonalController extends Controller {
	
	public $layout='//layouts/column1';
	public $base_url_assets = null;
	public $IsUsingDevice = 0;
	public $user_id = 0;
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
	'actions'=>array('MyPersonalDetails','ChangeMyPassword','MyProfileUpdate','MyLicencesInductions'),
	'users'=>array('supervisor','site_supervisor','staff'),
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
	


		public function actionChangeMyPassword() {
		
		$model = new ChangePasswordForm;
		
		if(isset($_POST['ChangePasswordForm']))
		{
			$model->attributes=$_POST['ChangePasswordForm'];	
			
			if ($model->validate()) {
				$user_model=$this->loadModel($this->user_id);
				$user_model->password = md5(trim($model->password));

					if($user_model->save())
						Yii::app()->user->setFlash('success', "Password changed successfully!");
						$this->refresh();
					}	
			}

		$this->render('change_password',array(
			'model'=>$model,
		)); 
	}
	
	public function actionMyProfileUpdate() {
		
		$model = $this->loadModel($this->user_id);
	        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
		$old_file = $model->Avatar;	
		if(isset($_POST['User'])) {
					$model->attributes=$_POST['User'];
					$model->Avatar = $old_file;	
					$date = date("Y-m-d H:i:s");
					$model->updated_at = $date;
						
						
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
				
				$this->render('my_personal_deails_edit',array(
				'model' => $model
				));		}
		

	public function actionMyPersonalDetails() {
		$model = $this->loadModel($this->user_id);
	        CommonFunctions::checkValidAgent($model->agent_id,$this->agent_id);
		$this->render('my_personal_deails_view',array(
		'model' => $model
		));
	}
		
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Agent the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


}
