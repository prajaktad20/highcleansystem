<?php

$role_name = '';
$username_role = '';
$button_induction_dues_class = "btn btn-default dropdown-toggle";


$logined_user_role = Yii::app()->user->name;
$logined_user_role_id = Yii::app()->user->id;
$profile_url = "";


switch ($logined_user_role) {

    case 'agent' :
        $role_name .= ' - Administrator';
        $profile_url = $this->user_role_base_url . "?r=Agent/personal/MyPersonalDetails";
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

            $path = Yii::app()->basePath . '/../uploads/service-agent-logos/thumbs/';
            if (isset($this->agent_info->logo) && $this->agent_info->logo != NULL && file_exists($path . $this->agent_info->logo)) {
                $img_src = Yii::app()->getBaseUrl(true) . '/uploads/service-agent-logos/thumbs/' . $this->agent_info->logo;
                $left_header_title = '<img style="margin:top:-5px;" height="40" src="'.$img_src.'" title="'.$this->agent_info->business_name.'"> ';
            } else {
                $left_header_title = '<span style="font-size:16px;">' . $this->agent_info->business_name . '</span>';               
            } 
     
?>
 
<a href="<?php echo $this->user_dashboard_url; ?>" class="logo"><?php echo $left_header_title; ?></a>
            
            <div class="pull-right">
                <a href="" class="menu-collapse">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
        </div>
        <!-- header-left -->


        <div class="header-right">

            <div class="pull-right">
                <div class="btn-group btn-group-option">



                    <button type="button" class="<?php echo $button_induction_dues_class; ?>"  data-toggle="dropdown">
                        <i class="fa fa-user"></i> <?php echo $username_role; ?> <i class="fa fa-caret-down"></i>
                    </button>

                    <ul class="dropdown-menu pull-right" role="menu">		  

                        <li><a href="<?php echo $profile_url; ?>"><i class="glyphicon glyphicon-user"></i>My Business Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $this->user_role_base_url; ?>?r=site/logout"><i class="glyphicon glyphicon-log-out"></i>Sign Out</a></li>
                    </ul>


                </div><!-- btn-group -->
            </div><!-- pull-right -->
        </div><!-- header-right -->
    </div><!-- headerwrapper -->
</header>


