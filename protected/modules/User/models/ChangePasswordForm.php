<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ChangePasswordForm extends CFormModel
{
     /*   public $owner_name;
        public $email;
        public $phone; */
        public $password;
	public $confirm_password;






	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{

	$obj= new CHtmlPurifier();

		return array(
			array('password,confirm_password', 'required'),

              
            array('password', 'length', 'min' => 6, 'max' => 150),
		  	array('password','filter','filter'=>array($obj,'purify')),
			array('confirm_password','filter','filter'=>array($obj,'purify')),
			array('confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match"),
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

                            
                                'password' => 'New Password',
                                'confirmpassword' => 'Confirm Password',


		);
	}


}