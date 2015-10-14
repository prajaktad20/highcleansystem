<?php

$role_name = '';
$username_role = '';
$button_induction_dues_class = "btn btn-default dropdown-toggle";


$logined_user_role = Yii::app()->user->name;
$logined_user_role_id = Yii::app()->user->id;
$profile_url = "";


switch ($logined_user_role) {

    case 'operation_manager' :
        $role_name .= ' - Operation Manager';
        $profile_url = $this->user_role_base_url . "?r=OperationManager/personal/MyPersonalDetails";
        break;
}


if (isset(Yii::app()->user->first_name)):
    $username_role = Yii::app()->user->first_name . $role_name;
endif;

$base = Yii::app()->baseUrl;

?>


<header>
    <div class="headerwrapper">

        <div class="header-left" >
<?php 
	if( isset(Yii::app()->user->agent_id) &&  !empty(Yii::app()->user->agent_id) && isset($this->agent_info)) {
            $path = Yii::app()->basePath . '/../uploads/service-agent-logos/thumbs/';
            if (isset($this->agent_info->logo) && $this->agent_info->logo != NULL && file_exists($path . $this->agent_info->logo)) {
                $img_src = Yii::app()->getBaseUrl(true) . '/uploads/service-agent-logos/thumbs/' . $this->agent_info->logo;
                $left_header_title = '<img style="margin:top:-5px;" height="40" src="'.$img_src.'" title="'.$this->agent_info->business_name.'"> ';
            } else {
                $left_header_title = '<span style="font-size:16px;">' . $this->agent_info->business_name . '</span>';               
            } 

		$logo_url = $this->user_role_base_url . "?r=AgentDashboard/default/index";
	} else {
                $left_header_title = '<span style="font-size:16px;">Service Managment</span>';               
		$logo_url = $this->user_dashboard_url;
            } 
     
?>


<a href="<?php echo $logo_url; ?>" class="logo">
<span style="font-size:16px;">
<?php echo $left_header_title; ?>
</span>
</a>            
            <div class="pull-right">
                <a href="" class="menu-collapse">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
        </div>
        <!-- header-left -->


        <div class="header-right">

                    
  <?php if(isset(Yii::app()->user->agent_id) &&  !empty(Yii::app()->user->agent_id) && isset($this->agent_info)) { ?>
        <div style="float:left;color: #ffffff">
        <?php echo 'You logged in "<strong>'.$this->agent_info->business_name.'</strong>" account!'; ?>
        <a style="color: #ffffff" href="<?php echo $this->user_role_base_url."?r=SystemOwner/personal/logoutAgentPanel"; ?>">(Sign Out Agent Panel)</a>
    </div>
    <?php } ?>                
            
            <div class="pull-right">
                <div class="btn-group btn-group-option">



                    <button type="button" class="<?php echo $button_induction_dues_class; ?>"  data-toggle="dropdown">
                        <i class="fa fa-user"></i> <?php echo $username_role; ?> <i class="fa fa-caret-down"></i>
                    </button>

                    <ul class="dropdown-menu pull-right" role="menu">		  

<?php if( isset(Yii::app()->user->agent_id) &&  !empty(Yii::app()->user->agent_id) && isset($this->agent_info)) { ?>
<li><a href="<?php echo $this->user_role_base_url."?r=OperationManager/personal/logoutAgentPanel"; ?>"><i class="glyphicon glyphicon-log-out"></i>Sign Out Agent Panel</a></li>
<?php } else { ?>

                        <li><a href="<?php echo $profile_url; ?>"><i class="glyphicon glyphicon-user"></i>My Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $this->user_role_base_url; ?>?r=site/logout"><i class="glyphicon glyphicon-log-out"></i>Sign Out</a></li>
                        <?php } ?>
                    </ul>


                </div><!-- btn-group -->
            </div><!-- pull-right -->
        </div><!-- header-right -->
    </div><!-- headerwrapper -->
</header>


