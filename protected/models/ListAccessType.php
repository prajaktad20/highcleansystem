<?php

/**
 * This is the model class for table "{{list_access_type}}".
 *
 * The followings are the available columns in table '{{list_access_type}}':
 * @property integer $id
 * @property string $name
 * @property integer $list_item_id
 * @property string $time_per_quantity
 * @property string $setup_time
 * @property string $status
 */
class ListAccessType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{list_access_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('list_item_id, time_per_quantity, setup_time', 'required'),
			array('list_item_id', 'numerical', 'integerOnly'=>true),
			array('name, time_per_quantity, setup_time', 'length', 'max'=>255),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, list_item_id, time_per_quantity, setup_time, status', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'list_item_id' => 'List Item',
			'time_per_quantity' => 'Time Per Quantity',
			'setup_time' => 'Setup Time',
			'status' => 'Status',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('list_item_id',$this->list_item_id);
		$criteria->compare('time_per_quantity',$this->time_per_quantity,true);
		$criteria->compare('setup_time',$this->setup_time,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ListAccessType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
