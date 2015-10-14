<?php

class Graphs extends CApplicationComponent {


    public static function top_quotes_approved_customer($agent_id) {
		$connection = Yii::app()->db;		
		$x_axis = array();
		$graph_1_data = array();
		// WHERE j.approval_status = 'Approved By Admin'
		$query = "SELECT c.name, sum(`final_total`) as total FROM `hc_quote_jobs` j
		LEFT JOIN hc_quotes q ON q.id = j.quote_id
		LEFT JOIN hc_company c ON q.company_id = c.id
		WHERE q.id > 2999 and j.approval_status = 'Approved By Admin' AND q.agent_id = $agent_id
		group by q.company_id
		order by `total` desc limit 10";			
		
		$result = $connection->createCommand($query)->queryall();
		
		$i = 0;
		
		foreach($result as $company) {
			
			$graph_1_data[$i]['name']	 = $company['name'];
			$graph_1_data[$i]['value']	 = $company['total'];
			
			$i++;
		}
		
			 return $graph_1_data;
	}
	

	public static function graph_booked_approved_and_not_approved($agent_id) {
		
		$connection = Yii::app()->db;		
		$x_axis = array();
		$mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
		
		$month_year = array();
		$current_date = date('Y-m-d');
		$next_month_date = $current_date;
        for ($i = 0; $i < 6; $i++) {

            $current_loop_date = strtotime($next_month_date);
            $next_month_date = date("Y-m-d", strtotime("+1 month", $current_loop_date));

            $month_year[$i]['month'] = date('m', strtotime($next_month_date));
            $month_year[$i]['year'] = date('Y', strtotime($next_month_date));
			
			$x_axis[] = $mons[(int)$month_year[$i]['month']];
        }
		
		
		
		$y_axis_booked_approved = array();
		$y_axis_not_booked_approved = array();
		
		for($i=0;$i<count($month_year);$i++) {
		
		
			$selectd_month = $month_year[$i]['month'];
			$selectd_year = $month_year[$i]['year'];
			
			$query = "SELECT IFNULL(SUM(final_total),0) as approved_booked_value FROM {{quote_jobs}}
			WHERE agent_id = $agent_id AND approval_status='Approved By Admin' AND booked_status='Booked' AND YEAR(job_started_date) = " . $selectd_year . " AND MONTH(job_started_date) = " . $selectd_month;			
			$result = $connection->createCommand($query)->queryRow();
			$approved_booked_value = $result['approved_booked_value'];
			
			$y_axis_booked_approved[] = $approved_booked_value;
		
			$query = "SELECT IFNULL(SUM(final_total),0) as not_approved_booked_value FROM {{quote_jobs}}
			WHERE agent_id = $agent_id AND approval_status='Pending Admin Approval' AND booked_status='Booked' AND YEAR(job_started_date) = " . $selectd_year . " AND MONTH(job_started_date) = " . $selectd_month;			
			$result = $connection->createCommand($query)->queryRow();
			$not_approved_booked_value = $result['not_approved_booked_value'];
		
			$y_axis_not_booked_approved[] = $not_approved_booked_value;
		
			
		}
		
		 $graph_2_data['x_axis_2_graph'] = $x_axis ;
		 $graph_2_data['y_axis_2_graph_booked_approved'] =  $y_axis_booked_approved ;
		 $graph_2_data['y_axis_2_graph_not_booked_approved'] = $y_axis_not_booked_approved ;
		
		return $graph_2_data;
	}


