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
				'users'=>array('system_owner', 'state_manager', 'operation_manager', 'agent','supervisor','site_supervisor','staff'),
			),
                    array('deny',  // deny all users
				'users'=>array('*'),
			),
			
		);
	}

			
	
		

	public function actionIndex()
	{	
        	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/highcharts.js', CClientScript::POS_END);	
		
		$graph_1 = Graphs::top_quotes_approved_customer($this->agent_id);
		$graph_2 = Graphs::graph_booked_approved_and_not_approved($this->agent_id);
		$graph_3 = Graphs::graph_top_five_services($this->agent_id);
		$graph_4 = Graphs::graph_quotes_status($this->agent_id);
		
		$this->render('index',
		array(
			
			'graph_1' => $graph_1,
			
			'x_axis_2_graph' => $graph_2['x_axis_2_graph'],
			'y_axis_2_graph_booked_approved' => $graph_2['y_axis_2_graph_booked_approved'],
			'y_axis_2_graph_not_booked_approved' => $graph_2['y_axis_2_graph_not_booked_approved'],
			
			'x_axis_3_graph' => $graph_3['x_axis_3_graph'],
			'y_axis_3_graph_top_five_services' => $graph_3['y_axis_3_graph_top_five_services'],
			
			'approve_quote_count' => $graph_4['approve_quote_count'],
			'decline_quote_count' => $graph_4['decline_quote_count'],
			'pending_quote_count' => $graph_4['pending_quote_count'],
			
			
		)
		
		);
	}



      

}
