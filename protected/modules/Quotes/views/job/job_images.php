<style>

.modal-dialog {
margin : 10px auto 30px; !important;	
width: 44%; !important;
}

.modal-body img {
	width:100%;
}
</style>


<div class="pageheader">
        <div class="media">
          <div class="media-body">
           	<a href="<?php echo Yii::app()->getBaseUrl(true).'/?r=Quotes/Job/view&id='.$model->id; ?>" class="btn btn-primary pull-right">Back To Job Details</a>
            <h4>Job Report</h4>
			
          </div>
        </div>
        <!-- media --> 
</div>

<?php $path = Yii::app()->basePath.'/../uploads/job_images/thumbs/'; ?>
<div class="contentpanel">

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
    
<div class="row">
<div class="col-md-12 quote_section">
 	
<!-- Job photos -->		
<div class="panel panel-default">
          <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
            <h2>Job Cleaning Report</h2>			
          </div>
</div>

<div class="col-md-12">		
<button id="<?php echo $model->id; ?>"  data-toggle="modal" data-target="#myModal"  class="add_new_job_image btn btn-primary mr5"  onclick="return false;" > Add New Record </button>



	<?php $aClass = 'style="display:none;"'; $display_slide_button = 0; foreach($job_images as $image) { ?>
	
	<?php if(isset($image->photo_before) && $image->photo_before !=NULL && file_exists($path.$image->photo_before))	 { ?>
	<a <?php if($display_slide_button)  {  echo $aClass; }  else { $display_slide_button = 1 ; }  ?> href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/job_images/'.$image->photo_before; ?>" title="<?php echo 'BEFORE - '.strtoupper($image->area); ?>" data-gallery>
	<button class="btn btn-primary mr5" > Slide Photos </button>
    </a>
	<?php } ?>	
	
	
	<?php if(isset($image->photo_after) && $image->photo_after !=NULL && file_exists($path.$image->photo_after))	 { ?>
	<a   <?php if($display_slide_button)  {  echo $aClass; }  else { $display_slide_button = 1 ; }  ?>  href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/job_images/'.$image->photo_after; ?>"  title="<?php echo 'AFTER - '.strtoupper($image->area); ?>" data-gallery>
        <img width="100%" src="<?php echo Yii::app()->getBaseUrl(true).'/uploads/job_images/thumbs/'.$image->photo_after; ?>" alt="">
    </a>
	<?php } ?>	
	
	<?php } ?>

	&nbsp;&nbsp;&nbsp;&nbsp;
	<strong>Cleaning Report</strong>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="<?php echo $this->user_role_base_url.'/?r=Quotes/Job/DownloadJobBeforeAfterReport&id='.$model->id; ?>" class="download">Download</a>
	&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;
	<a style="float:right; color:#000; line-height:32px;" href="javascript:void(0);" data-toggle="modal" data-target="#myModalShareReport" onclick="return false;" >Share Report Link</a>
	
	
	
<div class="clearfix"></div>


<div class="table-responsive">
<div class="col-md-12">
<?php 
	
	$jobImages_model=new JobImages('search');
	$jobImages_model->unsetAttributes();  // clear any default values
	$jobImages_model->job_id = $model->id;

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'building-grid-'.$model->id,
	'dataProvider'=>$jobImages_model->search(),
	'summaryText'=>'', 
	//'filter'=>$jobImages_model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',	
	'pagerCssClass'=>'pagination',
	'enablePagination' => false,

	'columns'=>array(
		array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'5%',
                                'class'=>'head'
                        )
                ),

		 
	 array(
                'name'=>'area',
				'htmlOptions'=>array('width'=> "15%"),
                'headerHtmlOptions'=>array('class'=>'head'),				
            ),

				array(
				'name' => 'photo_before',
				'htmlOptions'=>array('width'=> "15%"),
				'headerHtmlOptions'=>array('class'=>'head'),
				'type' => 'raw',
                'value' => 'CHtml::image(Yii::app()->getBaseUrl(true)."/uploads/job_images/thumbs/".$data->photo_before)'				
			),
			
		array(
                'name'=>'photo_after',
				'htmlOptions'=>array('width'=> "15%"),
                'headerHtmlOptions'=>array('class'=>'head'),
				'type' => 'raw',				
				'value' => 'CHtml::image(Yii::app()->getBaseUrl(true)."/uploads/job_images/thumbs/".$data->photo_after)'				
            ),


			 
	 array(
                'name'=>'note',
				'htmlOptions'=>array('width'=> "25%"),
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
				 				'url' => 'Yii::app()->createUrl("/Quotes/job/GetJobImageDataColumnsImage",array("job_image_id" => $data->primaryKey,"id" => $data->job_id))',
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
                		'url' => 'Yii::app()->createUrl("/Quotes/job/GetJobImageDataColumns",array("job_image_id" => $data->primaryKey,"id" => $data->job_id))',
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
								'url' => 'Yii::app()->createUrl("/Quotes/job/DeleteJobImageRecord",array("job_image_id" => $data->primaryKey,"id" => $data->job_id))',
							),
									
						
						
						),
			 
			 
		),
	),
)); ?>
          </div>
        </div>
     

