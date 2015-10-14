<style>

    .modal-dialog {
        margin : 10px auto 30px; !important;	
    }

</style>

<div class="pageheader">
    <div class="media">
        <div class="media-body">
            <ul class="breadcrumb">
                <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i></a></li>
                <li><a href="<?php echo Yii::app()->getBaseUrl(true); ?>?r=Quotes/default/admin">Quotes</a></li>
                <li><a href="<?php echo Yii::app()->getBaseUrl(true); ?>?r=Buildings/default/admin">Buildings</a></li>
                <li>Manage Building Photos/Documents</li>
            </ul>
            <h4>

                <?php
                echo CHtml::link(
                        Yii::t("Buildings.admin", "Manage"), array("admin"), array("class" => "btn btn-primary pull-right")
                );
                ?>
            </h4>

        </div>
    </div>
    <!-- media --> 
</div>


<div class="contentpanel">


    <!-- building documents start -->		
    <div class="row">
        <div class="col-md-12 quote_section">

            <div class="panel panel-default">
                <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                    <h2><?php echo $model->building_name; ?> (To select multiple, hold ctrl button while selection)</h2>			
                </div>
            </div>

            <div class="col-md-12">		
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'locations-form',
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array('enctype' => 'multipart/form-data'), // ADD THIS
                ));
                ?>


                <?php
                $this->widget('CMultiFileUpload', array(
                    'name' => 'documents',
                    'accept' => 'doc|docx|pdf', // useful for verifying files
                    'denied' => 'Only doc, docx and pdf allowed',
                    'max' => 100,
                    'duplicate' => 'Already Selected',
                    'htmlOptions' => array('multiple' => 'multiple',),
                ));
                ?>


                <br/>
<?php echo CHtml::submitButton('Save Building Documents', array('class' => 'btn btn-primary')); ?> 

                <?php $this->endWidget(); ?>
                <br/>
                <div class="clearfix"></div>

                <?php $path_building_doc = Yii::app()->basePath . '/../uploads/building_documents/'; ?>

                    <?php foreach ($building_documents as $docRow) { ?>
                    <?php if (isset($docRow->doc) && $docRow->doc != NULL && file_exists($path_building_doc . $docRow->doc)) { ?>
                        <a href="<?php echo Yii::app()->getBaseUrl(true) . '/uploads/building_documents/' . $docRow->doc; ?>" >
                        <?php echo $docRow->doc; ?>    
                        </a><br/>
    <?php } ?>	
<?php } ?>


            </div>
            <!-- building documents END -->			  


        </div> 
    </div>




    <br/>
    <br/>
    <!-- building photos start -->		
    <div class="row">
        <div class="col-md-12 quote_section">

            <!-- Job photos -->		
            <div class="panel panel-default">
                <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                    <h2><?php echo $model->building_name; ?>  (To select multiple, hold ctrl button while selection)</h2>	
                </div>
            </div>

            <div class="col-md-12">		
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'locations-form',
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array('enctype' => 'multipart/form-data'), // ADD THIS
                ));
                ?>


                <?php
                $this->widget('CMultiFileUpload', array(
                    'name' => 'images',
                    'accept' => 'jpeg|jpg|png', // useful for verifying files
                    'denied' => 'Only jpeg,jpg and pngs allowed',
                    'max' => 100,
                    'duplicate' => 'Already Selected',
                    'htmlOptions' => array('multiple' => 'multiple',),
                ));
                ?>

                <br/>
                <?php echo CHtml::submitButton('Save Building Photos', array('class' => 'btn btn-primary')); ?> 						  


                <?php $this->endWidget(); ?>
                <br/><br/>
                <div class="clearfix"></div>

                <?php $path_building = Yii::app()->basePath . '/../uploads/building_images/thumbs/'; ?>

                <?php foreach ($building_images as $image) { ?>
    <?php if (isset($image->photo) && $image->photo != NULL && file_exists($path_building . $image->photo)) { ?>
                        <a href="<?php echo Yii::app()->getBaseUrl(true) . '/uploads/building_images/' . $image->photo; ?>" title="" data-gallery>
                            <img src="<?php echo Yii::app()->getBaseUrl(true) . '/uploads/building_images/thumbs/' . $image->photo; ?>" alt="">
                        </a>
    <?php } ?>	
<?php } ?>


            </div>
            <!-- building photos END -->			  








        </div> 
    </div>







</div>
<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery">
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class="title"></h3>
    <a class="prev"> << </a>
    <a class="next"> >> </a>
    <a class="close"> X </a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class="modal fade">
        <div class="modal-dialog">
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
