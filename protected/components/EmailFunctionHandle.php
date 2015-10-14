<?php

/**
 * This component used to send emails on below action
 * Generate Quote
 * Approve Quote
 * Decline Quote
 * Allocate Supervisor	
 * Allocate Site Supervisor
 * Allocate Staff
 * Book Re-Book Job
 */
class EmailFunctionHandle extends CApplicationComponent {
    /*     * ************************************* jobs sending emails ********************************************** */

    /**
     * Allocate Supervisor	
     * Allocate Site Supervisor
     * Allocate Staff
     * Book Re-Book Job
     */
    public static function sendEmail_JOB_ALLOCATION($email_temp_id, $job_id, $admin_user_id, $supervisor_id, $site_supervisor_id, $staff_user_id) {


        /****************************** */
        $mailgun_email_notification = Setting::model()->findByPk(8);
        if ($mailgun_email_notification === NULL)
            return;


        if ($mailgun_email_notification->meta_value != 'ON')
            return;

        /****************************** */
        $noreply_notifications_email_address = Setting::model()->findByPk(2);
        if ($noreply_notifications_email_address === NULL)
            return;

        $fromheader = Setting::model()->findByPk(6);
        if ($fromheader === NULL)
            return;
        /****************************** */

        // user details
        $user_model = User::model()->findByPk($admin_user_id);
        if ($user_model === NULL)
            return;


        // supervisor user details
        $supervisor_user_model = User::model()->findByPk($supervisor_id);
        if ($supervisor_user_model === NULL)
            return;


        // supervisor user details
        $site_supervisor_user_model = NULL;
        if ($site_supervisor_id != 0) {
            $site_supervisor_user_model = User::model()->findByPk($site_supervisor_id);
        }

        // staff user details
        $staff_user_model = NULL;
        if ($staff_user_id != 0) {
            $staff_user_model = User::model()->findByPk($staff_user_id);
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
 E-mail Formatting
         */
        $EmailFormatting = EmailFunctionHandle::emailFormatting_JOB_ALLOCATION($email_temp_id, $job_model, $quote_model, $user_model, $company_model, $contact_model, $site_model, $service_model, $building_model, $supervisor_user_model, $site_supervisor_user_model, $staff_user_model);

        /*
Set E-mail Parameter for Mail gun
         */

        $from = trim($noreply_notifications_email_address->meta_value);
        $fromheader = ucwords(trim($fromheader->meta_value));
        $to = trim($supervisor_user_model->email);
        $toname = ucwords(trim($supervisor_user_model->first_name . ' ' . $supervisor_user_model->last_name));
        $sub = strip_tags($EmailFormatting[0]);
        $mail = $EmailFormatting[1];
        $header = trim($noreply_notifications_email_address->meta_value);





        if ($staff_user_id != 0) { // allocate staff
            $to = trim($staff_user_model->email);
            $toname = ucwords(trim($staff_user_model->first_name . ' ' . $staff_user_model->last_name));
            $supervisor_email_address = trim($supervisor_user_model->email); // keep cc to supervisor
            $site_supervisor_email_address = trim($site_supervisor_user_model->email); // keep cc to site supervisor
            EmailFunctionHandle::sendMailThroughMailgun_JOB_ALLOCATION($email_temp_id, $from, $fromheader, $to, $toname, $sub, $mail, $header, $supervisor_email_address, $site_supervisor_email_address);
        } else if ($site_supervisor_id != 0) { // allocate site supervisor
            $to = trim($site_supervisor_user_model->email);
            $toname = ucwords(trim($site_supervisor_user_model->first_name . ' ' . $site_supervisor_user_model->last_name));
            $supervisor_email_address = trim($supervisor_user_model->email); // keep cc to supervisor
            EmailFunctionHandle::sendMailThroughMailgun_JOB_ALLOCATION($email_temp_id, $from, $fromheader, $to, $toname, $sub, $mail, $header, $supervisor_email_address, '');
        } else {  // allocate supervisor		
            EmailFunctionHandle::sendMailThroughMailgun_JOB_ALLOCATION($email_temp_id, $from, $fromheader, $to, $toname, $sub, $mail, $header, '', '');
        }

        //return true;
    }

    public static function emailFormatting_JOB_ALLOCATION($email_temp_id, $job_model, $quote_model, $user_model, $company_model, $contact_model, $site_model, $service_model, $building_model, $supervisor_user_model, $site_supervisor_user_model, $staff_user_model) {


        /*
E-mail Format Tags Declaration
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
            "{job_number}",
            "{job_frequency}",
            "{site_supervisor_full_name}",
            "{staff_full_name}",
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
        $quote_created_user = '<span style="">' . $user_model->first_name . ' ' . $user_model->last_name . '</span>';
        $quote_approved_user = '<span style="">' . $user_model->first_name . ' ' . $user_model->last_name . '</span>';
        $contact_name = '<span style="">' . $contact_model->first_name . ' ' . $contact_model->surname . '</span>';
        $site_id = '<span style="">' . $site_model->site_id . '</span>';
        $site_address = '<span style="">' . $site_model->address . ' ' . $site_model->suburb . ', ' . $site_model->state . ' ' . $site_model->postcode . '</span>';
        $building_name = '<span style="">' . $building_model->building_name . '</span>';
        $building_id = '<span style="">' . $building_model->building_no . '</span>';
        $supervisor_full_name = '<span style="">' . $supervisor_user_model->first_name . ' ' . $supervisor_user_model->last_name . '</span>';
        $admin_full_name = '<span style="">' . $user_model->first_name . ' ' . $user_model->last_name . '</span>';
        $job_from_date = '<span style="">' . date("d-m-Y", strtotime($job_model->job_started_date)) . '</span>';
        $job_to_date = '<span style="">' . date("d-m-Y", strtotime($job_model->job_end_date)) . '</span>';
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



        $staff_full_name = '';
        if ($staff_user_model !== NULL)
            $staff_full_name = '<span style="">' . $staff_user_model->first_name . ' ' . $staff_user_model->last_name . '</span>';


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
Assign a value in E-mail formats.
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
            "{job_number}" => $job_number,
            "{job_frequency}" => $job_frequency,
            "{site_supervisor_full_name}" => $site_supervisor_full_name,
            "{staff_full_name}" => $staff_full_name,
            "{supervisor_mobile_number}" => $supervisor_mobile_number,
            "{site_supervisor_mobile_number}" => $site_supervisor_mobile_number,
            "{scope}" => $scope,
            "{service_description}" => $service_description,
        );



        /*
 Replacing Dynamic data in E-mail Suject and Email template.
         */


        if (count($EmailFormat_changes_tags) > 0) {
            foreach ($EmailFormat_changes_tags as $tag) {
                $Mail_Subject = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Subject);
                $Mail_Format = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Format);
            }
        }


