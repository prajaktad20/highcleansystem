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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('getInductionCompanySites','GetInductionDetails','index','view','create','update','admin','delete','notify_user'),
				'users'=>array('system_owner', 'state_manager', 'operation_manager', 'agent','supervisor','site_supervisor','staff'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionGetInductionCompanySites(){
		
				$induction_company_id= $_POST['induction_company_id'] ? $_POST['induction_company_id'] : 0;
			
				$criteria2 = new CDbCriteria();
				$criteria2->select = "id,site_name";
				$criteria2->order = 'site_name';
				$criteria2->condition = "need_induction='1' && $this->where_agent_condition && induction_company_id=$induction_company_id";
				$loop_site_contacts = ContactsSite::model()->findAll($criteria2);				
			
		$induction_company_model=InductionCompany::model()->findByPk($induction_company_id);
		
		$html = '';
        $html = $this->renderPartial('induction_company_sites',
                        array(
                            'loop_site_contacts' => $loop_site_contacts,
                            'induction_company_model' => $induction_company_model,
                        ),
                        true
        );

        echo $html;
        exit;
		
	}
	
	public function actionGetInductionDetails()
	{
		$id= $_POST['induction_id'] ? $_POST['induction_id'] : 0;
		$model = $this->loadModel($id);
		$data = array();
		
		$data['induction_id'] = $model->id;
		$data['induction_number'] = $model->induction_number;
		$data['induction_card'] = '';
		if(!empty($model->induction_card) && file_exists(Yii::app()->basePath.'/../uploads/induction/cards/'.$model->induction_card))	{
			$image_url = Yii::app()->getBaseUrl(true).'/uploads/induction/cards/'.$model->induction_card;	
			$data['induction_card'] = "<a target='_blank' href='$image_url'>Induction Card</a>";
		}
		
		$data['completion_date'] = $model->completion_date;
		$data['expiry_date'] = $model->expiry_date;
		$data['induction_status'] = $model->induction_status;
		
		echo json_encode($data); exit;
	}

	public function actionNotify_user($id)
	{
		$model = $this->loadModel($id);
		EmailFunctionHandle::sendEmail_GeneralInduction(13,$model->user_id,$model->id);
		return true;
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
		$date = date("Y-m-d H:i:s"); $total_records = 0;
		$induction_users = isset($_POST['induction_users']) ? $_POST['induction_users'] : array();
		$induction_company = isset($_POST['induction_company']) ? $_POST['induction_company'] : 0;
		$induction_type = isset($_POST['induction_type']) ? $_POST['induction_type'] : 0;
		$induction_sites = isset($_POST['induction_sites']) ? $_POST['induction_sites'] : array();
		$induction_link_document = isset($_POST['Induction']['induction_link_document']) ? $_POST['Induction']['induction_link_document'] : '0';
		$induction_link = isset($_POST['Induction']['induction_link']) ? $_POST['Induction']['induction_link'] : '';
		
		$password = isset($_POST['Induction']['password']) ? $_POST['Induction']['password'] : '';
		$induction_number = isset($_POST['Induction']['induction_number']) ? $_POST['Induction']['induction_number'] : '';
		$completion_date = isset($_POST['Induction']['completion_date']) ? $_POST['Induction']['completion_date'] : '0000-00-00';
		$expiry_date = isset($_POST['Induction']['expiry_date']) ? $_POST['Induction']['expiry_date'] : '0000-00-00';
		$induction_status = isset($_POST['Induction']['induction_status']) ? $_POST['Induction']['induction_status'] : 'pending';


		$model=new Induction;
		$model->created_at = $date;
		$model->user_id = $model->induction_company_id = $model->induction_type_id = $model->site_id = 0;
		$model->induction_link_document = $induction_link_document;
		
	
		if(isset($_POST['Induction'])) {		
		
			if(count($induction_users) == 0)			
			$model->addError('user_id', 'Must select at least one User');
			else if($induction_company == 0)			
			$model->addError('induction_company_id', 'Must select Company');		
			else if($induction_type == 0)			
			$model->addError('induction_type_id', 'Must select Type');
			else if(count($induction_sites) == 0)			
			$model->addError('site_id', 'Must select at least one Site');
			else if($model->induction_link_document == '0' && empty($induction_link))
				$model->addError('induction_link', 'Type Induction Link');
			else if($model->validate()){
	
				$induction_company_model=InductionCompany::model()->findByPk($induction_company);
				foreach($induction_users as $user_id) {
					
					if($induction_company_model->single_induction == '1') {	
						$model=new Induction;
						$model->user_id = $user_id;
						$model->induction_company_id = $induction_company; 
						$model->induction_type_id = $induction_type;
						$model->site_id = 0;		
						$model->created_at = $date;
						$model->induction_link_document = $induction_link_document;
						$model->induction_link = $induction_link;
						$model->password = $password;
						$model->induction_number = $induction_number;
						$model->completion_date = $completion_date;	
						$model->expiry_date = $expiry_date;
						$model->induction_status = $induction_status;
						$date = date("Y-m-d H:i:s");					
						$model->created_at = $date;
						$model->agent_id = $this->agent_id;
						/******* Uploading document **********/
						$model->document = NULL; // uploading document file
						if($model->induction_link_document == 1) {
							//echo '<pre>'; print_r($_FILES["document"]); echo '</pre>'; exit;
							if($total_records == 0 && isset($_FILES["document"]["tmp_name"]) && !empty($_FILES["document"]["tmp_name"])) {
							$newfilename_document = date("YmdHis").'-'.$total_records.'-'.$_FILES["document"]["name"];
								if(move_uploaded_file($_FILES["document"]["tmp_name"], Yii::app()->basePath.'/../uploads/induction/documents/'. $newfilename_document)) {
									$model->document = $newfilename_document;
									$original_doc_file_name = $_FILES["document"]["name"];
									$copied_doc_file_name = $model->document;
								}
							}
							
							if($total_records > 0 && isset($original_doc_file_name)) {
								$model->document = date("YmdHis").'-'.$total_records.'-'.$original_doc_file_name;
								copy(Yii::app()->basePath.'/../uploads/induction/documents/'. $copied_doc_file_name, Yii::app()->basePath.'/../uploads/induction/documents/'. $model->document);
								
							}
						}
						/*****************/
						
						/******** Uploading Induction Card *********/
						$model->induction_card = NULL; // uploading induction_card file
						//echo '<pre>'; print_r($_FILES["induction_card"]); echo '</pre>'; exit;
						if($total_records == 0 && isset($_FILES["induction_card"]["tmp_name"]) && !empty($_FILES["induction_card"]["tmp_name"])) {
						$newfilename_induction_card = date("YmdHis").'-'.$total_records.'-'.$_FILES["induction_card"]["name"];
							if(move_uploaded_file($_FILES["induction_card"]["tmp_name"], Yii::app()->basePath.'/../uploads/induction/cards/'. $newfilename_induction_card)) {
								$model->induction_card = $newfilename_induction_card;
								$original_file_name = $_FILES["induction_card"]["name"];
								$copied_file_name = $model->induction_card;
							}
						}
						
						if($total_records > 0 && isset($original_file_name)) {
							$model->induction_card = date("YmdHis").'-'.$total_records.'-'.$original_file_name;
							copy(Yii::app()->basePath.'/../uploads/induction/cards/'. $copied_file_name, Yii::app()->basePath.'/../uploads/induction/cards/'. $model->induction_card);
							
						}
						/****************/
						
						$model->save();
						$total_records++;
				} else {		
					
					foreach($induction_sites as $site_id) {
						$model=new Induction;
						$model->user_id = $user_id;
						$model->induction_company_id = $induction_company; 
						$model->induction_type_id = $induction_type;
						$model->site_id = $site_id;		
						$model->created_at = $date;
						$model->induction_link_document = $induction_link_document;
						$model->induction_link = $induction_link;
						$model->password = $password;
						$model->induction_number = $induction_number;
						$model->completion_date = $completion_date;	
						$model->expiry_date = $expiry_date;
						$model->induction_status = $induction_status;
						$date = date("Y-m-d H:i:s");	
						$model->agent_id = $this->agent_id;				
						$model->created_at = $date;
						
						/******* Uploading document **********/
						$model->document = NULL; // uploading document file
						if($model->induction_link_document == 1) {
							//echo '<pre>'; print_r($_FILES["document"]); echo '</pre>'; exit;
							if($total_records == 0 && isset($_FILES["document"]["tmp_name"]) && !empty($_FILES["document"]["tmp_name"])) {
							$newfilename_document = date("YmdHis").'-'.$total_records.'-'.$_FILES["document"]["name"];
								if(move_uploaded_file($_FILES["document"]["tmp_name"], Yii::app()->basePath.'/../uploads/induction/documents/'. $newfilename_document)) {
									$model->document = $newfilename_document;
									$original_doc_file_name = $_FILES["document"]["name"];
									$copied_doc_file_name = $model->document;
								}
							}
							
							if($total_records > 0 && isset($original_doc_file_name)) {
								$model->document = date("YmdHis").'-'.$total_records.'-'.$original_doc_file_name;
								copy(Yii::app()->basePath.'/../uploads/induction/documents/'. $copied_doc_file_name, Yii::app()->basePath.'/../uploads/induction/documents/'. $model->document);
								
							}
						}
						/*****************/
						
						/******** Uploading Induction Card *********/
						$model->induction_card = NULL; // uploading induction_card file
						//echo '<pre>'; print_r($_FILES["induction_card"]); echo '</pre>'; exit;
						if($total_records == 0 && isset($_FILES["induction_card"]["tmp_name"]) && !empty($_FILES["induction_card"]["tmp_name"])) {
						$newfilename_induction_card = date("YmdHis").'-'.$total_records.'-'.$_FILES["induction_card"]["name"];
							if(move_uploaded_file($_FILES["induction_card"]["tmp_name"], Yii::app()->basePath.'/../uploads/induction/cards/'. $newfilename_induction_card)) {
								$model->induction_card = $newfilename_induction_card;
								$original_file_name = $_FILES["induction_card"]["name"];
								$copied_file_name = $model->induction_card;
							}
						}
						
						if($total_records > 0 && isset($original_file_name)) {
							$model->induction_card = date("YmdHis").'-'.$total_records.'-'.$original_file_name;
							copy(Yii::app()->basePath.'/../uploads/induction/cards/'. $copied_file_name, Yii::app()->basePath.'/../uploads/induction/cards/'. $model->induction_card);
							
						}
						/****************/
						
						
						
						
						$model->save();
						$total_records++;
					}
				
				}
				
				
				}
						Yii::app()->user->setFlash('success', $total_records." records saved!");
						$this->refresh();
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
		$old_doc_file = $model->document;
		$old_induction_card = $model->induction_card;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Induction']))
		{
			$model->attributes=$_POST['Induction'];
			
					
			$_POST['Induction']['induction_card'] = $model->induction_card;				
			$rnd = rand(0,99999);  // generate random number between 0-99999			
			$uploadedFile2=CUploadedFile::getInstance($model,'induction_card');			
			if($uploadedFile2) {
            		$induction_card_file = "{$rnd}-{$uploadedFile2}"; 
			$model->induction_card = $induction_card_file;
			} else {
					$model->induction_card = $old_induction_card;	
			}		
			
			if($model->induction_link_document == 1) {
				
			$_POST['Induction']['document'] = $model->document;				
			$rnd = rand(0,99999);  // generate random number between 0-99999			
			$uploadedFile=CUploadedFile::getInstance($model,'document');			
				if($uploadedFile) {
				$document_file = "{$rnd}-{$uploadedFile}"; 
				$model->document = $document_file;
				} else {
					$model->document = $old_doc_file;	
				}	
			} else {
				$model->document = $old_doc_file;	
			}
			
			if($model->save()) {
				
				            
                    if(isset($document_file)){
						$save = Yii::app()->basePath.'/../uploads/induction/documents/'.$document_file;			
						$uploadedFile->saveAs($save);
						
						if(!empty($old_doc_file) && file_exists(Yii::app()->basePath.'/../uploads/induction/documents/'.$old_doc_file))
						unlink(Yii::app()->basePath.'/../uploads/induction/documents/'.$old_doc_file);	
												
					}
				
				            
                    if(isset($induction_card_file)){
						$save = Yii::app()->basePath.'/../uploads/induction/cards/'.$induction_card_file;			
						$uploadedFile2->saveAs($save);
						if(!empty($old_induction_card) && file_exists(Yii::app()->basePath.'/../uploads/induction/cards/'.$old_induction_card))
						unlink(Yii::app()->basePath.'/../uploads/induction/cards/'.$old_induction_card);							
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
		
		if(!empty($model->document) && file_exists(Yii::app()->basePath.'/../uploads/induction/documents/'.$model->document))
						unlink(Yii::app()->basePath.'/../uploads/induction/documents/'.$model->document);	

		if(!empty($model->induction_card) && file_exists(Yii::app()->basePath.'/../uploads/induction/cards/'.$model->induction_card))
						unlink(Yii::app()->basePath.'/../uploads/induction/cards/'.$model->induction_card);				
					
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		
		$model->delete();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Induction');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		
		$model=new Induction('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Induction']))
			$model->attributes=$_GET['Induction'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Induction the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Induction::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Induction $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='induction-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
