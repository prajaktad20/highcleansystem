<?php

/**
 * This is the model class for table "{{user_licenses}}".
 *
 * The followings are the available columns in table '{{user_licenses}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $license_type_id
 * @property string $license_number
 * @property string $license_issued_by
 * @property string $license_issued_date
 * @property string $license_expiry_date
 * @property string $license_file
 * @property integer $agent_id
 */
class UserLicenses extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_licenses}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, license_type_id, license_issued_by, license_issued_date, license_file', 'required'),
			array('user_id, license_type_id,agent_id', 'numerical', 'integerOnly'=>true),
			array('license_number, license_issued_by, license_file', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, agent_id, license_type_id, license_number, license_issued_by, license_issued_date, license_expiry_date, license_file', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'license_type_id' => 'License Type',
			'license_number' => 'License Number',
			'license_issued_by' => 'License Issued By',
			'license_issued_date' => 'License Issued Date',
			'license_expiry_date' => 'License Expiry Date',
			'license_file' => 'License File',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('license_type_id',$this->license_type_id);
		$criteria->compare('license_number',$this->license_number,true);
		$criteria->compare('license_issued_by',$this->license_issued_by,true);
		$criteria->compare('license_issued_date',$this->license_issued_date,true);
		$criteria->compare('license_expiry_date',$this->license_expiry_date,true);
		$criteria->compare('license_file',$this->license_file,true);
		$criteria->compare('agent_id',$this->agent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserLicenses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
