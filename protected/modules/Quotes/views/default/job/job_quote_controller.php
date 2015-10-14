<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
.table_main {
	border:none;
}
.table_main td, .table_main th {
	border:none;
}
.table_main label  {
	text-align:right; width:50%; float:left;
}
.table_main span  {
	text-align:left; width:50%; float:right;
}
.table_main .left_head{ font-family:sans-serif; font-size:18px;}
table {	
	font-family:sans-serif;
	font-size:12px;
	border-collapse:collapse;
	border:#220303 solid 0.5px; color:#220303;
}
table a{ color:#220303;}
table td {
	font-family:sans-serif;
	color:#3C3B3B;
	font-size:12px;
	padding:4px;
	border-collapse:collapse;
	border:#220303 solid 0.5px;
}
table th {
	font-family:sans-serif;
	font-size:14px;
	padding:4px;
	border-collapse:collapse;
	border:#220303 solid 0.5px;
}

strong {
	color:#323332;
}
</style>
</head>

<body>
<table bgcolor="ffffff" width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="table_main">
  <tr>
    <td align="left" valign="top" class="left_head" width="33%">

<?php 
$left_top_title = ''; 
if(!empty($this->agent_info->business_name))
$left_top_title .= $this->agent_info->business_name.'<br/>';

if(!empty($this->agent_info->abn))
$left_top_title .= 'ABN: '.$this->agent_info->abn;


?>
<strong><?php echo $left_top_title ; ?>
</strong>
</td>
    <td style="border:none; padding:0; background:#ffffff" bgcolor="ffffff" align="center" valign="bottom">

<?php $path = Yii::app()->basePath.'/../uploads/service-agent-logos/thumbs/'; ?>	
<?php if(isset($this->agent_info->logo) && $this->agent_info->logo !=NULL && file_exists($path.$this->agent_info->logo))	 { ?>
<?php $logo_src = Yii::app()->getBaseUrl(true).'/uploads/service-agent-logos/thumbs/'.$this->agent_info->logo; ?>
<img style="border:none; outline:none; width:100px;  background:#ffffff;"  src="<?php echo $logo_src; ?>" title="<?php echo $this->agent_info->business_name; ?>" alt=""> 
<?php } ?>

<!--<img style="border:none; outline:none; height:105px; width:105px;  background:#ffffff;" src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/pdf_logo_high.png" />-->

<br />
      <h4 style="font-weight:normal;color:#3C3B3B" class="left_head"><em>Just Clean It</em></h4></td>
    <td align="right" valign="top" class="left_head" width="33%"><strong>QUOTATION</strong></td>
  </tr>
  <tr>
    <td colspan="3" height="20">&nbsp;</td>
  </tr>
  <tr>


<?php 


$complete_address_text = '';

if(!empty($this->agent_info->business_name)){
$complete_address_text .=  $this->agent_info->business_name.'<br/>';
}




			$concat_business_address = '';
			
			if(!empty($this->agent_info->street))
			$concat_business_address .= $this->agent_info->street.'<br/>';
			
			if(!empty($this->agent_info->city))
			$concat_business_address .= $this->agent_info->city;			
			
			if(!empty($this->agent_info->state_province))
			$concat_business_address .= ', '.$this->agent_info->state_province;
			
			if(!empty($this->agent_info->zip_code))
			$concat_business_address .= ' '.$this->agent_info->zip_code;
			

if(!empty($concat_business_address)){
$complete_address_text .=  'A: '.$concat_business_address.'<br/>';
}


if(!empty($this->agent_info->phone)){
$complete_address_text .=  'P: '.$this->agent_info->phone;
}

if(!empty($this->agent_info->fax)){
$complete_address_text .=  ' F: '.$this->agent_info->fax;
}


if(!empty($this->agent_info->business_email_address)){
$complete_address_text .=  '<br/>E: <a href="mailto:'.$this->agent_info->business_email_address.'" target="_blank" style="color:#000000;text-decoration:none;">'.$this->agent_info->business_email_address.'</a>';
}



?>

<td align="left" valign="top">
<?php echo $complete_address_text; ?>
<!--High Clean Pty Ltd<br>
1/ 92 Railway Street South<br>
Altona, VIC<br>
P: 03 8398 0804 F: 03 8398 0899<br>
E: <a href="mailto:mikhil.kotak@highclean.com.au" target="_blank" style="color:#000000;text-decoration:none;">mikhil.kotak@highclean.com.au</a>-->
</td>
    
<td align="right" valign="top" colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_main">
  <tr>
    <td align="right">Quote No:</td>
    <td><?php echo $job_model->quote_id; ?></td>
  </tr>
  <tr>
    <td align="right">Date:</td>
    <td><?php if($job_model->job_started_date != '0000-00-00' )  { 
	echo date("d-m-Y", strtotime($job_model->job_started_date)); 
	} else { 
	echo date("d-m-Y", strtotime($quote_model->quote_date)); 
	}
	?></td>
  </tr>
  <tr>
    <td align="right">QUOTATION VALID FOR:</td>
    <td>30 Days from Above Date</td>
  </tr>
  
</table>
</td>
  </tr>

<tr> <td colspan="3" height="20"></td></tr>

  <tr>
  
	  <td colspan="3"  align="left" valign="top">
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_main">
	<tr>
	<td align="left" valign="top">To :</td>
	<td style="width:20%">&nbsp;</td>
	<td align="left" valign="top"> 
<?php 

$contact_full_text = 'Attention: '; 

if(!empty($contact_model->first_name))
$contact_full_text .= $contact_model->first_name;

if(!empty($contact_model->surname))
$contact_full_text .= ' '.$contact_model->surname;

if(!empty($company_model->name))
$contact_full_text .= '<br/>'.$company_model->name.'<br/>';

if(!empty($contact_model->address))
$contact_full_text .= $contact_model->address;

if(!empty($contact_model->suburb))
$contact_full_text .= ', '.$contact_model->suburb;

if(!empty($contact_model->state))
$contact_full_text .= ', '.$contact_model->state;

if(!empty($contact_model->postcode))
$contact_full_text .= ' '.$contact_model->postcode;


if(!empty($contact_model->email))
$contact_full_text .= '<br/>E: <a href="mailto:'.$contact_model->email.'" target="_blank"  style="color:#000000;text-decoration:none;">'.$contact_model->email.'</a>';

if(!empty($contact_model->mobile))
$contact_full_text .= '<br/>M: '.$contact_model->mobile;

echo $contact_full_text;

?> 
<!--Attention: <?php echo $contact_model->first_name.' '.$contact_model->surname ; ?><br>
      <?php echo $company_model->name; ?><br>
      <?php echo $contact_model->address.','.$contact_model->suburb.','.$contact_model->state.' '.$contact_model->postcode; ?><br>
      E: <a href="mailto:<?php echo $contact_model->email; ?>" target="_blank"  style="color:#000000;text-decoration:none;"><?php echo $contact_model->email; ?></a><br>
      M: <?php echo $contact_model->mobile; ?>  -->
	
</td>

	<td>&nbsp;</td>
	
	
	</tr>
	</table>
	
	</td>
	
	  </td>
	  
	</tr>
  
  
   <tr> <td colspan="3" height="20"></td></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle" bgcolor="#DDDDDD"><strong>JOB LOCATION</strong></td>
  </tr>
  <tr>
    <td align="center" valign="middle">
<?php
$site_full_text ='';
if(!empty($site_model->site_name))
$site_full_text .= $site_model->site_name.' - ';

if(!empty($site_model->address))
$site_full_text .= $site_model->address;

if(!empty($site_model->suburb))
$site_full_text .= ', '.$site_model->suburb;

if(!empty($site_model->state))
$site_full_text .= ', '.$site_model->state;

if(!empty($site_model->postcode))
$site_full_text .= ' '.$site_model->postcode;

echo $site_full_text;
?>

 </td>
  </tr>
  
</table>
<br />
<br />

<?php $sub_total = 0 ; ?>
<table style="border:none;" width="100%" border="0" cellspacing="1" bgcolor="#ccc" cellpadding="0">
  <tr>
    <td  width="10%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>QUANTITY</strong></td>
    <td  width="64%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>DESCRIPTION</strong></td>
    <td  width="13%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>UNIT PRICE</strong></td>
    <td  width="13%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>AMOUNT</strong></td>
  </tr>
  
  <?php  foreach($job_services_model as $job_service_row) { ?>
  
  <tr>
    <td bgcolor="#ffffff"><strong><?php echo $job_service_row->quantity ; ?></strong></td>
    <td bgcolor="#ffffff"><strong><?php echo $job_service_row->service_description ; ?></strong></td>
    <td bgcolor="#ffffff"><strong><?php echo '$'.$job_service_row->unit_price_rate ; ?></strong></td>
    <td bgcolor="#ffffff"><strong><?php echo '$'.$job_service_row->total ; ?></strong></td>
	<?php $sub_total = $sub_total + $job_service_row->total; ?>
  </tr>
    
	<?php if(! empty($job_service_row->notes) && $job_service_row->notes != null) { ?>
  <tr>
    <td bgcolor="#ffffff">&nbsp;</td>
    <td bgcolor="#ffffff"><!--Note:--><?php echo $job_service_row->notes ; ?></td>
    <td bgcolor="#ffffff">&nbsp;</td>
    <td bgcolor="#ffffff">&nbsp;</td>
  </tr>
  <?php } ?>
  
  <?php } ?>
  
  	

  <tr>
    <td bgcolor="#ffffff">&nbsp;</td>
    <td bgcolor="#ffffff"><strong>Special Notes:</td>
    <td bgcolor="#ffffff">&nbsp;</td>
    <td bgcolor="#ffffff">&nbsp;</td>
  </tr>  
  
  
  <tr>
    <td bgcolor="#ffffff">&nbsp;</td>
    <td bgcolor="#ffffff" height="50" valign="top" align="left"><?php echo $job_model->si_client ; ?></td>
    <td bgcolor="#ffffff">&nbsp;</td>
    <td bgcolor="#ffffff">&nbsp;</td>
  </tr>
 
  
   

			  
			  <tr style="margin-left:-1px;">
				<td bgcolor="#ffffff" style="border:none;" colspan="3" align="right">Subtotal</td>
				<td bgcolor="#ffffff"><strong><?php echo '$'.number_format((float)$sub_total, 2, '.', ''); ?></strong></td>
			  </tr>
			 
			  
			  <?php if($job_model->discount > 0 ) { ?>
			  <tr>
				<td bgcolor="#ffffff" style="border:none;" colspan="3" align="right">Discount</td>
				<td bgcolor="#ffffff"><strong><?php echo $job_model->discount.'%'; ?></strong></td>
			  </tr>
			  <?php } ?>
			  
			  <?php $including_gst = $job_model->final_total * (10/100); ?>
			  
			  <tr>
				<td bgcolor="#ffffff" style="border:none;" colspan="3" align="right">G.S.T</td>
				<td bgcolor="#ffffff"><strong><?php echo '$'.number_format((float)$including_gst, 2, '.', ''); ?></strong></td>
			  </tr>
			  
			  <tr>
<td bgcolor="#ffffff" style="border:none;" align="left" valign="bottom" colspan="2">
Quote Prepared By: 
<strong>
<big>
<?php echo ucfirst($this->agent_info->agent_first_name).' '.ucfirst($this->agent_info->agent_last_name); ?>
</big>
</strong>
</td>
				<td bgcolor="#ffffff" style="border:none;" align="right">Total</td>
				<?php $quote_total = $job_model->final_total + $including_gst; ?>
				<td bgcolor="#ffffff"><strong><?php echo '$'.number_format((float)$quote_total, 2, '.', ''); ?></strong></td>
			  </tr>
			  
			  
  
  
  
  
</table>


<div class="clear"></div>



</body>
</html>
