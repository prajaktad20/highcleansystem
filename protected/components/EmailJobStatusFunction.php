<?php

/**
 * This component used to send emails on below action
 * 
 * 
 * 
 */
class EmailJobStatusFunction extends CApplicationComponent {
    /*     * ************************************* jobs sending emails ********************************************** */

    /**
     * 
     */
    public static function sendEmail($email_temp_id, $job_id, $admin_user_id, $supervisor_id, $site_supervisor_id, $job_cleaning_report) {

        /*         * ***************************** */
        $mailgun_email_notification = Setting::model()->findByPk(8);
        if ($mailgun_email_notification === NULL)
            return;


        if ($mailgun_email_notification->meta_value != 'ON')
            return;

        /*         * ***************************** */
        $email_address_receiver = Setting::model()->findByPk(7);
        if ($email_address_receiver === NULL)
            return;



        $noreply_notifications_email_address = Setting::model()->findByPk(2);
        if ($noreply_notifications_email_address === NULL)
            return;

        $fromheader = Setting::model()->findByPk(6);
        if ($fromheader === NULL)
            return;
        /*         * ***************************** */

        // user details
        $user_model = NULL;
        if ($admin_user_id > 0) {
            $user_model = User::model()->findByPk($admin_user_id);
            if ($user_model === NULL)
                return;
        }

        // supervisor user details
        $supervisor_user_model = User::model()->findByPk($supervisor_id);
        if ($supervisor_user_model === NULL)
            return;


        // supervisor user details
        $site_supervisor_user_model = NULL;
        if ($site_supervisor_id != 0) {
            $site_supervisor_user_model = User::model()->findByPk($site_supervisor_id);
        }



        // job details
        $job_model = CommonFunctions::loadJobModel($job_id);
        if ($job_model === NULL)
            return;

        // quote details	
        $quote_model = Quotes::model()->findByPk($job_model->quote_id);
        if ($quote_model === NULL)
            return;



        //company details
        $company_model = Company::model()->findByPk($quote_model->company_id);
        if ($company_model === NULL)
            return;



        //contact details
        $contact_model = Contact::model()->findByPk($quote_model->contact_id);
        if ($contact_model === NULL)
            return;


        //site details
        $site_model = ContactsSite::model()->findByPk($quote_model->site_id);
        if ($site_model === NULL)
            return;


        //service details
        $service_model = Service::model()->findByPk($quote_model->service_id);
        if ($service_model === NULL)
            return;

        $building_model = Buildings::model()->findByPk($job_model->building_id);
        if ($building_model === NULL)
            return;



        /*
         *  E-mail Formatting
         */
        $EmailFormatting = EmailJobStatusFunction::emailFormatting($email_temp_id, $job_model, $quote_model, $user_model, $company_model, $contact_model, $site_model, $service_model, $building_model, $supervisor_user_model, $site_supervisor_user_model);

        /*
         * Set E-mail Parameter for Mail gun
         */

        $from = trim($noreply_notifications_email_address->meta_value);    //system@highclean.com.au  
        $fromheader = ucwords(trim($fromheader->meta_value)); //HighClean System
        $to = trim($email_address_receiver->meta_value); //info@highclean.com
        $toname = ''; //ucwords(trim($fromheader->meta_value)); //HighClean System
        $sub = strip_tags($EmailFormatting[0]);
        $mail = $EmailFormatting[1];
        $header = trim($noreply_notifications_email_address->meta_value);    //system@highclean.com.au  no reply email address

        if ($email_temp_id == 10) {
            $to = trim($job_model->agent_email);
            $toname = trim($job_model->agent_name);
        }

        $supervisor_email_address = trim($supervisor_user_model->email); // keep cc to supervisor
        $site_supervisor_email_address = trim($site_supervisor_user_model->email); // keep cc to site supervisor


        EmailJobStatusFunction::sendMailThroughMailgun($email_temp_id, $from, $fromheader, $to, $toname, $sub, $mail, $header, $supervisor_email_address, $site_supervisor_email_address, $job_cleaning_report);



        //return true;
    }

