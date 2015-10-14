<?php 

class QuoteJobService extends CApplicationComponent {		
	
		public static function addFrequencyJobs($job_id,$period_start_date,$period_end_date,$frequency_type,$interval_days,$staff_required,$agent_id) {
		$jobs_dates_array = array();			
		$frequency_model = FrequencyType::model()->findByPk($frequency_type);			
		$start_date = $period_start_date;			
		$end_date = date('Y-m-d', strtotime($start_date.' + '.$interval_days.' days'));			
		$i=0;				
		while($end_date <=  $period_end_date) {
			$start_date = date('Y-m-d', strtotime($start_date.' '.$frequency_model->value)); // find next job start date					
			$end_date = date('Y-m-d', strtotime($start_date.' + '.$interval_days.' days'));	 // find next job end date
			if($end_date >  $period_end_date)					break;										
			$jobs_dates_array[$i]['job_started_date'] = $start_date;					
			$jobs_dates_array[$i]['job_end_date'] = $end_date;					
			$i++;													
			}									
			foreach($jobs_dates_array as $value) {										
			$model = CommonFunctions::loadJobModel($job_id);						
			$model->id = null;						
			$model->job_started_date = $value['job_started_date'];						
			$model->job_end_date = $value['job_end_date'];						
			$model->approval_status = 'Pending Admin Approval';						
			$model->booked_status = 'Booked';						
			$model->job_status = 'NotStarted';						
			$model->original_record = '0';
			$model->job_total_working_hour = 0;
			$model->purchase_order = '';						
			$model->frequency_type = 1;						
			$model->paid = 'No';						
			$model->signed_off = 'No';						
			$model->client_signed_off_through = '';						
			$model->client_feedback = '';						
			$model->client_name = '';						
			$model->client_signature = '';						
			$model->client_date = null;						
			$model->client_email = '';						
			$model->sign_off_document = null;						
			$model->job_completed_date = null;						
                        $model->approval_status_date = null;						
			$model->created_at = date('Y-m-d');						
			$model->agent_id = $agent_id; // map record to service agent id
			$model->isNewRecord = true;												
			if($model->save()) {												
			$new_job_id = $model->id;						
			$Criteria = new CDbCriteria();						
			$Criteria->condition = "job_id = ".$job_id;						
			$job_services_model = QuoteJobServices::model()->findAll($Criteria); 						
			foreach($job_services_model as $services) {							
			$service_model = CommonFunctions::loadJobServiceModel($services->id); // job service id , make copy services	
			$service_model->id = null;							
			$service_model->image = null;
			$service_model->job_id = $new_job_id;
			$service_model->created_at = date('Y-m-d');
			$service_model->isNewRecord = true;
			$service_model->save();
			}						
			}
			}
			}
                        
			public static function UpdateQuoteTotalOnSeviceChange($job_id) {
				$connection = Yii::app()->db;
				$sql = "SELECT sum(`total`) as quote_value FROM `hc_quote_job_services` WHERE `job_id`=".$job_id;
				$sResult = $connection->createCommand($sql)->queryRow();
				$model = QuoteJobs::model()->findByPk($job_id);
				if($model->discount > 0) {
					$model->final_total = $sResult['quote_value'] - (($model->discount/100) * $sResult['quote_value']);
					$model->save();	
					}			
			}


public static function GetAccessActions($role_type) {
	$actions = array();

	switch ($role_type) {
	case 'agent':

	$actions = array(
	'delete_sepervisor', 'delete_site_sepervisor', 'delete_staff_user', 'view', 'assign_supervisor', 'assign_site_supervisor', 'Assign_staff', 'DownloadSignOffSheet', 'DownloadJobsheet', 'DownloadQuote', 'DownloadSwms', 'approve_job', 'change_job_status', 'update_job_note', 'update_extra_scope',
	'get_job_note', 'update_purchase_order','update_job_total_working_hour','Update_job_parameters_value', 'get_purchase_order', 'BookJob', 'RebookJob', 'AddPurchaseOrder', 'SignOffView',
	'SendSignOffEmail', 'PaperSignOff', 'SpotSignOff', 'GetImageSrcByServiceId', 'AddFrequencyJob', 'jobImages', 'BuildingDocuments',
	'Upload', 'UploadBuildingPhoto', 'UploadBuildingDocument', 'DownloadJobBeforeAfterReport', 'UpdateJob', 'UpdateJobLast',
	'Add_JobImageData', 'Update_JobImageData', 'GetJobImageDataColumns', 'GetJobImageDataColumnsImage', 'DeleteJobImageRecord',
	'AjaxJobImageBeforeUpload', 'AjaxJobImageAfterUpload', 'ViewSiteInduction', 'Delete_job_supervisor', 'SwmsSign','update_tool_types'
	);


	break;
	case 'supervisor':

	$actions = array(
	'delete_site_sepervisor', 'delete_staff_user', 'view', 'assign_supervisor', 'assign_site_supervisor', 'Assign_staff', 'DownloadSignOffSheet', 'DownloadJobsheet', 'DownloadQuote', 'DownloadSwms', 'change_job_status', 'update_job_note', 'update_extra_scope',
	'get_job_note', 'update_purchase_order','update_job_total_working_hour','Update_job_parameters_value', 'get_purchase_order', 'BookJob', 'RebookJob', 'AddPurchaseOrder', 'SignOffView',
	'SendSignOffEmail', 'PaperSignOff', 'SpotSignOff', 'GetImageSrcByServiceId', 'AddFrequencyJob', 'jobImages', 'BuildingDocuments',
	'Upload', 'UploadBuildingPhoto', 'UploadBuildingDocument', 'DownloadJobBeforeAfterReport', 'UpdateJob', 'UpdateJobLast',
	'Add_JobImageData', 'Update_JobImageData', 'GetJobImageDataColumns', 'GetJobImageDataColumnsImage', 'DeleteJobImageRecord',
	'AjaxJobImageBeforeUpload', 'AjaxJobImageAfterUpload', 'ViewSiteInduction', 'Delete_job_supervisor', 'SwmsSign','update_tool_types'
	);

	break;
	case 'site_supervisor':


	$actions = array(
	'delete_staff_user', 'view', 'assign_supervisor', 'assign_site_supervisor', 'Assign_staff', 'DownloadSignOffSheet', 'DownloadJobsheet', 'DownloadQuote', 'DownloadSwms','change_job_status', 'update_job_note', 'update_extra_scope',
	'get_job_note', 'update_purchase_order','get_purchase_order', 'BookJob', 'RebookJob', 'AddPurchaseOrder', 'SignOffView',
	'SendSignOffEmail', 'PaperSignOff', 'SpotSignOff', 'GetImageSrcByServiceId', 'AddFrequencyJob', 'jobImages', 'BuildingDocuments',
	'Upload', 'UploadBuildingPhoto', 'UploadBuildingDocument', 'DownloadJobBeforeAfterReport', 'UpdateJob', 'UpdateJobLast',
	'Add_JobImageData', 'Update_JobImageData', 'GetJobImageDataColumns', 'GetJobImageDataColumnsImage', 'DeleteJobImageRecord',
	'AjaxJobImageBeforeUpload', 'AjaxJobImageAfterUpload', 'ViewSiteInduction', 'Delete_job_supervisor', 'SwmsSign','update_tool_types'
	);


	break;

	case 'staff':

	$actions = array(
	'view', 'SwmsSign'
	);
	break;

	case 'service_client':
	$actions = array(
	'DownloadSignOffSheet'
	);
	break;
	} 


	sort($actions);
	return $actions;

	}




			}
?>
