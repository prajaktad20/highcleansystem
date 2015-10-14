<div class="clear"></div>

<div class="leftpanel" >
<h5 class="leftpanel-title"><?php echo date("l, F jS, Y", strtotime(date('Y-m-d'))); ?></h5>
  <ul class="nav nav-pills nav-stacked">
  
<?php 

$logined_user_role = Yii::app()->user->name;

switch($logined_user_role) {
	case 'operation_manager' :
	$this->beginContent('//layouts/includes/operation_manager_left_menus'); 
	$this->endContent(); break;

}


?>
  
  </ul>
</div>
<!-- leftpanel --> 


  
