<?php

class SmsService extends CApplicationComponent {

    public static function read_sms() {

        $user_name = Setting::model()->findByPk(10)->meta_value;
        $password = Setting::model()->findByPk(11)->meta_value;
        $si = new SmsInterface ();
        $si->connect($user_name, $password, true, false);

        if (($srl = $si->checkReplies()) === NULL) {
            // echo "Unable to read messages from the SMS server.\n";
        }

        if ($si->getResponseMessage() !== NULL) {
            //   echo "<BR>Reason: " . $si->getResponseMessage() . "\n";
        }

        if (isset($srl) && count($srl) > 0) {

            foreach ($srl as $sr) {
                $msg_id = $sr->messageID;
                $msg_replied_when = $sr->when;
                $msg_replied_text = $sr->message;

                $updating_prms = " SET msg_replied_status='1', msg_replied_text='" . $msg_replied_text . "', msg_replied_when='" . $msg_replied_when . "' WHERE msg_id = " . $msg_id;

                $ss_update_query = "UPDATE hc_job_site_supervisor " . $updating_prms;
                Yii::app()->db->createCommand($ss_update_query)->execute();


                $st_update_query = "UPDATE hc_job_staff " . $updating_prms;
                Yii::app()->db->createCommand($st_update_query)->execute();
            }
        }
    }

    /*
     * sent_sms => selected member should sent sms
     * ys => place to come fro ss and st
     * site model => site details
     */

    public static function send_sms($sent_sms, $ys, $site_model) {

        // send sms to staff
        if (isset($sent_sms['ST']) && count($sent_sms['ST']) > 0) {
            SmsService::st_send_sms($sent_sms['ST'], $ys, $site_model);
        }

        // send sms to site supervisor
        if (isset($sent_sms['SS']) && count($sent_sms['SS']) > 0) {
            SmsService::ss_send_sms($sent_sms['SS'], $ys, $site_model);
        }
    }

    public static function st_send_sms($sent_sms, $ys, $site_model) {


        // message media next message ID
        $message_model = Setting::model()->findByPk(12);
        $next_message_id = $message_model->meta_value;

        // message media credentials
        $user_name = Setting::model()->findByPk(10)->meta_value;
        $password = Setting::model()->findByPk(11)->meta_value;


        foreach ($sent_sms as $allocation_id) {
            $allocation_model = JobStaff::model()->findByPk($allocation_id);
            $message_text = SmsService::st_replace_sms_format_keywords($allocation_model, $ys['ST'][$allocation_id], $site_model);

            $phone = $allocation_model->mobile;
            
		if($allocation_model->msg_id == 0) {
            		$messageID = $next_message_id;
            		$next_message_id++;
            	} else {
	            	$messageID = $allocation_model->msg_id;
            	}
            
            $msg_sent_status = 'Failed';
            $mm_result_response = SmsService::messageMedia_send_sms($user_name, $password, $phone, $message_text, $messageID, 0, 169, false);
            if (isset($mm_result_response->responseCode) && $mm_result_response->responseCode == 100) {
                $msg_sent_status = 'Sent';
            }


            $allocation_model->msg_sent_status = $msg_sent_status;
            $allocation_model->msg_sent_text = $message_text;
            $allocation_model->msg_id = $messageID;
            $allocation_model->msg_sms_service_used = '1';
            $allocation_model->place_to_come = $ys['ST'][$allocation_id];
            $allocation_model->msg_sent_date_time = date("Y-m-d H:i:s");
            $allocation_model->msg_replied_status = '0'; 
            $allocation_model->msg_replied_text = NULL; 
            $allocation_model->msg_replied_when = '0';
            
		$allocation_model->save();
             
        }

        $message_model->meta_value = $next_message_id;
        $message_model->save();
    }

