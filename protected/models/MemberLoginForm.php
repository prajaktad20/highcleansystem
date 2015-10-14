<?php

/**
 * MemberLoginForm class.
 * MemberLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class MemberLoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;	
	public $agent_id;
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password,agent_id', 'required'),

                      //  array('username', 'email' ),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			//array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
                        'username' => 'username or email',
			'agent_id' => 'Client',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */

	public function authenticate($attribute,$params)
	{
	
		if(!$this->hasErrors())
		{	
			$this->_identity=new MemberIdentity($this->username,$this->password,$this->agent_id);
			if(!$this->_identity->authenticate())
				$this->addError('agent_id','Incorrect username /email or password for selected Service Agent.');
		}
		
	}


	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		
		if($this->_identity===null)
		{
			$this->_identity=new MemberIdentity($this->username,$this->password,$this->agent_id);
			//$this->_identity->authenticate();
			if(!$this->_identity->authenticate())
			$this->addError('agent_id','Incorrect username /email or password for selected Service Agent.');
		}
		if($this->_identity->errorCode===MemberIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
	

}
