<?php

/**
 * This is the model class for table "{{operation_manager}}".
 *
 * The followings are the available columns in table '{{operation_manager}}':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $logo
 * @property string $auth_key
 * @property string $email_address
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
 * @property string $status
 */
class OperationManager extends CActiveRecord
{
	
	public $fullName;
	public $concatedAddress;	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{operation_manager}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name,  auth_key, email_address, password', 'required'),
			array('first_name, last_name, city', 'length', 'max'=>150),
			array('logo,  auth_key, email_address, password, ip_address, phone, mobile, street', 'length', 'max'=>255),
			array('state_province, zip_code', 'length', 'max'=>100),
			array('status', 'length', 'max'=>1),
			array('last_logined, added_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fullName, concatedAddress,  first_name, last_name, logo,  auth_key, email_address, password, ip_address, phone, mobile, last_logined, street, city, state_province, zip_code, added_date, status', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'logo' => 'Logo',
			'auth_key' => 'Auth Key',
			'email_address' => 'Email Address',
			'password' => 'Password',
			'ip_address' => 'Ip Address',
			'phone' => 'Phone',
			'mobile' => 'Mobile',
			'last_logined' => 'Last Logined',
			'street' => 'Street',
			'city' => 'City',
			'state_province' => 'State Province',
			'zip_code' => 'Zip Code',
			'added_date' => 'Added Date',
			'status' => 'Status',
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
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('auth_key',$this->auth_key,true);
		$criteria->compare('email_address',$this->email_address,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('last_logined',$this->last_logined,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state_province',$this->state_province,true);
		$criteria->compare('zip_code',$this->zip_code,true);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('status',$this->status,true);
		$criteria->addSearchCondition('concat(first_name, " ", last_name)', $this->fullName); 
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
	 * @return OperationManager the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getFullName()	{
			return $this->first_name . ' ' . $this->last_name;
	}

	public function getConcatedAddress()
	{
			return $this->street . ', ' . $this->city. ', ' . $this->state_province. ' ' . $this->zip_code;
	}

}
