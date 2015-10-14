<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Job Swms Controller</title>
<style>
body{ font-family:sans-serif;}
.left{float:left;}
.right{float:right;}
.header{}
.header tr td{width:30%;}
.address{padding-left:300px;}
.title{font-size:22px; font-style:italic; font-weight:bold;}
.middle_first table{width:100%;}
.middle_first tr td{border:1px solid #000; padding-left:2px;}
.middle_two tr td{border:1px solid #000;}
.red{color:#ff0000;}
.middle_two{border:1px solid #000; padding:5px 8px 0; margin:15px 0;}
.table_box{border:1px solid #000; padding:5px 8px 0; margin-top:10px;}
.table_wrepp{border:1px solid #000; max-width:6470px; padding:0 15px; width:63%; line-height:23px;}
.table_wrepp table tr td{padding-left:2px; height:30px;}
.table_p{max-width:350px; padding:5px 5px 39px; width:32%; border:1px solid #000; border-left:none;}
.risk{font-size:14px; margin-bottom:10px; line-height:14px;}
.note{padding:5px 0; font-size:12px;}

/*.basic{ display: inline-block;
    font-family: Verdana;
    font-size: 14px;
    transform: rotate(-90deg);
    transform-origin: -13px -119% 0;
    white-space: nowrap;}*/
.item_table{width:100%; position:relative;}

.bkcolr_r{background:#ff0000; color:#fff;}
.bkcolr_y{background:#ffff00;}
.bkcolr_s{background:#00ffff;}
.middle_three tr td {height:70px; vertical-align:top; padding:0 8px;}
.middle_three table tr td:nth-child(2n+4){text-align:center;}
.block1 {
    left: 10px;    
    right: -16px;
    top: 0px;
 }
.footer table{margin:15px 0;} 
.footer table tr td{padding-left:8px; height:35px; vertical-align:top; border:1px solid #000;} 

</style>
</head>

<body>
<?php 
$td_height = '';
if($job_model->swms_signature_lock == '1')
$td_height = 'height="65px"';
?>

<div class="footer">
      <div class="">This SWMS has been developed through consultation with our agentmembers and has been read & signed by all agentmembers involved with this activity</div>
        <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#000">
            <thead>
           
                   <tr>
                       <td bgcolor="#FFFFFF" align="center" valign="middle" <?php echo $td_height; ?> ><strong>Name</strong></td>
                       <td bgcolor="#FFFFFF" align="center" valign="middle" <?php echo $td_height; ?>><strong>Signature</strong></td>
                       <td bgcolor="#FFFFFF" align="center" valign="middle" <?php echo $td_height; ?>><strong>Date</strong></td>
                   </tr>

              
                   <?php $i=0; foreach ($signed_users as $user) {  ?>
                   <tr>
                       <td bgcolor="#FFFFFF" width="30%" <?php echo $td_height; ?> valign="middle" align="center"><?php echo $user['Name']; ?></td>
                       <td bgcolor="#FFFFFF"  width="40%" <?php echo $td_height; ?> valign="middle" align="center">
					   
    <?php if($job_model->swms_signature_lock == '1') { ?>                        
    <?php $png_path_file = Yii::app()->basePath . '/../uploads/temp/user-'.$user['auto_user_id'].'.png'; ?>
	<?php if(file_exists($png_path_file)) { ?>
	<img height="45px" src="<?php echo Yii::app()->getBaseUrl(true).'/uploads/temp/user-'. $user['auto_user_id'].'.png'; ?>" />
	<?php  } ?>
	<?php  } ?>
                            
                            
                        </td>
                        <td bgcolor="#FFFFFF" width="30%" <?php echo $td_height; ?> valign="middle" align="center">
			<?php if($user['date_on_signed'] !== '0000-00-00' ) { echo date("d-m-Y", strtotime($user['date_on_signed'])); } ?>
			</td>
                   </tr>     
                   <?php } ?>
            </thead>
        </table>
    </div>

</body>
</html>