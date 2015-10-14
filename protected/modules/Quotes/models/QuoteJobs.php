<?php

/**
 * This is the model class for table "{{quote_jobs}}".
 *
 * The followings are the available columns in table '{{quote_jobs}}':
 * @property integer $id
 * @property integer $quote_id
 * @property integer $job_total_working_hour
 * @property integer $building_id
 * @property string $discount
 * @property string $final_total
 * @property string $si_staff_contractor
 * @property string $si_client
 * @property string $swms_ids
 * @property string $tool_types_ids
 * @property string $approval_status 
 * @property string $approval_status_date
 * @property string $booked_status
 * @property string $job_status
 * @property string $paid
 * @property string $signed_off
 * @property string $created_at
 * @property string $job_started_date
 * @property string $job_end_date
 * @property string $job_started_time
 * @property string $job_end_time
 * @property string $extra_scope_of_work
 * @property string $swms_signature_lock
 * @property integer $agent_id
 */
class QuoteJobs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{quote_jobs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quote_id, building_id, created_at', 'required'),
			array('quote_id, building_id,staff_required,frequency_type,job_total_working_hour,agent_id', 'numerical', 'integerOnly'=>true),
			array('discount, paid', 'length', 'max'=>10),
			array('final_total, booked_status,staff_required', 'length', 'max'=>10),
			array('swms_ids, tool_types_ids,purchase_order,client_signed_off_through,client_name,client_email,sign_off_document,job_started_time,job_end_time', 'length', 'max'=>255),
			array('job_note,note_for_client,extra_scope_of_work', 'length', 'max'=>4000),
			array('approval_status', 'length', 'max'=>22),
			array('job_status', 'length', 'max'=>11),
			array('signed_off', 'length', 'max'=>3),
			array('swms_signature_lock', 'length', 'max'=>1),
			array('original_record', 'length', 'max'=>3),
			array('client_email','email'),
			array('si_staff_contractor, si_client, job_started_date, job_end_date,job_completed_date,client_signature,client_date,client_feedback,approval_status_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id,agent_id, sign_off_document,approval_status_date,swms_signature_lock, job_total_working_hour, purchase_order, quote_id,original_record, frequency_type,staff_required,job_note, building_id, discount, final_total, si_staff_contractor, si_client, swms_ids, tool_types_ids, approval_status, booked_status, job_status, paid, signed_off, created_at, job_started_date, job_end_date', 'safe', 'on'=>'search'),
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
			'quote_id' => 'Quote',
			'building_id' => 'Building',
			'discount' => 'Discount',
			'final_total' => 'Final Total',
			'si_staff_contractor' => 'Si Staff Contractor',
			'si_client' => 'Si Client',
			'swms_ids' => 'Swms Ids',
			'tool_types_ids' => 'Tool Types Ids',
			'job_note' => 'Job Note',
			'note_for_client' => 'Note For Client',
			'approval_status' => 'Approval Status',
			'approval_status_date' => 'Approval Status Date',
			'booked_status' => 'Booked Status',
			'job_status' => 'Job Status',
			'paid' => 'Paid',
			'job_total_working_hour' => 'Job Hours',			
			'signed_off' => 'Signed Off',
			'created_at' => 'Created At',
			'job_started_date' => 'Job Started Date',
			'job_started_time' => 'Job Started Time',
			'job_end_date' => 'Job End Date',
			'job_end_time' => 'Job End Time',
			'staff_required' => 'Staff Required',
			'frequency_type' => 'Frequency Type',
			'original_record' => 'Original Record',
			'purchase_order' => 'Purchase order',			
			'client_signed_off_through' => 'Client Signed Off By',
			'client_feedback' => 'Client Feedback',
			'client_name' => 'Client Name',
			'client_signature' => 'Client Signature',
			'client_date' => 'Client Date',
			'client_email' => 'Client Email Address',
			'job_completed_date' => 'Job Completed Date',
			'sign_off_document' => 'Sign Off Document',
			'extra_scope_of_work' => 'Scope Of Work',
			'swms_signature_lock' => 'SWMS Signature Lock',
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
		$criteria->compare('quote_id',$this->quote_id);
		$criteria->compare('job_total_working_hour',$this->job_total_working_hour);
		$criteria->compare('building_id',$this->building_id);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('final_total',$this->final_total,true);
		$criteria->compare('si_staff_contractor',$this->si_staff_contractor,true);
		$criteria->compare('si_client',$this->si_client,true);
		$criteria->compare('swms_ids',$this->swms_ids,true);
		$criteria->compare('tool_types_ids',$this->tool_types_ids,true);
		$criteria->compare('job_note',$this->job_note,true);
		$criteria->compare('note_for_client',$this->note_for_client,true);
		$criteria->compare('approval_status',$this->approval_status,true);
        	$criteria->compare('approval_status_date',$this->approval_status_date,true);
		$criteria->compare('booked_status',$this->booked_status,true);
		$criteria->compare('job_status',$this->job_status,true);
		$criteria->compare('paid',$this->paid,true);
		$criteria->compare('swms_signature_lock',$this->swms_signature_lock,true);
		$criteria->compare('signed_off',$this->signed_off,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('job_started_date',$this->job_started_date,true);
		$criteria->compare('job_started_time',$this->job_started_time,true);
		$criteria->compare('job_end_date',$this->job_end_date,true);
		$criteria->compare('job_end_time',$this->job_end_time,true);
		$criteria->compare('staff_required',$this->staff_required);
		$criteria->compare('frequency_type',$this->frequency_type);
		$criteria->compare('original_record',$this->original_record);
		$criteria->compare('purchase_order',$this->purchase_order,true);
		$criteria->compare('client_signed_off_through',$this->client_signed_off_through,true);
		$criteria->compare('client_feedback',$this->client_feedback,true);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('client_signature',$this->client_signature,true);
		$criteria->compare('client_date',$this->client_date,true);
		$criteria->compare('client_email',$this->client_email,true);
		$criteria->compare('job_completed_date',$this->job_completed_date,true);
		$criteria->compare('sign_off_document',$this->sign_off_document,true);
		$criteria->compare('extra_scope_of_work',$this->extra_scope_of_work,true);
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
	 * @return QuoteBuilding the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
