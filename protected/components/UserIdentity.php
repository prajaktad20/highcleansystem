<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	
	
	public function authenticate()
	{

		$users = SystemOwner::model()->findByAttributes(array(),
		array( 'condition'=>'status=:status and username=:username or email=:email',
				'params'=>array(':status'=>'1', 
				'username' => $this->username, 
				'email'=> $this->username
				) 
			)
	);
	   
             if($users!=null){
              $this->password = md5($this->password);
             }
            if($users===null) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;                
            }
             else if($users->password != $this->password){
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }
       
            else {			               
		$this->errorCode = self::ERROR_NONE;
		$this->_id = $users->id;
		$this->username = 'system_owner';
		$this->setState('profile', 'system_owner');           
		$this->setState('first_name', $users->first_name);
            }

			return !$this->errorCode;
        }
	
        
             
        public function getId() {
            return $this->_id;
        }

}