	public static function graph_top_five_services($agent_id) {
		
		$connection = Yii::app()->db;	
		$current_date = date('Y-m-d');

		$x_axis = array();
		$mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
		
		$month_year = array();
		$current_date = date('Y-m-d');
		$next_month_date = $current_date;
        for ($i = 0; $i < 3; $i++) {

            $current_loop_date = strtotime($next_month_date);
            $next_month_date = date("Y-m-d", strtotime("+1 month", $current_loop_date));

            $month_year[$i]['month'] = date('m', strtotime($next_month_date));
            $month_year[$i]['year'] = date('Y', strtotime($next_month_date));
			
			$x_axis[] = $mons[(int)$month_year[$i]['month']];
        }
		
		 $services = array();
		 $details = array();
		 
		 $service_model = Service::model()->findAll();
		 
		$count = 0;
		foreach($service_model as $row) {
		$service_id = 	 $row->id;
		$service_name = 	 $row->service_name;
		$details[$count]['name'] = $service_name;	
		
				for($i=0;$i<count($month_year);$i++) {
				
				$selectd_month = $month_year[$i]['month'];
				$selectd_year = $month_year[$i]['year'];
					
				$query = "SELECT service_id,S.service_name, count(`service_id`) as service_frequency  FROM `hc_quote_jobs` J 
							join hc_quotes Q ON J.quote_id = Q.id
							join hc_services S ON Q.service_id = S.id
							WHERE Q.agent_id = $agent_id AND YEAR(J.job_started_date) = $selectd_year AND MONTH(J.job_started_date) = $selectd_month
							AND service_id = $service_id
							group by `service_id` order by service_frequency desc limit 5";
							
				$result = $connection->createCommand($query)->queryRow();
				$details[$count]['data'][$i] = isset($result['service_frequency']) ? $result['service_frequency'] : 0;
				
								
				}	
				$count++;
		}
			

		$final_data	= array();	
		$top_five = 0;
		
		for($i=0;$i<count($details);$i++) {
			
				$show = 0;
				for($j=0;$j<count($details[$i]['data']);$j++) {
						if($details[$i]['data'][$j] > 0) {
							$show++;
						}
				}
				
				if( $show > 0) {
					$final_data[$top_five]['name'] = $details[$i]['name'];
					$final_data[$top_five]['data'] = $details[$i]['data'];
					$top_five++;
				}
				
		}
		
		 $graph_3_data['x_axis_3_graph'] = $x_axis ;
		 $graph_3_data['y_axis_3_graph_top_five_services'] =  $final_data ;
		
		return $graph_3_data;
	}
	
	
	public static function graph_quotes_status($agent_id) {
	
		$model1=Quotes::model()->findAll(array(
			'condition'=>'status=:status AND id >= :id AND agent_id =  :agent_id',
			'params'=>array(':status'=>'Approved', ':id'=>2999, ':agent_id'=>$agent_id),
		));

		$approve_quote_count = count($model1);
		
		
		$model2=Quotes::model()->findAll(array(
			'condition'=>'status=:status AND id >= :id AND agent_id = :agent_id',
			'params'=>array(':status'=>'Declined', ':id'=>2999, ':agent_id'=>$agent_id),
		));

		$decline_quote_count = count($model2);
		
		
		
		$model3=Quotes::model()->findAll(array(
			'condition'=>'status=:status AND id >= :id AND agent_id = :agent_id',
			'params'=>array(':status'=>'Pending', ':id'=>2999, ':agent_id'=>$agent_id),
		));

		$pending_quote_count = count($model3);
		
	
		$graph_4_data['approve_quote_count'] = $approve_quote_count ;
		$graph_4_data['decline_quote_count'] = $decline_quote_count ;
		$graph_4_data['pending_quote_count'] = $pending_quote_count ;
		
		return $graph_4_data;
	}
	
    public static function system_owner_status() {
	
		$model1=SystemOwner::model()->findAll(array(
			'condition'=>'status=:status',
			'params'=>array(':status'=>'Approved'),
		));

		$approve_systemowner_count = count($model1);
		
		$model2=SystemOwner::model()->findAll(array(
			'condition'=>'status=:status',
			'params'=>array(':status'=>'Declined'),
		));

		$decline_systemowner_count = count($model2);
		
		//echo $approve_systemowner_count;
		//echo $decline_systemowner_count;
		//exit;
		
		$graph_4_data['approve_systemowner_count'] = $approve_systemowner_count ;
		$graph_4_data['decline_systemowner_count'] = $decline_systemowner_count ;
		
		return $graph_4_data;
	}
}

?>
