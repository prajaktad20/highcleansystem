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


<!------------------ User ------------------->

<?php 

$User =array();
$User[] = 'User/personal/MyPersonalDetails';
$User[] = 'User/personal/MyLicencesInductions';
$User[] = 'User/personal/ChangeMyPassword';

?>

<?php if(in_array($request_url,$User )) { ?>

<li class="parent parent-focus"><a href="<?php echo $this->user_role_base_url; ?>?r=User/personal/MyPersonalDetails" ><i class="fa fa-user fa-fw"></i> &nbsp;  <span>My Profile</span></a>
<ul class="children" style="display:block">
        <li <?php if($request_url === 'User/personal/MyPersonalDetails') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=User/personal/MyPersonalDetails"><i class="fa fa-user fa-fw"></i> &nbsp; Personal details</a></li>
        <li <?php if($request_url === 'User/personal/MyLicencesInductions') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=User/personal/MyLicencesInductions"><i class="fa fa-user fa-fw"></i> &nbsp; Licenses/Induction</a></li>
	<li <?php if($request_url === 'User/personal/ChangeMyPassword') echo 'class="active"'; ?> ><a href="<?php echo $this->user_role_base_url; ?>?r=User/personal/ChangeMyPassword"><i class="fa fa-user fa-fw"></i> &nbsp; Change Password</a></li>
      </ul>
   </li>

<?php } else { ?>

<li class="parent "><a href="<?php echo $this->user_role_base_url; ?>?r=User/personal/MyPersonalDetails" ><i class="fa fa-user fa-fw"></i> &nbsp;  <span>My Profile</span></a>
      <ul class="children">
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=User/personal/MyPersonalDetails"><i class="fa fa-user fa-fw"></i> &nbsp; Personal details</a></li>
        <li><a href="<?php echo $this->user_role_base_url; ?>?r=User/personal/MyLicencesInductions"><i class="fa fa-user fa-fw"></i> &nbsp; Licenses/Induction</a></li>
	<li><a href="<?php echo $this->user_role_base_url; ?>?r=User/personal/ChangeMyPassword"><i class="fa fa-user fa-fw"></i> &nbsp; Change Password</a></li>
      </ul>
   </li>
<?php } ?>


