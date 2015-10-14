
<style type="text/css">
body{font-size:13px;}
.wrapper{width:1000px; margin:0 auto;}
.left{float:left;}
.right{float:right;}
.header{}
.header tr td{width:30%;}
.address{ padding-left: 8px; }
.title{font-size:24px; font-style:italic; font-weight:bold; text-align:center; padding-top:6%;}
.middle_first table{width:100%;}
.middle_first td{border:px solid #000;}
.red{color:#ff0000;}
.middle_two{border:1px solid #000; padding:5px 8px 0; margin:15px 0;}
.table_box{border:1px solid #000; padding:5px 8px 0; margin-top:10px;}
.table_wrepp{max-width:6470px; padding:0 15px; width:63%; line-height:23px;}
.table_wrepp td{padding-left:8px; border:1px solid #ccc;}
.table_p{max-width:350px; padding:5px 5px 1px; line-height:27px; width:33%; border:1px solid #000; border-left:none;}
.risk{font-size:14px; margin-bottom:10px; line-height:14px;}
.note{padding:10px 0; font-size:12px;}

.basic{ display: inline-block;
    font-family: Verdana;
    font-size: 14px;
    transform: rotate(-90deg);
    transform-origin: -13px -119% 0;
    white-space: nowrap;}
.item_table{width:100%; position:relative;}

.bkcolr_r{background:#ff0000; color:#fff;}
.bkcolr_y{background:#ffff00;}
.bkcolr_s{background:#00ffff;}
.middle_three tr td {height:70px; vertical-align:top; padding:0 8px;}
.middle_three table tr td:nth-child(2n+4){text-align:center;}
.block1 {
    left: -9px;
    position: absolute;
    right: -16px;
    top: 510px;
 }
.block2 {
    left: -9px;
   
 }
.basic1{ display:inline-block;
    font-family:Verdana;
    font-size:14px;
    transform:rotate(-90deg);
    transform-origin:35px 147% 0;
    white-space: nowrap;
	
	}
.footer table{margin:15px 0;} 
.footer table tr td{padding-left:8px; height:35px; vertical-align:top;} 
.pageheader{border-bottom:none;}
.header table td{border:none;}
.logo_swms{padding-top:3%;}
.table_box .table_wrepp{border:1px solid #000;} 
.table_p{
    width: 35%;
}
</style>


 <?php 

	$risk_initails_options = array();

	$criteria = new CDbCriteria();
	$criteria->select = "id,name";
	$criteria->order = 'name';
	$loop_risk_initails_types = RiskLevel::model()->findAll($criteria);				
	foreach ($loop_risk_initails_types as $value)  {			
		 $risk_initails_options[$value->id] =  $value->name; 
	 }


?>					


<div class="pageheader">
    <div class="media">
      <div class="media-body">
          	<a href="<?php echo $this->user_role_base_url.'/?r=Quotes/Job/view&id='.$job_model->id; ?>" class="btn btn-primary pull-right">Back To Job Details</a>
	<h4>SWMS Sign Sheet</h4>
      </div>
    </div>
</div>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
    

<?php if(Yii::app()->user->hasFlash('danger')):?>
    <div class="alert alert-danger">
        <?php echo Yii::app()->user->getFlash('danger'); ?>
    </div>
<?php endif; ?>


<?php if(Yii::app()->user->hasFlash('warning')):?>
    <div class="alert alert-warning">
        <?php echo Yii::app()->user->getFlash('warning'); ?>
    </div>
<?php endif; ?>
	

<div class="container job_detalis table_wrepp" style="width:100%;">



    	<div class="row header">
        	<div class="col-md-2 col-sm-2 col-xs-12 logo_swms">
            	<a href="http://highclean.com.au/"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/pdf_logo_high.png" /></a>
            </div>    
            <div class="col-md-7 col-sm-7 col-xs-12 title">
            	Safe Work Method Statement
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 address">
           		High Clean Pty Ltd<br>
                ABN: 45631025732<br>
                E: infohighclean.com.au<br>
                W: www.highclean.com.au<br>
                A: 1/92 Railway St South, Altona VIC 3018<br>
                T: 03 8398 0804 F: 03 8398 9899 
            </div>
        </div>
       <div class="middle_first table-responsive">
       		<table border="1" cellpadding="1" cellspacing="0">
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
                            Work Dates: <span  class="red"><?php echo date("d-m-Y", strtotime($job_model->job_started_date)); ?> and <?php echo date("d-m-Y", strtotime($job_model->job_end_date)); ?></span>
                        </td>
                        <td style="padding-bottom:10px;">
                            This SWMS has been developed and approved by: <strong>M Kotak</strong><br />
                            Date SWMS Approved:<strong>1st July 2015</strong><br />
                            <div style="float:left;width: 200px; ">
                            Position:<strong>Director</strong><br/>
                            Director’s Signature: 
                            </div>
                            <div style="margin-left:50px;" >
                            <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/sign.png" align="absmiddle" />
                            </div>
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
      		<div class="left table_wrepp table-responsive">
				<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccc">
                	
                    	<tbody>
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
                        </tbody>
                    
                </table>            	
          </div>
            <div class="left table_p">
            	Risk Assessment Matrix<br />
                Risk is the combination of severity (impact- degree of harm) with event probability (frequency-likelihood).<br />
                The Risk Assessment Matrix is to be used to derive a Risk Indicator (RI) is used to assess the risk of an incident occurring
            </div>
            <br clear="all" />
            <div class="red note">
            	NOTE – Ladders are to be uses as a last resort.  Platform ladders, A Frame Ladders, EWP or Mobile Scaffolds to be used as a priority. 
                Training is the safe use of ladders is required.
            </div>    
        </div>
      </div>
      <div class="middle_three"> 
     	
          
          <div class="item_table table-responsive">
   
                

                        
<?php
        // swms loop content		
		foreach($swms_ids as $swms_id) {
		$swms_model = Swms::Model()->FindByPk($swms_id);
        	$item_count = 1;
		// task/activity
		$Criteria = new CDbCriteria();
		$Criteria->condition = "swms_id = ".$swms_id." && status = '1'";
		$Criteria->order = 'task_sort_order';
		$task_model = SwmsTask::model()->findAll($Criteria); 
               
                if(count($task_model) > 0) {
                
                ?>
                <div class="risk"><strong><?php echo $swms_model->name.' :'; ?></strong></div>
            	<table border="1" cellpadding="1" cellspacing="0">
            	
               <tr>
                  <td bgcolor="#d9d9d9" width="5%"><strong>Item</strong></td>
                  <td bgcolor="#d9d9d9" width="15%"><strong>Job Step</strong><br /> Break the job down into steps</td>
                  <td bgcolor="#d9d9d9" width="15%"><strong>Potential Hazards</strong><br /> Identify the hazards associated with each step. Examine each to find possibilities that could lead 
                  to an accident or adverse environmental impact
                                              </td>
                  <td nowrap="nowrap" bgcolor="#d9d9d9" width="10%"><strong><center>Risk Initial</center></strong></td>
                  <td bgcolor="#d9d9d9" width="30%"><strong>Controls</strong><br />Using the previous two columns as a guide, decide what actions are necessary to eliminate or 
                      minimise the hazards that could lead to an accident, injury or occupational illness or environmental impact
                                              </td>
                  <td bgcolor="#d9d9d9" width="10%" ><strong>Residual Risk</strong></td>
                  <td bgcolor="#d9d9d9" width="15%"><strong>Person Responsible</strong></td>
                </tr> 
                        
                        
                
                <?php
		foreach($task_model as $task_model_object) {
		// find hazards/consequences 
		$Criteria2 = new CDbCriteria();
		$Criteria2->condition = "task_id = ".$task_model_object->id." && status = '1'";
		$Criteria2->order = 'hrd_consq_sort_order';
		$hazards_consequences_model = SwmsHzrdsConsqs::model()->findAll($Criteria2); 

		$hazards_consequences_model_flag = 0;	
		$rowspan = SwmsHzrdsConsqs::Model()->countByAttributes(array(
                        'swms_id'=>$swms_id
                    ));
		
                foreach($hazards_consequences_model as $hazards_consequences_model_object) { ?>
                        <?php
                                $initial_risk_text = $risk_initails_options[$hazards_consequences_model_object->risk];		
                                $residual_risk_text = $risk_initails_options[$hazards_consequences_model_object->residual_risk];							
                        ?>
                        
                        <tr>                            
                        <td align="left"><?php echo $item_count; ?>.</td>
                        <td align="left"><?php echo $task_model_object->task; ?></td>
                        <td align="left">
                        <?php if(! empty($hazards_consequences_model_object->hazards)) { 
                            echo '<strong>Hazard : </strong><br/>'.$hazards_consequences_model_object->hazards.'<br/><br/>';
                         } ?>

                        <?php if(! empty($hazards_consequences_model_object->consequences)) { 
                            echo '<strong>Consequences : </strong><br/>'.$hazards_consequences_model_object->consequences;
                         } ?>
                        </td>
			<td nowrap="nowrap"><?php echo $initial_risk_text; ?></td>
                        <td align="left"><?php echo html_entity_decode($hazards_consequences_model_object->control_measures); ?></td>
                        <td><?php echo $residual_risk_text; ?></td>
                        <td align="left"><?php echo $hazards_consequences_model_object->person_responsible; ?></td>
                        </tr>     
                        
          
					
			<?php $item_count++;	} ?>		  
                        
		<?php } ?>
                        
            </table><br/>
                <?php } } ?>
                        
                        
               
                        
                   
                
        </div>
          
        <br clear="all" />
        </div>


<div class="clear"></div>  			
	
    
        <div class="footer">
       	  <div class="table-responsive">This SWMS has been developed through consultation with our agentmembers and has been read & signed by all agentmembers involved with this activity.
		  <br/>
            <a href="javascript:void(0);" id="toggle_extra_member_div">Add more member</a>
        
		<div id="lock_signature" class="pull right">    
			    <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'job-model-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // See class documentation of CActiveForm for details on this,
                    // you need to use the performAjaxValidation()-method described there.
                    'enableAjaxValidation'=>false,
            )); ?>


			<?php echo $form->hiddenField($job_model,'swms_signature_lock',array('value'=>1)); ?>     
               
			<div class="form-group">
			  <label class="col-sm-3">&nbsp;</label>
			  <div class="col-sm-9">
			  <?php echo CHtml::submitButton('Lock signature process',array('class'=>'btn btn-danger')); ?>
			  </div>
			</div>    
            
       
		<?php $this->endWidget(); ?>
			
        </div>
		
           <div id="add_extra_member_table" style="width:40%;margin-top:20px;">
	
            <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'job-extra-member-tttt-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // See class documentation of CActiveForm for details on this,
                    // you need to use the performAjaxValidation()-method described there.
                    'enableAjaxValidation'=>false,
            )); ?>   
               
        <div class="col-md-12">  
            
        <div class="form-group">
        <?php echo $form->labelEx($extra_member_model,'name',array('class'=>'col-sm-3')); ?>
        <div class="col-sm-9">    
        <?php echo $form->hiddenField($extra_member_model,'job_id',array('value'=>$job_model->id)); ?>     
	<?php echo $form->textField($extra_member_model,'name',array('class'=>'form-control')); ?> 
        <?php echo $form->error($extra_member_model,'name'); ?>
        </div>        
	</div>
               
        <div class="form-group">
          <label class="col-sm-3">&nbsp;</label>
          <div class="col-sm-9">
          <?php echo CHtml::submitButton('Save',array('class'=>'btn btn-primary')); ?>
          </div>
        </div>    
            
       
		<?php $this->endWidget(); ?>
		</div>			
        </div>   <br/>   
        	

			  
			<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#000">
            	
                  <tbody>
                       <tr>
                            <td bgcolor="#FFFFFF" align="center" height="20px">Name</td>
                            <td bgcolor="#FFFFFF" align="center" height="20px">Signature</td>
						   <td bgcolor="#FFFFFF" align="center" height="20px">Action</td>
                       </tr>
                       
                       <?php $i=0; foreach ($signed_users as $user) {  ?>
                       
                       <tr id="member_<?php echo $i; ?>">
                           
                       <td bgcolor="#FFFFFF" width="30%" valign="middle" align="center"><?php echo $user['Name']; ?></td>
                            
						<form action="" method="post">     
								  
						 	  
						   <td bgcolor="#FFFFFF" width="50%" valign="middle" align="center">                               
                           	 <div class="sigPad" style="margin-top:16px;"  id="<?php echo 't'.$i; ?>"  >	 
                                    
                                    <div class="sig sigWrapper">
                                        <div class="typed"></div>
                                        <canvas class="pad" width="290" height="98"></canvas>
                                        <input type="hidden" name="output" class="output">
                                        
                                    </div>
                                    <ul class="sigNav"  >     
                                        <li class="clearButton"><a href="#clear">Clear</a></li>                                        
                                    </ul>
                             </div>
							   
							  <div class="clear"></div>
							   	<input type="hidden" name="user_role_type" value="<?php echo $user['Position']; ?>" />
							    <input type="hidden" name="auto_user_id" value="<?php echo $user['auto_user_id']; ?>" />                                 	
								<input type="text" class="date_on_signed form-control" style="width:65%;margin-bottom:16px;margin-left:9px;" name="date_on_signed" value="<?php   if($user['date_on_signed'] !== '0000-00-00' ) { echo $user['date_on_signed'];  } ?>" />
							
                            </td>
						   
						
							<td bgcolor="#FFFFFF" width="30%" valign="middle" align="center" style="vertical-align:middle;">
								<input type="submit" value="Save Signature" name="save_signature" class="btn btn-primary" /> 
							</td>
								 
							
						   </form>
								 
					   
						   
                       </tr>
                  
                        
                       
                       <?php $i++; } ?>
                 
                  </tbody>

            </table>
              
              
        </div>
      </div>
 </div>     

<?php
Yii::app()->clientScript->registerCssFile($this->base_url_assets . '/js/assets/jquery.signaturepad.css');
Yii::app()->clientScript->registerScriptFile($this->base_url_assets . '/js/jquery.signaturepad.js', CClientScript::POS_END);
?>
 
  

    <script>
       $(document).ready(function() {
         $('.sigPad').signaturePad({drawOnly:true});
       });
   </script>

    
     <?php $i=0; foreach ($signed_users as $user) {  ?>

        <script>
            $(document).ready(function () {
                $('#t<?php echo $i; ?>').signaturePad({displayOnly: true}).regenerate(<?php echo $user['signature']; ?>);
            });
        </script>
        
         
     <?php $i++; } ?>
	 
	 
<script>

$(document).ready(function() {
	
		$( "#toggle_extra_member_div" ).on("click", function( e ) {
			e.preventDefault();
			$( "#add_extra_member_table" ).slideToggle( "slow" );
			return false;
    	});
	
	  $(".date_on_signed").datepicker({
		dateFormat:'yy-mm-dd',
       // minDate: 0,
        maxDate: "+1000D",
        numberOfMonths: 1,
    });
	
});

</script>
	 
