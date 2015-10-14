<?php

/**
 * This is the model class for table "{{site}}".
 *
 * The followings are the available columns in table '{{site}}':
 * @property integer $id
 
 * @property string $site_name
 * @property integer $site_id
 * @property string $address
 * @property string $suburb
 * @property string $state
 * @property string $postcode
 * @property string $phone
 * @property string $mobile
 * @property string $email
 * @property string $site_contact
 * @property string $site_comments
 * @property integer $how_many_buildings
 * @property string $created_at
 * @property string $updated_at
 * @property string $need_induction
 * @property string $status
 * @property integer $agent_id
 */
class ContactsSite extends CActiveRecord
{
   public $concatedAddress;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{site}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_name, site_id', 'required'),
			array('how_many_buildings,induction_company_id,agent_id', 'numerical', 'integerOnly'=>true),
			array('site_name, suburb, site_id, state, postcode, phone, mobile, email, site_contact, site_comments,address', 'length', 'max'=>255),
			array('need_induction, status', 'length', 'max'=>1),
			array('created_at, updated_at', 'safe'),
			array('email','unique', 'className' => 'ContactsSite'),
			array('email', 'email'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, site_name, agent_id, site_id, concatedAddress, address, suburb, state, postcode, phone, mobile, email, site_contact, site_comments, how_many_buildings, created_at, updated_at, need_induction, status', 'safe', 'on'=>'search'),
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
			
			'site_name' => 'Site Name',
			'site_id' => 'Site ID/Number',
			'address' => 'Address',
			'suburb' => 'Suburb',
			'state' => 'State',
			'postcode' => 'Postcode',
			'phone' => 'Phone',
			'mobile' => 'Mobile',
			'email' => 'Email',
			'site_contact' => 'Site Contact',
			'site_comments' => 'Site Comments',
			'how_many_buildings' => 'How many building are at this site?',
			'need_induction' => 'Does this site need induction?',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'status' => 'Status',
			'induction_company_id' => 'Induction Company',
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

		if(isset(Yii::app()->getController()->getAction()->controller->action->id) && Yii::app()->getController()->getAction()->controller->action->id == 'ViewSites') {
		
		if(isset($_GET['contact_id']) && $_GET['contact_id'] > 0)		
		$contact_id = $_GET['contact_id'];
		
		$site_ids = array();
		$Criteria = new CDbCriteria();
		$Criteria->condition = "contact_id = $contact_id";
		$SiteContactRelation_model = SiteContactRelation::model()->findAll($Criteria); // find related buildings by quote id
		foreach($SiteContactRelation_model as $Row) {
		$site_ids[] = $Row->site_id;
		}
		
		$criteria->addInCondition('id', $site_ids); // in condition

		} else	{
		$criteria->compare('id',$this->site_id);
		}

		
		$criteria->compare('site_name',$this->site_name,true);
		$criteria->compare('site_id',$this->site_id); // here site_id means ID/Number
		$criteria->compare('address',$this->address,true);
		$criteria->compare('suburb',$this->suburb,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('site_contact',$this->site_contact,true);
		$criteria->compare('site_comments',$this->site_comments,true);
		$criteria->compare('how_many_buildings',$this->how_many_buildings);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('need_induction',$this->need_induction,true);
		$criteria->compare('status',$this->status,true);
		$criteria->addSearchCondition('concat(address, ",", suburb,",",state," ",postcode)', $this->concatedAddress); 
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
	 * @return ContactsSite the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getconcatedAddress()
	{
			return $this->address . ', ' . $this->suburb. ', ' . $this->state. ' ' . $this->postcode;
	}
}
