<?php

/**
 * This is the model class for table "{{hire_staff}}".
 *
 * The followings are the available columns in table '{{hire_staff}}':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $auth_key
 * @property string $created_at
 * @property integer $sent_email_count
 * @property integer $agent_id
 * @property string $email_sent
 * @property string $registered
 */
class HireStaff extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{hire_staff}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, email, auth_key, agent_id', 'required'),
			array('sent_email_count, agent_id', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, email, auth_key', 'length', 'max'=>255),
			array('registered', 'length', 'max'=>1),
			array('email', 'email'),
			
			array('email','unique',"className"=>"HireStaff"),
			array('email','not_present_in_user'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, last_name, email, auth_key, created_at, sent_email_count, agent_id, email_sent, registered', 'safe', 'on'=>'search'),
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

	 public function not_present_in_user($attribute, $params)
    {
        
		$criteria = new CDbCriteria();
		$criteria->select = "*";
		$criteria->addCondition("email='".$this->email."'");
  
		$data = User::model()->find($criteria);
		
        if(!empty($data))
		$this->addError($attribute, Yii::t('email','Email already exists!'));
    }
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'auth_key' => 'Auth Key',
			'created_at' => 'Created At',
			'sent_email_count' => 'Sent Email Count',
			'agent_id' => 'Service Agent',
			'email_sent' => 'Email Sent',
			'registered' => 'Registered',
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
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('auth_key',$this->auth_key,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('sent_email_count',$this->sent_email_count);
		$criteria->compare('agent_id',$this->agent_id);
		$criteria->compare('email_sent',$this->email_sent,true);
		$criteria->compare('registered',$this->registered,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
					'pageSize'=> Yii::app()->user->getState('pageSize',
					Yii::app()->params['defaultPageSize']),
				),
				
				'sort'=>array(
			    'defaultOrder'=>'email_sent DESC',
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HireStaff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
