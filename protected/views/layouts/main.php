<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="<?php echo Yii::app()->getBaseUrl(true); ?>/images/favicon.png">



     <?php
        Yii::app()->clientScript->registerCssFile('http://fonts.googleapis.com/css?family=Oswald:400,300,700');
        Yii::app()->clientScript->registerCssFile($this->base_url_assets . '/css/style.default.css');
		Yii::app()->clientScript->registerCssFile($this->base_url_assets . '/css/bootstrap.min.css');
		Yii::app()->clientScript->registerCssFile($this->base_url_assets . '/css/style.css');
        Yii::app()->clientScript->registerCssFile($this->base_url_assets . '/css/morris.css');
        Yii::app()->clientScript->registerCssFile($this->base_url_assets . '/css/select2.css');
        Yii::app()->clientScript->registerCssFile($this->base_url_assets . '/css/bootstrap-timepicker.min.css');
        Yii::app()->clientScript->registerCssFile($this->base_url_assets . '/css/jquery-ui-1.11.4.custom/jquery-ui.theme.min.css');
      ?>



<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
        <script src="/js/html5shiv.js"></script>
        <script src="/js/respond.min.js"></script>
        <![endif]-->

		

	     <?php
        Yii::app()->clientScript->registerCoreScript('jquery'); 
        Yii::app()->clientScript->registerScriptFile($this->base_url_assets . '/js/ckeditor/ckeditor.js');		
	Yii::app()->clientScript->registerScriptFile($this->base_url_assets . '/js/jquery-migrate-1.2.1.min.js');
        Yii::app()->clientScript->registerScriptFile($this->base_url_assets . '/js/bootstrap.min.js');
	Yii::app()->clientScript->registerScriptFile($this->base_url_assets . '/js/bootstrap-timepicker.min.js');
        Yii::app()->clientScript->registerScriptFile($this->base_url_assets . '/js/custom.js');
        Yii::app()->clientScript->registerScriptFile($this->base_url_assets . '/js/jquery.form.js');
        Yii::app()->clientScript->registerScriptFile($this->base_url_assets . '/js/jquery-ui.js');
        ?>


	
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		
	

</head>

<body>


<?php $this->beginContent('//layouts/includes/header'); ?>
<?php $this->endContent(); ?>

<section>
  <div class="mainwrapper">
    
<?php $this->beginContent('//layouts/includes/left_section'); ?>
<?php $this->endContent(); ?>

  
  <!-- mainwrapper --> 
  
  
  <div class="mainpanel">
  <?php echo $content; ?>
  
<?php $this->beginContent('//layouts/includes/footer'); ?>
<?php $this->endContent(); ?>
 </div>
 <!-- mainpanel --> 
 
 </div>
</section>



</body>
</html>
