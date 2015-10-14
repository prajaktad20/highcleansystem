<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class OperationManagerIdentity extends CUserIdentity
{
	private $_id;	
	
	public function __construct($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}


	public function authenticate()
	{

	
	$users = OperationManager::model()->findByAttributes(array(),
		array( 'condition'=>'status=:status and email_address=:email_address',
				'params'=>array(':status'=>'1', 
				'email_address'=> $this->username
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
		$this->username = 'operation_manager';
		$this->setState('profile', 'operation_manager');           
		$this->setState('first_name', $users->first_name);
		

            }

			return !$this->errorCode;
        }
	
        
             
        public function getId() {
            return $this->_id;
        }

}
