<?php

/**
 * This is the model class for table "{{_email_format}}".
 *
 * The followings are the available columns in table '{{_email_format}}':
 * @property integer $email_format_ID
 * @property string $email_format_name
 * @property string $email_format
 */
class EmailFormat extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{email_format}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email_format_name, email_format', 'required'),
			array('email_format_name', 'length', 'max'=>255),
			array('note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('email_format_ID, email_format_name, email_format', 'safe', 'on'=>'search'),
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
			'email_format_ID' => 'Email Format',
			'email_format_name' => 'Email Subject',
			'email_format' => 'Email Body',
			'note' => 'Note',
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

		$criteria->compare('email_format_ID',$this->email_format_ID);
		$criteria->compare('email_format_name',$this->email_format_name,true);
		$criteria->compare('email_format',$this->email_format,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
					// CgridView Records/page section			
					'pagination'=>array(
					
						'pageSize'=> Yii::app()->user->getState('pageSize',
						Yii::app()->params['defaultPageSize']),
					),	
					
						'sort'=>array(
							'defaultOrder'=>'email_format_ID ASC',
					),
			
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmailFormat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
