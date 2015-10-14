<?php

class DefaultController extends Controller
{
	public $base_url_assets = null;
	public $layout='//layouts/column1';
	public $current_user_id = 0;
        public $user_role_base_url = ''; public $user_dashboard_url = '';

	public function init() {
		$this->base_url_assets = CommonFunctions::siteURL();         
		$this->user_role_base_url = CommonFunctions::getUserBaseUrl(Yii::app()->user->name);
		$this->user_dashboard_url = CommonFunctions::getUserDashboardUrl(Yii::app()->user->name);
		
		$current_user_id = isset(Yii::app()->user->id) ? Yii::app()->user->id : 0;
		$this->current_user_id = $current_user_id;	
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
				'users'=>array('service_client'),
			),
                    array('deny',  // deny all users
				'users'=>array('*'),
			),
			
		);
	}


	public function actionIndex()
	{
		$contact_user = ContactUserRelation::model()->findByAttributes(array('user_id' => $this->current_user_id));
		if($contact_user == null)
			throw new CHttpException(404,'The requested page does not exist.');
		//echo '<pre>'; print_r($contact_user); echo '</pre>';
		
		// Find contact id by logined user id
		$contact_id = $contact_user->contact_id;
		
		
		// Find all related quotes by contact id
		$quotes = Quotes::model()->findAllByAttributes(array('contact_id' => $contact_id));
		//echo '<pre>'; print_r($quotes); echo '</pre>';
		if($quotes == null)
			throw new CHttpException(404,'The requested page does not exist.');
		
		
		// store all quote ids in quotes_id array
		$quotes_id = array();
		
		foreach($quotes as $single_quote_row) {
			$quotes_id[] = $single_quote_row->id;
		}
		
		if(count($quotes_id) == 0)
			throw new CHttpException(404,'The requested page does not exist.');
		
		// find all signed off jobs by quotes_id
		$Criteria = new CDbCriteria();
		$Criteria->condition = "signed_off = 'Yes'";
		$Criteria->addInCondition("quote_id", $quotes_id);
		$signedOffJobs = QuoteJobs::model()->findAll($Criteria); 
		//echo '<pre>'; print_r($signedOffJobs); echo '</pre>';
		
		
      $this->render('index',
		  array(
			'signedOffJobs' => $signedOffJobs
		  )
	  );
	}


      

}
