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
            .middle_first tr td{border:1px solid #000; padding-left:8px;}
            .middle_two tr td{border:1px solid #000;}
            .red{color:#ff0000;}
            .middle_two{border:1px solid #000; padding:5px 8px 0; margin:15px 0;}
            .table_box{border:1px solid #000; padding:5px 8px 0; margin-top:10px;}
            .table_wrepp{border:1px solid #000; max-width:6470px; padding:0 15px; width:63%; line-height:23px;}
            .table_wrepp table tr td{padding-left:8px; height:30px;}
            .table_p{max-width:350px; padding:5px 5px 39px; width:32%; border:1px solid #000; border-left:none;}
            .risk{font-size:14px; margin-bottom:10px; line-height:14px;}
            .note{padding:5px 0; font-size:12px;}
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


        <div class="header">
            <table width="100%">
                <tr>
                    <td>
<!--<img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/pdf_logo_high.png" />-->

<?php $path = Yii::app()->basePath.'/../uploads/service-agent-logos/thumbs/'; ?>	
<?php if(isset($this->agent_info->logo) && $this->agent_info->logo !=NULL && file_exists($path.$this->agent_info->logo)) { ?>
<img src="<?php echo Yii::app()->getBaseUrl(true).'/uploads/service-agent-logos/thumbs/'.$this->agent_info->logo; ?>" title="<?php echo $this->agent_info->business_name; ?>" > 
<?php } ?>

</td>


<?php 


$complete_address_text = '';

if(!empty($this->agent_info->business_name)){
$complete_address_text .=  $this->agent_info->business_name.'<br/>';
}


if(!empty($this->agent_info->abn)){
$complete_address_text .=  'ABN: '.$this->agent_info->abn.'<br/>';
}


if(!empty($this->agent_info->business_email_address)){
$complete_address_text .=  'E: '.$this->agent_info->business_email_address.'<br/>';
}


if(!empty($this->agent_info->website)){
$complete_address_text .=  'W: '.$this->agent_info->website.'<br/>';
}

			$concat_business_address = '';
			
			if(!empty($this->agent_info->street))
			$concat_business_address .= $this->agent_info->street;
			
			if(!empty($this->agent_info->city))
			$concat_business_address .= ', '.$this->agent_info->city;			
			
			if(!empty($this->agent_info->state_province))
			$concat_business_address .= ', '.$this->agent_info->state_province;
			
			if(!empty($this->agent_info->zip_code))
			$concat_business_address .= ', '.$this->agent_info->zip_code;
			

if(!empty($concat_business_address)){
$complete_address_text .=  'A: '.$concat_business_address.'<br/>';
}


if(!empty($this->agent_info->phone)){
$complete_address_text .=  'T: '.$this->agent_info->phone;
}

if(!empty($this->agent_info->fax)){
$complete_address_text .=  ' F: '.$this->agent_info->fax;
}



?>

                    <td align="center" class="title">Safe Work Method Statement</td>
                    <td style="padding-left:80px;">
                        <div class="address"><?php echo $complete_address_text; ?></div>
                                                </td>
                                                </tr>
                                                </table>
                                                </div>

                                                <div class="middle_first">
                                                    <table cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>Work Group -  Names: Working Supervisor =
                                                            <span class="red">  
                                                            <?php echo $working_supervisor; ?>
														   </span>
														   <br/> Staff Names = 	
														   <span class="red">  
                                                            <?php echo $work_group_user_names; ?>
                                                            </span>
															</td>
                                                            <td>Main Task:  <span class="red"> <?php echo $service_model->service_name; ?></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="2" align="left" valign="top">
                                                                Client Name:<span class="red"> <?php echo $company_model->name; ?></span><br /> 
                                                                Site Name:<span class="red"> <?php echo $site_model->site_name; ?></span><br />
                                                                Site Address:<span class="red"> <?php echo $site_model->address . ', ' . $site_model->suburb . ', ' . $site_model->state . ' ' . $site_model->postcode; ?></span><br /> 
                                                                Work Dates:<span  class="red"> <?php echo date("d-m-Y", strtotime($job_model->job_started_date)); ?> and <?php echo date("d-m-Y", strtotime($job_model->job_end_date)); ?></span>
                                                            </td>
                                                            <td style="padding-bottom:10px;">
                                                                This SWMS has been developed and approved by: <strong><?php echo ucfirst($this->agent_info->agent_first_name[0]).' '.ucfirst($this->agent_info->agent_last_name); ?></strong><br />
                                                                Date SWMS Approved: <strong>1st July 2015</strong><br />
                                                                Position: <strong>Director</strong><br />
                                                                Director’s Signature: <br />
<?php $path = Yii::app()->basePath.'/../uploads/service-agent-logos/signature/'; ?>	
	<?php if(isset($this->agent_info->signature_image) && $this->agent_info->signature_image !=NULL && file_exists($path.$this->agent_info->signature_image))	 { ?>
	<img  src="<?php echo Yii::app()->getBaseUrl(true).'/uploads/service-agent-logos/signature/'.$this->agent_info->signature_image; ?>" style="margin-left:150px; margin-top:-20px;" align="absmiddle" > 
<?php }  ?>
	

<!--<img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/sign.png" style="margin-left:150px; margin-top:-20px;" align="absmiddle" />-->
                                                            </td>
                                                        </tr>
                                                       
                                                    </table>
                                                </div>
                                                <div class="middle_two">
                                                    <p>
                                                        Comply with the Victorian and NSW OH&S Act, OH&S Regulations and Relevant Compliance Codes and Work at Heights Requirements.
                                                        Comply with the High Clean Safety Management Plan requirements and Client Site Requirements as outlined when commencing on site at the 
                                                        Project Specific Induction. Where applicable comply with relevant manufacturer’s assembly requirements and recommendations for tasks being undertaken.
                                                    </p>
                                                    <div class="table_box">
                                                        <div class="risk"><strong>Risk Score Calculator</strong></div>
                                                        <div class="left table_wrepp">
                                                            <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccc">
                                                                <thead>

                                                                    <tr>
                                                                        <td bgcolor="#FFFFFF"></td>
                                                                        <td align="center" bgcolor="#FFFFFF">CATASTROPHIC<br />(4)</td>
                                                                        <td align="center" bgcolor="#FFFFFF">CRITICAL<br />(3)</td>
                                                                        <td align="center" bgcolor="#FFFFFF">MARGINAL<br />(2)</td>
                                                                        <td align="center" bgcolor="#FFFFFF">NEGLIGIBLE<br />(1)</td>	
                                                                    </tr>
                                                                    <tr>
                                                                        <td bgcolor="#FFFFFF">FREQUENT (A)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_r">HIGH (4A)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_r">HIGH (3A)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_r">HIGH (2A)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_y">MEDIUM (1A)</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td bgcolor="#FFFFFF">PROBABLE (B)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_r">HIGH (4B)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_r">HIGH (3B)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_y">MEDIUM (2B)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_s">LOW (1B)</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td bgcolor="#FFFFFF">OCCASIONAL (C)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_r">HIGH (4C)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_r">HIGH (3C)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_y">MEDIUM (2C)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_s">LOW (1C)</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td bgcolor="#FFFFFF">REMOTE (D)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_r">HIGH (4D)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_y">MEDIUM (3D)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_s">LOW (2D)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_s">LOW (1D)</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td bgcolor="#FFFFFF">IMPROBABLE (E)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_y">MEDIUM (4E)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_s">LOW (3E)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_s">LOW (2E)</td>
                                                                        <td bgcolor="#FFFFFF" class="bkcolr_s">LOW (1E)</td>
                                                                    </tr>

                                                                </thead>
                                                            </table>            	
                                                        </div>
                                                        <div class="left table_p">
                                                            Risk Assessment Matrix<br />
                                                            Risk is the combination of severity (impact- degree of harm) with event probability (frequency-likelihood).<br /><br />
                                                            The Risk Assessment Matrix is to be used to derive a Risk Indicator (RI) is used to assess the risk of an incident occurring
                                                        </div>
                                                        <br clear="all" />
                                                        <div class="red note">
                                                            NOTE – Ladders are to be uses as a last resort.  Platform ladders, A Frame Ladders, EWP or Mobile Scaffolds to be used as a priority. 
                                                            Training is the safe use of ladders is required.
                                                        </div>    
                                                    </div>
                                                </div>


                                                </body>
                                                </html>
