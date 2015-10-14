<?php

class DefaultController extends Controller {

	public $layout = '//layouts/column1';
	public $base_url_assets = null;
	public $current_user_id = 0;
	public $user_role_base_url = ''; public $user_dashboard_url = '';
	public $agent_id = '';
	public $agent_info = null;
	public $where_agent_condition = '';

    public function init() {
     
        $this->current_user_id = isset(Yii::app()->user->id) ? Yii::app()->user->id : 0;        
        $this->base_url_assets = CommonFunctions::siteURL();         
        $this->user_role_base_url = CommonFunctions::getUserBaseUrl(Yii::app()->user->name);
		$this->user_dashboard_url = CommonFunctions::getUserDashboardUrl(Yii::app()->user->name);
        $this->agent_id = CommonFunctions::getCurrentpageAgentId(Yii::app()->user->name);
	$this->agent_info = CommonFunctions::getAgentInfo($this->agent_id);
        $this->where_agent_condition = " agent_id = ".$this->agent_id ;        
        
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('job_profitability','GenerateJobProfitablityReport'),
                'users' => array('system_owner', 'state_manager', 'operation_manager', 'agent'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }


	public function actionJob_profitability() {

		$default_start_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 20, date('Y')));
		$default_last_date = date('Y-m-d');

		$job_from_date = isset($_REQUEST['job_from_date']) ? $_REQUEST['job_from_date'] : $default_start_date;
		$job_to_date = isset($_REQUEST['job_to_date']) ? $_REQUEST['job_to_date'] : $default_last_date;

	 if(!empty($job_from_date) && !empty($job_to_date)) {
	           $job_result  = $this->findJobsBetweenDates($job_from_date,$job_to_date);
            }
            


