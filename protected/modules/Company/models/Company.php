<?php

/**
 * This is the model class for table "{{company}}".
 *
 * The followings are the available columns in table '{{company}}':
 * @property integer $id
 * @property string $name
 * @property string $office_address
 * @property string $office_suburb
 * @property string $mailing_address
 * @property string $mailing_suburb
 * @property string $abn
 * @property string $phone
 * @property string $mobile
 * @property string $fax
 * @property string $email
 * @property string $website
 * @property integer $number_of_site
 * @property string $office_state
 * @property string $office_postcode
 * @property string $mailing_state
 * @property string $mailing_postcode
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 * @property integer $agent_id
 */
class Company extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{company}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('number_of_site,agent_id', 'numerical', 'integerOnly'=>true),
			array('name, office_address, office_suburb, mailing_address, mailing_suburb, abn, phone, mobile, fax, email, website, office_state, office_postcode, mailing_state, mailing_postcode', 'length', 'max'=>255),
			array('status', 'length', 'max'=>1),
			array('created_at, updated_at', 'safe'),
			
			array('name','unique', 'className' => 'Company'),
			array('email','unique', 'className' => 'Company'),
			array('email', 'email'),
			array('website', 'url'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, agent_id, office_address, office_suburb, mailing_address, mailing_suburb, abn, phone, mobile, fax, email, website, number_of_site, office_state, office_postcode, mailing_state, mailing_postcode, created_at, updated_at, status', 'safe', 'on'=>'search'),
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
			'name' => 'Company Name',
			'office_address' => 'Office Address',
			'office_suburb' => 'Office Suburb',
			'mailing_address' => 'Mailing Address',
			'mailing_suburb' => 'Mailing Suburb',
			'abn' => 'Abn',
			'phone' => 'Phone',
			'mobile' => 'Mobile',
			'fax' => 'Fax',
			'email' => 'Email',
			'website' => 'Website',
			'number_of_site' => 'Number Of Site',
			'office_state' => 'Office State',
			'office_postcode' => 'Office Postcode',
			'mailing_state' => 'Mailing State',
			'mailing_postcode' => 'Mailing Postcode',
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
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('office_address',$this->office_address,true);
		$criteria->compare('office_suburb',$this->office_suburb,true);
		$criteria->compare('mailing_address',$this->mailing_address,true);
		$criteria->compare('mailing_suburb',$this->mailing_suburb,true);
		$criteria->compare('abn',$this->abn,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('number_of_site',$this->number_of_site);
		$criteria->compare('office_state',$this->office_state,true);
		$criteria->compare('office_postcode',$this->office_postcode,true);
		$criteria->compare('mailing_state',$this->mailing_state,true);
		$criteria->compare('mailing_postcode',$this->mailing_postcode,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('status',$this->status,true);
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
	 * @return Company the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
