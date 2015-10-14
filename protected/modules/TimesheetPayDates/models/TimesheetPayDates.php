<?php

/**
 * This is the model class for table "{{timesheet_pay_dates}}".
 *
 * The followings are the available columns in table '{{timesheet_pay_dates}}':
 * @property integer $id
 * @property string $pay_date
 * @property string $payment_start_date
 * @property string $payment_end_date
 * @property integer $agent_id
 */
class TimesheetPayDates extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{timesheet_pay_dates}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pay_date, payment_start_date, payment_end_date', 'required'),
			array('agent_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pay_date, payment_start_date, payment_end_date', 'safe', 'on'=>'search'),
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
			'pay_date' => 'Pay Date',
			'payment_start_date' => 'Payment Start Date',
			'payment_end_date' => 'Payment End Date',
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
		$criteria->compare('pay_date',$this->pay_date,true);
		$criteria->compare('payment_start_date',$this->payment_start_date,true);
		$criteria->compare('payment_end_date',$this->payment_end_date,true);
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
	 * @return TimesheetPayDates the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
