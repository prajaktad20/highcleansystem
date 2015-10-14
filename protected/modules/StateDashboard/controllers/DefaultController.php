<?php

class DefaultController extends Controller
{
	public $base_url_assets = null;
	public $layout='//layouts/column1';
        public $user_role_base_url = ''; public $user_dashboard_url = '';

	public function init() {

		$this->base_url_assets = CommonFunctions::siteURL();         
		$this->user_role_base_url = CommonFunctions::getUserBaseUrl(Yii::app()->user->name);
		$this->user_dashboard_url = CommonFunctions::getUserDashboardUrl(Yii::app()->user->name);

	}

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
				'actions'=>array('index'),
				'users'=>array('system_owner','state_manager'),
			),
                    array('deny',  // deny all users
				'users'=>array('*'),
			),
			
		);
	}

			
	
	public function actionIndex()
	{	
        // All module count
		
        $result =array();
		$agents_count = Agents::Model()->countByAttributes(array());
		$statemanager_count = StateManager::Model()->countByAttributes(array());
		$operationmanager_count = OperationManager::Model()->countByAttributes(array());
		$systemowner_count = SystemOwner::Model()->countByAttributes(array());
		$emailformat_count = EmailFormat::Model()->countByAttributes(array());
		$smsformat_count = SmsFormat::Model()->countByAttributes(array());
		$service_count = Service::Model()->countByAttributes(array());
		
		$result['system_owner'] = $systemowner_count;
		$result['agents'] = $agents_count;
		$result['state_manager'] = $statemanager_count;
		$result['operation_manager'] = $operationmanager_count;
		$result['email_format'] = $emailformat_count;
		$result['sms_format'] = $smsformat_count;
		$result['services'] = $service_count;
		
		// latest five agents
		
		$sql='SELECT * FROM {{agent}} ORDER BY added_date DESC LIMIT 5 ';
		$latest_five_agents = Agents::model()->findAllBySql($sql);
		//echo '<pre>';
		//print_r($latest_five_agents);
		//echo '</pre>';
		
		$this->render('index',array(
			'result'=>$result,
			'latest_agents'=>$latest_five_agents,
		));
	}


      

}
