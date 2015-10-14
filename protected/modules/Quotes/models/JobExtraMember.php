<?php

/**
 * This is the model class for table "{{job_extra_member}}".
 *
 * The followings are the available columns in table '{{job_extra_member}}':
 * @property integer $id
 * @property integer $job_id
 * @property string $name
 * @property string $date_on_signed
 * @property string $signature
 * @property integer $agent_id
 */
class JobExtraMember extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{job_extra_member}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('job_id, name', 'required'),
			array('job_id,agent_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('date_on_signed, signature', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, job_id, agent_id, name, date_on_signed, signature', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'date_on_signed' => 'Date On Signed',
			'signature' => 'Signature',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('date_on_signed',$this->date_on_signed,true);
		$criteria->compare('signature',$this->signature,true);
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
	 * @return JobExtraMember the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
