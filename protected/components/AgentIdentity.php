<?php

/**
* UserIdentity represents the data needed to identity a user.
* It contains the authentication method that checks if the provided
* data can identity the user.
*/
class AgentIdentity extends CUserIdentity
		{
		private $_id;	

		public function __construct($username, $password)
		{
			$this->username = $username;
			$this->password = $password;
		}


		public function authenticate()
		{

			$users = Agents::model()->findByAttributes(array(),
					array( 'condition'=>'status=:status and business_email_address=:business_email_address',
							'params'=>array(':status'=>'1', 
							'business_email_address'=> $this->username
							) 
					)
			);


		if($users!=null){
			$this->password = md5($this->password);
		} 

		if($users===null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;                
		} else if($users->password != $this->password){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}

		else {

			$this->errorCode = self::ERROR_NONE;
			$this->_id = $users->id;
			$this->setState('agent_id', $users->id);

			$this->username = 'agent';
			$this->setState('profile', 'agent');           
			$this->setState('first_name', $users->agent_first_name);

		}

		return !$this->errorCode;
		}



		public function getId() {
		return $this->_id;
		}

}
