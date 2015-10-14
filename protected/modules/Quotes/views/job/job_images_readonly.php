<style>

.top_wrepp a{display:inline-block; float:left;}
.top_wrepp span{display:inline-block; float:right; color:#fff;}



    #slides
    {
      display: none;
     
    }

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
      margin-right: 5px;
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
	
	.slidesjs-container{height:484px !important; width:550px !important; position:static;}
	.slidesjs-control{top:22px; width:auto; height:auto;}
    
 
    #slides {
      display: none
    }

    .slider_wrapper {
      margin: 0 auto
    }

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

<div class="top_wrepp">

<a href="http://highclean.com.au/"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/logo_new.png"/></a>
<span>
	High Clean Pty Ltd<br />
    E: info@highclean.com.au<br />
    A: 1/92 Railway St South, Altona VIC 3018<br />
    T: 03 8398 0804
        
     
</span>
<br clear="all" />	
</div>
<div class="pageheader">

        <div class="media">

          <div class="media-body">

            <h4 align="center">Job Report</h4>			

          </div>

        </div>

        <!-- media --> 

</div>



<?php $path = Yii::app()->basePath.'/../uploads/job_images/thumbs/'; ?>

<div class="contentpanel">



<div class="row">

<div class="col-md-12 quote_section">





        <div class="row mb20">

       

			<dt class="col-md-6 blue4">Company Name</dt>

              <dd class="col-md-6 blue4"><?php echo Contact::Model()->FindByPk($quote_model->contact_id)->first_name." ".Contact::Model()->FindByPk($quote_model->contact_id)->surname; ?></dd>

         
			<dt class="col-md-6 blue2">Contact Name</dt>

              <dd class="col-md-6 blue2"><?php echo Company::Model()->FindByPk($quote_model->company_id)->name; ?></dd>

              

			  <dt class="col-md-6 blue2">Site Name</dt>

              <dd class="col-md-6 blue2"><?php echo ContactsSite::Model()->FindByPk($quote_model->site_id)->site_name; ?></dd>

      

			  <dt class="col-md-6 blue3">Site Address</dt>

              <dd class="col-md-6 blue3"><?php echo ContactsSite::Model()->FindByPk($quote_model->site_id)->address . ', ' . ContactsSite::Model()->FindByPk($quote_model->site_id)->suburb. ', ' . ContactsSite::Model()->FindByPk($quote_model->site_id)->state. ' ' . ContactsSite::Model()->FindByPk($quote_model->site_id)->postcode; ?></dd>

      

			  

			  <dt class="col-md-6 blue3">Scope of Works</dt>

              <dd class="col-md-6 blue3"><?php echo Service::Model()->FindByPk($quote_model->service_id)->service_name; ?></dd>

      

			  

			  <dt class="col-md-6 blue2">Purchase Order Number</dt>

              <dd class="col-md-6 blue2"><?php if(! empty($model->purchase_order) && $model->purchase_order != NULL) { 

				echo $model->purchase_order; 

			  } else { echo '-'; } ?></dd>

      





        

        </div>



<div style="text-align:center;">


 <a href="javascript:void(0);" class="btn btn-primary mr5" onclick="return false;" data-toggle="modal" data-target="#myModal"  >Slide</a>
 </div>


	

	

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

		

	

			 

	

	),

)); ?>

          </div>

        </div>

     



</div>

<!-- Job photos END -->			  



</div>



<br/>

<br/>





</div>

<!--- Content Panel --->




<!-- Modal box 1 -->

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">

<div class="modal-dialog">

<div class="modal-content">

  <div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>


  </div>
  
      <div class="modal-body">

      	<div class="slider_wrapper">
    <div id="slides">
    	
    	 <a href="#" class="slidesjs-previous slidesjs-navigation btn"><i class="glyphicon glyphicon-chevron-left"></i>Previous</a>
         <a href="#" class="slidesjs-next slidesjs-navigation btn">Next<i class="glyphicon glyphicon-chevron-right"></i></a>
    
     
   	<?php  foreach($job_images as $image) { ?>

	<?php if(isset($image->photo_before) && $image->photo_before !=NULL && file_exists($path.$image->photo_before))	 { ?>
	<img src="<?php echo Yii::app()->getBaseUrl(true).'/uploads/job_images/'.$image->photo_before; ?>" >
	<?php } ?>	


	<?php if(isset($image->photo_after) && $image->photo_after !=NULL && file_exists($path.$image->photo_after))	 { ?>
	 <img src="<?php echo Yii::app()->getBaseUrl(true).'/uploads/job_images/'.$image->photo_after; ?>" >
	<?php } ?>	

	<?php } ?>  
     
     
     
     
    </div>
  </div>

      </div>

    </div>

    <!-- modal-content --> 

  </div>

  <!-- modal-dialog --> 

  

</div>


   <script>
    $(function() {
      $('#slides').slidesjs({
        width: 600,
        height: 300,
        navigation: false
      });

      /*
        To have multiple slideshows on the same page
        they just need to have separate IDs
      */
          
    });
  </script>

