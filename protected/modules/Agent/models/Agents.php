<?php

/**
 * This is the model class for table "{{agent}}".
 *
 * The followings are the available columns in table '{{agent}}':
 * @property integer $id
 * @property string $agent_first_name
 * @property string $agent_last_name
 * @property string $business_name
 * @property string $logo
 * @property string $business_url_code
 * @property string $auth_key
 * @property string $business_email_address
 * @property string $password
 * @property string $ip_address
 * @property string $phone
 * @property string $mobile
 * @property string $last_logined
 * @property string $street
 * @property string $city
 * @property string $state_province
 * @property string $zip_code
 * @property string $added_date
 * @property string $fax
 * @property string $abn
 * @property string $website
 * @property string $signature_image
 *
 * The followings are the available model relations:
 * @property BuildingDocuments[] $buildingDocuments
 * @property BuildingImages[] $buildingImages
 * @property Buildings[] $buildings
 * @property Company[] $companies
 * @property Contact[] $contacts
 * @property ContactUserRelation[] $contactUserRelations
 * @property Induction[] $inductions
 * @property JobExtraMember[] $jobExtraMembers
 * @property JobImages[] $jobImages
 * @property JobSiteSupervisor[] $jobSiteSupervisors
 * @property JobStaff[] $jobStaff
 * @property JobSupervisor[] $jobSupervisors
 * @property JobWorking[] $jobWorkings
 * @property QuoteJobServices[] $quoteJobServices
 * @property QuoteJobs[] $quoteJobs
 * @property Quotes[] $quotes
 * @property SiteContactRelation[] $siteContactRelations
 * @property TimesheetApprovedStatus[] $timesheetApprovedStatuses
 * @property TimesheetPayDates[] $timesheetPayDates
 * @property TimesheetPayDatesUser[] $timesheetPayDatesUsers
 * @property User[] $users
 * @property UserLicenses[] $userLicenses
 */
class Agents extends CActiveRecord
{

	public $fullName;
	public $concatedAddress;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{agent}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('agent_first_name, agent_last_name, business_name, business_url_code, auth_key, business_email_address, password', 'required'),
			array('agent_first_name, agent_last_name, city, fax', 'length', 'max'=>150),
			array('business_name, logo, business_url_code, auth_key, signature_image, abn, website, business_email_address, password, ip_address, phone, mobile, street', 'length', 'max'=>255),
			array('state_province, zip_code', 'length', 'max'=>100),
			array('last_logined, added_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fullName, concatedAddress, signature_image, fax, abn, website, agent_first_name, agent_last_name, business_name, logo, business_url_code, auth_key, business_email_address, password, ip_address, phone, mobile, last_logined, street, city, state_province, zip_code, added_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'buildingDocuments' => array(self::HAS_MANY, 'BuildingDocuments', 'agent_id'),
			'buildingImages' => array(self::HAS_MANY, 'BuildingImages', 'agent_id'),
			'buildings' => array(self::HAS_MANY, 'Buildings', 'agent_id'),
			'companies' => array(self::HAS_MANY, 'Company', 'agent_id'),
			'contacts' => array(self::HAS_MANY, 'Contact', 'agent_id'),
			'contactUserRelations' => array(self::HAS_MANY, 'ContactUserRelation', 'agent_id'),
			'inductions' => array(self::HAS_MANY, 'Induction', 'agent_id'),
			'jobExtraMembers' => array(self::HAS_MANY, 'JobExtraMember', 'agent_id'),
			'jobImages' => array(self::HAS_MANY, 'JobImages', 'agent_id'),
			'jobSiteSupervisors' => array(self::HAS_MANY, 'JobSiteSupervisor', 'agent_id'),
			'jobStaff' => array(self::HAS_MANY, 'JobStaff', 'agent_id'),
			'jobSupervisors' => array(self::HAS_MANY, 'JobSupervisor', 'agent_id'),
			'jobWorkings' => array(self::HAS_MANY, 'JobWorking', 'agent_id'),
			'quoteJobServices' => array(self::HAS_MANY, 'QuoteJobServices', 'agent_id'),
			'quoteJobs' => array(self::HAS_MANY, 'QuoteJobs', 'agent_id'),
			'quotes' => array(self::HAS_MANY, 'Quotes', 'agent_id'),
			'siteContactRelations' => array(self::HAS_MANY, 'SiteContactRelation', 'agent_id'),
			'timesheetApprovedStatuses' => array(self::HAS_MANY, 'TimesheetApprovedStatus', 'agent_id'),
			'timesheetPayDates' => array(self::HAS_MANY, 'TimesheetPayDates', 'agent_id'),
			'timesheetPayDatesUsers' => array(self::HAS_MANY, 'TimesheetPayDatesUser', 'agent_id'),
			'users' => array(self::HAS_MANY, 'User', 'agent_id'),
			'userLicenses' => array(self::HAS_MANY, 'UserLicenses', 'agent_id'),
			'Hazard' => array(self::HAS_MANY, 'Hazard', 'agent_id'),
			'Incident' => array(self::HAS_MANY, 'Incident', 'agent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Agent ID',
			'agent_first_name' => 'Client First Name',
			'agent_last_name' => 'Client Last Name',
			'business_name' => 'Business Name',
			'logo' => 'Logo',
			'business_url_code' => 'Business Url Code',
			'auth_key' => 'Auth Key',
			'business_email_address' => 'Business Email Address',
			'password' => 'Password',
			'ip_address' => 'Ip Address',
			'phone' => 'Phone',
			'mobile' => 'Mobile',
			'last_logined' => 'Last Logined',
			'street' => 'Street',
			'city' => 'City',
			'state_province' => 'State Province',
			'zip_code' => 'Zip Code',
			'fax'=> 'Fax',
			'abn'=> 'ABN',
			'website'=> 'Website',
			'added_date' => 'Registered Date',
			'signature_image'=> 'Signature Image'
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

		$criteria->compare('id',$this->id);
		$criteria->compare('agent_first_name',$this->agent_first_name,true);
		$criteria->compare('agent_last_name',$this->agent_last_name,true);
		$criteria->compare('business_name',$this->business_name,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('business_url_code',$this->business_url_code,true);
		$criteria->compare('auth_key',$this->auth_key,true);
		$criteria->compare('business_email_address',$this->business_email_address,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('last_logined',$this->last_logined,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state_province',$this->state_province,true);
		$criteria->compare('zip_code',$this->zip_code,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('abn',$this->abn,true);
		$criteria->compare('signature_image',$this->signature_image,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->addSearchCondition('concat(agent_first_name, " ", agent_last_name)', $this->fullName); 
		$criteria->addSearchCondition('concat(street, ",", city,",",state_province," ",zip_code)', $this->concatedAddress); 

	

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
					'pageSize'=> Yii::app()->user->getState('pageSize',
					Yii::app()->params['defaultPageSize']),
				),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Agent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getFullName()	{
			return $this->agent_first_name . ' ' . $this->agent_last_name;
	}

	public function getConcatedAddress()
	{
			return $this->street . ', ' . $this->city. ', ' . $this->state_province. ' ' . $this->zip_code;
	}

}
