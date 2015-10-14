<?php

/**
 * This is the model class for table "{{buildings}}".
 *
 * The followings are the available columns in table '{{buildings}}':
 * @property integer $id
 * @property string $building_name
 * @property integer $building_no
 * @property string $water_source_availability
 * @property string $dist_from_office
 * @property string $no_of_floors
 * @property string $size_of_building
 * @property string $height_of_building
 * @property string $job_notes
 * @property integer $site_id
 * @property integer $building_type_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $agent_id
 */
class Buildings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{buildings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_id, building_type_id', 'required'),
			array('site_id, building_type_id,no_of_floors,agent_id', 'numerical', 'integerOnly'=>true),
			array('building_no, building_name, dist_from_office, size_of_building, height_of_building', 'length', 'max'=>255),
			array('water_source_availability', 'length', 'max'=>1),
			array('created_at, updated_at', 'safe'),
			array('job_notes', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, agent_id, building_name, building_no, water_source_availability, dist_from_office, no_of_floors, size_of_building, height_of_building, job_notes, site_id, building_type_id, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'building_name' => 'Building Name',
			'building_no' => 'Building No',
			'water_source_availability' => 'Is water source available on location?',
			'dist_from_office' => 'Dist From Office',
			'no_of_floors' => 'No Of Floors',
			'size_of_building' => 'Size Of Building',
			'height_of_building' => 'Height Of Building',
			'job_notes' => 'Job Notes',
			'site_id' => 'Site',
			'building_type_id' => 'Building Type',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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

		
		if(isset(Yii::app()->getController()->getAction()->controller->action->id) && Yii::app()->getController()->getAction()->controller->action->id == 'ViewBuildings') {
		
		if(isset($_GET['site_id']) && $_GET['site_id'] > 0)		
		$this->site_id = $_GET['site_id'];
	}		
		
		
		$criteria=new CDbCriteria;
		$this->agent_id = CommonFunctions::getCurrentpageAgentId(Yii::app()->user->name);
		$criteria->compare('id',$this->id);
		$criteria->compare('building_name',$this->building_name,true);
		$criteria->compare('building_no',$this->building_no);
		$criteria->compare('water_source_availability',$this->water_source_availability,true);
		$criteria->compare('dist_from_office',$this->dist_from_office,true);
		$criteria->compare('no_of_floors',$this->no_of_floors);	
		$criteria->compare('size_of_building',$this->size_of_building,true);
		$criteria->compare('height_of_building',$this->height_of_building,true);
		$criteria->compare('job_notes',$this->job_notes,true);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('building_type_id',$this->building_type_id);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
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
	 * @return Buildings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
