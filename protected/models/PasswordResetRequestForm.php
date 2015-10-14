<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class PasswordResetRequestForm extends CFormModel
{

        public $email;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{

	$obj= new CHtmlPurifier();

		return array(
			// name, email, subject and body are required
			//array('email ,name, business_name,phone,website ,password,confirm_password, address, location,category,verifyCode', 'required'),
                        array('email', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
                                'email' => 'Email Address',
                              
		);
	}
}