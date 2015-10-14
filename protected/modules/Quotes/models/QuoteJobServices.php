<?php

/**
 * This is the model class for table "{{quote_job_services}}".
 *
 * The followings are the available columns in table '{{quote_job_services}}':
 * @property integer $id
 * @property integer $job_id
 * @property string $service_description
 * @property integer $quantity
 * @property string $unit_price_rate
 * @property string $total
 * @property string $image
 * @property string $notes
 * @property string $created_at
 * @property integer $agent_id
 *
 * The followings are the available model relations:
 * @property QuoteJobs $job
 */
class QuoteJobServices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{quote_job_services}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('job_id, created_at', 'required'),
			array('job_id, quantity,agent_id', 'numerical', 'integerOnly'=>true),
			array('unit_price_rate, total', 'length', 'max'=>10),
			array('image', 'length', 'max'=>255),
			array('service_description, notes', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, job_id, agent_id, service_description, quantity, unit_price_rate, total, image, notes, created_at', 'safe', 'on'=>'search'),
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
			'service_description' => 'Service Description',
			'quantity' => 'Quantity',
			'unit_price_rate' => 'Unit Price Rate',
			'total' => 'Total',
			'image' => 'Image',
			'notes' => 'Notes',
			'created_at' => 'Created At',
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
		$criteria->compare('service_description',$this->service_description,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('unit_price_rate',$this->unit_price_rate,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('created_at',$this->created_at,true);
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
	 * @return QuoteJobServices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
