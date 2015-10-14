<?php

/**
 * This is the model class for table "{{swms_hzrds_consqs}}".
 *
 * The followings are the available columns in table '{{swms_hzrds_consqs}}':
 * @property integer $id
 * @property string $hazards
 * @property string $consequences
 * @property integer $risk
 * @property string $control_measures
 * @property integer $task_id
 * @property integer $swms_id
 * @property integer $residual_risk
 * @property string $person_responsible
 * @property string $status
 * @property integer $hrd_consq_sort_order
 */
class SwmsHzrdsConsqs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{swms_hzrds_consqs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('control_measures, task_id, swms_id, residual_risk', 'required'),
			array('risk, task_id, swms_id, residual_risk, hrd_consq_sort_order', 'numerical', 'integerOnly'=>true),
			array('hazards, consequences, person_responsible', 'length', 'max'=>255),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hazards, consequences, risk, control_measures, task_id, swms_id, residual_risk, person_responsible, status, hrd_consq_sort_order', 'safe', 'on'=>'search'),
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
			'hazards' => 'Hazards',
			'consequences' => 'Consequences',
			'risk' => 'Risk Initial',
			'control_measures' => 'Control Measures',
			'task_id' => 'Task',
			'swms_id' => 'Swms',
			'residual_risk' => 'Residual Risk',
			'person_responsible' => 'Person Responsible',
			'status' => 'Status',
			'hrd_consq_sort_order' => 'Hrd Consq Sort Order',
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
		$criteria->compare('hazards',$this->hazards,true);
		$criteria->compare('consequences',$this->consequences,true);
		$criteria->compare('risk',$this->risk);
		$criteria->compare('control_measures',$this->control_measures,true);
		$criteria->compare('task_id',$this->task_id);
		$criteria->compare('swms_id',$this->swms_id);
		$criteria->compare('residual_risk',$this->residual_risk);
		$criteria->compare('person_responsible',$this->person_responsible,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('hrd_consq_sort_order',$this->hrd_consq_sort_order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
			'pageSize'=> Yii::app()->user->getState('pageSize',
			Yii::app()->params['defaultPageSize']),
		),

		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SwmsHzrdsConsqs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