    public static function st_replace_sms_format_keywords($allocation_model, $place_to_come, $site_model) {


        $messageformat_changes_tags = array(
            "{staff_first_name}",
            "{start_time}",
            "{day_date}",
            "{site_address}",
            "{site_start_time}",
            "{site_supervisor_first_name}",
        );



        // sms format for site supervisor
        if ($place_to_come == 'YARD')
            $sms_format = SmsFormat::model()->findByPk(1);
        else
            $sms_format = SmsFormat::model()->findByPk(2);

        $message = $sms_format->sms_text;


        // to find all staff details working on this day_date
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id=" . $allocation_model->job_id . " && job_date='" . $allocation_model->job_date . "'" . " && day_night='" . $allocation_model->day_night . "'";
        $ss_model = JobSiteSupervisor::model()->find($Criteria);
        $ss_user_model = User::model()->findByPk($ss_model->user_id);

        // to find site time and yard time
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id=" . $allocation_model->job_id . " && working_date='" . $allocation_model->job_date . "'" . " && day_night='" . $allocation_model->day_night . "'";
        $job_working_model = JobWorking::model()->find($Criteria);

        // message receiver details
        $mst_receiver_user_model = User::model()->findByPk($allocation_model->user_id);


        // updating parameters values
        $staff_first_name = $mst_receiver_user_model->first_name;

        if ($place_to_come == 'SITE')
            $start_time = $job_working_model->site_time;
        else
            $start_time = $job_working_model->yard_time;

        $day_date = date("d/m/Y", strtotime($allocation_model->job_date)) . ' ' . strtolower($allocation_model->day_night);
        $site_address = $site_model->address . ' ' . $site_model->suburb . ' ' . $site_model->state . ' ' . $site_model->postcode;
        $site_start_time = $job_working_model->site_time;

        $site_supervisor_first_name = $ss_user_model->first_name;

        $messageformat_changes_tags_value = array(
            "{staff_first_name}" => $staff_first_name,
            "{start_time}" => $start_time,
            "{day_date}" => $day_date,
            "{site_address}" => $site_address,
            "{site_start_time}" => $site_start_time,
            "{site_supervisor_first_name}" => $site_supervisor_first_name,
        );


        foreach ($messageformat_changes_tags as $tag) {
            $message = str_replace($tag, $messageformat_changes_tags_value[$tag], $message);
        }


        return $message;
    }

    public static function ss_send_sms($sent_sms, $ys, $site_model) {


        // message media next message ID
        $message_model = Setting::model()->findByPk(12);
        $next_message_id = $message_model->meta_value;

        // message media credentials
        $user_name = Setting::model()->findByPk(10)->meta_value;
        $password = Setting::model()->findByPk(11)->meta_value;


        foreach ($sent_sms as $allocation_id) {
            $allocation_model = JobSiteSupervisor::model()->findByPk($allocation_id);
            $message_text = SmsService::ss_replace_sms_format_keywords($allocation_model, $ys['SS'][$allocation_id], $ys['ST'], $site_model);


            $phone = $allocation_model->mobile;
            
            	if($allocation_model->msg_id == 0) {
            		$messageID = $next_message_id;
            		$next_message_id++;
            	} else {
	            	$messageID = $allocation_model->msg_id;
            	}
            	
            $msg_sent_status = 'Failed';
            $mm_result_response = SmsService::messageMedia_send_sms($user_name, $password, $phone, $message_text, $messageID, 0, 169, false);
            if (isset($mm_result_response->responseCode) && $mm_result_response->responseCode == 100) {
                $msg_sent_status = 'Sent';
            }

            $allocation_model->msg_sent_status = $msg_sent_status;
            $allocation_model->msg_sent_text = $message_text;
            $allocation_model->msg_id = $messageID;
            $allocation_model->msg_sms_service_used = '1';
            $allocation_model->place_to_come = $ys['SS'][$allocation_id];
            $allocation_model->msg_sent_date_time = date("Y-m-d H:i:s");
            $allocation_model->msg_replied_status = '0'; 
            $allocation_model->msg_replied_text = NULL; 
            $allocation_model->msg_replied_when = '0';
            
		$allocation_model->save();
		
        }

        $message_model->meta_value = $next_message_id;
        $message_model->save();
    }

