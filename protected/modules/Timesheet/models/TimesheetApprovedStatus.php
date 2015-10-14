<?php

/**
 * This is the model class for table "{{timesheet_approved_status}}".
 *
 * The followings are the available columns in table '{{timesheet_approved_status}}':
 * @property integer $id
 * @property integer $pay_date_id
 * @property integer $user_id
 * @property string $status
 * @property string $approved_date
 * @property integer $agent_id
 */
class TimesheetApprovedStatus extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{timesheet_approved_status}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pay_date_id, user_id', 'required'),
			array('pay_date_id, user_id, agent_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>1),
			array('total_hours, regular_hours, overtime_hours, double_time_hours,reg_rate_per_hr,ot_rate_per_hr,dt_rate_per_hr', 'length', 'max'=>10),
			array('total_wage', 'length', 'max'=>10),
			array('approved_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pay_date_id, agent_id, total_wage, user_id, status, approved_date,  total_hours, regular_hours, overtime_hours, double_time_hours,reg_rate_per_hr,ot_rate_per_hr,dt_rate_per_hr', 'safe', 'on'=>'search'),
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
			'pay_date_id' => 'Pay Date',
			'user_id' => 'User',
			'status' => 'Status',
			'approved_date' => 'Approved Date',
			'total_hours' => 'Total Hours',
			'regular_hours' => 'Regular Hours',
			'overtime_hours' => 'Overtime Hours',
			'double_time_hours' => 'Double Time Hours',
			'total_wage' => 'Total Wage',
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
		$criteria->compare('pay_date_id',$this->pay_date_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('approved_date',$this->approved_date,true);
		$criteria->compare('total_hours',$this->total_hours,true);
		$criteria->compare('regular_hours',$this->regular_hours,true);
		$criteria->compare('overtime_hours',$this->overtime_hours,true);
		$criteria->compare('double_time_hours',$this->double_time_hours,true);
		$criteria->compare('total_wage',$this->double_time_hours,true);
		$criteria->compare('agent_id',$this->agent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TimesheetApprovedStatus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
