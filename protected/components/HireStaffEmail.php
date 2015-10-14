<?php

/**
 * This component used to send emails on below action
 * System owner reset password
 */

class HireStaffEmail extends CApplicationComponent {
   
	public static function sendEmail($email_temp_id, $user_id) {

        /****************************** */
        $noreply_notifications_email_address = Setting::model()->findByPk(2);
        if ($noreply_notifications_email_address === NULL)
            return;

        $fromheader = Setting::model()->findByPk(6);
        if ($fromheader === NULL)
            return;
        /****************************** */

        // user details
        $user_model = HireStaff::model()->findByPk($user_id);
        if ($user_model === NULL)
            return;


        /* E-mail Formatting */
        $EmailFormatting = HireStaffEmail::emailFormatting($email_temp_id, $user_model);

        /* Set E-mail Parameter for Mail gun */

        $from = trim($noreply_notifications_email_address->meta_value);   // system@highclean.com.au   
        $fromheader = ucwords(trim($fromheader->meta_value)); // HighClean System
        $to = trim($user_model->email); // user email address
        $toname = ucwords(trim($user_model->first_name . ' ' . $user_model->last_name)); // user first name and last name
        $sub = strip_tags($EmailFormatting[0]); // email subject
        $mail = $EmailFormatting[1]; // email message
        $header = trim($noreply_notifications_email_address->meta_value);

        HireStaffEmail::sendMailThroughMailgun($from, $fromheader, $to, $toname, $sub, $mail, $header);

        //return true;
    }
   
    public static function emailFormatting($email_temp_id, $user_model) {

        /* E-mail Format Tags Declaration */

        $EmailFormat_changes_tags = array(
            "{business_name}",
            "{user_first_name}",
            "{user_last_name}",
            "{registration_link}",
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

		$agent_id = $user_model->agent_id;
		$agent_model = Agents::model()->findByPk($agent_id);

		$business_name = $agent_model->business_name;
        $user_first_name = '<span style="">' . $user_model->first_name . '</span>';
        $user_last_name = '<span style="">' . $user_model->last_name . '</span>';
        $registration_link = '<a href="' . Yii::app()->getBaseUrl(true) . '/member?r=member/registration&code=' . $user_model->id . '-' . $user_model->auth_key . '&service_agent_id=' . $agent_model->id . '"><span style="">Sign up</span></a>';


        /* Assign a value in E-mail formats.  */

        $EmailFormat_changes_tags_value = array(
            "{business_name}" => $business_name,
            "{user_first_name}" => $user_first_name,
            "{user_last_name}" => $user_last_name,
            "{registration_link}" => $registration_link,
        );

        /* Replacing Dynamic data in E-mail Subject and Email template.  */

        if (count($EmailFormat_changes_tags) > 0) {
            foreach ($EmailFormat_changes_tags as $tag) {
                $Mail_Subject = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Subject);
                $Mail_Format = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Format);
            }
        }


        return array($Mail_Subject, $Mail_Format);
    }

	// mail to staff after registration
	
	public static function sendEmailToStaff($email_temp_id, $user_id) {

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


        /* E-mail Formatting */
        $EmailFormatting = HireStaffEmail::staffEmailFormatting($email_temp_id, $user_model);

        /* Set E-mail Parameter for Mail gun */

        $from = trim($noreply_notifications_email_address->meta_value);   // system@highclean.com.au   
        $fromheader = ucwords(trim($fromheader->meta_value)); // HighClean System
        $to = trim($user_model->email); // user email address
        $toname = ucwords(trim($user_model->first_name . ' ' . $user_model->last_name)); // user first name and last name
        $sub = strip_tags($EmailFormatting[0]); // email subject
        $mail = $EmailFormatting[1]; // email message
        $header = trim($noreply_notifications_email_address->meta_value);

        HireStaffEmail::sendMailThroughMailgun($from, $fromheader, $to, $toname, $sub, $mail, $header);

        //return true;
    }
   public static function staffEmailFormatting($email_temp_id, $user_model) {

        /* E-mail Format Tags Declaration */

        $EmailFormat_changes_tags = array(
            "{business_name}",
            "{user_first_name}",
            "{user_last_name}",
            "{username}",
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

		$agent_id = $user_model->agent_id;
		$agent_model = Agents::model()->findByPk($agent_id);

		$business_name = $agent_model->business_name;
        $user_first_name = '<span style="">' . $user_model->first_name . '</span>';
        $user_last_name = '<span style="">' . $user_model->last_name . '</span>';
        $username = '<span style="">' . $user_model->username . '</span>';


        /* Assign a value in E-mail formats.  */

        $EmailFormat_changes_tags_value = array(
            "{business_name}" => $business_name,
            "{user_first_name}" => $user_first_name,
            "{user_last_name}" => $user_last_name,
            "{username}" => $username,
        );

        /* Replacing Dynamic data in E-mail Subject and Email template.  */

        if (count($EmailFormat_changes_tags) > 0) {
            foreach ($EmailFormat_changes_tags as $tag) {
                $Mail_Subject = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Subject);
                $Mail_Format = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Format);
            }
        }
        return array($Mail_Subject, $Mail_Format);
    }
   
   // mail to agent after new staff registration
   
   public static function sendEmailToAgent($email_temp_id, $user_id) {

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
		$agent_model = Agents::model()->findByPk($user_model->agent_id);
        if ($user_model === NULL)
            return;


        /* E-mail Formatting */
        $EmailFormatting = HireStaffEmail::agentEmailFormatting($email_temp_id, $user_model);

        /* Set E-mail Parameter for Mail gun */

        $from = trim($noreply_notifications_email_address->meta_value);   // system@highclean.com.au   
        $fromheader = ucwords(trim($fromheader->meta_value)); // HighClean System
        $to = trim($agent_model->business_email_address); // user email address
        $toname = ucwords(trim($agent_model->agent_first_name . ' ' . $agent_model->agent_first_name)); // user first name and last name
        $sub = strip_tags($EmailFormatting[0]); // email subject
        $mail = $EmailFormatting[1]; // email message
        $header = trim($noreply_notifications_email_address->meta_value);

        HireStaffEmail::sendMailThroughMailgun($from, $fromheader, $to, $toname, $sub, $mail, $header);

        //return true;
    }
   public static function agentEmailFormatting($email_temp_id, $user_model) {

        /* E-mail Format Tags Declaration */

        $EmailFormat_changes_tags = array(
            "{business_name}",
            "{user_first_name}",
            "{user_last_name}",
            "{gender}",
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

		$agent_id = $user_model->agent_id;
		$agent_model = Agents::model()->findByPk($agent_id);

		$business_name = $agent_model->business_name;
        $user_first_name = '<span style="">' . $user_model->first_name . '</span>';
        $user_last_name = '<span style="">' . $user_model->last_name . '</span>';
        $gender = '<span style="">' . $user_model->gender . '</span>';


        /* Assign a value in E-mail formats.  */

        $EmailFormat_changes_tags_value = array(
            "{business_name}" => $business_name,
            "{user_first_name}" => $user_first_name,
            "{user_last_name}" => $user_last_name,
            "{gender}" => $gender,
        );

        /* Replacing Dynamic data in E-mail Subject and Email template.  */

        if (count($EmailFormat_changes_tags) > 0) {
            foreach ($EmailFormat_changes_tags as $tag) {
                $Mail_Subject = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Subject);
                $Mail_Format = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Format);
            }
        }
        return array($Mail_Subject, $Mail_Format);
    }
   
	// common function
	
    public static function sendMailThroughMailgun($from, $fromheader, $to, $toname, $sub, $mail, $header) {

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

}

?>