    /*
     * allocation model => ss selected allocation model
     * place_to_come => site supervisor place to come
     * staff_place => all staff place to come
     * site model => site details
     */

    public static function ss_replace_sms_format_keywords($allocation_model, $place_to_come, $staff_place, $site_model) {

        $messageformat_changes_tags = array(
            "{ss_first_name}",
            "{start_time}",
            "{day_date}",
            "{site_address}",
            "{site_start_time}",
            "{yard_staff}",
            "{site_staff}"
        );


        // sms format for site supervisor
        if ($place_to_come == 'YARD')
            $sms_format = SmsFormat::model()->findByPk(3);
        else
            $sms_format = SmsFormat::model()->findByPk(4);

        $message = $sms_format->sms_text;


        // to find all staff details working on this day_date
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id=" . $allocation_model->job_id . " && job_date='" . $allocation_model->job_date . "'" . " && day_night='" . $allocation_model->day_night . "'";
        $staffDetails_model = JobStaff::model()->findAll($Criteria);

        // to find site time and yard time
        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id=" . $allocation_model->job_id . " && working_date='" . $allocation_model->job_date . "'" . " && day_night='" . $allocation_model->day_night . "'";
        $job_working_model = JobWorking::model()->find($Criteria);

        // message receiver details
        $mst_receiver_user_model = User::model()->findByPk($allocation_model->user_id);


        // updating parameters values
        $ss_first_name = $mst_receiver_user_model->first_name;

        if ($place_to_come == 'SITE')
            $start_time = $job_working_model->site_time;
        else
            $start_time = $job_working_model->yard_time;

        $day_date = date("d/m/Y", strtotime($allocation_model->job_date)) . ' ' . strtolower($allocation_model->day_night);
        $site_address = $site_model->address . ' ' . $site_model->suburb . ' ' . $site_model->state . ' ' . $site_model->postcode;
        $site_start_time = $job_working_model->site_time;

        $staff_ys_array = SmsService::findStaffPlace($staffDetails_model, $staff_place);
        $yard_staff = $staff_ys_array[0];
        $site_staff = $staff_ys_array[1];



        $messageformat_changes_tags_value = array(
            "{ss_first_name}" => $ss_first_name,
            "{start_time}" => $start_time,
            "{day_date}" => $day_date,
            "{site_address}" => $site_address,
            "{site_start_time}" => $site_start_time,
            "{yard_staff}" => $yard_staff,
            "{site_staff}" => $site_staff,
        );


        foreach ($messageformat_changes_tags as $tag) {
            $message = str_replace($tag, $messageformat_changes_tags_value[$tag], $message);
        }


        return $message;
    }

    public static function findStaffPlace($staffDetails_model, $staff_place) {

        $st_site = array();
        $st_yard = array();
        $site_staff = '';
        $yard_staff = '';
        foreach ($staffDetails_model as $st_allocation_model) {

            $st_user_model = User::model()->findByPk($st_allocation_model->user_id);

            if ($staff_place[$st_allocation_model->id] == 'SITE') {
                $st_site[] = $st_user_model->first_name;
            } else {
                $st_yard[] = $st_user_model->first_name;
            }
        }


        if (count($st_site) > 0)
            $site_staff = implode(', ', $st_site);

        if (count($st_yard) > 0)
            $yard_staff = implode(', ', $st_yard);


        return array($yard_staff, $site_staff);
    }

    public static function messageMedia_send_sms($user_name, $password, $phone, $messageText, $messageID, $delay, $validityPeriod, $deliveryReport) {

        $si = new SmsInterface(false, false);
        $si->addMessage($phone, $messageText, $messageID, $delay, $validityPeriod, $deliveryReport);

        if (!$si->connect($user_name, $password, true, false))
            return;
        //echo "failed. Could not contact server.\n";
        elseif (!$si->sendMessages()) {
            return;
            //echo "failed. Could not send message to server.\n";
            if ($si->getResponseMessage() !== NULL)
                return;
            //echo "<BR>Reason: " . $si->getResponseMessage() . "\n";
        }
        return $si;
    }

}

?>
