<div class="pageheader">
  <div class="media">
    <div class="media-body">
      <ul class="breadcrumb">
        <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Quotes</li>
      </ul>
 <a href="<?php echo Yii::app()->getBaseUrl(true).'/?r=Quotes/Job/view&id='.$model->id; ?>" class="btn btn-primary pull-right">Back To Job Details</a>
 </h4>
    </div>
  </div>
  <!-- media --> 
  
</div>

	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>
<div class="contentpanel">
  <div class="row">
    <?php if($model !== null) { ?>
    <div class="col-md-12 quote_section">
      <div class="panel panel-default">
        <div class="panel-body titlebar building_titlebar"> <span class="glyphicon  glyphicon-th"></span>
          <h2>Building : <?php echo Buildings::Model()->FindByPk($model->building_id)->building_name; ?></h2>
        </div>
      </div>
      <div class="col-md-12">
        <button id="<?php echo $model->id; ?>"  data-toggle="modal" data-target="#myModal"  class="add_new_service btn btn-primary mr5"  onclick="return false;" > Add New Service for Building "<?php echo Buildings::Model()->FindByPk($model->building_id)->building_name;; ?>"</button>
        <div class="table-responsive">
          <div class="col-md-12">
<?php 
	
	$service_model=new QuoteJobServices('search');
	$service_model->unsetAttributes();  // clear any default values
	$service_model->job_id = $model->id;

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'building-grid-'.$model->id,
	'dataProvider'=>$service_model->search(),
	'summaryText'=>'', 
	'enablePagination' => false,
	//'filter'=>$service_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',	
	'pagerCssClass'=>'pagination',
	

	'columns'=>array(
		array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ),

		 
	 array(
                'name'=>'service_description',
				'htmlOptions'=>array('width'=> "25%"),
                'headerHtmlOptions'=>array('class'=>'head'),				
            ),

				array(
				'name' => 'quantity',
				'htmlOptions'=>array('width'=> "6%"),
				'headerHtmlOptions'=>array('class'=>'head'),				
			),
			
		array(
                'name'=>'unit_price_rate',
				'htmlOptions'=>array('width'=> "13%"),
                'headerHtmlOptions'=>array('class'=>'head'),				
            ),


			 
	 array(
                'name'=>'total',
				'htmlOptions'=>array('width'=> "13%"),
                'headerHtmlOptions'=>array('class'=>'head'),
				
            ),
		
	

	

	array(
				'name' => 'notes',
				'htmlOptions'=>array('width'=> "20%"),
				'headerHtmlOptions'=>array('class'=>'head'),
				
			),
			
		
		array(
			'class'=>'CButtonColumn',			
			'htmlOptions'=>array('width'=> "25%","style"=>"text-align:center;"),
			'headerHtmlOptions'=>array('class'=>'head'),
			'header'=>'Action',
			'template'=>'{edit} | {delete} | {upload}',
			'buttons'=>array
						(
						
					'upload' => array
							(
								'label'=>'Upload Image', 
								'imageUrl'=>false,																
				 				'url' => 'Yii::app()->createUrl("/Quotes/default/GetQuoteBuldingColumnsImage",array("id" => $data->primaryKey))',
								'click' => 'function(e) {
                                      $("#ajaxModal").remove();
                                      e.preventDefault();
                                      var $this = $(this)
                                        , $remote = $this.data("remote") || $this.attr("href")
                                        , $modal = $("<div class=\'modal\' id=\'ajaxModal\'><div class=\'modal-body\'><h5 align=\'center\'> <img src=\'' . Yii::app()->request->baseUrl . '/images/ajax-loader.gif\'>&nbsp;  Please Wait .. </h5></div></div>");
                                      $("body").append($modal);
                                      $modal.modal({backdrop: "static", keyboard: false});
                                      $modal.load($remote);
                                    }',
							'options' => array('data-toggle' => 'ajaxModal','style' => 'padding:4px;'),
							),
							

 'edit' => array( // My custom button options
                        'label' => 'Edit',
						'imageUrl'=>false,	
                		'url' => 'Yii::app()->createUrl("/Quotes/default/GetQuoteBuldingColumns",array("id" => $data->primaryKey))',
                        'click' => 'function(e) {
                                      $("#ajaxModal").remove();
                                      e.preventDefault();
                                      var $this = $(this)
                                        , $remote = $this.data("remote") || $this.attr("href")
                                        , $modal = $("<div class=\'modal\' id=\'ajaxModal\'><div class=\'modal-body\'><h5 align=\'center\'> <img src=\'' . Yii::app()->request->baseUrl . '/images/ajax-loader.gif\'>&nbsp;  Please Wait .. </h5></div></div>");
                                      $("body").append($modal);
                                      $modal.modal({backdrop: "static", keyboard: false});
                                      $modal.load($remote);
                                    }',
                        'options' => array('data-toggle' => 'ajaxModal','style' => 'padding:4px;'),
                    ),

				
							'delete' => array
							(
								'label'=>'Delete',
								'imageUrl'=>false,
								'url' => 'Yii::app()->createUrl("/Quotes/default/deletequotebuildingservice",array("id" => $data->primaryKey))',
							),
									
						
						
						),
			 
			 
		),
	),
)); ?>
          </div>
        </div>
        <div class="col-md-6 mb30">
          <div class="panel panel-default">
            <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
              <h2>Special Instruction for STAFF / CONTRACTOR</h2>
            </div>
          </div>

<?php echo $form->textArea($model,'si_staff_contractor',array('rows'=>4, 'cols'=>80,'class'=>'form-control mb20')); ?>


          <div class="panel panel-default">
            <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
              <h2>Select SWMS Document</h2>
            </div>
          </div>
          <div class="swms_document">
            <ul>
              <?php 
