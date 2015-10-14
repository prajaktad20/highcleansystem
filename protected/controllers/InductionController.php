<?php

class InductionController extends Controller
{
	public $layout='//layouts/column2';
	public $base_url_assets = null;
	
	public function init() {
		$this->base_url_assets = CommonFunctions::siteURL();
	}
	
	public function actionIndex() {
		
		
		$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;
		$induction_company_id = isset($_GET['induction_company_id']) ? $_GET['induction_company_id'] : 0;
		
		
		if($user_id == 0)
			throw new CHttpException(404,'The requested page does not exist.');
			
		$user_model = User::model()->findByPk($user_id);
		$user_role_model = Group::model()->findByPk($user_model->role_id);
		$condition = "user_id = $user_id && induction_company_id=$induction_company_id";
		$Criteria = new CDbCriteria();		
		$Criteria->condition = $condition;
		$Criteria->order = "expiry_date";
		$user_inductions = Induction::model()->findAll($Criteria);
		
		
		if($user_model === null)
			throw new CHttpException(404,'The requested page does not exist.');
	
                       Yii::app()->clientScript->scriptMap = array(
            'jquery-1.11.1.min.js' => false
        );
		
		$this->render('index',
		
					  array(
						  'user_model'=> $user_model,
						  'user_role_model'=> $user_role_model,
						  'user_inductions'=> $user_inductions,
						   )
		);
	}
	
}
