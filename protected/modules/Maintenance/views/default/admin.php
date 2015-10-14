<?php
/* @var $this MaintenanceController */
/* @var $model Maintenance */
?>
<?php /* $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'maintenance-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'date',
		'equipment',
		'note',
		'photo',
		'status',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); */ ?>


<div class="pageheader">
        <div class="media">
          <div class="media-body">
         <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li>Manage Maintenances</li>
            </ul>

          </div>
        </div>
        <!-- media --> 
</div>


    <div class="contentpanel">
	
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>


        <div class="row">
          <div class="col-md-12 quote_section">
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2>Maintenances Management</h2>
              </div>
            </div>
            <div class="col-md-12">
<button data-toggle="modal" data-target="#myModal"  class="add_new_maintenance btn btn-primary mr5"  onclick="return false;" >Add New Maintenance</button>		
			
              <div class="table-responsive">
            
	<div class="col-md-12 pull-right mb10 pr0" style="text-align:right">
           
</div>

<?php 

// CgridView Records/page
$pageSize = Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'maintenance-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-bordered mb30 quote_table',
	'pagerCssClass'=>'pagination',
	'columns'=>array(
/* 	
	        array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                'width'=>'10%',
                                'class'=>'head'
                        )
                ), */
			 
	
		array(
                'name'=>'date',
                'header'=>'Date',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'10%'),
            ),
			array(
                'name'=>'equipment',
                'header'=>'Equipment',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'20%'),
            ),
			
			array(
                'name'=>'note',
                'header'=>'Note',
				'headerHtmlOptions'=>array('class'=>'head','width'=>'25%'),
            ),

			array(
                        'name'=>'status',
						'headerHtmlOptions'=>array('class'=>'head','width'=>'10%'),
						'filter'=>array('Pending'=>'Pending', 'Completed'=>'Completed'),		
						'value' => 'ucwords($data->status)',
                    
			),		
			
			array(
            'name'=>'photo',
			'header'=>'Photo',
			'headerHtmlOptions'=>array('class'=>'head','width'=>'15%','align'=>'center'),
            'type'=>'html',
       		'value' => '(!empty($data->photo))? CHtml::image(Yii::app()->baseUrl . "/uploads/maintenances/thumb/" . $data->photo):"no image"'
        ),
		
		
		array(
			'class'=>'CButtonColumn',
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,25=>25,50=>50,100=>100,150=>150,200=>200),
			array(
			'onchange'=>"$.fn.yiiGridView.update('maintenance-grid',{ data:{pageSize: $(this).val() }})",
			)),	
			'headerHtmlOptions'=>array('width'=>'20%','class'=>'head'),
			'template'=>'{update} | {delete}',
			'buttons'=>array
						(
							
							'update' => array
							(
								'label'=>'Edit',
								'imageUrl'=>false,
							),'delete' => array
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
        <h4 class="modal-title" id="myModalLabel">Add New Maintenance</h4>
      </div>
 
 
 <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'maintenance-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
	
)); ?>
	  
	  
      <div class="modal-body">
      <?php echo $form->errorSummary($model_maintenance); ?>

		<div class="form-group">
          <?php echo $form->labelEx($model_maintenance,'date',array('class'=>'col-sm-4')); ?>
          <div class="col-sm-8">
		   <?php echo $form->textField($model_maintenance,'date',array('id'=>'date','class'=>'form-control')); ?>
		</div>
        </div>
		
        <div class="form-group">
          <?php echo $form->labelEx($model_maintenance,'equipment',array('class'=>'col-sm-4')); ?>
          <div class="col-sm-8">
		  <?php echo $form->textField($model_maintenance,'equipment',array('class'=>'form-control')); ?>
		 </div>
        </div>
		  <div class="form-group">
          <?php echo $form->labelEx($model_maintenance,'note',array('class'=>'col-sm-4')); ?>
          <div class="col-sm-8">
		  <?php echo $form->textArea($model_maintenance,'note',array('class'=>'form-control')); ?>
		 </div>
        </div>
		
        <div class="form-group">
          <?php echo $form->labelEx($model_maintenance,'photo',array('class'=>'col-sm-4')); ?>
          <div class="col-sm-8">
		    <?php echo  CHtml::activeFileField($model_maintenance,'photo',array('class'=>'form-control')); ?>            
          </div>
        </div>
		
		<div class="form-group">
          <?php echo $form->labelEx($model_maintenance,'status',array('class'=>'col-sm-4')); ?>
          <div class="col-sm-8">
		   <?php echo $form->dropDownList($model, 'status', array("Pending" => "Pending", "Completed" => "Completed"),array('class'=>'form-control')); ?>		
		  </div>
        </div>
		
        <div class="form-group">
          <label class="col-sm-4">&nbsp;</label>
          <div class="col-sm-8">
          <?php echo CHtml::submitButton('Save',array('class'=>'btn btn-primary')); ?>
          </div>
        </div>
		
      </div>
   

 
<?php $this->endWidget(); ?>


    </div>
    <!-- modal-content --> 
  </div>
  <!-- modal-dialog --> 
  
</div>

<!-- Modal box 1 --> 


  
  <script type="text/javascript">
  	jQuery(document).ready(function(){
	

    $("#date").datepicker({
		dateFormat:'yy-mm-dd',
       // minDate: 0,
        maxDate: "+1000D",
        numberOfMonths: 1,
    });
	
	}); 
			
  </script>
  
  
