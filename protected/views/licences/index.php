<style>

.top_wrepp a{display:inline-block; float:left;}
.top_wrepp span{display:inline-block; float:right; color:#fff;}

</style>

<div class="row top_wrepp">
	<div class="col-md-6 col-sm-4 col-xs-6 col-mb-12">
		<a href="http://highclean.com.au/"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/logo_new.png"/></a>
    </div>
    <div class="col-md-6 col-sm-8 col-xs-6 col-mb-12">
    	<span>
            High Clean Pty Ltd<br />
            E: info@highclean.com.au<br />
            A: 1/92 Railway St South, Altona VIC 3018<br />
            T: 03 8398 0804
        </span>
    </div>    
</div>
<div class="pageheader">

        <div class="media">

          <div class="media-body">

            <h4 align="center">Licences</h4>			

          </div>

        </div>

        <!-- media --> 

</div>




<div class="contentpanel">

<div class="row">

<div class="col-md-12">

	
	 <div class="row mb20">

       

			<dt class="col-md-6 blue4">User Name</dt>

              <dd class="col-md-6 blue4"><?php echo $user_model->first_name.' '.$user_model->last_name; ?></dd>

     </div>    
	
</div>
	
</div>
	
	
	
<div class="row">	
	<?php if(count($user_licences) > 0) { ?>
	<div class="table-responsive">
 
<?php

$userLicense=new UserLicenses('search');
$userLicense->unsetAttributes();  // clear any default values
$userLicense->user_id = $user_model->id;;


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$userLicense->search(),
	'summaryText'=>'', 
	'filter'=>null,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'columns'=>array(
	
		array(
			'name'=>'license_type_id',
			'header'=>'License Type',
			'headerHtmlOptions'=>array('class'=>'head'),
			'filter' => CHtml::listData(LicencesType::model()->findAll(), 'id', 'name'), // fields from country table
			'value' => 'LicencesType::Model()->FindByPk($data->license_type_id)->name',
		),

	array(
			'name'=>'license_number',
			'headerHtmlOptions'=>array('class'=>'head'),
		),


	 
		array(
			'name'=>'license_issued_by',
			'headerHtmlOptions'=>array('class'=>'head'),
		),

  
		array(
			'name'=>'license_issued_date',
			'headerHtmlOptions'=>array('class'=>'head'),
			'value'=>'Yii::app()->dateFormatter->format("d/M/y",strtotime($data->license_issued_date))'
		),


	  	array(
			'name'=>'license_expiry_date',
			'headerHtmlOptions'=>array('class'=>'head'),
			'value'=> '($data->license_expiry_date != "0000-00-00") ? Yii::app()->dateFormatter->format("d/M/y",strtotime($data->license_expiry_date)) : ""'
		),


	  
	
	
			array(
			'class'=>'CButtonColumn',
			'header'=>'Action',
			'headerHtmlOptions'=>array('width'=>'25%','class'=>'head'),
			'template'=>'{download}',
			
			'buttons'=>array
						(
				
	
						'download'	 => array (
							'label'=>'Download',
							'imageUrl'=>null,
							'url' => 'Yii::app()->createUrl("/User/default/DownloadLicense",array("id" => $data->primaryKey))',
						),	
						
	

	

						
						),
			 
			 
		),
	),
)); 

?>

</div>
	<?php } else { ?>
<strong>No Licenses Found.</strong>
	<?php } ?>
	  	
</div>	
	
</div>	


