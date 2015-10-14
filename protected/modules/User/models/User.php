<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $Avatar
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $role_id
 * @property string $last_logined
 * @property string $salt
 * @property string $ip_address
 * @property string $gender
 * @property string $date_of_birth
 * @property string $view_jobs
 * @property string $home_phone
 * @property string $mobile_phone
 * @property string $street
 * @property string $city
 * @property string $state_province
 * @property integer $country_id
 * @property string $zip_code
 * @property string $interested_in
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 * @property string $regular_hours
 * @property string $overtime_hours
 * @property string $double_time_hours
 * @property string $marital_status
 * @property string $australian_citizen
 * @property string $australian_resident
 * @property string $passport_number
 * @property string $visa_number
 * @property string $driving_licence
 * @property string $driving_licence_state
 * @property string $em_first_name
 * @property string $em_last_name
 * @property string $em_address
 * @property string $em_superb
 * @property string $em_state
 * @property string $em_postcode
 * @property string $em_phone
 * @property string $em_mobile
 * @property string $em_email
 * @property string $em_relationship_with_user
 * @property string $superannuation_company
 * @property string $superannuation_number
 * @property string $tax_file_number
 * @property integer $agent_id
 * @property string $bank_name
 * @property string $bank_bsb
 * @property integer $bank_account
 
 * The followings are the available model relations:
 * @property Countries $country
 * @property Group $role
 */
class User extends CActiveRecord
{

	public $fullName;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, username, password, email, country_id', 'required'),
			array('role_id, country_id, agent_id', 'numerical', 'integerOnly'=>true),
			array('Avatar, first_name, last_name, username, password, email, home_phone, mobile_phone, street, city, state_province, zip_code, passport_number, visa_number, driving_licence, driving_licence_state, em_first_name, em_last_name, em_address, em_superb, em_state, em_postcode, em_phone, em_mobile, em_email, em_relationship_with_user, superannuation_company, superannuation_number, tax_file_number, bank_name, bank_bsb, bank_account', 'length', 'max'=>255),
			array('salt, ip_address', 'length', 'max'=>32),
			array('gender', 'length', 'max'=>7),
			array('view_jobs, status', 'length', 'max'=>1),
			array('interested_in', 'length', 'max'=>17),
			array('regular_hours, overtime_hours, double_time_hours', 'length', 'max'=>5),
			array('marital_status', 'length', 'max'=>15),
			array('australian_citizen, australian_resident', 'length', 'max'=>3),
			array('last_logined, date_of_birth, created_at, updated_at', 'safe'),


