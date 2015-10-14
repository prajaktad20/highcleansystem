<?php

/**
 * This is the model class for table "{{induction}}".
 *
 * The followings are the available columns in table '{{induction}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $site_id
 * @property integer $induction_type_id
 * @property integer $induction_company_id
 * @property string $induction_link_document
 * @property string $induction_link
 * @property string $document
 * @property string $password
 * @property string $completion_date
 * @property string $induction_status
 * @property string $induction_number
 * @property string $induction_card
 * @property string $expiry_date
 * @property string $created_at
 * @property integer $agent_id
 */
class Induction extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{induction}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, induction_type_id, induction_company_id, induction_link_document, created_at', 'required'),
			array('user_id, site_id, induction_type_id, induction_company_id,agent_id', 'numerical', 'integerOnly'=>true),
			array('induction_link_document', 'length', 'max'=>1),
			array('induction_link, document, password, induction_number, induction_card', 'length', 'max'=>255),
			array('induction_status', 'length', 'max'=>9),
			array('completion_date, expiry_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, agent_id, site_id, induction_type_id, induction_company_id, induction_link_document, induction_link, document, password, completion_date, induction_status, induction_number, induction_card, expiry_date, created_at', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'site_id' => 'Site',
			'induction_type_id' => 'Induction Type',
			'induction_company_id' => 'Induction Company',
			'induction_link_document' => 'Induction Link/Document',
			'induction_link' => 'Induction Link',
			'document' => 'Document',
			'password' => 'Password',
			'completion_date' => 'Completion Date',
			'induction_status' => 'Induction Status',
			'induction_number' => 'Induction Number',
			'induction_card' => 'Induction Card',
			'expiry_date' => 'Expiry Date',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('induction_type_id',$this->induction_type_id);
		$criteria->compare('induction_company_id',$this->induction_company_id);
		$criteria->compare('induction_link_document',$this->induction_link_document,true);
		$criteria->compare('induction_link',$this->induction_link,true);
		$criteria->compare('document',$this->document,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('completion_date',$this->completion_date,true);
		$criteria->compare('induction_status',$this->induction_status,true);
		$criteria->compare('induction_number',$this->induction_number,true);
		$criteria->compare('induction_card',$this->induction_card,true);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('agent_id',$this->agent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			
		'sort'=>array(
            'defaultOrder'=>'id DESC',
        ),
		
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Induction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getFullName($user_id) {
		$user_model = User::model()->findByPk($user_id);
		return $user_model->first_name.' '.$user_model->last_name;
	}
}
