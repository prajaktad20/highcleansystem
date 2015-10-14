<style>

    .top_wrepp a{display:inline-block; float:left;}
    .top_wrepp span{display:inline-block; float:right; color:#fff;}



    .modal-header .close{margin-top:-9px;}
    .slidesjs-navigation {
        margin-top:3px;
    }

    .slidesjs-previous {
        margin-right: 5px;
        float: left;
        background:#e4e7ea;
        color:#636e7b;
    }
    .btn {
        border-radius: 3px;
        border-width: 0;
        line-height: 21px;
        padding: 8px 15px;
        transition: all 0.2s ease-out 0s;
    }

    .slidesjs-next {

        float:right;
        background:#428bca;
        border-color: #357ebd;
        color: #fff;
    }

    .slidesjs-pagination {
        display: none;

    }
    .slider_heading{
        padding-bottom: 20px;
        text-align:center;
        border-bottom: 2px solid #ccc;
        font-size:20px;
        line-height:34px;
        margin-bottom:15px;
    }

    a.btn {margin-bottom:10px;}
    a{text-decoration:none;}

    .slidesjs-container{height:410px !important; width:100% !important; position:static;   border:1px solid #000; padding:0 10px;}
    .slidesjs-control{top:28px; width:100% !important; min-height:371px !important; height:100% !important;}
    #close_slide_photos {
        position: relative;
        top: -20px;
        right: -71px;
    }    
    .slidesjs-slide{min-height:365px !important; height:90% !important;}

    .slider_wrapper {border-top:1px solid #ccc; margin-top:15px; margin:0 auto; max-width:600px; width:100%;}
    #slides{padding-top:21px;}
    /* For tablets & smart phones */
    @media (max-width: 767px) {

        .slider_wrapper {
            width: auto
        }
    }

    /* For smartphones */
    @media (max-width: 480px) {
        .slider_wrapper {
            width: auto
        }
    }

    /* For smaller displays like laptops */
    @media (min-width: 768px) and (max-width: 979px) {
        .slider_wrapper {
            width: 724px
        }
    }

    /* For larger displays 
    @media (min-width: 1200px) {
      .slider_wrapper {
        max-width: 980px;
                width:100%;
                background:#fff;
                padding:10px;
      }*/
    }
</style>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.slides.min.js'); ?>

<div class="row top_wrepp">
    <div class="col-md-6 col-sm-4 col-xs-6 col-mb-12">
       <!-- <a href="http://highclean.com.au/"><img src="<?php //echo Yii::app()->getBaseUrl(true); ?>/images/logo_new.png"/></a>-->
		<?php 

            $path = Yii::app()->basePath . '/../uploads/service-agent-logos/thumbs/';
            if (isset($agent_model->logo) && $agent_model->logo != NULL && file_exists($path . $agent_model->logo)) {
                $img_src = Yii::app()->getBaseUrl(true) . '/uploads/service-agent-logos/thumbs/' . $agent_model->logo;
                $left_header_title = '<img src="'.$img_src.'" title="'.$agent_model->business_name.'" style="width:100%"> ';
            } else {
                $left_header_title = '<span style="font-size:16px;">' . $agent_model->business_name . '</span>';               
            } 
     
?>
<a href="http://highclean.com.au/"><?php echo $left_header_title; ?></a>
	</div>
    <div class="col-md-6 col-sm-8 col-xs-6 col-mb-12">
        <!--<span>
            High Clean Pty Ltd<br />
            E: info@highclean.com.au<br />
            A: 1/92 Railway St South, Altona VIC 3018<br />
            T: 03 8398 0804
        </span>-->
		<span>
	<?php
		$complete_address_text = '';

			if(!empty($agent_model->business_name)){
			$complete_address_text .=  $agent_model->business_name.'<br/>';
			}

			$concat_business_address = '';
			
			if(!empty($agent_model->street))
			$concat_business_address .= $agent_model->street.'<br/>';
			
			if(!empty($agent_model->city))
			$concat_business_address .= $agent_model->city;			
			
			if(!empty($agent_model->state_province))
			$concat_business_address .= ', '.$agent_model->state_province;
			
			if(!empty($agent_model->zip_code))
			$concat_business_address .= ' '.$agent_model->zip_code;
			
			if(!empty($agent_model->business_email_address)){
			$complete_address_text .=  'E: <a href="mailto:'.$agent_model->business_email_address.'" target="_blank" style="color:#fff;float:right;">'.$agent_model->business_email_address.'</a>'.'<br/>';
			}
			
			if(!empty($concat_business_address)){
			$complete_address_text .=  'A: '.$concat_business_address.'<br/>';
			}

			if(!empty($agent_model->phone)){
			$complete_address_text .=  'T: '.$agent_model->phone.'<br/>';
			}

		echo $complete_address_text;
?>	
		</span>
    </div>    
</div>
<div class="pageheader">

    <div class="media">

        <div class="media-body">

            <h4 align="center">Job Report</h4>			

        </div>

    </div>

    <!-- media --> 

</div>



<?php $path = Yii::app()->basePath . '/../uploads/job_images/thumbs/'; ?>

<div class="contentpanel">



    <div class="row">

        <div class="col-md-12 quote_section">



            <div class="row mb20">



                <dt class="col-md-6 blue4">Company Name</dt>

                <dd class="col-md-6 blue4"><?php echo Company::Model()->FindByPk($quote_model->company_id)->name; ?></dd>


                <dt class="col-md-6 blue2">Contact Name</dt>

                <dd class="col-md-6 blue2"><?php echo Contact::Model()->FindByPk($quote_model->contact_id)->first_name . ' ' . Contact::Model()->FindByPk($quote_model->contact_id)->surname; ?></dd>



                <dt class="col-md-6 blue2">Site Name</dt>

                <dd class="col-md-6 blue2"><?php echo ContactsSite::Model()->FindByPk($quote_model->site_id)->site_name; ?></dd>



                <dt class="col-md-6 blue3">Site Address</dt>

                <dd class="col-md-6 blue3"><?php echo ContactsSite::Model()->FindByPk($quote_model->site_id)->address . ', ' . ContactsSite::Model()->FindByPk($quote_model->site_id)->suburb . ', ' . ContactsSite::Model()->FindByPk($quote_model->site_id)->state . ' ' . ContactsSite::Model()->FindByPk($quote_model->site_id)->postcode; ?></dd>





                <dt class="col-md-6 blue3">Scope of Works</dt>

                <dd class="col-md-6 blue3"><?php echo Service::Model()->FindByPk($quote_model->service_id)->service_name; ?></dd>





                <dt class="col-md-6 blue2">Purchase Order Number</dt>

                <dd class="col-md-6 blue2"><?php
                    if (!empty($model->purchase_order) && $model->purchase_order != NULL) {

                        echo $model->purchase_order;
                    } else {
                        echo '-';
                    }
                    ?></dd>









            </div>



            <div style="text-align:center;">
                <a href="javascript:void(0);" id="slide_photos" class="btn btn-primary mr5"  >Slide Photos</a>
            </div>




            <div class="clearfix"></div>





            <div class="slider_wrapper" >
                <div id="slides">    	

                    <a href="#" class="slidesjs-previous slidesjs-navigation btn"><i class="glyphicon glyphicon-chevron-left"></i>Previous</a>
                    <a href="#" class="slidesjs-next slidesjs-navigation btn">Next<i class="glyphicon glyphicon-chevron-right"></i></a>
                    <a href="#" id="close_slide_photos" class="slidesjs-navigation pull-right"><i class="glyphicon glyphicon-remove"></i></a>


                    <?php foreach ($job_images as $image) { ?>

    <?php if (isset($image->photo_before) && $image->photo_before != NULL && file_exists($path . $image->photo_before)) { ?>
                            <img style="display:block;" src="<?php echo Yii::app()->getBaseUrl(true) . '/uploads/job_images/' . $image->photo_before; ?>" />
                        <?php } ?>	


    <?php if (isset($image->photo_after) && $image->photo_after != NULL && file_exists($path . $image->photo_after)) { ?>
                            <img style="display:block;"  src="<?php echo Yii::app()->getBaseUrl(true) . '/uploads/job_images/' . $image->photo_after; ?>" />
                        <?php } ?>	


<?php } ?>  



                </div>
            </div>










            <div class="clearfix"></div>





            <div class="table-responsive">

                <div class="col-md-12">

                    <?php
                    $jobImages_model = new JobImages('search');

                    $jobImages_model->unsetAttributes();  // clear any default values

                    $jobImages_model->job_id = $model->id;



                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'building-grid-' . $model->id,
                        'dataProvider' => $jobImages_model->search(),
                        'summaryText' => '',
                        //'filter'=>$jobImages_model,
                        'itemsCssClass' => 'table table-bordered mb30 quote_table',
                        'pagerCssClass' => 'pagination',
                        'enablePagination' => false,
                        'columns' => array(
                            array(
                                'header' => 'No.',
                                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                'headerHtmlOptions' => array(
                                    'width' => '5%',
                                    'class' => 'head'
                                )
                            ),
                            array(
                                'name' => 'area',
                                'htmlOptions' => array('width' => "15%"),
                                'headerHtmlOptions' => array('class' => 'head'),
                            ),
                            array(
                                'name' => 'photo_before',
                                'htmlOptions' => array('width' => "15%", 'align' => 'center'),
                                'headerHtmlOptions' => array('class' => 'head'),
                                'type' => 'raw',
                                'value' => 'CHtml::image(Yii::app()->getBaseUrl(true)."/uploads/job_images/thumbs/".$data->photo_before)'
                            ),
                            array(
                                'name' => 'photo_after',
                                'htmlOptions' => array('width' => "15%", 'align' => 'center'),
                                'headerHtmlOptions' => array('class' => 'head'),
                                'type' => 'raw',
                                'value' => 'CHtml::image(Yii::app()->getBaseUrl(true)."/uploads/job_images/thumbs/".$data->photo_after)'
                            ),
                            array(
                                'name' => 'note',
                                'htmlOptions' => array('width' => "25%"),
                                'headerHtmlOptions' => array('class' => 'head'),
                            ),
                        ),
                    ));
                    ?>

                </div>

            </div>





        </div>

        <!-- Job photos END -->			  



    </div>



    <br/>

    <br/>




    <br/><br/>
</div>

<!--- Content Panel --->


<script>

    $(document).ready(function () {

        $("#slide_photos").on("click", function (e) {
            e.preventDefault();
            $(".slider_wrapper").slideToggle("slow");
            $('html, body').animate({scrollTop: 250}, 'slow');
            return false;
        });



        $("#close_slide_photos").on("click", function (e) {
            e.preventDefault();
            $(".slider_wrapper").slideToggle("slow");
        });

    });

</script>




<script>



    $(function () {

        $(".slider_wrapper").slideToggle("fast");

        $('#slides').slidesjs({
            width: 600,
            height: 300,
            navigation: false
        });



    });
</script>

