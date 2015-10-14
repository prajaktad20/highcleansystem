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
				'users'=>array('system_owner'),
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
		$model=new OperationManager;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OperationManager']))
		{
			$model->attributes=$_POST['OperationManager'];
			$model->password = md5(trim($_POST['OperationManager']['password']));
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
						$save = Yii::app()->basePath.'/../uploads/operation_manager/'.$fileName;
						$uploadedFile->saveAs($save);
					
						$vimage = new resize($save);
						$vimage->resizeImage(126, 117);
						$save_thumb = Yii::app()->basePath . '/../uploads/operation_manager/thumbs/' . $model->logo;
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

		if(isset($_POST['OperationManager']))
		{
			$model->attributes=$_POST['OperationManager'];
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
                        
		                $save = Yii::app()->basePath.'/../uploads/operation_manager/'.$fileName;
		                $save_thumb = Yii::app()->basePath . '/../uploads/operation_manager/thumbs/' . $fileName;

		                $uploadedFile->saveAs($save); // updloaded original image
		                // convert original image to thumb 
		                $vimage = new resize($save);
		                $vimage->resizeImage(100, 100);					
		                $vimage->saveImage($save_thumb);

		                //delete previous image
		                // $uploadedFile->saveAs(Yii::app()->basePath.'/../uploads/operation_manager/'.$model->logo);
		                if(!empty($old_file) && file_exists(Yii::app()->basePath.'/../uploads/operation_manager/'.$old_file))
		                unlink(Yii::app()->basePath.'/../uploads/operation_manager/'.$old_file);	


		                if(!empty($old_file) && file_exists(Yii::app()->basePath.'/../uploads/operation_manager/thumbs/'.$old_file))
		                unlink(Yii::app()->basePath.'/../uploads/operation_manager/thumbs/'.$old_file);


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
	* Change Password
	*/
	
	public function actionChangePassword($id)
	{
		$operation_model=$this->loadModel($id);
		$model = new ChangePasswordForm;
		
		if(isset($_POST['ChangePasswordForm']))
		{
			$model->attributes=$_POST['ChangePasswordForm'];	
			
			if ($model->validate()) {
				$operation_model->password = md5(trim($model->password));

					if($operation_model->save())
						Yii::app()->user->setFlash('success', "Password changed successfully!");
						$this->refresh();
					}	
			}

		$this->render('change_password',array(
			'model'=>$model,
			'operation_model'=>$operation_model,
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
		$dataProvider=new CActiveDataProvider('OperationManager');
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

		$model=new OperationManager('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OperationManager']))
			$model->attributes=$_GET['OperationManager'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OperationManager the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OperationManager::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OperationManager $model the model to be validated
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