		 $this->render('job_profitability', array(
		               'job_result' => $job_result
	            ));
	}

        
    public function findJobsBetweenDates($job_from_date,$job_to_date) {

		$connection = Yii::app()->db;
		$job_users_data = array();
		$user_rate_per_hour = array();	
		$result = array(); $i=0;
		
		$select_fields = "job_id, user_id,pay_date_id, working_date, formatted_working_date, ";
		$select_fields .= " SUM(total_hours) as total_hours, SUM(regular_hours) as regular_hours, SUM(overtime_hours) as overtime_hours, SUM(double_time_hours) as double_time_hours ";
		$query_calculation = "SELECT $select_fields from hc_timesheet_pay_dates_user where  $this->where_agent_condition && job_id > 0 && saved_status='1' && working_date between '".$job_from_date."' AND '".$job_to_date."' group by job_id,user_id order by working_date";
		$summaryResult = $connection->createCommand($query_calculation)->queryAll();

		if(count($summaryResult) === 0) {
			echo 'no records found'; exit;
		}
		

		foreach($summaryResult as $job_records) {
			$job_users_data[$job_records['job_id']][] = $job_records;
		}
//		echo '<pre>';  print_r($job_users_data); echo '</pre>';
//		exit;
		foreach($job_users_data as $job_id=>$job_records) {

			$job_model = QuoteJobs::model()->findByPk($job_id);
			
		  	// quote model by job id
			$quote_model = Quotes::model()->findByPk($job_model->quote_id);

			// building model
			$building_model = Buildings::model()->findByPk($job_model->building_id);

			// site model
			$site_model = ContactsSite::model()->findByPk($quote_model->site_id);

			// contact model
			$contact_model = Contact::model()->findByPk($quote_model->contact_id);

			// contact model
			$company_model = Company::model()->findByPk($quote_model->company_id);
			
			// service model
			$service_model = Service::model()->findByPk($quote_model->service_id);

			// supervisor model
			$supervisor_model = JobSupervisor::model()->findByAttributes(
		                array(
		                    'job_id' => $job_id,
		                )
               		 );

			$result[$i]['job_id'] = $job_id;
			$result[$i]['company_name'] = $company_model->name;
			$result[$i]['contact_name'] = $contact_model->first_name.' '.$contact_model->surname;
			$result[$i]['site_name'] = $site_model->site_name;
			$result[$i]['building_name'] = $building_model->building_name;
			$result[$i]['service_name'] = $service_model->service_name;
			$result[$i]['supervisor_name'] = $supervisor_model->name;
			$quote_amount = $job_model->final_total;
			$result[$i]['quote_amount'] = round($quote_amount,2);

			
			
			$total_wage = 0; $job_working_dates = array();
			foreach($job_records as $inner_records)  {	

				$userid_paydateid = $inner_records['user_id']."_".$inner_records['pay_date_id'];
				if(!isset($user_rate_per_hour[$userid_paydateid])) {
					// find rate per hour of user
					$rate_per_hour_model = TimesheetApprovedStatus::model()->findByAttributes(
					  	  array(
							'pay_date_id' => $inner_records['pay_date_id'],
							'user_id' => $inner_records['user_id'],
					   	 )
			    		);
				
					$user_rate_per_hour[$userid_paydateid]['reg_rate_per_hr'] = $rate_per_hour_model->reg_rate_per_hr;
					$user_rate_per_hour[$userid_paydateid]['ot_rate_per_hr'] = $rate_per_hour_model->ot_rate_per_hr;
					$user_rate_per_hour[$userid_paydateid]['dt_rate_per_hr'] = $rate_per_hour_model->dt_rate_per_hr;
				}

				$temp_job_sum = ($inner_records['regular_hours'] * $user_rate_per_hour[$userid_paydateid]['reg_rate_per_hr']) + ($inner_records['overtime_hours'] * $user_rate_per_hour[$userid_paydateid]['ot_rate_per_hr']) + ($inner_records['double_time_hours'] * $user_rate_per_hour[$userid_paydateid]['dt_rate_per_hr']);
				$total_wage = $total_wage + $temp_job_sum;
			}

			

			$total_wage = round($total_wage,2);	
			$result[$i]['total_wage'] = $total_wage;
			// total profite
			$diff_value = round($quote_amount - $total_wage,2);
			$result[$i]['diff_value'] = $diff_value;
			// total % of labour
			$labour_percentage = round(($total_wage/$quote_amount) * 100,2);
			$result[$i]['labour_percentage'] = $labour_percentage;

			//last_working_date
			$result[$i]['last_working_date'] = date("d/m/Y", strtotime($job_model->job_end_date));
			
$i++;

		}
		


		//echo '<pre>';  print_r($result); echo '</pre>';
	
		return $result;
    }


    public function actionGenerateJobProfitablityReport() {

		$default_start_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 20, date('Y')));
		$default_last_date = date('Y-m-d');

		$job_from_date = isset($_REQUEST['job_from_date']) ? $_REQUEST['job_from_date'] : $default_start_date;
		$job_to_date = isset($_REQUEST['job_to_date']) ? $_REQUEST['job_to_date'] : $default_last_date;

		 if(!empty($job_from_date) && !empty($job_to_date)) {
			   $job_result  = $this->findJobsBetweenDates($job_from_date,$job_to_date);


			Yii::import('ext.phpexcel.XPHPExcel');

			$objPHPExcel = XPHPExcel::createPHPExcel();
			$objPHPExcel->getProperties()->setCreator("Mikhil Kotak")
				->setLastModifiedBy("Mikhil Kotak")
				->setTitle("Time sheet")
				->setSubject("Time sheet")
				->setDescription("Pay date.")
				->setKeywords("Time Sheet")
				->setCategory("Time sheet");

			$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri')
				->setSize(11);
$sheet_count = 0;
$start_index = 1;

       		$objPHPExcel->setActiveSheetIndex($sheet_count)
                        ->setCellValue('A' . $start_index, 'Job ID')
                        ->setCellValue('B' . $start_index, 'Company')
                        ->setCellValue('C' . $start_index, 'Contact')
                        ->setCellValue('D' . $start_index, 'Site Name')
                        ->setCellValue('E' . $start_index, 'Building')
                        ->setCellValue('F' . $start_index, 'Service')
                        ->setCellValue('G' . $start_index, 'Supervisor')
                        ->setCellValue('H' . $start_index, 'Quote Amt')
                        ->setCellValue('I' . $start_index, 'Total Wage')
                        ->setCellValue('J' . $start_index, 'Diff $$')
                        ->setCellValue('K' . $start_index, 'Labour %');

                $objPHPExcel->getActiveSheet()->getStyle('A' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('D' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('E' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('F' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('G' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('I' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $start_index)->getFont()->setBold(true)->setSize(11);
                $objPHPExcel->getActiveSheet()->getStyle('K' . $start_index)->getFont()->setBold(true)->setSize(11);

// looping values

$start_index++;
foreach($job_result as $record)  {

			$objPHPExcel->setActiveSheetIndex($sheet_count)
			->setCellValue('A' . $start_index, $record['job_id']);

			$objPHPExcel->setActiveSheetIndex($sheet_count)
			->setCellValue('B' . $start_index, $record['company_name']);


			$objPHPExcel->setActiveSheetIndex($sheet_count)
			->setCellValue('c' . $start_index, $record['contact_name']);


			$objPHPExcel->setActiveSheetIndex($sheet_count)
			->setCellValue('D' . $start_index, $record['site_name']);



			$objPHPExcel->setActiveSheetIndex($sheet_count)
			->setCellValue('E' . $start_index, $record['building_name']);



			$objPHPExcel->setActiveSheetIndex($sheet_count)
			->setCellValue('F' . $start_index, $record['service_name']);



			$objPHPExcel->setActiveSheetIndex($sheet_count)
			->setCellValue('G' . $start_index, $record['supervisor_name']);



			$objPHPExcel->setActiveSheetIndex($sheet_count)
			->setCellValue('H' . $start_index, '$'.$record['quote_amount']);
			$objPHPExcel->getActiveSheet()->getStyle('H' . $start_index)->getNumberFormat()->setFormatCode('0.00');


			$objPHPExcel->setActiveSheetIndex($sheet_count)
			->setCellValue('I' . $start_index, '$'.$record['total_wage']);
			$objPHPExcel->getActiveSheet()->getStyle('I' . $start_index)->getNumberFormat()->setFormatCode('0.00');


			$objPHPExcel->setActiveSheetIndex($sheet_count)
			->setCellValue('J' . $start_index, '$'.$record['diff_value']);
			$objPHPExcel->getActiveSheet()->getStyle('J' . $start_index)->getNumberFormat()->setFormatCode('0.00');

			$objPHPExcel->setActiveSheetIndex($sheet_count)
			->setCellValue('K' . $start_index,$record['labour_percentage'].'%');
			$objPHPExcel->getActiveSheet()->getStyle('K' . $start_index)->getNumberFormat()->setFormatCode('0.00');



$start_index++;
}

// Auto size cell
                //$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

// Rename worksheet
                $sheet_name = 'Job Profitabilitity';
                $objPHPExcel->getActiveSheet()->setTitle($sheet_name);


		  // Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			$file_name = "job-profitabilty-" . date("d-m-Y", strtotime($job_from_date))."to".date("d-m-Y", strtotime($job_to_date)) . ".xls";
			header('Content-Disposition: attachment;filename="' . $file_name . '"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			Yii::app()->end();




		    }
		    
		}


}
