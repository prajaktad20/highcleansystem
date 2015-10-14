<?php

/**
 * This is the model class for table "{{timesheet_pay_dates_user}}".
 *
 * The followings are the available columns in table '{{timesheet_pay_dates_user}}':
 * @property integer $id
 * @property integer $job_id
 * @property string $saved_status
 * @property integer $pay_date_id
 * @property string $working_date
 * @property string $day_night
 * @property string $work_start_time
 * @property string $work_end_time
 * @property string $total_hours
 * @property string $regular_hours
 * @property string $overtime_hours
 * @property string $double_time_hours
 * @property integer $agent_id
 *
 * The followings are the available model relations:
 * @property TimesheetPayDates $payDate
 */
class TimesheetPayDatesUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{timesheet_pay_dates_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pay_date_id, user_id, working_date', 'required'),
			array('job_id, pay_date_id,user_id,agent_id', 'numerical', 'integerOnly'=>true),
			array('day_night, total_hours, regular_hours, overtime_hours, double_time_hours', 'length', 'max'=>10),
			array('day,work_start_time, work_end_time', 'length', 'max'=>100),
			array('job_location, service_name,formatted_working_date', 'length', 'max'=>255),
			array('saved_status', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, job_id, agent_id, user_id,saved_status, job_location, service_name, pay_date_id, working_date, day_night, work_start_time, work_end_time, total_hours, regular_hours, overtime_hours, double_time_hours', 'safe', 'on'=>'search'),
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
			'payDate' => array(self::BELONGS_TO, 'TimesheetPayDates', 'pay_date_id'),
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
			'user_id'=>'User Id',
			'saved_status' => 'Saved Status',
			'pay_date_id' => 'Pay Date',
			'day' => 'Day',
			'working_date' => 'Working Date',
			'formatted_working_date' => 'formatted_working_date',
			'day_night' => 'Day Night',
			'work_start_time' => 'Work Start Time',
			'work_end_time' => 'Work End Time',
			'total_hours' => 'Total Hours',
			'regular_hours' => 'Regular Hours',
			'overtime_hours' => 'Overtime Hours',
			'double_time_hours' => 'Double Time Hours',
			'job_location' => 'Job Location',
			'service_name' => 'Service',
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
		$criteria->compare('job_id',$this->job_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('day',$this->day,true);
		$criteria->compare('saved_status',$this->saved_status,true);
		$criteria->compare('pay_date_id',$this->pay_date_id);
		$criteria->compare('working_date',$this->working_date,true);
		$criteria->compare('formatted_working_date',$this->working_date,true);
		$criteria->compare('day_night',$this->day_night,true);
		$criteria->compare('work_start_time',$this->work_start_time,true);
		$criteria->compare('work_end_time',$this->work_end_time,true);
		$criteria->compare('total_hours',$this->total_hours,true);
		$criteria->compare('regular_hours',$this->regular_hours,true);
		$criteria->compare('overtime_hours',$this->overtime_hours,true);
		$criteria->compare('double_time_hours',$this->double_time_hours,true);
		$criteria->compare('job_location',$this->job_location,true);
		$criteria->compare('service_name',$this->service_name,true);
		$criteria->compare('agent_id',$this->agent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TimesheetPayDatesUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
