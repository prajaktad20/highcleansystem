<?php

/**
 * This is the model class for table "{{job_supervisor}}".
 *
 * The followings are the available columns in table '{{job_supervisor}}':
 * @property integer $id
 * @property integer $job_id
 * @property integer $user_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $mobile
 * @property string $signature
 * @property string $date_on_signed
 * @property integer $agent_id
 * The followings are the available model relations:
 * @property QuoteJobs $job
 */
class JobSupervisor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{job_supervisor}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('job_id, user_id, name', 'required'),
			array('job_id, user_id,agent_id', 'numerical', 'integerOnly'=>true),
			array('name, email, phone, mobile,date_on_signed', 'length', 'max'=>255),
                        array('signature', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, job_id, agent_id, user_id, name, email, phone, mobile', 'safe', 'on'=>'search'),
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
			'job' => array(self::BELONGS_TO, 'QuoteJobs', 'job_id'),
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
			'job_id' => 'Job',
			'user_id' => 'User',
			'name' => 'Name',
			'email' => 'Email',
			'phone' => 'Phone',
			'mobile' => 'Mobile',
                        'signature' => 'Signature',
                        'date_on_signed' => 'Date On Signed',
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
		$criteria->compare('job_id',$this->job_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('mobile',$this->mobile,true);
                $criteria->compare('signature',$this->signature,true);
                $criteria->compare('date_on_signed',$this->date_on_signed,true);
		$criteria->compare('agent_id',$this->agent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JobSupervisor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
