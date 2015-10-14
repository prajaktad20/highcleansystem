<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
table{ font-family:sans-serif; font-size:12px; border-collapse:collapse;  border:#000000 solid 1px;}
table td{ font-family:sans-serif; font-size:12px; padding:4px; border-collapse:collapse;  border:#000000 solid 1px;}
table th{ font-family:sans-serif; font-size:14px; padding:4px; border-collapse:collapse; border:#000000 solid 1px;}
h1 { font-size:16px;}
</style>
</head>

<body>
<?php $path = Yii::app()->basePath.'/../uploads/job_images/'; ?>

<h1 align="center"> <span style="color:#FF0000;"><?php echo $site_model->site_name ?></span> </h1>
<h1 align="center"> <span style="color:#FF0000;"><?php echo $service_model->service_name; ?></span> </h1>
<h1 align="center"> <span style="color:#FF0000;"></span> Report by </h1>
<p align="center"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/pdf_logo_high.png" /></p>
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
	<tr>
	<th bgcolor="#C5E0B4" valign="middle"  align="center" width="20%" height="30%">AREA</th>
	<th bgcolor="#C5E0B4"  valign="middle"  align="center"  width="30%"  height="30%">BEFORE PHOTO</th>
	<th bgcolor="#C5E0B4"  valign="middle"  align="center"  width="30%"  height="30%">AFTER PHOTO</th>
	<th bgcolor="#C5E0B4" valign="middle"  align="center" width="20%"  height="30%">NOTE</th>
	</tr>
	  
	<?php foreach($job_images as $image) { ?>
	
	
    <tr>
	<td valign="middle"  align="left">
	<?php echo $image->area; ?>
	</td>
	
	<?php if(isset($image->photo_before) && $image->photo_before !=NULL && file_exists($path.$image->photo_before))	 { ?>
	<td  valign="top"  align="center" >   <a href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/job_images/'.$image->photo_before; ?>"> <img  src="<?php echo Yii::app()->getBaseUrl(true).'/uploads/job_images/thumbs/'.$image->photo_before; ?>" alt=""> </a>  </td>
	<?php } else { echo '<td>&nbsp;</td>'; } ?>
	
	<?php if(isset($image->photo_after) && $image->photo_after !=NULL && file_exists($path.$image->photo_after))	 { ?>
	<td  valign="top"  align="center" >   <a href="<?php echo Yii::app()->getBaseUrl(true).'/uploads/job_images/'.$image->photo_after; ?>"> <img   src="<?php echo Yii::app()->getBaseUrl(true).'/uploads/job_images/thumbs/'.$image->photo_after; ?>" alt=""> </a>  </td>
	<?php } else { echo '<td>&nbsp;</td>'; } ?>
	
	<td  valign="middle" align="left"><?php echo $image->note; ?></td>
	
	</tr>
	
	<?php } ?>	
	
</table>
	
</body>
</html>