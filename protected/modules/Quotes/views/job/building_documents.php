<style>

    .modal-dialog {
        margin : 10px auto 30px; !important;	
        width: 44%; !important;
    }

    .modal-body img {
        width:100%;
    }
    .border_hr{height:1px; background:#e5e5e5; margin:0 0 15px 0; width:100%;}
</style>



<div class="pageheader">
    <div class="media">
        <div class="media-body">
            <a href="<?php echo Yii::app()->getBaseUrl(true) . '/?r=Quotes/Job/view&id=' . $model->id; ?>" class="btn btn-primary pull-right">Back To Job Details</a>
            <h4>Documents/Photos</h4>

        </div>
    </div>
    <!-- media --> 
</div>

<?php $path = Yii::app()->basePath . '/../uploads/job_images/thumbs/'; ?>
<div class="contentpanel">


    <!-- building documents start -->		
    <div class="row">
        <div class="col-md-12 quote_section">
            <?php $path_building_doc = Yii::app()->basePath . '/../uploads/building_documents/'; ?>

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

                <?php if (count($building_documents) > 0) { ?>
                    <table width="100%">
                        <?php foreach ($building_documents as $docRow) { ?>

                            <?php if (isset($docRow->doc) && $docRow->doc != NULL && file_exists($path_building_doc . $docRow->doc)) { ?>

                                <tr><td>    
                                        <a href="<?php echo Yii::app()->getBaseUrl(true) . '/uploads/building_documents/' . $docRow->doc; ?>" >
                                            <?php echo $docRow->doc; ?>    
                                        </a>
                                    </td></tr>    

                            <?php } ?>	

                        <?php } ?>
                    </table>    
                <?php } ?>

                <br/>   
                <hr class="border_hr" /> 
                <?php echo CHtml::submitButton('Save Building Documents', array('class' => 'btn btn-primary')); ?> 

                <?php $this->endWidget(); ?>
                <br/>
                <div class="clearfix"></div>




            </div>
            <!-- building documents END -->			  


        </div> 
    </div>


    <!-- building photos start -->		
    <div class="row">
        <div class="col-md-12 quote_section">



            <?php $path_building = Yii::app()->basePath . '/../uploads/building_images/thumbs/'; ?>

            <?php if (count($building_images) > 0) { ?>
                <div id="jcl-demo" >

                    <div class="custom-container default">
                        <a href="#" class="prev">&lsaquo;</a>
                        <div class="carousel" >
                            <ul>
                                <?php foreach ($building_images as $image) { ?>
                                    <?php if (isset($image->photo) && $image->photo != NULL && file_exists($path_building . $image->photo)) { ?>
                                        <li><img width="100%" src="<?php echo Yii::app()->getBaseUrl(true) . '/uploads/building_images/thumbs/' . $image->photo; ?>" alt="" ></li>
                                    <?php } ?>	
                                <?php } ?>


                            </ul>
                        </div>
                        <a href="#" class="next">&rsaquo;</a>
                        <div class="clear"></div>
                    </div>

                </div>
            <?php } ?>	
            <div class="col-md-12">		
                <br/>

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
                <div class="clear"></div> 	

                <?php echo CHtml::submitButton('Save Building Photos', array('class' => 'btn btn-primary')); ?> 						  



                <?php
                $aClass = 'style="display:none;"';
                $display_slide_button = 0;
                foreach ($building_images as $image) {
                    ?>

                    <?php if (isset($image->photo) && $image->photo != NULL && file_exists($path_building . $image->photo)) { ?>
                        <a <?php
                        if ($display_slide_button) {
                            echo $aClass;
                        } else {
                            $display_slide_button = 1;
                        }
                        ?> href="<?php echo Yii::app()->getBaseUrl(true) . '/uploads/building_images/' . $image->photo; ?>" data-gallery>
                            <button class="btn btn-primary mr5" > Slide Photos </button>
                        </a>
                    <?php } ?>	
                <?php } ?>	



<?php $this->endWidget(); ?>

                <div class="clearfix"></div>



            </div>
            <!-- building photos END -->			  








        </div> 
    </div>



    <script type="text/javascript">
        $(function () {

            $(".default .carousel").jCarouselLite({
                btnNext: ".default .next",
                btnPrev: ".default .prev",
                visible: 6
            });

        });
    </script>




</div>
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
