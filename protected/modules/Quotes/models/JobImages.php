<?php

/**
 * This is the model class for table "{{job_images}}".
 *
 * The followings are the available columns in table '{{job_images}}':
 * @property integer $id
 * @property integer $job_id
 * @property string $area
 * @property string $photo_before
 * @property string $photo_after
 * @property string $note
 * @property string $date_added
 * @property integer $agent_id
 */
class JobImages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{job_images}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('job_id, date_added', 'required'),
			array('job_id,agent_id', 'numerical', 'integerOnly'=>true),
			array('area, photo_before, photo_after', 'length', 'max'=>255),
			array('note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, job_id, agent_id, area, photo_before, photo_after, note, date_added', 'safe', 'on'=>'search'),
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
			'area' => 'Area',
			'photo_before' => 'Photo Before',
			'photo_after' => 'Photo After',
			'note' => 'Note',
			'date_added' => 'Date Added',
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
		if(isset(Yii::app()->user->name) && Yii::app()->user->name != 'Guest')
		$this->agent_id = CommonFunctions::getCurrentpageAgentId(Yii::app()->user->name);
		$criteria->compare('id',$this->id);
		$criteria->compare('job_id',$this->job_id);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('photo_before',$this->photo_before,true);
		$criteria->compare('photo_after',$this->photo_after,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('date_added',$this->date_added,true);
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
	 * @return JobImages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
