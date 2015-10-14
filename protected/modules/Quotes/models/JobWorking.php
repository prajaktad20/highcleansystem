<?php

/**
 * This is the model class for table "{{job_working}}".
 *
 * The followings are the available columns in table '{{job_working}}':
 * @property integer $id
 * @property integer $job_id
 * @property string $working_date
 * @property string $day_night
 * @property string $working_status
 * @property string $yard_time
 * @property string $site_time
 * @property string $finish_time
 * @property integer $agent_id
 */
class JobWorking extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{job_working}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('job_id, working_date', 'required'),
			array('job_id,agent_id', 'numerical', 'integerOnly'=>true),
			array('day_night', 'length', 'max'=>5),
			array('working_status', 'length', 'max'=>1),
			array('yard_time, site_time, finish_time', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, job_id, agent_id, working_date, day_night, working_status, yard_time, site_time, finish_time', 'safe', 'on'=>'search'),
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
			'job_id' => 'Job',
			'working_date' => 'Working Date',
			'day_night' => 'Day Night',
			'working_status' => 'Working Status',
			'yard_time' => 'Yard Time',
			'site_time' => 'Site Time',
			'finish_time' => 'Finish Time',
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
		$criteria->compare('working_date',$this->working_date,true);
		$criteria->compare('day_night',$this->day_night,true);
		$criteria->compare('working_status',$this->working_status,true);
		$criteria->compare('yard_time',$this->yard_time,true);
		$criteria->compare('site_time',$this->site_time,true);
		$criteria->compare('finish_time',$this->finish_time,true);
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
	 * @return JobWorking the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