$Criteria = new CDbCriteria();
$SWMStypes = Swms::model()->findAll($Criteria);
?>
              <?php foreach($SWMStypes as $RowSWMStypes) {  ?>
              <?php 

$post_swms_ids = array();
if(! empty($model->swms_ids))
$post_swms_ids = explode(',',$model->swms_ids);

?>
              <li>
                <input  <?php if(in_array($RowSWMStypes->id, $post_swms_ids)) echo 'checked';  ?>  type="checkbox" value="<?php echo $RowSWMStypes->id; ?>" name="swms[]"/>
                &nbsp;<?php echo $RowSWMStypes->name; ?>&nbsp;&nbsp;&nbsp;&nbsp;</li>
              <?php  } ?>
            </ul>
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
              <h2>Special Instruction for CLIENT</h2>
            </div>
          </div>
<?php echo $form->textArea($model,'si_client',array('rows'=>4, 'cols'=>80,'class'=>'form-control mb20')); ?>

          <div class="panel panel-default">
            <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
              <h2>Select TOOL TYPE</h2>
            </div>
          </div>
          <div class="swms_document">
            <ul>
              <?php 
$post_tooltypes_ids = array();
if(! empty($model->tool_types_ids))
$post_tooltypes_ids = explode(',',$model->tool_types_ids);
?>
              <?php 
$Criteria = new CDbCriteria();
$ToolTypes = ListToolsType::model()->findAll($Criteria);
?>
              <?php foreach($ToolTypes as $RowToolTypes) { ?>
              <li>
                <input <?php if(in_array($RowToolTypes->id, $post_tooltypes_ids)) echo 'checked';  ?>  type="checkbox" value="<?php echo $RowToolTypes->id; ?>" name="tool_types[]" />
                &nbsp;<?php echo $RowToolTypes->name; ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>
      
        <div class="clearfix"></div>
      </div>
    </div>
    <?php } ?>
    <div class="row buttons aligncenter"> <a href="<?php echo Yii::app()->getBaseUrl(true).'/?r=Quotes/Job/view&id='.$model->id; ?>" class="btn btn-primary mr5">Back</a> 
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>	
	</div>
  </div>
</div>

<!-- Modal box 1 -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add New Service</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="job_id" value="<?php echo $model->id; ?>" class="form-control" />
        
        <div class="form-group">
          <label class="col-sm-4">Description</label>
          <div class="col-sm-8">
            <input type="text"  autocomplete="off"  id="description" value="" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4">Quantity</label>
          <div class="col-sm-8">
            <input type="text"  autocomplete="off"  id="quantity"  onkeypress="return isNumber(event)"  class="pricede form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4">Unit Price</label>
          <div class="col-sm-8">
            <input type="text"  autocomplete="off"  id="unit" value="" class="pricede form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4">Notes</label>
          <div class="col-sm-8">
            <input type="text"  autocomplete="off"  id="notes" value="" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4">&nbsp;</label>
          <div class="col-sm-8">
            <button class="btn btn-primary mr5" id="addbtn0" onclick="add_building_service(); return false;" >Add</button>
          </div>
        </div>
      </div>
    </div>
    <!-- modal-content --> 
  </div>
  <!-- modal-dialog --> 
  
</div>

<!-- Modal box 1 --> 



<?php $this->endWidget(); ?>


<!-- contentpanel --> 

<script type="text/javascript" charset="utf-8">


function add_building_service() {

		var job_id = jQuery('input#job_id').val(); 
		var description = jQuery('input#description').val(); 
		var quantity = jQuery('input#quantity').val(); 
		var unit = jQuery('input#unit').val(); 
		var notes = jQuery('input#notes').val(); 

		if(description == '' || description == null ) {
		alert("Please enter Description"); return false;
		}
		else if(quantity == '' || quantity == null ) {
		alert("Please enter Quantity");return false;
		}
		else if(unit == '' || unit == null ) {
		alert("Please enter Unit Price");return false;
		}

		//var post_data = 'job_id='+job_id+'&description='+description+'&quantity='+quantity+'&unit='+unit+'&notes='+notes;

	post_data = {
           job_id: job_id,
           description: description,
           quantity: quantity,
           unit: unit,
           notes: notes
       };
		
		  jQuery.ajax(
							{
							url : '/?r=Quotes/default/add_buliding_service',
							type: "POST",
							data : post_data,
							success:function(data, textStatus, jqXHR){
								post_data = '';
								
								jQuery("input#job_id").val('');
								jQuery("input#description").val('');
								jQuery("input#quantity").val('');
								jQuery("input#unit").val('');
								jQuery("input#notes").val('');
								jQuery('#myModal').modal('hide');
								
								jQuery('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                jQuery.fn.yiiGridView.update('building-grid-'+job_id); 
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
								
									return false;

}


jQuery('.pricede').keypress(function(event) {
            if(event.which == 8 || event.which == 0){
                return true;
            }
            if(event.which < 46 || event.which > 59) {
                return false;
                //event.preventDefault();
            } // prevent if not number/dot

            if(event.which == 46 && $(this).val().indexOf('.') != -1) {
                return false;
                //event.preventDefault();
            } // prevent if already dot
        });
		
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}		


	jQuery(document).ready(function(){
	
        jQuery(".add_new_service").click(function(){
		var job_id = jQuery(this).attr("id");
		jQuery("input#job_id").val(job_id);
		jQuery("input#description").val('');
		jQuery("input#quantity").val('1');
		jQuery("input#unit").val('');
		jQuery("input#additional_charges").val('');
		jQuery("input#notes").val('');
		
	}); 
	}); 
			
</script> 

