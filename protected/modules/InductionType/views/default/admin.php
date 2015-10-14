<?php
/* @var $this InductionTypeController */
/* @var $model InductionType */
?>


<div class="pageheader">
        <div class="media">
          <div class="media-body">
         <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
	  <li><a href="<?php echo $this->user_role_base_url; ?>?r=User/default/admin">User</a></li>
              <li>Manage Induction Type</li>
            </ul>

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
                <h2>Induction Type Management</h2>
              </div>
            </div>
            <div class="col-md-12">
<button data-toggle="modal" data-target="#myModal"  class="add_new_induction_type btn btn-primary mr5"  onclick="return false;" >Add New Induction Type</button>		
			
              <div class="table-responsive">
            
	<div class="col-md-12 pull-right mb10 pr0" style="text-align:right">
           
</div>

<?php 

// CgridView Records/page
$pageSize = Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'induction-type-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'columns'=>array(
	
	      /*  array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'head'
                        )
                ),
			 */	
		array(
                'name'=>'name',
                'header'=>'Induction Type',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'20%'),
            ),
		
		array(
			'class'=>'CButtonColumn',
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('company-grid',{ data:{pageSize: $(this).val() }})",
			)),	
			'headerHtmlOptions'=>array('width'=>'24%','class'=>'head'),
			'template'=>'{update} | {delete}',
			'buttons'=>array
						(
						
 'update' => array( // My custom button options
                        'label' => 'Edit',
						'imageUrl'=>false,	
                		'url' => 'Yii::app()->createUrl("/InductionType/default/getInductionType",array("id" => $data->primaryKey))',
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
							),
							
						
						),
			 
			 
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



<!-- Modal box 1 -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add New Induction Type</h4>
      </div>
      <div class="modal-body">
     
        <div class="form-group">
          <label class="col-sm-4">Induction Type</label>
          <div class="col-sm-8">
            <input type="text"  autocomplete="off"  id="InductionTypeName" value="" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4">&nbsp;</label>
          <div class="col-sm-8">
            <button class="btn btn-primary mr5" id="addbtn0" onclick="add_new_induction_type(); return false;" >Add</button>
          </div>
        </div>
      </div>
    </div>
    <!-- modal-content --> 
  </div>
  <!-- modal-dialog --> 
  
</div>

<!-- Modal box 1 --> 

	  
	  <script>

function add_new_induction_type() {

		var InductionTypeName = jQuery('input#InductionTypeName').val(); 
		if(InductionTypeName == '' || InductionTypeName == null ) {
		alert("Please enter Induction Type Name"); return false;
		}
		
	
	post_data = {          
           InductionTypeName: InductionTypeName
       };

		
		  jQuery.ajax(
							{
							url : '/?r=InductionType/default/addNewInductionType',
							type: "POST",
							data : post_data,
							success:function(data, textStatus, jqXHR){
								if(data == 'already_exist') {
									alert('This Induction Type already exist.');	return false;
								}			
								jQuery("input#InductionTypeName").val('');								
								jQuery('#myModal').modal('hide');
								jQuery('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                                jQuery.fn.yiiGridView.update('induction-type-grid'); 
							},
							error: function(jqXHR, textStatus, errorThrown)
								{}
					});
	
								
									return false;

}
	  
</script>
