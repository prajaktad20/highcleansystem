<?php

/**
 * This component used to send emails on below action
 * System owner reset password
 */

class MemberEmailResetPwd extends CApplicationComponent {
   

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
        $user_model = User::model()->findByPk($user_id);
        if ($user_model === NULL)
            return;


        /* E-mail Formatting */
        $EmailFormatting = MemberEmailResetPwd::emailFormatting($email_temp_id, $user_model);

        /* Set E-mail Parameter for Mail gun */

        $from = trim($noreply_notifications_email_address->meta_value);   // system@highclean.com.au   
        $fromheader = ucwords(trim($fromheader->meta_value)); // HighClean System
        $to = trim($user_model->email); // user email address
        $toname = ucwords(trim($user_model->first_name . ' ' . $user_model->last_name)); // user first name and last name
        $sub = strip_tags($EmailFormatting[0]); // email subject
        $mail = $EmailFormatting[1]; // email message
        $header = trim($noreply_notifications_email_address->meta_value);



        MemberEmailResetPwd::sendMailThroughMailgun($from, $fromheader, $to, $toname, $sub, $mail, $header);


        //return true;
    }
   
    public static function emailFormatting($email_temp_id, $user_model) {


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
        $user_reset_link = '<a href="' . Yii::app()->getBaseUrl(true) . '/member?r=site/Resetaccount&code=' . $user_model->id . '-' . $user_model->password . '"><span style="">Reset your password</span></a>';


        /* Assign a value in E-mail formats.  */

        $EmailFormat_changes_tags_value = array(
            "{user_first_name}" => $user_first_name,
            "{user_last_name}" => $user_last_name,
            "{user_reset_link}" => $user_reset_link,
        );



        /* Replacing Dynamic data in E-mail Suject and Email template.  */


        if (count($EmailFormat_changes_tags) > 0) {
            foreach ($EmailFormat_changes_tags as $tag) {
                $Mail_Subject = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Subject);
                $Mail_Format = str_replace($tag, $EmailFormat_changes_tags_value[$tag], $Mail_Format);
            }
        }


        return array($Mail_Subject, $Mail_Format);
    }

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