        return array($Mail_Subject, $Mail_Format);
    }

    public static function sendMailThroughMailgun_JOB_ALLOCATION($email_temp_id, $from, $fromheader, $to, $toname, $sub, $mail, $header, $supervisor_email_address, $site_supervisor_email_address) {

        $mailgunDomain_data = Setting::model()->findByPk(4);
        if ($mailgunDomain_data === NULL)
            return;
        $mailgunApiKey_data = Setting::model()->findByPk(3);
        if ($mailgunDomain_data === NULL)
            return;

        $mailgun = new MailgunApi($mailgunDomain_data->meta_value, $mailgunApiKey_data->meta_value);
        $message = $mailgun->newMessage();
        $message->setFrom($from, $fromheader);


        $email_address_receiver = Setting::model()->findByPk(7);
        if ($email_address_receiver === NULL)
            return;

        $to = trim($email_address_receiver->meta_value);
        $toname = '';
        $message->addTo($to, $toname);
        $message->setSubject($sub);
        $message->setHtml($mail);

        $message = $message->send();


        return $message;
    }

    /*     * ************************************* Quote sending emails ********************************************** */

    /**
     * Generate Quote
     * Approve Quote
     * Decline Quote
     */
    public static function sendEmail($email_temp_id, $quote_id, $user_id, $quote_sheet_pdf_name) {


        /****************************** */
        $mailgun_email_notification = Setting::model()->findByPk(8);
        if ($mailgun_email_notification === NULL)
            return;


        if ($mailgun_email_notification->meta_value != 'ON')
            return;

        /****************************** */
        $email_address_receiver = Setting::model()->findByPk(9);
        if ($email_address_receiver === NULL)
            return;

        $noreply_notifications_email_address = Setting::model()->findByPk(2);
        if ($noreply_notifications_email_address === NULL)
            return;

        $fromheader = Setting::model()->findByPk(6);
        if ($fromheader === NULL)
            return;
        /****************************** */


        // user details
        $user_model = User::model()->findByPk($user_id);
        if ($user_model === NULL)
            return;



        // quote details	
        $quote_model = Quotes::model()->findByPk($quote_id);
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



        $Criteria = new CDbCriteria();
        $Criteria->condition = "quote_id = " . $quote_model->id . " && original_record='1'";
        $job_model = QuoteJobs::model()->findAll($Criteria); // find related buildings by quote id
        if (isset($job_model) && count($job_model) > 0) {
            foreach ($job_model as $job) {
                $building_id = $job->building_id;
                //Buildings model
                $building_model[] = Buildings::model()->findByPk($building_id);
            }
        }


        /*
 E-mail Formatting
         */
        $EmailFormatting = EmailFunctionHandle::emailFormatting($email_temp_id, $quote_model, $user_model, $company_model, $contact_model, $site_model, $service_model, $building_model);

        /*
Set E-mail Parameter for Mail gun
         */
        $from = trim($noreply_notifications_email_address->meta_value);
        $fromheader = ucwords(trim($fromheader->meta_value));
        $to = trim($email_address_receiver->meta_value);
        $toname = ucwords(trim($fromheader->meta_value));
        $sub = strip_tags($EmailFormatting[0]);
        $mail = $EmailFormatting[1];
        $header = trim($noreply_notifications_email_address->meta_value);

        EmailFunctionHandle::sendMailThroughMailgun($from, $fromheader, $to, $toname, $sub, $mail, $header, $quote_sheet_pdf_name);



        //return true;
    }

    public static function emailFormatting($email_temp_id, $quote_model, $user_model, $company_model, $contact_model, $site_model, $service_model, $building_model) {


        /*
E-mail Format Tags Declaration
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
        );



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
        $quote_created_user = '<span style="">' . $user_model->first_name . ' ' . $user_model->last_name . '</span>';
        $quote_approved_user = '<span style="">' . $user_model->first_name . ' ' . $user_model->last_name . '</span>';
        $contact_name = '<span style="">' . $contact_model->first_name . ' ' . $contact_model->surname . '</span>';
        $site_id = '<span style="">' . $site_model->site_id . '</span>';
        $site_address = '<span style="">' . $site_model->address . ' ' . $site_model->suburb . ', ' . $site_model->state . ' ' . $site_model->postcode . '</span>';

        $building_name_array = array();
        $building_id_array = array();
        foreach ($building_model as $building) {
            $building_name_array[] = $building->building_name;
            $building_id_array[] = $building->building_no;
        }

        $building_name = '<span style="">' . implode(', ', $building_name_array) . '</span>';
        $building_id = '<span style="">' . implode(', ', $building_id_array) . '</span>';


        /*
Assign a value in E-mail formats.
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
        );



        /*
 Replacing Dynamic data in E-mail Suject and Email template.
         */


        if (count($EmailFormat_changes_tags) > 0) {
            foreach ($EmailFormat_changes_tags as $tag) {
                $Mail_Subject = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Subject);
                $Mail_Format = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Format);
            }
        }


        return array($Mail_Subject, $Mail_Format);
    }

    public static function sendMailThroughMailgun($from, $fromheader, $to, $toname, $sub, $mail, $header, $quote_sheet_pdf_name) {

        $mailgunDomain_data = Setting::model()->findByPk(4);
        if ($mailgunDomain_data === NULL)
            return;
        $mailgunApiKey_data = Setting::model()->findByPk(3);
        if ($mailgunDomain_data === NULL)
            return;

        $mailgun = new MailgunApi($mailgunDomain_data->meta_value, $mailgunApiKey_data->meta_value);
        $message = $mailgun->newMessage();
        $message->setFrom($from, $fromheader);

        $multiple_recipient = array();
        $multiple_recipient = explode(',', $to);

        if (count($multiple_recipient) > 1) {
            foreach ($multiple_recipient as $recipient) {
                $message->addTo($recipient, CommonFunctions::GetUserDetailsByEmailAddress($recipient));
            }
        } else {
            $message->addTo($to, $toname);
        }

        $message->setSubject($sub);
        $message->setHtml($mail);


        // attachment
        $attachment_path = Yii::app()->basePath . '/../uploads/temp/';
        foreach ($quote_sheet_pdf_name as $file) {
            if (file_exists($attachment_path . $file)) {
                $message->addAttachment($attachment_path . $file);
            }
        }

        $message = $message->send();

        return $message;
    }

