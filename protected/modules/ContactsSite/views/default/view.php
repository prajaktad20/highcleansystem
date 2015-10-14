<?php
/* @var $this ContactsSiteController */
/* @var $model ContactsSite */

?>
 <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i></a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
              <li><a href="<?php echo $this->user_role_base_url; ?>?r=ContactsSite/default/admin">Sites</a></li>
			  <li>View Site Details</li>
            </ul>
            <h4><?php echo CHtml::link(
                Yii::t("ContactsSite.admin", "Manage"),
                array("admin"),
                array("class"=>"btn btn-primary pull-right")
 ); ?></h4>
          </div>
        </div>
        <!-- media --> 
      </div>
      <div class="contentpanel">
        <div class="row">
          <div class="col-md-12 quote_section">
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2><?php echo $model->site_name; ?> : View Site Details</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
<?php

		// to make checked last selected contacts
		$last_selected_contact_ids = array();
		$last_selected_contact_names = array();
		$Criteria = new CDbCriteria();
		$Criteria->condition = "site_id = $model->id";
		$last_selected_contact_ids_model = SiteContactRelation::model()->findAll($Criteria); // find related buildings by quote id
		foreach($last_selected_contact_ids_model as $Row) {
		$last_selected_contact_ids[] = $Row->contact_id;
		}
		
		foreach($last_selected_contact_ids as $contact_id) {
		$last_selected_contact_names[] = Contact::Model()->FindByPk($contact_id)->first_name." ".Contact::Model()->FindByPk($contact_id)->surname;
		}
		
		
?>
<table id="yw0" class="detail-view"><tbody>
<tr class="even"><th>Contacts</th><td><?php echo implode(', ',$last_selected_contact_names); ?></td></tr>
</tbody>
</table>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		//'contact_id',
/* 		array(
            'name' => 'Contact',
            'value' => Contact::Model()->FindByPk($model->contact_id)->first_name." ".Contact::Model()->FindByPk($model->contact_id)->surname
        ), */
		
		'site_name',
		'site_id',
		'address',
		'suburb',
		'state',
		'postcode',
		'phone',
		'mobile',
		'email',
		'site_contact',
		'site_comments',
		'how_many_buildings',
		'created_at',
		'updated_at',
		/* 'need_induction',
		'status',
		 */
		array (
		'name' => 'Need Induction',
		'value' => $model->need_induction ? 'Yes' : 'No'
		),
		
	),
)); ?>
</div>
              <!-- table-responsive --> 
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- contentpanel -->
      
