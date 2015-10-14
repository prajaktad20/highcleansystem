<?php $request_url = Yii::app()->urlManager->parseUrl(Yii::app()->request); ?>


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



<!------------------ Agent ------------------->

<?php 

$Agent =array();
$Agent[] = 'Agent/personal/MyPersonalDetails';
$Agent[] = 'Agent/personal/ChangeMyPassword';

?>

<?php if(in_array($request_url,$Agent )) { ?>
<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=Agent/personal/MyPersonalDetails" ><i class="fa fa-user fa-fw"></i> &nbsp; <span>Business Profile</span></a>
	<ul class="children" style="display:block">
<li <?php if($request_url === 'Agent/personal/MyPersonalDetails') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Agent/personal/MyPersonalDetails"><i class="fa fa-user fa-fw"></i> &nbsp; Business Details</a></li>
<li <?php if($request_url === 'Agent/personal/ChangeMyPassword') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=Agent/personal/ChangeMyPassword"><i class="fa fa-user fa-fw"></i> &nbsp; Change Password</a></li>
</ul>
</li>
<?php } else { ?>

<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=Agent/personal/MyPersonalDetails" ><i class="fa fa-user fa-fw"></i> &nbsp; <span>Business Profile</span></a>
<ul class="children">
<li><a href="<?php echo $this->user_role_base_url; ?>?r=Agent/personal/MyPersonalDetails"><i class="fa fa-user fa-fw"></i> &nbsp; Business Details</a></li>
<li><a href="<?php echo $this->user_role_base_url; ?>?r=Agent/personal/ChangeMyPassword"><i class="fa fa-user fa-fw"></i> &nbsp; Change Password</a></li>
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


  