// General email functions for user model

    public static function sendEmail_General($email_temp_id, $user_id) {


        /****************************** */
        $noreply_notifications_email_address = Setting::model()->findByPk(2);
        if ($noreply_notifications_email_address === NULL)
            return;

        $fromheader = Setting::model()->findByPk(6);
        if ($fromheader === NULL)
            return;
        /****************************** */

        // user details
        $user_model = User::model()->findByPk($user_id);
        if ($user_model === NULL)
            return;




        /*
 		E-mail Formatting
         */
        $EmailFormatting = EmailFunctionHandle::emailFormatting_General($email_temp_id, $user_model);

        /* Set E-mail Parameter for Mail gun */

        $from = trim($noreply_notifications_email_address->meta_value);   // system@highclean.com.au   
        $fromheader = ucwords(trim($fromheader->meta_value)); // HighClean System
        $to = trim($user_model->email); // user email address
        $toname = ucwords(trim($user_model->first_name . ' ' . $user_model->last_name)); // user first name and last name
        $sub = strip_tags($EmailFormatting[0]); // email subject
        $mail = $EmailFormatting[1]; // email message
        $header = trim($noreply_notifications_email_address->meta_value);



        EmailFunctionHandle::sendMailThroughMailgun_General($from, $fromheader, $to, $toname, $sub, $mail, $header);


        //return true;
    }

    public static function emailFormatting_General($email_temp_id, $user_model) {


        /* E-mail Format Tags Declaration */


        $EmailFormat_changes_tags = array(
            "{user_first_name}",
            "{user_last_name}",
            "{user_reset_link}",
        );


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



        $user_first_name = '<span style="">' . $user_model->first_name . '</span>';
        $user_last_name = '<span style="">' . $user_model->last_name . '</span>';
        $user_reset_link = '<a href="' . Yii::app()->getBaseUrl(true) . '/?r=site/Resetaccount&code=' . $user_model->id . '-' . $user_model->password . '"><span style="">Reset your password</span></a>';


        /* Assign a value in E-mail formats.  */

        $EmailFormat_changes_tags_value = array(
            "{user_first_name}" => $user_first_name,
            "{user_last_name}" => $user_last_name,
            "{user_reset_link}" => $user_reset_link,
        );



        /*
 Replacing Dynamic data in E-mail Suject and Email template.
         */


        if (count($EmailFormat_changes_tags) > 0) {
            foreach ($EmailFormat_changes_tags as $tag) {
                $Mail_Subject = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Subject);
                $Mail_Format = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Format);
            }
        }


        return array($Mail_Subject, $Mail_Format);
    }

    public static function sendMailThroughMailgun_General($from, $fromheader, $to, $toname, $sub, $mail, $header) {

        $mailgunDomain_data = Setting::model()->findByPk(4);
        if ($mailgunDomain_data === NULL)
            return;
        $mailgunApiKey_data = Setting::model()->findByPk(3);
        if ($mailgunDomain_data === NULL)
            return;

        $mailgun = new MailgunApi($mailgunDomain_data->meta_value, $mailgunApiKey_data->meta_value);
        $message = $mailgun->newMessage();
        $message->setFrom($from, $fromheader);

        $multiple_recipient = array();
        $multiple_recipient = explode(',', $to);

        if (count($multiple_recipient) > 1) {
            foreach ($multiple_recipient as $recipient) {
                $message->addTo($recipient, '');
            }
        } else {
            $message->addTo($to, $toname);
        }

        $message->setSubject($sub);
        $message->setHtml($mail);

        $message = $message->send();

        return $message;
    }

