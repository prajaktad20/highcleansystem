<?php


class DefaultController extends Controller
{

 public $base_url_assets = null;
 public $layout='//layouts/column1';
public $user_role_base_url = ''; public $user_dashboard_url = '';

	public function init() {
		$this->base_url_assets = CommonFunctions::siteURL();         $this->user_role_base_url = CommonFunctions::getUserBaseUrl(Yii::app()->user->name);
		$this->user_dashboard_url = CommonFunctions::getUserDashboardUrl(Yii::app()->user->name);
	}
	
	public function actionIndex()	{

	// CgridView Records/page section
		if (isset($_GET['pageSize'])) {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);
		}
		
		
		$list_building_type_model = new ListBuildingType('search');
		$list_building_type_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ListBuildingType']))
		$list_building_type_model->attributes=$_GET['ListBuildingType'];

		
	
		$list_glass_type_model = new ListGlassType('search');
		$list_glass_type_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ListGlassType']))
		$list_glass_type_model->attributes=$_GET['ListGlassType'];
		
		$list_access_type_model = new ListAccessType('search');
		$list_access_type_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ListAccessType']))
		$list_access_type_model->attributes=$_GET['ListAccessType'];

		
		
		$list_display_for_agent_model = new ListDisplayForClient('search');
		$list_display_for_agent_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ListDisplayForClient']))
		$list_display_for_agent_model->attributes=$_GET['ListDisplayForClient'];

	
		
		$list_equipment_type_model = new ListEquipmentType('search');
		$list_equipment_type_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ListEquipmentType']))
		$list_equipment_type_model->attributes=$_GET['ListEquipmentType'];

	
		
		
		$list_pane_size_type_model = new ListPaneSizeType('search');
		$list_pane_size_type_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ListPaneSizeType']))
		$list_pane_size_type_model->attributes=$_GET['ListPaneSizeType'];
	
		
		$list_quality_type_model = new ListQualityType('search');
		$list_quality_type_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ListQualityType']))
		$list_quality_type_model->attributes=$_GET['ListQualityType'];

		
		$list_service_type_model = new ListServiceType('search');
		$list_service_type_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ListServiceType']))
		$list_service_type_model->attributes=$_GET['ListServiceType'];

		
		$list_side_type_model = new ListSideType('search');
		$list_side_type_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ListSideType']))
		$list_side_type_model->attributes=$_GET['ListSideType'];

	
		
