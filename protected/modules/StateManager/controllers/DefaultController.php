<?php

class DefaultController extends Controller
{

 public $layout='//layouts/column1';
 public $base_url_assets = null;
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
				'actions'=>array('index','view','create','update','admin','delete','changepassword'),
				'users'=>array('system_owner','operation_manager'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new StateManager;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['StateManager']))
		{
			$model->attributes=$_POST['StateManager'];
			$model->password = md5(trim($_POST['StateManager']['password']));
			$model->auth_key = CommonFunctions::random_string(32);
			$date = date("Y-m-d H:i:s");
			$model->added_date = $date;


			$rnd = rand(0,99999);  // generate random number between 0-99999
			$uploadedFile=CUploadedFile::getInstance($model,'logo');
			if($uploadedFile) {
                        $fileName = "{$rnd}-{$uploadedFile}"; 
			$model->logo = $fileName;
			} else {
			$model->logo = "{$rnd}";
			}

			if($model->save()) {

                            if(isset($fileName)){
						$save = Yii::app()->basePath.'/../uploads/state_manager/'.$fileName;
						$uploadedFile->saveAs($save);
					
						$vimage = new resize($save);
						$vimage->resizeImage(126, 117);
						$save_thumb = Yii::app()->basePath . '/../uploads/state_manager/thumbs/' . $model->logo;
						$vimage->saveImage($save_thumb);
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
		$old_file = $model->logo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);



		if(isset($_POST['StateManager']))
		{
			$model->attributes=$_POST['StateManager'];
			$model->logo = $old_file;
			$model->auth_key = CommonFunctions::random_string(32);
			
                        
                        $rnd = rand(0,99999);  // generate random number between 0-99999			
                        $uploadedFile=CUploadedFile::getInstance($model,'logo');

                        if($uploadedFile) {
                        $fileName = "{$rnd}-{$uploadedFile}"; 
                        $model->logo = $fileName;
                        } 
                        

			if($model->save()) {

     			if(isset($fileName)){
                        
		                $save = Yii::app()->basePath.'/../uploads/state_manager/'.$fileName;
		                $save_thumb = Yii::app()->basePath . '/../uploads/state_manager/thumbs/' . $fileName;

		                $uploadedFile->saveAs($save); // updloaded original image
		                // convert original image to thumb 
		                $vimage = new resize($save);
		                $vimage->resizeImage(100, 100);					
		                $vimage->saveImage($save_thumb);

		                //delete previous image
		                // $uploadedFile->saveAs(Yii::app()->basePath.'/../uploads/state_manager/'.$model->logo);
		                if(!empty($old_file) && file_exists(Yii::app()->basePath.'/../uploads/state_manager/'.$old_file))
		                unlink(Yii::app()->basePath.'/../uploads/state_manager/'.$old_file);	


		                if(!empty($old_file) && file_exists(Yii::app()->basePath.'/../uploads/state_manager/thumbs/'.$old_file))
		                unlink(Yii::app()->basePath.'/../uploads/state_manager/thumbs/'.$old_file);


                    	} 

				
						Yii::app()->user->setFlash('success', "Profile updated successfully!");
						$this->refresh();
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	/**
	* Change Password
	*/
	
	public function actionChangePassword($id)
	{
		$state_model=$this->loadModel($id);
		$model = new ChangePasswordForm;
		
		if(isset($_POST['ChangePasswordForm']))
		{
			$model->attributes=$_POST['ChangePasswordForm'];	
			
			if ($model->validate()) {
				$state_model->password = md5(trim($model->password));

					if($state_model->save())
						Yii::app()->user->setFlash('success', "Password changed successfully!");
						$this->refresh();
					}	
			}

		$this->render('change_password',array(
			'model'=>$model,
			'state_model'=>$state_model,
		)); 
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('StateManager');
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

		$model=new StateManager('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['StateManager']))
			$model->attributes=$_GET['StateManager'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return StateManager the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=StateManager::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param StateManager $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='operation-manager-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
