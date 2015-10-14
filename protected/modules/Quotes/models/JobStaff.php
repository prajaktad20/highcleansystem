<?php

/**
 * This is the model class for table "{{job_staff}}".
 *
 * The followings are the available columns in table '{{job_staff}}':
 * @property integer $id
 * @property integer $job_id
 * @property integer $user_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $mobile
 * @property string $job_date
 * @property string $date_on_signed
 * @property string $signature
 * @property string $day_night
 * @property string $msg_sent_text
 * @property string $msg_replied_text
 * @property string $msg_sent_status
 * @property string $msg_replied_status
 * @property string $msg_sent_date_time
 * @property string $msg_replied_when
 * @property integer $msg_id
 * @property string $msg_sms_service_used
 * @property integer $agent_id
 *
 * The followings are the available model relations:
 * @property QuoteJobs $job
 */
class JobStaff extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{job_staff}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('job_id, user_id, name, job_date', 'required'),
			array('job_id, user_id, msg_id,agent_id', 'numerical', 'integerOnly'=>true),
			array('name, email, phone, mobile, msg_sent_text, msg_replied_text', 'length', 'max'=>255),
			array('day_night', 'length', 'max'=>5),
			array('msg_sent_status', 'length', 'max'=>9),
			array('place_to_come', 'length', 'max'=>20),
			array('msg_replied_status, msg_sms_service_used', 'length', 'max'=>1),
			array('msg_replied_when', 'length', 'max'=>100),
			array('date_on_signed, signature, msg_sent_date_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, job_id, agent_id, place_to_come, user_id, name, email, phone, mobile, job_date, date_on_signed, signature, day_night, msg_sent_text, msg_replied_text, msg_sent_status, msg_replied_status, msg_sent_date_time, msg_replied_when, msg_id, msg_sms_service_used', 'safe', 'on'=>'search'),
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
			'job_date' => 'Job Date',
			'date_on_signed' => 'Date On Signed',
			'signature' => 'Signature',
			'day_night' => 'Day Night',
			'msg_sent_text' => 'Msg Sent Text',
			'msg_replied_text' => 'Msg Replied Text',
			'msg_sent_status' => 'Msg Sent Status',
			'msg_replied_status' => 'Msg Replied Status',
			'msg_sent_date_time' => 'Msg Sent Date Time',
			'msg_replied_when' => 'Msg Replied When',
			'msg_id' => 'Msg',
			'msg_sms_service_used' => 'Msg Sms Service Used',
			'place_to_come' => 'Place to Come',
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
		$criteria->compare('job_date',$this->job_date,true);
		$criteria->compare('date_on_signed',$this->date_on_signed,true);
		$criteria->compare('signature',$this->signature,true);
		$criteria->compare('day_night',$this->day_night,true);
		$criteria->compare('msg_sent_text',$this->msg_sent_text,true);
		$criteria->compare('msg_replied_text',$this->msg_replied_text,true);
		$criteria->compare('msg_sent_status',$this->msg_sent_status,true);
		$criteria->compare('msg_replied_status',$this->msg_replied_status,true);
		$criteria->compare('msg_sent_date_time',$this->msg_sent_date_time,true);
		$criteria->compare('msg_replied_when',$this->msg_replied_when,true);
		$criteria->compare('msg_id',$this->msg_id);
		$criteria->compare('msg_sms_service_used',$this->msg_sms_service_used,true);
		$criteria->compare('place_to_come',$this->place_to_come,true);
		$criteria->compare('agent_id',$this->agent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,


	'pagination' => array(
                'pageSize' => 100,
            ),


		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JobStaff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
