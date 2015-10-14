<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class MemberIdentity extends CUserIdentity
{
	private $_id;	
	private $agent_id;

	public function __construct($username, $password, $agent_id)
	{
		$this->username = $username;
		$this->password = $password;
		$this->agent_id = $agent_id;
	}


	public function authenticate()
	{



		$users = User::model()->findByAttributes(array(),
		array( 'condition'=>'status=:status and agent_id=:agent_id and username=:username or email=:email ',
				'params'=>array(':status'=>'1', 
				'username' => $this->username, 
				'email'=> $this->username,
				'agent_id'=> $this->agent_id,
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
		$this->setState('agent_id', $this->agent_id);

	
		$usergroup = Group::model()->findByAttributes(array('id'=>$users->role_id));
		$this->username = $usergroup->role_val;
		$this->setState('profile', $usergroup->role_val);           
		$this->setState('first_name', $users->first_name);

		
		

            }

			return !$this->errorCode;
        }
	
        
             
        public function getId() {
            return $this->_id;
        }

}