// Induction mail for user model

    public static function sendEmail_GeneralInduction($email_temp_id, $user_id, $induction_id) {


        $noreply_notifications_email_address = Setting::model()->findByPk(2);
        if ($noreply_notifications_email_address === NULL)
            return;

        $fromheader = Setting::model()->findByPk(6);
        if ($fromheader === NULL)
            return;
        /****************************** */

        // user details
        $user_model = User::model()->findByPk($user_id);
        if ($user_model === NULL)
            return;




        /*
 E-mail Formatting
         */
        $EmailFormatting = EmailFunctionHandle::emailFormatting_GeneralInduction($email_temp_id, $user_model, $induction_id);

        /*
Set E-mail Parameter for Mail gun
         */

        $from = trim($noreply_notifications_email_address->meta_value);   // system@highclean.com.au   
        $fromheader = ucwords(trim($fromheader->meta_value)); // HighClean System
        $to = trim($user_model->email); // user email address
        $toname = ucwords(trim($user_model->first_name . ' ' . $user_model->last_name)); // user first name and last name
        $sub = strip_tags($EmailFormatting[0]); // email subject
        $mail = $EmailFormatting[1]; // email message
        $header = trim($noreply_notifications_email_address->meta_value);



        EmailFunctionHandle::sendMailThroughMailgun_GeneralInduction($from, $fromheader, $to, $toname, $sub, $mail, $header);


        //return true;
    }

    public static function emailFormatting_GeneralInduction($email_temp_id, $user_model, $induction_id) {


        /*
E-mail Format Tags Declaration
         */


        $EmailFormat_changes_tags = array(
            "{user_first_name}",
            "{user_last_name}",
            "{induction_company}",
            "{induction_type}",
            "{site_name}",
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

        $induction_model = Induction::model()->findByPk($induction_id);
        if ($induction_model === NULL)
            return;

        $user_first_name = '<span style="">' . $user_model->first_name . '</span>';
        $user_last_name = '<span style="">' . $user_model->last_name . '</span>';

        $induction_company = '<span style="">' . InductionCompany::Model()->FindByPk($induction_model->induction_company_id)->name . '</span>';
        $induction_type = '<span style="">' . InductionType::Model()->FindByPk($induction_model->induction_type_id)->name . '</span>';
        $site_name = '<span style="">' . ContactsSite::Model()->FindByPk($induction_model->site_id)->site_name . '</span>';


        /*
Assign a value in E-mail formats.
         */

        $EmailFormat_changes_tags_value = array(
            "{user_first_name}" => $user_first_name,
            "{user_last_name}" => $user_last_name,
            "{induction_company}" => $induction_company,
            "{induction_type}" => $induction_type,
            "{site_name}" => $site_name,
        );



        /*
 Replacing Dynamic data in E-mail Suject and Email template.
         */


        if (count($EmailFormat_changes_tags) > 0) {
            foreach ($EmailFormat_changes_tags as $tag) {
                $Mail_Subject = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Subject);
                $Mail_Format = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Format);
            }
        }


        return array($Mail_Subject, $Mail_Format);
    }

    public static function sendMailThroughMailgun_GeneralInduction($from, $fromheader, $to, $toname, $sub, $mail, $header) {

        $mailgunDomain_data = Setting::model()->findByPk(4);
        if ($mailgunDomain_data === NULL)
            return;
        $mailgunApiKey_data = Setting::model()->findByPk(3);
        if ($mailgunDomain_data === NULL)
            return;

        $mailgun = new MailgunApi($mailgunDomain_data->meta_value, $mailgunApiKey_data->meta_value);
        $message = $mailgun->newMessage();
        $message->setFrom($from, $fromheader);

        $multiple_recipient = array();
        $multiple_recipient = explode(',', $to);

        if (count($multiple_recipient) > 1) {
            foreach ($multiple_recipient as $recipient) {
                $message->addTo($recipient, CommonFunctions::GetUserDetailsByEmailAddress($recipient));
            }
        } else {
            $message->addTo($to, $toname);
        }

        $message->setSubject($sub);
        $message->setHtml($mail);

        $message = $message->send();

        return $message;
    }

}

?>
