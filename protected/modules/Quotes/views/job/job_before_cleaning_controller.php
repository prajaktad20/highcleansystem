<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
table{ font-family:sans-serif; font-size:12px; border-collapse:collapse;  border:#666666 solid 1px;}
table td{ font-family:sans-serif; font-size:12px; padding:4px; border-collapse:collapse;  border:#666666 solid 1px;}
table th{ font-family:sans-serif; font-size:14px; padding:4px; border-collapse:collapse; border:#666666 solid 1px;}
</style>
</head>

<body>
<?php $path = Yii::app()->basePath.'/../uploads/job_images/thumbs/'; ?>


<h1 align="center">JOB CLEANING REPORT</h1>
<p align="center"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/pdf_logo_high.png" /></p>
<p align="left"><strong>BEFORE CLEANING : </strong></p>


<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#666666">

	<?php foreach($job_images_before_cleaning as $image) { ?>
	<?php if(isset($image->photo) && $image->photo !=NULL && file_exists($path.$image->photo))	 { ?>	
    <tr><td>    <img width="100%" src="<?php echo Yii::app()->getBaseUrl(true).'/uploads/job_images/'.$image->photo; ?>" alt="">   </tr></td>
	<?php } ?>	
	<?php } ?>
	
</table>

	    

</body>
</html>