    public static function emailFormatting($email_temp_id, $job_model, $quote_model, $user_model, $company_model, $contact_model, $site_model, $service_model, $building_model, $supervisor_user_model, $site_supervisor_user_model) {


        /*
         * E-mail Format Tags Declaration
         */


        $EmailFormat_changes_tags = array(
            "{quote_number}",
            "{service_required}",
            "{company_name}",
            "{site_name}",
            "{quote_created_user}",
            "{quote_approved_user}",
            "{contact_name}",
            "{site_id}",
            "{site_address}",
            "{building_name}",
            "{building_id}",
            "{supervisor_full_name}",
            "{admin_full_name}",
            "{job_from_date}",
            "{job_to_date}",
            "{job_completed_date}",
            "{agent_first_name}",
            "{sign_off_name}",
            "{sign_off_link}",
            "{job_number}",
            "{job_frequency}",
            "{site_supervisor_full_name}",
            "{supervisor_mobile_number}",
            "{site_supervisor_mobile_number}",
            "{scope}",
            "{service_description}",
        );

        //$scope = '<span style="">All the details of the scope from the quote will be shown in this email.</span>';


        $Mail_Subject = NULL;
        $Mail_Format = NULL;
        $Admin_Email_format_model = NULL;


        $Admin_Email_format_model = EmailFormat::model()->findByPk($email_temp_id);

        if ($Admin_Email_format_model === NULL)
            return;
        if ($Admin_Email_format_model != NULL) {
            $Mail_Subject = $Admin_Email_format_model->email_format_name;
            $Mail_Format = $Admin_Email_format_model->email_format;
        }



        $quote_number = '<span style="">' . $quote_model->id . '</span>';
        $service_required = '<span style="">' . $service_model->service_name . '</span>';
        $company_name = '<span style="">' . $company_model->name . '</span>';
        $site_name = '<span style="">' . $site_model->site_name . '</span>';

        $quote_created_user = '';
        $quote_approved_user = '';
        $admin_full_name = '';
        if ($user_model !== NULL) {
            $quote_created_user = '<span style="">' . $user_model->first_name . ' ' . $user_model->last_name . '</span>';
            $quote_approved_user = '<span style="">' . $user_model->first_name . ' ' . $user_model->last_name . '</span>';
            $admin_full_name = '<span style="">' . $user_model->first_name . ' ' . $user_model->last_name . '</span>';
        }
        $contact_name = '<span style="">' . $contact_model->first_name . ' ' . $contact_model->surname . '</span>';
        $site_id = '<span style="">' . $site_model->site_id . '</span>';
        $site_address = '<span style="">' . $site_model->address . ' ' . $site_model->suburb . ', ' . $site_model->state . ' ' . $site_model->postcode . '</span>';
        $building_name = '<span style="">' . $building_model->building_name . '</span>';
        $building_id = '<span style="">' . $building_model->building_no . '</span>';
        $supervisor_full_name = '<span style="">' . $supervisor_user_model->first_name . ' ' . $supervisor_user_model->last_name . '</span>';

        $job_from_date = '<span style="">' . date("d-m-Y", strtotime($job_model->job_started_date)) . '</span>';
        $job_to_date = '<span style="">' . date("d-m-Y", strtotime($job_model->job_end_date)) . '</span>';
        $job_completed_date = '<span style="">' . date("d-m-Y", strtotime($job_model->job_completed_date)) . '</span>';
        $sign_off_name = '<span style="">' . $job_model->agent_name . '</span>';
        $agent_first_name = '<span style="">' . $job_model->agent_name . '</span>';
        $job_number = '<span style="">' . $job_model->id . '</span>';
        $job_frequency = '<span style="">' . FrequencyType::Model()->FindByPk($job_model->frequency_type)->name . '</span>';




        $supervisor_mobile_number = '';
        if ($supervisor_user_model !== NULL) {
            $supervisor_mobile_number = '<span style="">' . $supervisor_user_model->mobile_phone . '</span>';
        }


        $site_supervisor_full_name = '';
        $site_supervisor_mobile_number = '';
        if ($site_supervisor_user_model !== NULL) {
            $site_supervisor_full_name = '<span style="">' . $site_supervisor_user_model->first_name . ' ' . $site_supervisor_user_model->last_name . '</span>';
            $site_supervisor_mobile_number = '<span style="">' . $site_supervisor_user_model->mobile_phone . '</span>';
        }

        $sign_off_link = '';
        if ($email_temp_id == 10) {

            $JobsignoffRequestsModel = JobsignoffRequests::model()->findByAttributes(
                    array(
                        'job_id' => $job_model->id
                    )
            );

            if ($JobsignoffRequestsModel === NULL)
                return;

            $sign_off_link = '<a href="' . Yii::app()->getBaseUrl(true) . '/?r=site/signoffjob&code=' . $JobsignoffRequestsModel->unique_code . '"><span style="">' . Yii::app()->getBaseUrl(true) . '/?r=site/signoffjob&code=' . $JobsignoffRequestsModel->unique_code . '</span></a>';
        }


        $Criteria = new CDbCriteria();
        $Criteria->condition = "job_id = " . $job_model->id;
        $job_services_model = QuoteJobServices::model()->findAll($Criteria);

        $service_description = '';
        $scope = '';
        $service_count = 1;
        foreach ($job_services_model as $service) {
            $service_description .= '<span style="font-weight: bold;">' . $service_count . ') ' . $service->service_description . '</span><br/>';
            $scope .= '<span style="font-weight: bold;">' . $service_count . ') ' . $service->service_description . '</span><br/>';
            $service_count++;
        }


        /*
         * Assign a value in E-mail formats.
         */

        $EmailFormat_changes_tags_value = array(
            "{quote_number}" => $quote_number,
            "{service_required}" => $service_required,
            "{company_name}" => $company_name,
            "{site_name}" => $site_name,
            "{quote_created_user}" => $quote_created_user,
            "{quote_approved_user}" => $quote_approved_user,
            "{contact_name}" => $contact_name,
            "{site_id}" => $site_id,
            "{site_address}" => $site_address,
            "{building_name}" => $building_name,
            "{building_id}" => $building_id,
            "{supervisor_full_name}" => $supervisor_full_name,
            "{admin_full_name}" => $admin_full_name,
            "{job_from_date}" => $job_from_date,
            "{job_to_date}" => $job_to_date,
            "{job_completed_date}" => $job_completed_date,
            "{agent_first_name}" => $agent_first_name,
            "{sign_off_name}" => $sign_off_name,
            "{sign_off_link}" => $sign_off_link,
            "{job_number}" => $job_number,
            "{job_frequency}" => $job_frequency,
            "{site_supervisor_full_name}" => $site_supervisor_full_name,
            "{supervisor_mobile_number}" => $supervisor_mobile_number,
            "{site_supervisor_mobile_number}" => $site_supervisor_mobile_number,
            "{scope}" => $scope,
            "{service_description}" => $service_description,
        );



        /*
         *  Replacing Dynamic data in E-mail Suject and Email template.
         */


        if (count($EmailFormat_changes_tags) > 0) {
            foreach ($EmailFormat_changes_tags as $tag) {
                $Mail_Subject = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Subject);
                $Mail_Format = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Format);
            }
        }


        return array($Mail_Subject, $Mail_Format);
    }

    public static function sendMailThroughMailgun($email_temp_id, $from, $fromheader, $to, $toname, $sub, $mail, $header, $supervisor_email_address, $site_supervisor_email_address, $job_cleaning_report) {

        $email_address_receiver = Setting::model()->findByPk(7);
        if ($email_address_receiver === NULL)
            return;


        $mailgunDomain_data = Setting::model()->findByPk(4);
        if ($mailgunDomain_data === NULL)
            return;
        $mailgunApiKey_data = Setting::model()->findByPk(3);
        if ($mailgunDomain_data === NULL)
            return;

        $mailgun = new MailgunApi($mailgunDomain_data->meta_value, $mailgunApiKey_data->meta_value);
        $message = $mailgun->newMessage();
       
        if(in_array($email_temp_id,array(10,14))) {
		$user_model = CommonFunctions::GetUserDetailsByUserId(Yii::app()->user->id);		
		$logined_user_email_address = $user_model->email;
		$logined_user_name =  ucfirst($user_model->first_name).' '.ucfirst($user_model->last_name);
                $message->setFrom($logined_user_email_address,$logined_user_name);
         } else {
                 $message->setFrom($from, $fromheader);
         }



        if ($email_temp_id == 10) {
            $multiple_recipient = array();
            $multiple_recipient = explode(',', $to);

            if (count($multiple_recipient) > 1) {
                foreach ($multiple_recipient as $recipient) {
                    $message->addTo($recipient, CommonFunctions::GetUserDetailsByEmailAddress($recipient));
                }
            } else {
                $message->addTo($to, $toname);
            }
        } else {
            // except 10th email templates, all emails going to info
            $to = trim($email_address_receiver->meta_value);
            $toname = CommonFunctions::GetUserDetailsByEmailAddress($to);
            $message->addTo($to, $toname);
        }


        if ($email_temp_id == 10) {
            $message->addCc($email_address_receiver->meta_value, 'HighClean System'); // info email address
        }


        // for sign off job, keep cc in mikhil
        if (in_array($email_temp_id, array(10, 11))) {

            if (!empty($supervisor_email_address))
                $message->addCc($supervisor_email_address, CommonFunctions::GetUserDetailsByEmailAddress($supervisor_email_address));


            $SystemAdmin = Setting::model()->findByPk(1);
            if ($SystemAdmin === NULL)
                return;

		if($supervisor_email_address != $SystemAdmin->meta_value)
			$message->addCc($SystemAdmin->meta_value, 'Mikhil'); // system admin email address
        }


        // attachment
        if (!empty($job_cleaning_report)) {
            $attachment_path = Yii::app()->basePath . '/../uploads/temp/';
            if (file_exists($attachment_path . $job_cleaning_report))
                $message->addAttachment($attachment_path . $job_cleaning_report);
        }

        $message->setSubject($sub);
        $message->setHtml($mail);
        $message = $message->send();

        return $message;
    }

}

?>
