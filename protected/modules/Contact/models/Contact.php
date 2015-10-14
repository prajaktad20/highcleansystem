<?php

/**
 * This is the model class for table "{{contact}}".
 *
 * The followings are the available columns in table '{{contact}}':
 * @property integer $id
 * @property integer $company_id
 
 * @property string $first_name
 * @property string $surname
 * @property string $address
 * @property string $suburb
 * @property string $state
 * @property string $postcode
 * @property string $phone
 * @property string $mobile
 * @property string $email
 * @property string $position
 * @property integer $no_of_sites_managed
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 * @property integer $agent_id
 */
class Contact extends CActiveRecord
{

	public $fullName;
	public $concatedAddress;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{contact}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, first_name, surname', 'required'),
			array('company_id, no_of_sites_managed, agent_id', 'numerical', 'integerOnly'=>true),
			array('first_name, surname, suburb, state, postcode, phone, mobile, email, position', 'length', 'max'=>255),
			array('status', 'length', 'max'=>1),
			array('address, created_at, updated_at', 'safe'),
			
			
			array('email','unique', 'className' => 'Contact'),
			array('email', 'email'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fullName,concatedAddress, company_id, first_name, surname, address, suburb, state, postcode, phone, mobile, email, position, no_of_sites_managed, created_at, updated_at, status', 'safe', 'on'=>'search'),
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
			'company_id' => 'Company',
			'company_name' => 'Company Name',
			'first_name' => 'First Name',
			'surname' => 'Surname',
			'address' => 'Address',
			'suburb' => 'Suburb',
			'state' => 'State',
			'postcode' => 'Postcode',
			'phone' => 'Phone',
			'mobile' => 'Mobile',
			'email' => 'Email',
			'position' => 'Position',
			'no_of_sites_managed' => 'No Of Sites Managed',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'status' => 'Status',
			'agent_id' => 'Service Agent',
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

		if(isset(Yii::app()->getController()->getAction()->controller->action->id) && Yii::app()->getController()->getAction()->controller->action->id == 'ViewContacts') {
		
			if(isset($_GET['company_id']) && $_GET['company_id'] > 0)		
			$this->company_id = $_GET['company_id'];
		}

		
		$criteria->compare('id',$this->id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('suburb',$this->suburb,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('no_of_sites_managed',$this->no_of_sites_managed);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('status',$this->status,true);
		$criteria->addSearchCondition('concat(first_name, " ", surname)', $this->fullName); 
		$criteria->addSearchCondition('concat(address, ",", suburb,",",state," ",postcode)', $this->concatedAddress); 
		$criteria->compare('agent_id',$this->agent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
		// CgridView Records/page section			
		'pagination'=>array(
			'pageSize'=> Yii::app()->user->getState('pageSize',
			Yii::app()->params['defaultPageSize']),
		),	
		
			'sort'=>array(
            'defaultOrder'=>'id DESC',
        ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function getFullName()
	{
			return $this->first_name . ' ' . $this->surname;
	}
	
		public function getconcatedAddress()
	{
			return $this->address . ', ' . $this->suburb. ', ' . $this->state. ' ' . $this->postcode;
	}
	
}
