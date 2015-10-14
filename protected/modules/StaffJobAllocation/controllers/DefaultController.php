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
				'actions'=>array('UpdateSS','index','UpdateRightSideBar','DeleteJobWorkingRecord','getWorkingDateStaffs','getWorkingDateSupervsior','AddUpdateWorkingDate','get_extra_scope'),
				'users' => array('system_owner', 'state_manager', 'operation_manager', 'agent', 'supervisor'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	
	
	public function actionUpdateSS() {
		$model = JobStaff::model()->findAll();
		$array = array();
		foreach($model  as $staff) {
			//echo '<pre>'; print_r($staff); echo '</pre>';
		
			
			$site_supervisor_model = JobSiteSupervisor::model()->findByAttributes(
                array(
                    'job_id' => $staff->job_id, 'agent_id' => $this->agent_id,
                )
			);
			
			if($site_supervisor_model !== null) {
				
					if(! in_array($staff->job_id,$array)) {
						
						$site_supervisor_model->job_date = $staff->job_date;
						$site_supervisor_model->save();
						
						$array[] = $staff->job_id;	
					}
			}
			
		}
		
	}

	public function actionDeleteJobWorkingRecord(){
		$job_id = isset($_REQUEST['job_id']) ? $_REQUEST['job_id'] : 0;	
		$working_date = isset($_REQUEST['working_date']) ? $_REQUEST['working_date'] : '0000-00-00';	
		$day_night = 'NIGHT';
		
		
        $Criteria = new CDbCriteria();
		$Criteria->condition = "job_id=" . $job_id ." && working_date='".$working_date."'" ." && day_night='".$day_night."' && $this->where_agent_condition";
		$model_exist_record = JobWorking::model()->find($Criteria);

		$model = JobWorking::model()->findByPk($model_exist_record->id);
		if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
		
		JobStaff::model()->deleteAll(array("condition" => "job_id = " . $job_id . " and job_date ='" . $working_date . "' and day_night ='" . $day_night . "' && $this->where_agent_condition"));
		JobSiteSupervisor::model()->deleteAll(array("condition" => "job_id = " . $job_id . " and job_date ='" . $working_date . "' and day_night ='" . $day_night . "' && $this->where_agent_condition"));
		
		$model->delete();
		
	}
        
    public function actionGet_extra_scope(){
            $job_id = isset($_REQUEST['job_id']) ? $_REQUEST['job_id'] : 0;
            $model = QuoteJobs::model()->findByPk($job_id);
            echo $model->extra_scope_of_work; exit;
        }

    public function actionAddUpdateWorkingDate() {
		
		$job_id = isset($_REQUEST['job_id']) ? $_REQUEST['job_id'] : 0;	
		$working_date = isset($_REQUEST['working_date']) ? $_REQUEST['working_date'] : '0000-00-00';	
		$day_night = isset($_REQUEST['day_night']) ? $_REQUEST['day_night'] : '';	
        $last_day_night = isset($_REQUEST['last_day_night']) ? $_REQUEST['last_day_night'] : 'DAY';	                
		$yard_time = isset($_REQUEST['yard_time']) ? $_REQUEST['yard_time'] : '';	
		$site_time = isset($_REQUEST['site_time']) ? $_REQUEST['site_time'] : '';	
		$finish_time = isset($_REQUEST['finish_time']) ? $_REQUEST['finish_time'] : '';	
		
                if($job_id === 0) exit;
                if($last_day_night === '0000-00-00') exit;
                if(empty($day_night) === '0000-00-00') exit;
                
                if($last_day_night != $day_night) {
                   
              
        $Criteria = new CDbCriteria();
		$Criteria->condition = "job_id=" . $job_id ." && working_date='".$working_date."'" ." && day_night='".$day_night."'";
		$same_two_day_night = JobWorking::model()->find($Criteria);

                    
                   
                }
                
                if(isset($same_two_day_night) && $same_two_day_night !== NULL) {
                     echo 'same_day_night_switch';  exit;
                }
                
		$Criteria = new CDbCriteria();
		$Criteria->condition = "job_id=" . $job_id ." && working_date='".$working_date."'" ." && day_night='".$last_day_night."'";
		$job_working_model_exist = JobWorking::model()->find($Criteria);

		if($job_working_model_exist === NULL){
			
				$model = new JobWorking;
				$model->job_id = $job_id;
				$model->working_date = $working_date;
				$model->day_night = $day_night;
				$model->yard_time = $yard_time;
				$model->site_time = $site_time;
				$model->finish_time = $finish_time;
				$model->working_status = '1';
				if($model->save()) {
					echo 'inserted'; 
                                        

Yii::app()->db
    ->createCommand("UPDATE hc_job_site_supervisor SET day_night = '".$day_night."' WHERE job_id=" . $job_id ." && job_date='".$working_date."'" ." && day_night='".$last_day_night."'")
    ->execute();   

Yii::app()->db
    ->createCommand("UPDATE hc_job_staff SET day_night = '".$day_night."' WHERE job_id=" . $job_id ." && job_date='".$working_date."'" ." && day_night='".$last_day_night."'")
    ->execute();                                        
                                        
                                        
	exit;			}
			
			
		} else {
			
				$model = JobWorking::model()->findByPk($job_working_model_exist->id);;
				$model->job_id = $job_id;
				$model->working_date = $working_date;
				$model->day_night = $day_night;
				$model->yard_time = $yard_time;
				$model->site_time = $site_time;
				$model->finish_time = $finish_time;
				$model->working_status = '1';
				if($model->save()) {
					echo 'updated'; 

Yii::app()->db
    ->createCommand("UPDATE hc_job_site_supervisor SET day_night = '".$day_night."' WHERE job_id=" . $job_id ." && job_date='".$working_date."'" ." && day_night='".$last_day_night."'")
    ->execute();   

Yii::app()->db
    ->createCommand("UPDATE hc_job_staff SET day_night = '".$day_night."' WHERE job_id=" . $job_id ." && job_date='".$working_date."'" ." && day_night='".$last_day_night."'")
    ->execute();                                        
                                                           
                                        exit;
				}
		}
		exit;
	}
	
	
	public function actionUpdateRightSideBar() {
		
		$result = array();
		
		$job_id = isset($_REQUEST['job_id']) ? $_REQUEST['job_id'] : 0;
		$working_date = isset($_REQUEST['working_date']) ? $_REQUEST['working_date'] : '';
        	$day_night = isset($_REQUEST['day_night']) ? $_REQUEST['day_night'] : 'DAY';
		
		
		if($job_id > 0) { 
			
			
			
		$Criteria = new CDbCriteria();
		$Criteria->condition = "job_id=" . $job_id ." && working_date='".$working_date."'" ." && day_night='".$day_night."' && $this->where_agent_condition";
		$job_working_model_exist = JobWorking::model()->find($Criteria);

		if($job_working_model_exist === NULL) {
			
				$model = new JobWorking;
				$model->job_id = $job_id;
				$model->working_date = $working_date;
				$model->day_night = $day_night;
				$model->working_status = '1';
				$model->save();
			
			
		} 			
			
			
			
			
					// job details
					$model = QuoteJobs::model()->findByPk($job_id);
					$result['job_id'] = $model->id;
					$result['staff_required'] = $model->staff_required;

					if ($model->signed_off === 'Yes') {
						$job_status = 'Signed Off';
					} else {
						$job_status = $model->job_status;
					}

					$result['job_status'] = $job_status;
					$result['job_total_working_hour'] = $model->job_total_working_hour;

					// quote detials
					$quote_model = Quotes::model()->findByPk($model->quote_id);
					// site details

                        $site_model = ContactsSite::model()->findByPk($quote_model->site_id);
                                    // service details
                        $service_model = Service::model()->findByPk($quote_model->service_id);


                        $result['site_name'] = $site_model->site_name;
                        $result['service_name'] = $service_model->service_name;
                        
                        
                        // quote service/scope
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "job_id = $job_id";
                        $job_services_model = QuoteJobServices::model()->findAll($Criteria);
                        $scope = '';
                        foreach($job_services_model as $scope_service) {
                        $scope .= $scope_service->service_description.'.&nbsp;';
                        }
                        $scope .= '<span id="extra_scope_of_work_p">'.$model->extra_scope_of_work.'</span>';
                        
                        $result['scope'] = $scope;
                        
                        
                        $result['extra_scope_of_work'] = '';
                        
                        if(!empty($model->extra_scope_of_work))
                        $result['extra_scope_of_work'] = $model->extra_scope_of_work;
                                
                        $result['default_mysql_working_date'] = $working_date;
                        $result['working_date'] = date("d-m-Y", strtotime($working_date));

                        $timestamp = strtotime($working_date);
                        $startDay = date('D', $timestamp);
                        $result['working_day'] = $startDay;                        

                            // last selected supervisor
                            $Criteria = new CDbCriteria();
                            $Criteria->condition = "job_id = $job_id && $this->where_agent_condition";
                            $job_supervisor = JobSupervisor::model()->find($Criteria);
                            $result['supervisor_id'] = 0;
                            $result['supervisor_name'] = '';
                            if($job_supervisor !== NULL) {
                                $result['supervisor_id'] = $job_supervisor->user_id;
                                $result['supervisor_name'] = $job_supervisor->name;
                            }

                        
                            // last selected site supervisor
                           $Criteria = new CDbCriteria();
                           $Criteria->condition = "job_id=" . $job_id ." && job_date='".$working_date."'" ." && day_night='".$day_night."' && $this->where_agent_condition";
                           $job_site_supervisor = JobSiteSupervisor::model()->find($Criteria);

                           $result['site_supervisor_id'] = 0;
                           $result['site_supervisor_name'] = '';
                           if($job_site_supervisor !== NULL) {
                               $result['site_supervisor_id'] = $job_site_supervisor->user_id;
                               $result['site_supervisor_name'] = $job_site_supervisor->name;
                           }
                        
	
	$connection = Yii::app()->db;  
	$scratched_staff_user_ids = array();
	$scratched_staff_user_ids_key_count = array();
			
	$yesterday_night_workers = array();
		if($day_night === 'DAY') {
		$yesterday_working_date = date('Y-m-d', strtotime('-1 day', strtotime($working_date)));
		$query = "select user_id from hc_job_staff where  job_date='".$yesterday_working_date."' && day_night='NIGHT' && $this->where_agent_condition";
		$scratched_staff_date = $connection->createCommand($query)->queryAll();   
		foreach ($scratched_staff_date as $row) {
			$yesterday_night_workers[] = $row['user_id'];
		}
				
		$query = "select user_id from hc_job_site_supervisor where job_date='".$yesterday_working_date."' && day_night='NIGHT' && $this->where_agent_condition";
		$scratched_staff_date = $connection->createCommand($query)->queryAll();   
		foreach ($scratched_staff_date as $row) {
			$yesterday_night_workers[] = $row['user_id'];
		}
	}
			
	$query = "select user_id, count(user_id) as selected_count from hc_job_staff where job_date='".$working_date."' && $this->where_agent_condition group by user_id";
    $scratched_staff_date = $connection->createCommand($query)->queryAll();   
    foreach ($scratched_staff_date as $row) {
        $scratched_staff_user_ids[] = $row['user_id'];
        $scratched_staff_user_ids_key_count[$row['user_id']] = $row['selected_count'];
    }
			
    $query = "select user_id, count(user_id) as selected_count from hc_job_site_supervisor where job_date='".$working_date."' && $this->where_agent_condition group by user_id";
    $scratched_staff_date = $connection->createCommand($query)->queryAll();   
    foreach ($scratched_staff_date as $row) {
        $scratched_staff_user_ids[] = $row['user_id'];
		$pre_count = isset($scratched_staff_user_ids_key_count[$row['user_id']]) ? $scratched_staff_user_ids_key_count[$row['user_id']] : 0;
		$scratched_staff_user_ids_key_count[$row['user_id']] = $pre_count + $row['selected_count'];
    }
	//echo '<pre>'; print_r($scratched_staff_user_ids_key_count); echo '</pre>';
				
						  $i=0; $sorted_staff = array();	$dummy_staff = array();	$original_staff = array();	 $staff_ids = array();
                           // last selected staff
                           $Criteria = new CDbCriteria();
                           $Criteria->condition = "job_id=" . $job_id ." && job_date='".$working_date."'" ." && day_night='".$day_night."' && $this->where_agent_condition";
                           $job_staff = JobStaff::model()->findAll($Criteria);
						  
						   foreach($job_staff as $staffUser) {
							$staff_ids[] =  $staffUser->user_id;  
						   }
			
			
                            $criteria = new CDbCriteria();
                            $criteria->select = "id,first_name,last_name";
                            $criteria->condition = "role_id in(1,3,5,6) && status='1' && $this->where_agent_condition";
                            $criteria->order = 'first_name';
                            $staff = User::model()->findAll($criteria);	
			
						
						
						foreach ($staff as $value)  { 
							if($value->first_name == 'New Staff') {
								$dummy_staff[$i]['id'] = $value->id;
								$dummy_staff[$i]['first_name'] = $value->first_name;
								$dummy_staff[$i]['last_name'] = $value->last_name;
							} else {
								$original_staff[$i]['id'] = $value->id;
								$original_staff[$i]['first_name'] = $value->first_name;
								$original_staff[$i]['last_name'] = $value->last_name;
							}
							
							$i++;
						}

						$temp_dumy_staff = array();
						for($j=1;$j<=count($dummy_staff);$j++) {
							foreach ($dummy_staff as $value)  { 
								if($value['last_name'] == $j)
								$temp_dumy_staff[] = $value;
							}
						}
					
						$dummy_staff = $temp_dumy_staff;
						$sorted_staff = array_merge($original_staff,$dummy_staff);

                        // staff checkboxes
                        $staff_html_text = '<table width="100%">';
                        $total_available_staff = count($staff); $i=0;

                        foreach ($sorted_staff as $value)  { 

                        if($i == 0 || $i%3 ==0)
                                $staff_html_text .= '<tr>';

							$staff_html_text .= '<td  width="33%" >';
							
							$checkbox_status = '';
							$style_status = '';

							
							if(in_array($value['id'],$staff_ids))
							$checkbox_status = 'checked="checked"';
						
							if(isset($scratched_staff_user_ids_key_count[$value['id']])) {
							if($scratched_staff_user_ids_key_count[$value['id']] == 1)								
							$style_status = 'style="text-decoration: line-through; color:#000000;"'; // black scratch
							
							if($scratched_staff_user_ids_key_count[$value['id']] > 1)								
							$style_status = 'style="text-decoration: line-through; color:#FF0000;"'; // red scratch
							}
							
							if(in_array($value['id'],$yesterday_night_workers))
							$style_status = 'style="text-decoration: line-through; color:#006400;"'; // green scratch
							
							$staff_html_text .= '<span '.$style_status.'>';
							$staff_html_text .= '<input '.$checkbox_status.' class="chk" name="assign_staff_id" type="checkbox" value="'.$value['id'].'" />&nbsp;&nbsp;&nbsp;'.$value['first_name'].' '.$value['last_name'];
							$staff_html_text .= '</span>';

							$staff_html_text .= '</td>';
								   
                        if($i > 0 && (($i+1)%3 == 0 || ($i+1) == $total_available_staff))
                                $staff_html_text .= '</tr>';

                                $i++;
                        }
                        $staff_html_text .= '</table>';

                        $result['staff_html_text'] = $staff_html_text;
						
						
						
                            //times
                          // check if already record exist in job_working table
                          $Criteria = new CDbCriteria();
                          $Criteria->condition = "job_id=" . $job_id ." && working_date='".$working_date."'" ." && day_night='".$day_night."' && $this->where_agent_condition";
                          $job_working_model_exist = JobWorking::model()->find($Criteria);

                          if($job_working_model_exist === NULL) {
                          $result['yard_time'] = date("g:i A", strtotime($model->job_started_time));
                          $result['site_time'] = date("g:i A", strtotime($model->job_started_time));
                          $result['finish_time'] = date("g:i A", strtotime($model->job_end_time));
                          $result['day_night_radio_text'] = '<input checked="checked" type="radio" value="DAY" name="job_day_or_night">&nbsp;DAY &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" value="NIGHT" name="job_day_or_night">&nbsp;NIGHT';
                          } else {
                          $result['yard_time'] = $job_working_model_exist->yard_time;
                          $result['site_time'] = $job_working_model_exist->site_time;
                          $result['finish_time'] = $job_working_model_exist->finish_time;
                            if($job_working_model_exist->day_night == 'DAY')
                                    $result['day_night_radio_text'] = '<input checked="checked" type="radio" value="DAY" name="job_day_or_night">&nbsp;DAY &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" value="NIGHT" name="job_day_or_night">&nbsp;NIGHT';
                              else
                                    $result['day_night_radio_text'] = '<input type="radio" value="DAY" name="job_day_or_night">&nbsp;DAY &nbsp;&nbsp;&nbsp;&nbsp;<input checked="checked" type="radio" value="NIGHT" name="job_day_or_night">&nbsp;NIGHT';	  
			}
					
						
						
						
		}
		
			echo json_encode($result); exit;
		
	}
	
	
	public function actionIndex() {
           
            // echo '<pre>';  print_r($_REQUEST); echo '</pre>'; exit;
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/staff_job_allocation.js', CClientScript::POS_END);
            
			
            $current_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 5, date('Y')));
            $Date_After_Five_Days = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 10, date('Y')));
			
            $job_from_date = isset($_REQUEST['job_from_date']) ? $_REQUEST['job_from_date'] : $current_date;
            $job_to_date = isset($_REQUEST['job_to_date']) ? $_REQUEST['job_to_date'] : $Date_After_Five_Days;
            
            $jobs = array();
            
            // find all jobs between dates
            if(!empty($job_from_date) && !empty($job_to_date) && !isset($_REQUEST['JobWorking'])) {
                $jobs  = $this->findJobsBetweenDates($job_from_date,$job_to_date);
            }
            
            
            
             // add new record/row
            $model = new JobWorking;
            $model->day_night = 'NIGHT';
            if(isset($_REQUEST['JobWorking'])) {	
                
                $model->attributes=$_REQUEST['JobWorking'];                
                $model->working_status = '1';
                
                $day_model = new JobWorking;
                $day_model->attributes=$_REQUEST['JobWorking'];
               
                
                
                if($model->day_night === 'NIGHT') {
                    $Criteria = new CDbCriteria();
                    $Criteria->condition = "job_id=" . $model->job_id ." && working_date='".$model->working_date."'" ." && day_night='".$model->day_night."' && $this->where_agent_condition";
                    $job_working_model_exist = JobWorking::model()->find($Criteria);

                    if($job_working_model_exist === NULL){                    
                        if($model->save()){
                            
							
							$user_id = Yii::app()->user->id;	
							$user_model = User::model()->findByPk($user_id);
					
							$job_id = $model->job_id;
                       
								$supervisor_model = JobSupervisor::model()->findByAttributes(
										array(
											'job_id' => $job_id, 'agent_id' => $this->agent_id,
										)
								);
								
								$deleted = 0;
								if($supervisor_model !== null && $supervisor_model->user_id != $user_id) {
									$s_model = JobSupervisor::model()->findByPk($supervisor_model->id);
									$s_model->delete();
									$deleted = 1;
								}
								
								if($supervisor_model === null || $deleted == 1) {
									$current_user_id = Yii::app()->user->id;	
									$user_model = User::model()->findByPk($current_user_id);
			
									$new_supervisor_model = new JobSupervisor;
									$new_supervisor_model->job_id = $job_id;
									$new_supervisor_model->user_id = $user_id;
									$new_supervisor_model->name = $user_model->first_name . ' ' . $user_model->last_name;
									$new_supervisor_model->email = $user_model->email;
									$new_supervisor_model->phone = $user_model->home_phone;
									$new_supervisor_model->mobile = $user_model->mobile_phone;
									$new_supervisor_model->save();
								}
                            
                         Yii::app()->user->setFlash('success', "Data saved!");   
                        // $this->refresh();
                        }
                    } else {
                    Yii::app()->user->setFlash('danger', "This job is already exist on the date for your selection inputs.");
                }
                    
                } else {
                    Yii::app()->user->setFlash('danger', "Only night jobs, you can add");
                }
                
                 $jobs  = $this->findJobsBetweenDates($job_from_date,$job_to_date);
            }
            

            
            
        // supervisor
        $criteria = new CDbCriteria();
        $criteria->select = "id,first_name,last_name,mobile_phone";
        $criteria->condition = "role_id in(1,5) && status='1' && $this->where_agent_condition";
        $criteria->order = 'first_name';
        $supervisors = User::model()->findAll($criteria);

        // site supervisor
        $criteria = new CDbCriteria();
        $criteria->select = "id,first_name,last_name,mobile_phone";
        $criteria->condition = "role_id in(1,5,6) && status='1' && $this->where_agent_condition";
        $criteria->order = 'first_name';
        $site_supervisors = User::model()->findAll($criteria);    

        // staff
        $criteria = new CDbCriteria();
        $criteria->select = "id,first_name,last_name,mobile_phone";
        $criteria->condition = "role_id in(1,3,5,6) && status='1' && $this->where_agent_condition";
        $criteria->order = 'first_name';
        $staff = User::model()->findAll($criteria);            
            
            
            $this->render('index', array(
                'jobs'=>$jobs,
                'model'=>$model,
                'job_from_date'=>$job_from_date,
                'job_to_date'=>$job_to_date,
                'supervisors' => $supervisors,
                'site_supervisors' => $site_supervisors,
                'staff' => $staff,
                
            ));
	}
        
    public function findJobsBetweenDates($job_from_date,$job_to_date) {
            
            $connection = Yii::app()->db;
            $final_jobs = array();
            $selected_fields = array('id','quote_id','building_id','job_status','si_staff_contractor','si_client','job_started_date','job_end_date','job_started_time','job_end_time','extra_scope_of_work','job_note','note_for_client');
            $select_fields_str = implode(',',$selected_fields);
            $query = "select $select_fields_str from {{quote_jobs}} where $this->where_agent_condition && approval_status = 'Approved By Admin' && job_end_date >= '".$job_from_date."' && job_started_date <= '".$job_to_date."' && booked_status= 'Booked' order by job_started_date ";
            
			if(Yii::app()->user->name === 'supervisor')	{
			
				$current_user_id = Yii::app()->user->id;	
				$user_model = User::model()->findByPk($current_user_id);
		
				if($user_model->view_jobs == '0') {
					$valid_jobs_model = JobSupervisor::model()->findAll(array("condition" => "user_id= $current_user_id && $this->where_agent_condition"));
					$valid_job_ids = array();
					foreach($valid_jobs_model as $allocated_staff_details) {
						$valid_job_ids[] = $allocated_staff_details->job_id;
					}
					if(count($valid_job_ids) > 0) {
					$valid_job_ids_str = implode(',',$valid_job_ids);	
						$query = "select $select_fields_str from {{quote_jobs}} where $this->where_agent_condition && approval_status = 'Approved By Admin' && job_status = 'NotStarted' && job_end_date >= '".$job_from_date."' && job_started_date <= '".$job_to_date."' && booked_status= 'Booked' && id IN ($valid_job_ids_str) order by job_started_date";
					}
				}
			}
			
			$result = $connection->createCommand($query)->queryAll();
            
            $i=0; 
            
            foreach($result as $row) {
                $quote_model = Quotes::model()->findByPk($row['quote_id']);
                $site_model = ContactsSite::model()->findByPk($quote_model->site_id);
                $service_model = Service::model()->findByPk($quote_model->service_id);
                
                $job_start_date = $row['job_started_date'];
                $job_end_date = $row['job_end_date'];
                $job_id = $row['id'];
                
                    if($job_start_date != $job_end_date ) {
                           // for multiple days job
                        
                        $date1 = new DateTime($job_start_date);
                        $date2 = new DateTime($job_end_date);
                        $diff = $date2->diff($date1)->format("%a");
                        $job_working_date = $job_start_date;
                        while($diff >= 0) {
                        
			foreach($selected_fields as $basic_fields) {
                            $final_jobs[$i][$basic_fields] = $row[$basic_fields];
                        }
                        
                        $final_jobs[$i]['site_name'] = $site_model->site_name;
                        $final_jobs[$i]['service_name'] = $service_model->service_name;
                        $final_jobs[$i]['job_working_date'] = $job_working_date; 
                        $timestamp = strtotime($job_working_date);
                        $startDay = date('D', $timestamp);
                        $final_jobs[$i]['job_working_day'] = $startDay;                        
                        $working_date = $job_working_date;
                       
// quote service/scope
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "job_id = $job_id";
                        $job_services_model = QuoteJobServices::model()->findAll($Criteria);
                        $scope = '';
                        foreach($job_services_model as $scope_service) {
                        $scope .= $scope_service->service_description.'<br/>';
                        }
                        $scope .= '<span class="'.$job_id.'_extra_scope_of_work_p">'.$row['extra_scope_of_work'].'</span>';
                        
                        $final_jobs[$i]['scope'] = $scope;
                        $final_jobs[$i]['extra_scope_of_work'] = '';
                        if(!empty($model->extra_scope_of_work))
                        $final_jobs[$i]['extra_scope_of_work'] = $row['extra_scope_of_work'];
                        
                        
                        
                        $day_night = 'NIGHT';         
                        // check if same job date exist for day and night
			$Criteria = new CDbCriteria();
                        $Criteria->condition = "job_id=" . $job_id ." && working_date='".$working_date."' && $this->where_agent_condition";
                        $job_working_model_exist_All = JobWorking::model()->findAll($Criteria);
			
                        if(count($job_working_model_exist_All) === 0) {
                            $final_jobs[$i]['yard_time'] = date("g:i A", strtotime($row['job_started_time']));
                            $final_jobs[$i]['site_time'] = date("g:i A", strtotime($row['job_started_time']));
                            $final_jobs[$i]['finish_time'] = date("g:i A", strtotime($row['job_end_time']));
                            $day_night = 'DAY';
                        } else {
                            
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "job_id=" . $job_id ." && working_date='".$working_date."' && day_night='DAY' && $this->where_agent_condition";
                        $job_working_model_exist = JobWorking::model()->find($Criteria);
			    
                        if($job_working_model_exist !== NULL)    {
                            
                            $final_jobs[$i]['yard_time'] = $job_working_model_exist->yard_time;
                            $final_jobs[$i]['site_time'] = $job_working_model_exist->site_time;
                            $final_jobs[$i]['finish_time'] = $job_working_model_exist->finish_time;
                            $day_night = 'DAY';
                        }
                            
                        }
						
			$final_jobs[$i]['job_working_day_night'] = $day_night;					    
                        $final_jobs[$i]['site_supervisor_name'] = $this->getWorkingDateSupervsior($job_id,$working_date,$day_night);
                        $final_jobs[$i]['staff_names'] = $this->getWorkingDateStaffs($job_id,$working_date,$day_night);
                        
                        
                        
			
                        if(count($job_working_model_exist_All) === 2){
                                $i++;
                                $final_jobs[$i] = $final_jobs[$i-1];
                                if($day_night == 'DAY')
                                $day_night = 'NIGHT';
                                else
                                $day_night = 'DAY';	


                                $final_jobs[$i]['job_working_day_night'] = $day_night;
                                $final_jobs[$i]['site_supervisor_name'] = $this->getWorkingDateSupervsior($job_id,$working_date,$day_night);
                                $final_jobs[$i]['staff_names'] = $this->getWorkingDateStaffs($job_id,$working_date,$day_night);

                        }
						
                        
                        $Criteria = new CDbCriteria();
                            $Criteria->condition = "job_id=" . $job_id ." && working_date='".$working_date."' && day_night='NIGHT' && $this->where_agent_condition";
                            $job_working_model_exist = JobWorking::model()->find($Criteria);
                            if($job_working_model_exist !== NULL)   {
                            $final_jobs[$i]['yard_time'] = $job_working_model_exist->yard_time;
                            $final_jobs[$i]['site_time'] = $job_working_model_exist->site_time;
                            $final_jobs[$i]['finish_time'] = $job_working_model_exist->finish_time;
                         }    
                        
                        
                        
                        $job_working_date = date('Y-m-d', strtotime($job_working_date.' + 1 days'));
                        $diff--;  $i++;

                        }
                       
                    } else { 

                        foreach($selected_fields as $basic_fields) {
                            $final_jobs[$i][$basic_fields] = $row[$basic_fields];
                        }

                        $final_jobs[$i]['site_name'] = $site_model->site_name;
                        $final_jobs[$i]['service_name'] = $service_model->service_name;
                        $final_jobs[$i]['job_working_date'] = $job_start_date;                        
                        $timestamp = strtotime($job_start_date);
                        $startDay = date('D', $timestamp);
                        $final_jobs[$i]['job_working_day'] = $startDay;
                        $working_date = $job_start_date;
                        
 // quote service/scope
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "job_id = $job_id";
                        $job_services_model = QuoteJobServices::model()->findAll($Criteria);
                        $scope = '';
                        foreach($job_services_model as $scope_service) {
                        $scope .= $scope_service->service_description.'.&nbsp;';
                        }
                        $scope .= '<span class="'.$job_id.'_extra_scope_of_work_p">'.$row['extra_scope_of_work'].'</span>';
                        
                        $final_jobs[$i]['scope'] = $scope;
                        $final_jobs[$i]['extra_scope_of_work'] = '';
                        if(!empty($model->extra_scope_of_work))
                        $final_jobs[$i]['extra_scope_of_work'] = $row['extra_scope_of_work'];
                                               
						
			 //times
                        // check if already record exist in job_working table
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "job_id=" . $job_id ." && working_date='".$working_date."'";// ." && day_night='".$day_night."'";
                        $job_working_model_exist = JobWorking::model()->find($Criteria);

                        if($job_working_model_exist === NULL) {
                        $final_jobs[$i]['yard_time'] = date("g:i A", strtotime($row['job_started_time']));
                        $final_jobs[$i]['site_time'] = date("g:i A", strtotime($row['job_started_time']));
                        $final_jobs[$i]['finish_time'] = date("g:i A", strtotime($row['job_end_time']));
						$day_night = 'DAY';
                        } else {
                        $final_jobs[$i]['yard_time'] = $job_working_model_exist->yard_time;
                        $final_jobs[$i]['site_time'] = $job_working_model_exist->site_time;
                        $final_jobs[$i]['finish_time'] = $job_working_model_exist->finish_time;
						if($job_working_model_exist->day_night == 'DAY'){
							$day_night = 'DAY';
                                                }	else {
							$day_night = 'NIGHT';
                                                }
                        }
						
						
						
			$final_jobs[$i]['job_working_day_night'] = $day_night;
                        $final_jobs[$i]['site_supervisor_name'] = $this->getWorkingDateSupervsior($job_id,$working_date,$day_night);
                        $final_jobs[$i]['staff_names'] = $this->getWorkingDateStaffs($job_id,$working_date,$day_night);
                        
  
                        
			// check if same job date exist for day and night
			$Criteria = new CDbCriteria();
                        $Criteria->condition = "job_id=" . $job_id ." && working_date='".$working_date."' && $this->where_agent_condition";// ." && day_night='".$day_night."'";
                        $job_working_model_exist_All = JobWorking::model()->findAll($Criteria);
						
						if(count($job_working_model_exist_All) === 2){
							$i++;
							$final_jobs[$i] = $final_jobs[$i-1];
							if($day_night == 'DAY')
							$day_night = 'NIGHT';
							else
							$day_night = 'DAY';	
						
							
							$final_jobs[$i]['job_working_day_night'] = $day_night;
							$final_jobs[$i]['site_supervisor_name'] = $this->getWorkingDateSupervsior($job_id,$working_date,$day_night);
							$final_jobs[$i]['staff_names'] = $this->getWorkingDateStaffs($job_id,$working_date,$day_night);

						}
						
					
                        $i++;
                    }
            }
            
			//echo '<pre>'; print_r($final_jobs); echo '</pre>';exit;
                        //$job_from_date,$job_to_date
                        $result_final_jobs = array();
                        $date1 = new DateTime($job_from_date);
                        $date2 = new DateTime($job_to_date);
                        $diff = $date2->diff($date1)->format("%a");
                        while($diff >= 0) {
                            
                            foreach($final_jobs as $job){
                                if($job['job_working_date'] == $job_from_date){ 
                                    $result_final_jobs[$job_from_date][] = $job;
                                }
                                
                            }
                            $job_from_date = date('Y-m-d', strtotime($job_from_date.' + 1 days'));
                            
                            $diff--;
                        }
            
            
            return $result_final_jobs;
        }

        
        public function getWorkingDateStaffs($job_id,$working_date,$day_night) {
             
			// last selected staff
		   $Criteria = new CDbCriteria();
		   $Criteria->condition = "job_id=" . $job_id ." && job_date='".$working_date."'" ." && day_night='".$day_night."' && $this->where_agent_condition";
		   $job_staff = JobStaff::model()->findAll($Criteria);
		   $staff_ids = array();
		   foreach($job_staff as $staffUser) {
				$staff_ids[] =  $staffUser->user_id;  
		   }

             $criteria = new CDbCriteria();
             $criteria->select = "id,first_name,last_name,mobile_phone";
             $criteria->condition = "role_id in(1,3,5,6) && status='1' && $this->where_agent_condition";
             $criteria->order = 'first_name';
             $staff = User::model()->findAll($criteria);	

            $staff_html_text = ''; $staff_html = array();
             foreach ($staff as $value)  { 
                if(in_array($value->id,$staff_ids)) 
                $staff_html[] = $value->first_name.' '.strtoupper($value->last_name[0]);;            
             }
            
                if(count($staff_html) > 0)
                $staff_html_text = implode(', ', $staff_html);

              return $staff_html_text;
        }
          
        public function getWorkingDateSupervsior($job_id,$working_date,$day_night) {
              $Criteria = new CDbCriteria();
              $Criteria->condition = "agent_id = $this->agent_id && job_id=" . $job_id ." && job_date='".$working_date."'" ." && day_night='".$day_night."' && $this->where_agent_condition";
              $job_site_supervisor = JobSiteSupervisor::model()->find($Criteria);

               $site_supervisor_name = '';
              if($job_site_supervisor !== NULL) {                 
                  $site_supervisor_name = $job_site_supervisor->name;
              }
              
              return $site_supervisor_name;
        }
      
        
        
        
        public function actionGetWorkingDateStaffs() {
            
            $job_id = isset($_REQUEST['job_id']) ? $_REQUEST['job_id'] : 0;
            $working_date = isset($_REQUEST['working_date']) ? $_REQUEST['working_date'] : '';
            $day_night = isset($_REQUEST['day_night']) ? $_REQUEST['day_night'] : '';
          
          if($job_id > 0)    {   
                  
            // last selected staff
            $Criteria = new CDbCriteria();
            $Criteria->condition = "job_id=" . $job_id ." && job_date='".$working_date."'" ." && day_night='".$day_night."' && $this->where_agent_condition";
            $job_staff = JobStaff::model()->findAll($Criteria);
            $staff_ids = array();
            foreach($job_staff as $staffUser) {
                 $staff_ids[] =  $staffUser->user_id;  
            }

             $criteria = new CDbCriteria();
             $criteria->select = "id,first_name,last_name,mobile_phone";
             $criteria->condition = "role_id in(1,3,5,6) && status='1'";
             $criteria->order = 'first_name';
             $staff = User::model()->findAll($criteria);	

            $staff_html_text = ''; $staff_html = array();
             foreach ($staff as $value)  { 
                if(in_array($value->id,$staff_ids)) 
                $staff_html[] = $value->first_name.' '.strtoupper($value->last_name[0]);
             }
           
                if(count($staff_html) > 0)
                $staff_html_text = implode(', ', $staff_html);

              echo $staff_html_text; exit;
            }  
        }
          
        public function actionGetWorkingDateSupervsior() {
           // print_r($_REQUEST);  exit;
            $job_id = isset($_REQUEST['job_id']) ? $_REQUEST['job_id'] : 0;
            $working_date = isset($_REQUEST['working_date']) ? $_REQUEST['working_date'] : '';
            $day_night = isset($_REQUEST['day_night']) ? $_REQUEST['day_night'] : '';
          
            if($job_id > 0)    {    
                        
                $Criteria = new CDbCriteria();
                $Criteria->condition = "job_id=" . $job_id ." && job_date='".$working_date."'" ." && day_night='".$day_night."' && $this->where_agent_condition";
                $job_site_supervisor = JobSiteSupervisor::model()->find($Criteria);

                 $site_supervisor_name = '';
                if($job_site_supervisor !== NULL) {                 
                    $site_supervisor_name = $job_site_supervisor->name;
                }
                echo $site_supervisor_name; exit;
                
            }
             
        }
        
        
}	
