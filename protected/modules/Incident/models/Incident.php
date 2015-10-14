<?php

/**
 * This is the model class for table "{{incident}}".
 *
 * The followings are the available columns in table '{{incident}}':
 * @property integer $id
 * @property string $date
 * @property string $location
 * @property string $note
 * @property string $photo
  * @property integer $agent_id
 */
class Incident extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{incident}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, location, note,agent_id', 'required'),
			array('location, note, photo', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, location, note, agent_id, photo', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'Date',
			'location' => 'Location',
			'note' => 'Note',
			'photo' => 'Photo',
			'agent_id' => 'Agent',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('agent_id',$this->agent_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
				
			// CgridView Records/page section			
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',
				Yii::app()->params['defaultPageSize']),
			),	
			
				'sort'=>array(
            'defaultOrder'=>'date DESC',
        ),
			
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Incident the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