		$list_tools_type_model = new ListToolsType('search');
		$list_tools_type_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ListToolsType']))
		$list_tools_type_model->attributes=$_GET['ListToolsType'];

		
		$this->render('index', array(

			'list_building_type_model' => $list_building_type_model, //1
			'list_glass_type_model' => $list_glass_type_model, //2
			'list_quality_type_model' => $list_quality_type_model, //3			
			'list_access_type_model' => $list_access_type_model,  //4
			'list_display_for_agent_model' => $list_display_for_agent_model, //5
			'list_equipment_type_model' => $list_equipment_type_model, //6			
			'list_pane_size_type_model' => $list_pane_size_type_model, //7			
			'list_service_type_model' => $list_service_type_model, //8
			'list_side_type_model' => $list_side_type_model, //9
			'list_tools_type_model' => $list_tools_type_model, //10
			
		)
		);
	
	}

	public function actionDelete($id,$model_name) { // delete for all table/models
			$model = $model_name::model()->findByPk($id);
			$model->delete();
	}
	
	public function actionUpdate_list_buliding_type() {
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_buliding_type_id = isset($_POST['list_buliding_type_id']) ? $_POST['list_buliding_type_id'] : '';
		$list_buliding_type_name = isset($_POST['list_buliding_type_name']) ? trim($_POST['list_buliding_type_name']) : '';
		
		if(! empty($list_buliding_type_name)) {
			$model = ListBuildingType::model()->findByPk($list_buliding_type_id);			
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_buliding_type_name;
			$model->save();
		
		}
	}
		
	public function actionAdd_list_buliding_type() {
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_buliding_type_name = isset($_POST['list_buliding_type_name']) ? trim($_POST['list_buliding_type_name']) : '';
		
		if(! empty($list_buliding_type_name)) {
		$model = ListBuildingType::model()->findByAttributes(array('name'=>$list_buliding_type_name));
		if(isset($model->id) && $model->id > 0 ) {
			echo '1'; exit;
		}
		else {
			$model=new ListBuildingType;
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_buliding_type_name;
			$model->save();
		}
		}
	}
	

	 public function actionAdd_list_glass_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_glass_type_name = isset($_POST['list_glass_type_name']) ? trim($_POST['list_glass_type_name']) : '';
		
		if(! empty($list_glass_type_name)) {
		$model = ListGlassType::model()->findByAttributes(array('name'=>$list_glass_type_name));
		if(isset($model->id) && $model->id > 0 ) {
			echo '1'; exit;
		}
		else {
			$model=new ListGlassType;
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_glass_type_name;
			$model->save();
		}
		}
	}
	//End Add ListGalssType
	//Update ListGalssType
	 public function actionUpdate_list_glass_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_glass_type_id = isset($_POST['list_glass_type_id']) ? trim($_POST['list_glass_type_id']) : '';
		$list_glass_type_name = isset($_POST['list_glass_type_name']) ? trim($_POST['list_glass_type_name']) : '';
		
		if(! empty($list_glass_type_name)) {
	
			$model=ListGlassType::model()->findByPk($list_glass_type_id);	
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_glass_type_name;
			$model->save();
		
		}
	}
	//End Update ListGalssType
	
	
	//Add ListQualityType
	 public function actionAdd_list_quality_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_quality_type_name = isset($_POST['list_quality_type_name']) ? trim($_POST['list_quality_type_name']) : '';
		
		if(! empty($list_quality_type_name)) {
		$model = ListQualityType::model()->findByAttributes(array('name'=>$list_quality_type_name));
		if(isset($model->id) && $model->id > 0 ) {
			echo '1'; exit;
		}
		else {
			$model=new ListQualityType;
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_quality_type_name;
			$model->save();
		}
		}
	}
	//End Add ListQualityType
	
		//Update ListQualityType
	 public function actionUpdate_list_quality_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_quality_type_id = isset($_POST['list_quality_type_id']) ? trim($_POST['list_quality_type_id']) : '';
		$list_quality_type_name = isset($_POST['list_quality_type_name']) ? trim($_POST['list_quality_type_name']) : '';
		
		if(! empty($list_quality_type_name)) {
		
   		    $model=ListQualityType::model()->findByPk($list_quality_type_id);
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_quality_type_name;
			$model->save();
		
		}
	}
	//End Update ListQualityType
	
		//Add ListAccessType
	 public function actionAdd_list_access_type() { 
	
	    $list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_access_type_name = isset($_POST['list_access_type_name']) ? trim($_POST['list_access_type_name']) : '';
		$list_access_type_time_per_quantity = isset($_POST['list_access_type_time_per_quantity']) ? trim($_POST['list_access_type_time_per_quantity']) : '';
		$list_access_type_setup_time = isset($_POST['list_access_type_setup_time']) ? trim($_POST['list_access_type_setup_time']) : '';
		if(! empty($list_access_type_name)) {
		$model = ListAccessType::model()->findByAttributes(array('name'=>$list_access_type_name));
		$model = ListAccessType::model()->findByAttributes(array('name'=>$list_access_type_time_per_quantity));
		$model = ListAccessType::model()->findByAttributes(array('name'=>$list_access_type_setup_time));
		if(isset($model->id) && $model->id > 0 ) {
			echo '1'; exit;
		}
		else {
			$model=new ListAccessType;
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_access_type_name;
			$model->time_per_quantity = $list_access_type_time_per_quantity;
			$model->setup_time = $list_access_type_setup_time;
			$model->save();
		}
		}
	}
	//End Add ListAccessType
	//Update ListAccessType
	 public function actionUpdate_list_access_type() { 
	
	    $list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_access_type_id = isset($_POST['list_access_type_id']) ? trim($_POST['list_access_type_id']) : '';
		$list_access_type_name = isset($_POST['list_access_type_name']) ? trim($_POST['list_access_type_name']) : '';
		$list_access_type_time_per_quantity = isset($_POST['list_access_type_time_per_quantity']) ? trim($_POST['list_access_type_time_per_quantity']) : '';
		$list_access_type_setup_time = isset($_POST['list_access_type_setup_time']) ? trim($_POST['list_access_type_setup_time']) : '';
		if(! empty($list_access_type_name)) {
	
			$model = ListAccessType::model()->findByPk($list_access_type_id);
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_access_type_name;
			$model->time_per_quantity = $list_access_type_time_per_quantity;
			$model->setup_time = $list_access_type_setup_time;
			$model->save();
		}
	}
	//End Update ListAccessType
	
	
	
		//Add ListDisplayForClient
	 public function actionAdd_list_display_for_client() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_display_for_agent_name = isset($_POST['list_display_for_agent_name']) ? trim($_POST['list_display_for_agent_name']) : '';
		
		if(! empty($list_display_for_agent_name)) {
		$model = ListDisplayForClient::model()->findByAttributes(array('name'=>$list_display_for_agent_name));
		if(isset($model->id) && $model->id > 0 ) {
			echo '1'; exit;
		}
		else {
			$model=new ListDisplayForClient;
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_display_for_agent_name;
			$model->save();
		}
		}
	} 
	//End Add ListDisplayForClient
	
	//Update ListDisplayForClient
	 public function actionUpdate_list_display_for_client() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_display_for_agent_id = isset($_POST['list_display_for_agent_id']) ? trim($_POST['list_display_for_agent_id']) : '';
		$list_display_for_agent_name = isset($_POST['list_display_for_agent_name']) ? trim($_POST['list_display_for_agent_name']) : '';
		
		if(! empty($list_display_for_agent_name)) {
		
			$model= ListDisplayForClient::model()->findByPk($list_display_for_agent_id);
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_display_for_agent_name;
			$model->save();
		}
	} 
	//End Update ListDisplayForClient
	
		//Add ListEquipmentType
 	 public function actionAdd_list_equipment_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_equipment_type_name = isset($_POST['list_equipment_type_name']) ? trim($_POST['list_equipment_type_name']) : '';
		$list_equipment_type_cost_per_day = isset($_POST['list_equipment_type_cost_per_day']) ? trim($_POST['list_equipment_type_cost_per_day']) : '';
		if(! empty($list_equipment_type_name)) {
		$model = ListEquipmentType::model()->findByAttributes(array('name'=>$list_equipment_type_name));
		if(isset($model->id) && $model->id > 0 ) {
			echo '1'; exit;
		}
		else {
			$model=new ListEquipmentType;
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_equipment_type_name;
			$model->cost_per_day = $list_equipment_type_cost_per_day;
			$model->save();
		}
		}
	} 
	//End Add ListEquipmentType
	
		//Update ListEquipmentType
 	 public function actionUpdate_list_equipment_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_equipment_type_id = isset($_POST['list_equipment_type_id']) ? trim($_POST['list_equipment_type_id']) : '';
		$list_equipment_type_name = isset($_POST['list_equipment_type_name']) ? trim($_POST['list_equipment_type_name']) : '';
		$list_equipment_type_cost_per_day = isset($_POST['list_equipment_type_cost_per_day']) ? trim($_POST['list_equipment_type_cost_per_day']) : '';
		if(! empty($list_equipment_type_name)) {
		
			$model= ListEquipmentType::model()->findByPk($list_equipment_type_id);
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_equipment_type_name;
			$model->cost_per_day = $list_equipment_type_cost_per_day;
			}
	} 
	//Update Add ListEquipmentType
	 
	 	 
		//Add ListPaneSizeType
	 public function actionAdd_list_pane_size_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_pane_size_type_name = isset($_POST['list_pane_size_type_name']) ? trim($_POST['list_pane_size_type_name']) : '';
		$list_pane_size_time_per_quantity = isset($_POST['list_pane_size_time_per_quantity']) ? trim($_POST['list_pane_size_time_per_quantity']) : '';
		$list_pane_size_setup_time = isset($_POST['list_pane_size_setup_time']) ? trim($_POST['list_pane_size_setup_time']) : '';
		
		if(! empty($list_pane_size_type_name)) {
		$model = ListPaneSizeType::model()->findByAttributes(array('name'=>$list_pane_size_type_name));
		$model = ListPaneSizeType::model()->findByAttributes(array('name'=>$list_pane_size_time_per_quantity));
		$model = ListPaneSizeType::model()->findByAttributes(array('name'=>$list_pane_size_setup_time));
		if(isset($model->id) && $model->id > 0 ) {
			echo '1'; exit;
		}
		else {
			$model=new ListPaneSizeType;
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_pane_size_type_name;
			$model->time_per_quantity = $list_pane_size_time_per_quantity;
			$model->setup_time = $list_pane_size_setup_time;
			$model->save();
		}
		}
	}
	//End Add ListPaneSizeType
	
		//Add ListPaneSizeType
	 public function actionUpdate_list_pane_size_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_pane_size_type_id = isset($_POST['list_pane_size_type_id']) ? trim($_POST['list_pane_size_type_id']) : '';
		$list_pane_size_type_name = isset($_POST['list_pane_size_type_name']) ? trim($_POST['list_pane_size_type_name']) : '';
		$list_pane_size_time_per_quantity = isset($_POST['list_pane_size_time_per_quantity']) ? trim($_POST['list_pane_size_time_per_quantity']) : '';
		$list_pane_size_setup_time = isset($_POST['list_pane_size_setup_time']) ? trim($_POST['list_pane_size_setup_time']) : '';
		
		if(! empty($list_pane_size_type_name)) {
			$model= ListPaneSizeType::model()->findByPk($list_pane_size_type_id);
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_pane_size_type_name;
			$model->time_per_quantity = $list_pane_size_time_per_quantity;
			$model->setup_time = $list_pane_size_setup_time;
			$model->save();
		}
	}
	//End Add ListPaneSizeType
	
	
	
		//Add ListServiceType
	 public function actionAdd_list_service_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_service_type_name = isset($_POST['list_service_type_name']) ? trim($_POST['list_service_type_name']) : '';
		$list_service_type_cost_per_hour = isset($_POST['list_service_type_cost_per_hour']) ? trim($_POST['list_service_type_cost_per_hour']) : '';
		if(! empty($list_service_type_name)) {
		$model = ListEquipmentType::model()->findByAttributes(array('name'=>$list_service_type_name));
		$model = ListEquipmentType::model()->findByAttributes(array('name'=>$list_service_type_cost_per_hour));
		if(isset($model->id) && $model->id > 0 ) {
			echo '1'; exit;
		}
		else {
			$model=new ListServiceType;
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_service_type_name;
			$model->cost_per_hour = $list_service_type_cost_per_hour;
			$model->save();
		}
		}
	}
	//End Add ListServiceType
	
	
		//Update ListServiceType
	 public function actionUpdate_list_service_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_service_type_id = isset($_POST['list_service_type_id']) ? trim($_POST['list_service_type_id']) : '';
		$list_service_type_name = isset($_POST['list_service_type_name']) ? trim($_POST['list_service_type_name']) : '';
		$list_service_type_cost_per_hour = isset($_POST['list_service_type_cost_per_hour']) ? trim($_POST['list_service_type_cost_per_hour']) : '';
		if(! empty($list_service_type_name)) {
		
			$model= ListServiceType::model()->findByPk($list_service_type_id);
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_service_type_name;
			$model->cost_per_hour = $list_service_type_cost_per_hour;
			$model->save();
	
		}
	}
	//End Update ListServiceType
	
	//Add ListSideType
	 public function actionAdd_list_side_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_side_type_name = isset($_POST['list_side_type_name']) ? trim($_POST['list_side_type_name']) : '';
		
		if(! empty($list_side_type_name)) {
		$model = ListSideType::model()->findByAttributes(array('name'=>$list_side_type_name));
		if(isset($model->id) && $model->id > 0 ) {
			echo '1'; exit;
		}
		else {
			$model=new ListSideType;
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_side_type_name;
			$model->save();
		}
		}
	}
	//End Add ListSideType
	
		//Update ListSideType
	 public function actionUpdate_list_side_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_side_type_id = isset($_POST['list_side_type_id']) ? trim($_POST['list_side_type_id']) : '';
		$list_side_type_name = isset($_POST['list_side_type_name']) ? trim($_POST['list_side_type_name']) : '';
		
		if(! empty($list_side_type_name)) {
			$model= ListSideType::model()->findByPk($list_side_type_id);
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_side_type_name;
			$model->save();
		}
	}
	//End Update ListSideType
	
	//ADD ListToolsType
	 public function actionAdd_list_tools_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_tools_type_name = isset($_POST['list_tools_type_name']) ? trim($_POST['list_tools_type_name']) : '';
		
		if(! empty($list_tools_type_name)) {
		$model = ListToolsType::model()->findByAttributes(array('name'=>$list_tools_type_name));
		if(isset($model->id) && $model->id > 0 ) {
			echo '1'; exit;
		}
		else {
			$model=new ListToolsType;
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_tools_type_name;
			$model->save();
		}
		}
	}
	//End Add ListToolsType
	
	//Update ListToolsType
	 public function actionUpdate_list_tools_type() { 
	
		$list_item_id = isset($_POST['list_item_id']) ? $_POST['list_item_id'] : '';
		$list_tools_type_id = isset($_POST['list_tools_type_id']) ? trim($_POST['list_tools_type_id']) : '';
		$list_tools_type_name = isset($_POST['list_tools_type_name']) ? trim($_POST['list_tools_type_name']) : '';
		
		if(! empty($list_tools_type_name)) {
			$model= ListToolsType::model()->findByPk($list_tools_type_id);
			$model->list_item_id = $list_item_id;
			$model->status = '1';
			$model->name = $list_tools_type_name;
			$model->save();
		}
	}
	//Update ListToolsType
	
	 //return building type columns
	 public function actionGetBuldingTypeColumns($id) {
	 $model = ListBuildingType::model()->findByPk($id);
	 $data['id'] = $model->id;
	 $data['name'] = $model->name;
	 echo json_encode($data);	exit;	
	 }
	 
	 
	
		//return Glass type columns 
	 public function actionGetGlassTypeColumns($id) {
	 $model = ListGlassType::model()->findByPk($id);
	 $data['id'] = $model->id;
	 $data['name'] = $model->name;
	 echo json_encode($data);	exit;
	
	 }
	 
	 //return Quality type columns 
	 public function actionGetQualityTypeColumns($id) {
	 $model = ListQualityType::model()->findByPk($id);
	 $data['id'] = $model->id;
	 $data['name'] = $model->name;
	 echo json_encode($data);	exit;
	
	 }
	
	//return Access type columns 
	 public function actionGetAccessTypeColumns($id) {
	 $model = ListAccessType::model()->findByPk($id);
	 $data['id'] = $model->id;
	 $data['name'] = $model->name;
	 $data['time_per_quantity'] = $model->time_per_quantity;
	 $data['setup_time'] = $model->setup_time;
	 echo json_encode($data);	exit;
	
	 }
	 
	 //return Display For client type columns 
	 public function actionGetDisplayForClientColumns($id) {
	 $model = ListDisplayForClient::model()->findByPk($id);
	 $data['id'] = $model->id;
	 $data['name'] = $model->name;
	 echo json_encode($data);	exit;
	
	 }
	 
	  //return Equipment type columns 
	 public function actionGetEquipmentTypeColumns($id) {
	 $model = ListEquipmentType::model()->findByPk($id);
	 $data['id'] = $model->id;
	 $data['name'] = $model->name;
     $data['cost_per_day'] = $model->cost_per_day;
	 echo json_encode($data);	exit;
	
	 }
	 
	 
	 
	   //return Pane Size type columns 
	 public function actionGetPaneSizeTypeColumns($id) {
	 $model = ListPaneSizeType::model()->findByPk($id);
	 $data['id'] = $model->id;
	 $data['name'] = $model->name;
     $data['time_per_quantity'] = $model->time_per_quantity;
	 $data['setup_time'] = $model->setup_time;
	 echo json_encode($data);	exit;
	
	 }
	 
	 
	 
	    //return Service type columns 
	 public function actionGetServiceTypeColumns($id) {
	 $model = ListServiceType::model()->findByPk($id);
	 $data['id'] = $model->id;
	 $data['name'] = $model->name;
     $data['cost_per_hour'] = $model->cost_per_hour;
	 echo json_encode($data);	exit;
	
	 }
	 
	 
	 
	   //return Side type columns 
	 public function actionGetSideTypeColumns($id) {
	 $model = ListSideType::model()->findByPk($id);
	 $data['id'] = $model->id;
	 $data['name'] = $model->name;
     echo json_encode($data);	exit;
	
	 }
	 
	    //return Tool type columns 
	 public function actionGetToolsTypeColumns($id) {
	 $model = ListToolsType::model()->findByPk($id);
	 $data['id'] = $model->id;
	 $data['name'] = $model->name;
     echo json_encode($data);	exit;
	
	 }
}