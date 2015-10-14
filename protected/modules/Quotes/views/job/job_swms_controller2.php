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
td {
    font-size: 12px;
}
</style>
</head>

<body>
	
<div class="middle_three"> 
<div class="item_table">
    <div class="risk"><strong><?php echo $swms_model->name.' :'; ?></strong></div>
    <table border="1" cellpadding="1" cellspacing="0">
            <thead>
               
                    <tr>
                        <td bgcolor="#d9d9d9"><strong>Item</strong></td>
                        <td bgcolor="#d9d9d9"><strong>Job Step</strong><br /> Break the job down into steps</td>
                        <td bgcolor="#d9d9d9"><strong>Potential Hazards</strong><br /> Identify the hazards associated with each step. Examine each to find possibilities that could lead 
                        to an accident or adverse environmental impact
                        </td>
                        <td nowrap="nowrap" bgcolor="#d9d9d9"><strong><center>Risk Initial</center></strong></td>
                        <td bgcolor="#d9d9d9"><strong>Controls</strong><br />Using the previous two columns as a guide, decide what actions are necessary to eliminate or 
                            minimise the hazards that could lead to an accident, injury or occupational illness or environmental impact
                        </td>
                        <td bgcolor="#d9d9d9"><strong>Residual Risk</strong></td>
                        <td bgcolor="#d9d9d9"><strong>Person Responsible</strong></td>
                    </tr>
       

<?php  foreach($page_result as $hazards_consequences_model_object) { ?>			

                <tr>
                <td align="left"><?php echo $hazards_consequences_model_object['item_count']; ?>.</td>
                <td align="left"><?php echo $hazards_consequences_model_object['item_task']; ?></td>
                <td align="left"><?php echo $hazards_consequences_model_object['hazards_consqs']; ?></td>
                <td nowrap="nowrap"><?php echo $hazards_consequences_model_object['initial_risk_text']; ?></td>
                <td align="left"><?php echo $hazards_consequences_model_object['control_measures']; ?></td>
                <td><?php echo $hazards_consequences_model_object['residual_risk_text']; ?></td>
                <td align="left"><?php echo $hazards_consequences_model_object['person_responsible']; ?></td>
                </tr>

<?php	} ?>	   
					
		</thead>
        </table>
</div>
<br clear="all" />
</div>
	
	
</body>
</html>
