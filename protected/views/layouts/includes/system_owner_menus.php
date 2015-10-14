<?php $request_url = Yii::app()->urlManager->parseUrl(Yii::app()->request); ?>

<!-- if accessing agent panel else system owner panel -->
<?php  if( isset(Yii::app()->user->agent_id) && !empty(Yii::app()->user->agent_id) && isset($this->agent_info)) { ?>

<!------------------ Calendar ------------------->

<?php 

$Calendar =array();
$Calendar[] = 'Calendar/default/index';
$Calendar[] = 'Maintenance/default/calendar';

?>

<?php if(in_array($request_url,$Calendar )) { ?>
<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=Calendar/default/index" ><i class="fa fa-calendar fa-fw"></i> &nbsp;  <span>Calender</span></a>
	<ul class="children" style="display:block">
        <li <?php if($request_url === 'Calendar/default/index') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Calendar/default/index"><i class="fa fa-calendar fa-fw"></i> &nbsp;Jobs Calender</a></li>
         <li <?php if($request_url === 'Maintenance/default/calendar') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Maintenance/default/calendar"><i class="fa fa-calendar fa-fw"></i> &nbsp;Maintenance Calender</a></li>        
      </ul>
   </li>
<?php } else { ?>

<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=Calendar/default/index" ><i class="fa fa-calendar fa-fw"></i> &nbsp;  <span>Calender</span></a>
      <ul class="children">
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=Calendar/default/index"><i class="fa fa-calendar fa-fw"></i> &nbsp;Jobs Calender</a></li>
         <li><a href="<?php echo $this->user_role_base_url; ?>?r=Maintenance/default/calendar"><i class="fa fa-calendar fa-fw"></i> &nbsp;Maintenance Calender</a></li>        
      </ul>
</li>
<?php } ?>


<!------------------ Quote ------------------->

<?php 

$Quotes =array();
$Quotes[] = 'Quotes/default/admin';
$Quotes[] = 'Company/default/admin';
$Quotes[] = 'Contact/default/admin';
$Quotes[] = 'ContactsSite/default/admin';
$Quotes[] = 'Buildings/default/admin';

?>

<?php if(in_array($request_url,$Quotes )) { ?>
<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin"><i class="fa fa-briefcase fa-fw"></i> &nbsp;  <span>Quotes</span></a>
	<ul class="children" style="display:block">
        <li  <?php if($request_url === 'Quotes/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin"><i class="fa fa-briefcase fa-fw"></i> &nbsp; Quotes</a></li>
        <li  <?php if($request_url === 'Company/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Company/default/admin"><i class="fa fa-briefcase fa-fw"></i> &nbsp; Companies</a></li>
        <li  <?php if($request_url === 'Contact/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Contact/default/admin"><i class="fa fa-briefcase fa-fw"></i> &nbsp; Contacts</a></li>
        <li  <?php if($request_url === 'ContactsSite/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=ContactsSite/default/admin"><i class="fa fa-briefcase fa-fw"></i> &nbsp; Sites</a></li>
        <li  <?php if($request_url === 'Buildings/default/admin') echo 'class="active"'; ?>  ><a href="<?php echo $this->user_role_base_url; ?>?r=Buildings/default/admin"><i class="fa fa-briefcase fa-fw"></i> &nbsp; Buildings</a></li>
      </ul>
    </li> 
<?php } else { ?>

<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin"><i class="fa fa-briefcase fa-fw"></i> &nbsp;  <span>Quotes</span></a>
      <ul class="children">
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin"><i class="fa fa-briefcase fa-fw"></i> &nbsp; Quotes</a></li>
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=Company/default/admin"><i class="fa fa-briefcase fa-fw"></i> &nbsp; Companies</a></li>
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=Contact/default/admin"><i class="fa fa-briefcase fa-fw"></i> &nbsp; Contacts</a></li>
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=ContactsSite/default/admin"><i class="fa fa-briefcase fa-fw"></i> &nbsp; Sites</a></li>
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=Buildings/default/admin"><i class="fa fa-briefcase fa-fw"></i> &nbsp; Buildings</a></li>
      </ul>
    </li> 
<?php } ?>


<!------------------ StaffJobAllocation ------------------->

<?php 

$StaffJobAllocation =array();
$StaffJobAllocation[] = 'StaffJobAllocation/default/index';

?>

<?php if(in_array($request_url,$StaffJobAllocation )) { ?>
<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=StaffJobAllocation/default/index" ><i class="fa fa-lock fa-fw"></i> &nbsp;  <span>Staff Job Allocation</span></a>
	<ul class="children">
        <li <?php if($request_url === 'StaffJobAllocation/default/index') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=StaffJobAllocation/default/index"><i class="fa fa-lock fa-fw"></i> &nbsp;Staff Job Allocation</a></li>
      </ul>
    </li>
<?php } else { ?>
<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=StaffJobAllocation/default/index" ><i class="fa fa-lock fa-fw"></i> &nbsp;  <span>Staff Job Allocation</span></a>
      <ul class="children">
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=StaffJobAllocation/default/index"><i class="fa fa-lock fa-fw"></i> &nbsp;Staff Job Allocation</a></li>
      </ul>
    </li>
<?php } ?>




<!------------------ User ------------------->

<?php 

$User =array();
$User[] = 'User/default/admin';
$User[] = 'HireStaff/default/admin';

?>

<?php if(in_array($request_url,$User )) { ?>

<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=User/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  <span>User Accounts</span></a>
	<ul class="children" style="display:block">
        <li <?php if($request_url === 'User/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=User/default/admin"> <i class="fa fa-user fa-fw"></i> &nbsp; User Accounts</a></li>
<li <?php if($request_url === 'HireStaff/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=HireStaff/default/admin"> <i class="fa fa-user fa-fw"></i> &nbsp; Hire Staff</a></li>
      </ul>
    </li>
<?php } else { ?>
<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=User/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  <span>User Accounts</span></a>
      <ul class="children">
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=User/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp; User Accounts</a></li>
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=HireStaff/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp; Hire Staff</a></li>
      </ul>
    </li>
<?php } ?>




<!------------------ Induction ------------------->

<?php 

$Inductions =array();
$Inductions[] = 'Induction/default/admin';
$Inductions[] = 'Induction/default/create';

?>

<?php if(in_array($request_url,$Inductions )) { ?>

<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=Induction/default/admin" ><i class="fa fa-barcode fa-fw"></i> &nbsp; <span>Induction</span></a>
  <ul class="children" style="display:block">
        <li <?php if($request_url === 'Induction/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Induction/default/admin"><i class="fa fa-barcode fa-fw"></i> &nbsp;User Inductions</a></li>
        <li <?php if($request_url === 'Induction/default/create') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Induction/default/create"><i class="fa fa-barcode fa-fw"></i> &nbsp;Add New Induction</a></li>
      </ul>
    </li>

<?php } else { ?>
  <li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=Induction/default/admin" ><i class="fa fa-barcode fa-fw"></i> &nbsp; <span>Induction</span></a>
      <ul class="children">
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=Induction/default/admin"><i class="fa fa-barcode fa-fw"></i> &nbsp;User Inductions</a></li>
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=Induction/default/create"><i class="fa fa-barcode fa-fw"></i> &nbsp;Add New Induction</a></li>
      </ul>
    </li>

<?php } ?>   


<!------------------ Hazard ------------------->

<?php 

$Hazard =array();
$Hazard[] = 'Hazard/default/admin';
$Hazard[] = 'Incident/default/admin';
$Hazard[] = 'Maintenance/default/admin';

?>

<?php if(in_array($request_url,$Hazard )) { ?>

<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=Hazard/default/admin" ><i class="fa fa-fire fa-fw"></i> &nbsp;  <span>Hazard/Incident</span></a>
	<ul class="children" style="display:block">
<li <?php if($request_url === 'Hazard/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Hazard/default/admin"><i class="fa fa-fire fa-fw"></i> &nbsp; Hazard</a></li>
<li <?php if($request_url === 'Incident/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Incident/default/admin"><i class="fa fa-fire fa-fw"></i> &nbsp; Incident</a></li>
<li <?php if($request_url === 'Maintenance/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Maintenance/default/admin"><i class="fa fa-fire fa-fw"></i> &nbsp; Maintenance</a></li>
</ul>
</li>	
  
<?php } else { ?>
	<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=Hazard/default/admin" ><i class="fa fa-fire fa-fw"></i> &nbsp;  <span>Hazard/Incident</span></a>
      <ul class="children">
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=Hazard/default/admin"><i class="fa fa-fire fa-fw"></i> &nbsp; Hazard</a></li>
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=Incident/default/admin"><i class="fa fa-fire fa-fw"></i> &nbsp; Incident</a></li>
		<li><a href="<?php echo $this->user_role_base_url; ?>?r=Maintenance/default/admin"><i class="fa fa-fire fa-fw"></i> &nbsp; Maintenance</a></li>
      </ul>
    </li>	
  
<?php } ?>




<!------------------ Timesheet ------------------->

<?php 

$Timesheet =array();
$Timesheet[] = 'Timesheet/default/index';
$Timesheet[] = 'TimesheetPayDates/default/admin';

?>

<?php if(in_array($request_url,$Timesheet )) { ?>

<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=Timesheet/default/index" ><i class="fa fa-pencil fa-fw"></i> &nbsp;  <span>Timesheet</span></a>
	<ul class="children" style="display:block">
        <li <?php if($request_url === 'Timesheet/default/index') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Timesheet/default/index"><i class="fa fa-pencil fa-fw"></i> &nbsp; Timesheet</a></li>
	<li <?php if($request_url === 'TimesheetPayDates/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=TimesheetPayDates/default/admin"><i class="fa fa-pencil fa-fw"></i> &nbsp; Pay Dates</a></li>
      </ul>
    </li>	  
<?php } else { ?>
<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=Timesheet/default/index" ><i class="fa fa-pencil fa-fw"></i> &nbsp;  <span>Timesheet</span></a>
      <ul class="children">
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=Timesheet/default/index"><i class="fa fa-pencil fa-fw"></i> &nbsp; Timesheet</a></li>
	<li><a href="<?php echo $this->user_role_base_url; ?>?r=TimesheetPayDates/default/admin"><i class="fa fa-pencil fa-fw"></i> &nbsp; Pay Dates</a></li>
      </ul>
    </li>	

<?php } ?>


    


<!------------------ Report ------------------->

<?php 

$Timesheet =array();
$Timesheet[] = 'Report/default/job_profitability';
?>

<?php if(in_array($request_url,$Timesheet )) { ?>

<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=Report/default/job_profitability"><i class="fa fa-signal fa-fw"></i> &nbsp;  <span>Report</span></a>
	<ul class="children" style="display:block">
	<li <?php if($request_url === 'Report/default/job_profitability') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Report/default/job_profitability"><i class="fa fa-signal fa-fw"></i> &nbsp;  <span>Job profitability</span></a></li>
	</ul>
</li> 	
	  
<?php } else { ?>
<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=Report/default/job_profitability"><i class="fa fa-signal fa-fw"></i> &nbsp;  <span>Report</span></a>
	<ul class="children">
	<li ><a href="<?php echo $this->user_role_base_url; ?>?r=Report/default/job_profitability"><i class="fa fa-signal fa-fw"></i> &nbsp;  <span>Job profitability</span></a></li>
	</ul>
</li> 	

<?php } ?>


  


<?php } else { ?>

<!----------------- System Owner Panel ------------------->
<!------------------ MyPersonalDetails ------------------->
<?php 

$MyPersonalDetails =array();
$MyPersonalDetails[] = 'SystemOwner/personal/MyPersonalDetails';
$MyPersonalDetails[] = 'SystemOwner/personal/ChangeMyPassword';

?>

<?php if(in_array($request_url,$MyPersonalDetails )) { ?>

<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=SystemOwner/personal/MyPersonalDetails" ><i class="fa fa-user fa-fw"></i> &nbsp; <span>My Profile</span></a>
      <ul class="children" style="display:block">	
 <li <?php if($request_url === 'SystemOwner/personal/MyPersonalDetails') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=SystemOwner/personal/MyPersonalDetails"><i class="fa fa-user fa-fw"></i> &nbsp;  Personal details</a></li>
	<li <?php if($request_url === 'SystemOwner/personal/ChangeMyPassword') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=SystemOwner/personal/ChangeMyPassword"><i class="fa fa-user fa-fw"></i> &nbsp;  Change Password</a></li>
      </ul>
</li>
<?php } else { ?>

<li class="parent"><a href="<?php echo $this->user_role_base_url; ?>?r=SystemOwner/personal/MyPersonalDetails" ><i class="fa fa-user fa-fw"></i> &nbsp; <span>My Profile</span></a>
      <ul class="children" >
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=SystemOwner/personal/MyPersonalDetails"><i class="fa fa-user fa-fw"></i> &nbsp;  Personal details</a></li>
	<li><a href="<?php echo $this->user_role_base_url; ?>?r=SystemOwner/personal/ChangeMyPassword"><i class="fa fa-user fa-fw"></i> &nbsp;  Change Password</a></li>
      </ul>
</li>
<?php } ?>


<!------------------ System Owners ------------------->

<?php 

$SystemOwner =array();
$SystemOwner[] = 'SystemOwner/default/admin';

?>

<?php if(in_array($request_url,$SystemOwner )) { ?>
<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=SystemOwner/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  <span>System Owners</span></a>
	<ul class="children" style="display:block">
	<li <?php if($request_url === 'SystemOwner/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=SystemOwner/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  System Owners</a></li>
	</ul>
</li> 
<?php } else { ?>

<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=SystemOwner/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  <span>System Owners</span></a>
	<ul class="children">
	<li ><a href="<?php echo $this->user_role_base_url; ?>?r=SystemOwner/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  System Owners</a></li>
	</ul>
</li> 
<?php } ?>


<!------------------ Agents ------------------->

<?php 

$Agent =array();
$Agent[] = 'Agent/default/admin';

?>


<?php if(in_array($request_url,$Agent )) { ?>
<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=Agent/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  <span>Service Agent</span></a>
	<ul class="children" style="display:block">
	<li <?php if($request_url === 'Agent/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Agent/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  Service Agent</a></li>
	</ul>
</li> 

<?php } else { ?>

<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=Agent/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  <span>Service Agent</span></a>
	<ul class="children">
	<li ><a href="<?php echo $this->user_role_base_url; ?>?r=Agent/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  Service Agent</a></li>
	</ul>
</li> 
<?php } ?>


<!------------------ OperationManager ------------------->

<?php 

$OperationManager =array();
$OperationManager[] = 'OperationManager/default/admin';

?>

<?php if(in_array($request_url,$OperationManager )) { ?>
<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=OperationManager/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  <span>Operation Manager</span></a>
	<ul class="children" style="display:block">
	<li <?php if($request_url === 'OperationManager/default/admin') echo 'class="active"'; ?>><a href="<?php echo $this->user_role_base_url; ?>?r=OperationManager/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  Operation Manager</a></li>
	</ul>
</li> 
<?php } else { ?>
<li class="parent"><a href="<?php echo $this->user_role_base_url; ?>?r=OperationManager/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  <span>Operation Manager</span></a>
	<ul class="children">
	<li ><a href="<?php echo $this->user_role_base_url; ?>?r=OperationManager/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  Operation Manager</a></li>
	</ul>
</li> 
<?php } ?>



<!------------------ StateManager ------------------->

<?php 

$StateManager =array();
$StateManager[] = 'StateManager/default/admin';

?>

<?php if(in_array($request_url,$StateManager )) { ?>
<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=StateManager/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  <span>State Manager</span></a>
	<ul class="children" style="display:block">
	<li <?php if($request_url === 'StateManager/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=StateManager/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  State Manager</a></li>
	</ul>
</li> 
<?php } else { ?>
<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=StateManager/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  <span>State Manager</span></a>
	<ul class="children">
	<li ><a href="<?php echo $this->user_role_base_url; ?>?r=StateManager/default/admin"><i class="fa fa-user fa-fw"></i> &nbsp;  State Manager</a></li>
	</ul>
</li> 
<?php } ?>

<!------------------ SwmsHzrdsConsqs ------------------->

<?php 

$SwmsHzrdsConsqs =array();
$SwmsHzrdsConsqs[] = 'Swms/default/admin';
$SwmsHzrdsConsqs[] = 'SwmsTask/default/admin';
$SwmsHzrdsConsqs[] = 'SwmsHzrdsConsqs/default/admin';
$SwmsHzrdsConsqs[] = 'SwmsHzrdsConsqs/default/create';

?>

<?php if(in_array($request_url,$SwmsHzrdsConsqs )) { ?>

<li class="parent parent-focus">
<a href="<?php echo $this->user_role_base_url; ?>?r=SwmsHzrdsConsqs/default/create" ><i class="fa fa-th fa-fw"></i> &nbsp;  <span>SWMS</span></a>
  <ul class="children" style="display:block">
	<li <?php if($request_url === 'Swms/default/admin') echo 'class="active"'; ?>  ><a href="<?php echo $this->user_role_base_url; ?>?r=Swms/default/admin"><i class="fa fa-th fa-fw"></i> &nbsp;  Types</a></li>
	<li <?php if($request_url === 'SwmsTask/default/admin') echo 'class="active"'; ?>  ><a href="<?php echo $this->user_role_base_url; ?>?r=SwmsTask/default/admin"><i class="fa fa-th fa-fw"></i> &nbsp;Task/Activity</a></li>
	<li <?php if($request_url === 'SwmsHzrdsConsqs/default/admin') echo 'class="active"'; ?>  ><a href="<?php echo $this->user_role_base_url; ?>?r=SwmsHzrdsConsqs/default/admin"><i class="fa fa-th fa-fw"></i> &nbsp;Hazards/Consequences</a></li>
	<li <?php if($request_url === 'SwmsHzrdsConsqs/default/create') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=SwmsHzrdsConsqs/default/create"><i class="fa fa-th fa-fw"></i> &nbsp;Add Hzrds/Consq.</a></li>
  </ul>
</li>

<?php } else { ?>

<li class="parent">
<a href="<?php echo $this->user_role_base_url; ?>?r=SwmsHzrdsConsqs/default/create" ><i class="fa fa-th fa-fw"></i> &nbsp;  <span>SWMS</span></a>
  <ul class="children">
	<li><a href="<?php echo $this->user_role_base_url; ?>?r=Swms/default/admin"><i class="fa fa-th fa-fw"></i> &nbsp;  Types</a></li>
	<li><a href="<?php echo $this->user_role_base_url; ?>?r=SwmsTask/default/admin"><i class="fa fa-th fa-fw"></i> &nbsp;Task/Activity</a></li>
	<li><a href="<?php echo $this->user_role_base_url; ?>?r=SwmsHzrdsConsqs/default/admin"><i class="fa fa-th fa-fw"></i> &nbsp;Hazards/Consequences</a></li>
	<li><a href="<?php echo $this->user_role_base_url; ?>?r=SwmsHzrdsConsqs/default/create"><i class="fa fa-th fa-fw"></i> &nbsp;Add Hzrds/Consq.</a></li>
  </ul>
</li>
<?php } ?>



<!------------------ EmailFormat/SmsFormat ------------------->

<?php 

$Formats =array();
$Formats[] = 'EmailFormat/default/admin';
$Formats[] = 'SmsFormat/default/admin';

?>

<?php if(in_array($request_url,$Formats )) { ?>
<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=EmailFormat/default/admin"><i class="fa fa-tags fa-fw"></i> &nbsp;  <span>Formats</span></a>
	<ul class="children" style="display:block">
	<li <?php if($request_url === 'EmailFormat/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=EmailFormat/default/admin"><i class="fa fa-tags fa-fw"></i> &nbsp;  <span>EmailFormat</span></a></li>
	<li <?php if($request_url === 'SmsFormat/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=SmsFormat/default/admin"><i class="fa fa-tags fa-fw"></i> &nbsp;  <span>SmsFormat</span></a></li>
	</ul>
</li> 
<?php } else { ?>
<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=EmailFormat/default/admin"><i class="fa fa-tags fa-fw"></i> &nbsp;  <span>Formats</span></a>
	<ul class="children">
	<li ><a href="<?php echo $this->user_role_base_url; ?>?r=EmailFormat/default/admin"><i class="fa fa-tags fa-fw"></i> &nbsp;  <span>EmailFormat</span></a></li>
	<li ><a href="<?php echo $this->user_role_base_url; ?>?r=SmsFormat/default/admin"><i class="fa fa-tags fa-fw"></i> &nbsp;  <span>SmsFormat</span></a></li>
	</ul>
</li> 
<?php } ?>




<!------------------ Induction ------------------->

<?php 

$Inductions2 =array();
$Inductions2[] = 'InductionType/default/admin';
$Inductions2[] = 'InductionCompany/default/admin';

?>

<?php if(in_array($request_url,$Inductions2 )) { ?>

<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=Induction/default/admin" ><i class="fa fa-barcode fa-fw"></i> &nbsp; <span>Induction</span></a>
  <ul class="children" style="display:block">
        <li <?php if($request_url === 'InductionType/default/admin') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=InductionType/default/admin"><i class="fa fa-barcode fa-fw"></i> &nbsp;Induction Type</a></li>
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=InductionCompany/default/admin"><i class="fa fa-barcode fa-fw"></i> &nbsp;Induction Company</a></li>
      </ul>
    </li>

<?php } else { ?>
  <li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=Induction/default/admin" ><i class="fa fa-barcode fa-fw"></i> &nbsp; <span>Induction</span></a>
      <ul class="children">
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=InductionType/default/admin"><i class="fa fa-barcode fa-fw"></i> &nbsp;Induction Type</a></li>
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=InductionCompany/default/admin"><i class="fa fa-barcode fa-fw"></i> &nbsp;Induction Company</a></li>
	</ul>
    </li>

<?php } ?>   



<!------------------ Services/Settings ------------------->

<?php 

$ServiceSettings =array();
$ServiceSettings[] = 'Service/default/admin';
$ServiceSettings[] = 'Setting/Setting/admin';

?>

<?php if(in_array($request_url,$ServiceSettings )) { ?>
<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=Service/default/admin"><i class="fa fa-cog fa-fw"></i> &nbsp; <span>Service/Settings</span></a>
	<ul class="children" style="display:block">
	<li <?php if($request_url === 'Service/default/admin') echo 'class="active"'; ?>><a href="<?php echo $this->user_role_base_url; ?>?r=Service/default/admin"><i class="fa fa-cog fa-fw"></i> &nbsp;  <span>Services</span></a></li>
	<li <?php if($request_url === 'Setting/Setting/admin') echo 'class="active"'; ?>><a href="<?php echo $this->user_role_base_url; ?>?r=Setting/Setting/admin"><i class="fa fa-cog fa-fw"></i> &nbsp;  <span>Settings</span></a></li>
	</ul>
</li> 
<?php } else { ?>

<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=Service/default/admin"><i class="fa fa-cog fa-fw"></i> &nbsp; <span>Service/Settings</span></a>
	<ul class="children">
	<li class="services"><a href="<?php echo $this->user_role_base_url; ?>?r=Service/default/admin"><i class="fa fa-cog fa-fw"></i> &nbsp;  <span>Services</span></a></li>
	<li ><a href="<?php echo $this->user_role_base_url; ?>?r=Setting/Setting/admin"><i class="fa fa-cog fa-fw"></i> &nbsp;  <span>Settings</span></a></li>
	</ul>
</li> 
<?php } ?>

<?php } ?>