</div>
<!-- Job photos END -->			  

	

	

</div> 
</div>

<br/>
<br/>


</div>
<!--- Content Panel --->

<script type="text/javascript" charset="utf-8">


function add_job_image_data() {

		var job_id = jQuery('input#job_id').val(); 
		var area = jQuery('input#area').val(); 
		var note = jQuery('input#note').val(); 

		if(area == '' || area == null ) {
		alert("Please enter area"); return false;
		}

		//var post_data = 'job_id='+job_id+'&area='+area+'&note='+note;

	post_data = {
          id: job_id,
          area: area,
          note: note
       };
		
jQuery.ajax(
            {
            url : '?r=Quotes/Job/Add_JobImageData',
            type: "POST",
            data : post_data,
            success:function(data, textStatus, jqXHR){
                    post_data = '';

                    jQuery("input#job_id").val('');
                    jQuery("input#area").val('');
                    jQuery("input#note").val('');
                    jQuery('#myModal').modal('hide');

                    jQuery('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow'); 
                    jQuery.fn.yiiGridView.update('building-grid-'+job_id); 
            },
            error: function(jqXHR, textStatus, errorThrown)
                    {}
});
	
								
									return false;

}


	jQuery(document).ready(function(){
	
        jQuery(".add_new_job_image").click(function(){
		var job_id = jQuery(this).attr("id");
		jQuery("input#job_id").val(job_id);
		jQuery("input#area").val('');
		jQuery("input#note").val('');
		
	}); 
	}); 
			
</script> 

<!-- Modal box 1 -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add New Cleaning Record</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="job_id" value="<?php echo $model->id; ?>" class="form-control" />
        
        <div class="form-group">
          <label class="col-sm-4">Area</label>
          <div class="col-sm-8">
            <input type="text"  autocomplete="off"  id="area" value="" class="form-control" />
          </div>
        </div>
		
       <div class="form-group">
          <label class="col-sm-4">Note</label>
          <div class="col-sm-8">
            <input type="text"  autocomplete="off"  id="note" value="" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4">&nbsp;</label>
          <div class="col-sm-8">
            <button class="btn btn-primary mr5" id="addbtn0" onclick="add_job_image_data(); return false;" >Add</button>
          </div>
        </div>
      </div>
    </div>
    <!-- modal-content --> 
  </div>
  <!-- modal-dialog --> 
  
</div>

<!-- Modal box 1 --> 




<!-- Modal box 1 -->
<div class="modal fade" id="myModalShareReport" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Share Job Report Link</h4>
      </div>
      <div class="modal-body">
	  
	  <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'buildings-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

      
        <div class="form-group">
          <?php echo $form->labelEx($model,'client_name',array('class'=> 'col-md-4')); ?>
          <div class="col-sm-8">
            <?php echo $form->textField($model,'client_name',array('class'=> 'form-control')); ?>
          </div>
        </div>
		
	 <div class="form-group">
          <?php echo $form->labelEx($model,'client_email',array('class'=> 'col-md-4')); ?>
          <div class="col-sm-8">
            <?php echo $form->textField($model,'client_email',array('class'=> 'form-control')); ?>
          </div>
        </div>
		
	 <div class="form-group">
          <?php echo $form->labelEx($model,'note_for_client',array('class'=> 'col-md-4')); ?>
          <div class="col-sm-8">
            <?php echo $form->textArea($model,'note_for_client',array('class'=> 'form-control')); ?>
          </div>
        </div>
		
        <div class="form-group">
          <label class="col-sm-4">&nbsp;</label>
          <div class="col-sm-8">
             <?php echo CHtml::submitButton('Save',array('class'=>'btn btn-primary')); ?> &nbsp; 
		  </div>
        </div>
		<?php $this->endWidget(); ?>
      </div>
    </div>
    <!-- modal-content --> 
  </div>
  <!-- modal-dialog --> 
  
</div>

<!-- Modal box 1 --> 




 <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery">
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class="modal fade">
        <div class="modal-dialog"  style="46px auto 30px">
            <div class="modal-content">
				
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
				
				<div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left prev">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                        Previous
                    </button>
                    <button type="button" class="btn btn-primary next">
                        Next
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                </div>
				
                <div class="modal-body next"></div>
                
            </div>
        </div>
    </div>
</div>

 
