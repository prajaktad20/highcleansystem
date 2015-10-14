<?php

/**
 * This is the model class for table "{{quotes}}".
 *
 * The followings are the available columns in table '{{quotes}}':
 * @property integer $id
 * @property integer $company_id
 * @property integer $contact_id
 * @property integer $site_id
 * @property integer $service_id
 * @property string $quote_date
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $quote_created_user_id
 * @property integer $agent_id
 */
class Quotes extends CActiveRecord
{

	public $Building;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{quotes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, contact_id, site_id, service_id,  quote_date', 'required'),
			array('company_id, contact_id, site_id, service_id,quote_created_user_id,agent_id', 'numerical', 'integerOnly'=>true),
			
			array('status', 'length', 'max'=>10),
			
			
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_id, agent_id, quote_created_user_id, contact_id, site_id, service_id, quote_date, status, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'service_id' => 'Service Required',
			'company_id' => 'Company',
			'contact_id' => 'Contact',
			'site_id' => 'Site',
			'quote_date' => 'Quote Date',
			'status' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'quote_created_user_id' => 'Quote created user id',
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
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('quote_created_user_id',$this->quote_created_user_id);
		$criteria->compare('contact_id',$this->contact_id);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('quote_date',$this->quote_date,true);
		$criteria->compare('status',$this->status,true);
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
	 * @return Quotes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
		public function getBuilding($qid)
	{
			$Criteria = new CDbCriteria();
			$Criteria->condition = "quote_id = $qid";
			$model_building_service = QuoteJobs::model()->findAll($Criteria); // find related buildings by quote id
		
			$building_names = array();
		
			foreach($model_building_service as $building_row) {
			
					$building_name = Buildings::Model()->findByPK($building_row->building_id)->building_name;					
					
					if(! in_array($building_name,$building_names) ) {
					$building_names[] = $building_name;
					}
					
			}
		
	
			return implode(', ',$building_names);
	}
	
	
	
	    protected function  afterDelete() {
        parent::afterDelete();
	
			// find building from source quote
			$Criteria = new CDbCriteria();
			$Criteria->condition = "quote_id = ".$this->id;
			$jobs = QuoteJobs::model()->findAll($Criteria); // find related buildings by quote id
			
		
			
				if(isset($jobs) && count($jobs) > 0) { 
				foreach($jobs as $row) {
				
						// $row->id is existing job id
						$existing_job_id = $row->id;
						
								// find releated user which was assigned to this user
								if(isset($existing_job_id) && $existing_job_id > 0) {
										JobSupervisor::model()->deleteAll(array("condition" => "job_id=".(int)$existing_job_id));	
										JobSiteSupervisor::model()->deleteAll(array("condition" => "job_id=".(int)$existing_job_id));	
										JobStaff::model()->deleteAll(array("condition" => "job_id=".(int)$existing_job_id));	
									}
						
						
						
							// deleting services under specific job
							$Criteria = new CDbCriteria();
							$Criteria->condition = "job_id = $existing_job_id";
							$model_quote_building_service = QuoteJobServices::model()->findAll($Criteria); // find related service by job_id
								foreach($model_quote_building_service as $Row) {
								$job_service_model = QuoteJobServices::model()->findByPk($Row->id);
								$path = Yii::app()->basePath.'/../uploads/quote-building-service/';			
								if(isset($job_service_model->image) && $job_service_model->image !=NULL && file_exists($path.$job_service_model->image))	
								unlink($path.$job_service_model->image);								
								$job_service_model->delete();
							}
						
						
						}
					
												
					//(from table "QuoteJobs")
					QuoteJobs::model()->deleteAll(array("condition" => "quote_id=".$this->id));	
			}
		
		}
	
}