			array('Avatar', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true, 'on'=>'update'), // this 
			array('email', 'email'),
			array('username','not_present_in_username'),
			array('email','not_present_in_email'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, Avatar, agent_id, first_name, last_name, username, password, email, role_id, last_logined, salt, ip_address, gender, date_of_birth, view_jobs, home_phone, mobile_phone, street, city, state_province, country_id, zip_code, interested_in, created_at, updated_at, status, regular_hours, overtime_hours, double_time_hours, marital_status, australian_citizen, australian_resident, passport_number, visa_number, driving_licence, driving_licence_state, em_first_name, em_last_name, em_address, em_superb, em_state, em_postcode, em_phone, em_mobile, em_email, em_relationship_with_user, superannuation_company, superannuation_number, tax_file_number, bank_name, bank_bsb, bank_account', 'safe', 'on'=>'search'),
		);
	}

	
	
	 public function not_present_in_username($attribute, $params)
    {
        
		$criteria = new CDbCriteria();
		$criteria->select = "*";
		$criteria->addCondition("agent_id=".$this->agent_id." && username='".$this->username."'");
  
		$data = User::model()->find($criteria);
		
        if(!empty($data))
		$this->addError($attribute, Yii::t('username','username already exists!'));
    }
		
	
	 public function not_present_in_email($attribute, $params)
    {
        
		$criteria = new CDbCriteria();
		$criteria->select = "*";
		$criteria->addCondition("agent_id=".$this->agent_id." && email='".$this->email."'");
  
		$data = User::model()->find($criteria);
		
        if(!empty($data))
		$this->addError($attribute, Yii::t('email','Email already exists!'));
    }
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'country' => array(self::BELONGS_TO, 'Countries', 'country_id'),
			'role' => array(self::BELONGS_TO, 'Group', 'role_id'),
			'businessPartner' => array(self::BELONGS_TO, 'Agent', 'agent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'Avatar' => 'Avatar',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'role_id' => 'Role',
			'last_logined' => 'Last Logined',
			'salt' => 'Salt',
			'ip_address' => 'Ip Address',
			'gender' => 'Gender',
			'date_of_birth' => 'Date Of Birth',
			'view_jobs' => 'View Jobs',
			'home_phone' => 'Home Phone',
			'mobile_phone' => 'Mobile',
			'street' => 'Street',
			'city' => 'Suburb',
			'state_province' => 'State Province',
			'country_id' => 'Country',
			'zip_code' => 'Zip Code',
			'interested_in' => 'Interested In',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'status' => 'Status',
			'regular_hours' => 'RH',
			'overtime_hours' => 'OH',
			'double_time_hours' => 'DTH',
			'marital_status' => 'Marital Status',
			'australian_citizen' => 'Australian Citizen',
			'australian_resident' => 'Australian Resident',
			'passport_number' => 'Passport Number',
			'visa_number' => 'Visa Number',
			'driving_licence' => 'Driving Licence',
			'driving_licence_state' => 'Driving Licence State',
			'em_first_name' => 'First Name',
			'em_last_name' => 'Last Name',
			'em_address' => 'Address',
			'em_superb' => 'Suburb',
			'em_state' => 'State',
			'em_postcode' => 'Postcode',
			'em_phone' => 'Phone',
			'em_mobile' => 'Mobile',
			'em_email' => 'Email',
			'em_relationship_with_user' => 'Relationship With User',
			'superannuation_company' => 'Superannuation Company',
			'superannuation_number' => 'Superannuation Number',
			'tax_file_number' => 'Tax File Number',
			'agent_id' => 'Service Agent',
			'bank_name' => 'Bank Name',
			'bank_bsb' => 'Bank BSB',
			'bank_account' => 'Bank Account No.',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $this->agent_id = CommonFunctions::getCurrentpageAgentId(Yii::app()->user->name);
                
                
                $criteria->compare('id',$this->id);

		if(isset(Yii::app()->controller->action->id) && Yii::app()->controller->action->id == 'admin') { 
		
		if(Yii::app()->user->name === 'site_supervisor') {
			$this->role_id = 3;
			$criteria->compare('role_id',$this->role_id);
		} else if(Yii::app()->user->name === 'supervisor') {
			$criteria->addInCondition('role_id',array(3,6));	
		} else {
			$criteria->compare('role_id',$this->role_id);
		}
		
		} else {
			$criteria->compare('role_id',$this->role_id);
		}
		
		
		
		$criteria->compare('Avatar',$this->Avatar,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('last_logined',$this->last_logined,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);
		$criteria->compare('view_jobs',$this->view_jobs,true);
		$criteria->compare('home_phone',$this->home_phone,true);
		$criteria->compare('mobile_phone',$this->mobile_phone,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state_province',$this->state_province,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('zip_code',$this->zip_code,true);
		$criteria->compare('interested_in',$this->interested_in,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('regular_hours',$this->regular_hours,true);
		$criteria->compare('overtime_hours',$this->overtime_hours,true);
		$criteria->compare('double_time_hours',$this->double_time_hours,true);
		$criteria->compare('marital_status',$this->marital_status,true);
		$criteria->compare('australian_citizen',$this->australian_citizen,true);
		$criteria->compare('australian_resident',$this->australian_resident,true);
		$criteria->compare('passport_number',$this->passport_number,true);
		$criteria->compare('visa_number',$this->visa_number,true);
		$criteria->compare('driving_licence',$this->driving_licence,true);
		$criteria->compare('driving_licence_state',$this->driving_licence_state,true);
		$criteria->compare('em_first_name',$this->em_first_name,true);
		$criteria->compare('em_last_name',$this->em_last_name,true);
		$criteria->compare('em_address',$this->em_address,true);
		$criteria->compare('em_superb',$this->em_superb,true);
		$criteria->compare('em_state',$this->em_state,true);
		$criteria->compare('em_postcode',$this->em_postcode,true);
		$criteria->compare('em_phone',$this->em_phone,true);
		$criteria->compare('em_mobile',$this->em_mobile,true);
		$criteria->compare('em_email',$this->em_email,true);
		$criteria->compare('em_relationship_with_user',$this->em_relationship_with_user,true);
		$criteria->compare('superannuation_company',$this->superannuation_company,true);
		$criteria->compare('superannuation_number',$this->superannuation_number,true);
		$criteria->compare('tax_file_number',$this->tax_file_number,true);
		$criteria->compare('agent_id',$this->agent_id);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('bank_bsb',$this->bank_bsb,true);
		$criteria->compare('bank_account',$this->bank_account,true);
		$criteria->addSearchCondition('concat(first_name, " ", last_name)', $this->fullName); 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,

			// CgridView Records/page section			
				'pagination'=>array(
					'pageSize'=> Yii::app()->user->getState('pageSize',
					Yii::app()->params['defaultPageSize']),
				),	
		
				'sort'=>array(
			    'defaultOrder'=>'updated_at DESC',
			),

		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getFullName()
	{
			return $this->first_name . ' ' . $this->last_name;
	}
}
