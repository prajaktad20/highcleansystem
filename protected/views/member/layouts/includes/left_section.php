<div class="leftpanel">
<h5 class="leftpanel-title"><?php echo date("l, F jS, Y", strtotime(date('Y-m-d'))); ?></h5>
  <ul class="nav nav-pills nav-stacked">
  
<?php 

$logined_user_role = Yii::app()->user->name;

switch($logined_user_role) {

	case 'supervisor' :
	$this->beginContent('//layouts/includes/supervisor_left_menus'); 
	$this->endContent(); break;

	case 'site_supervisor' :
	$this->beginContent('//layouts/includes/site_supervisor_left_menus'); 
	$this->endContent(); break;

	case 'staff' :
	$this->beginContent('//layouts/includes/staff_left_menus'); 
	$this->endContent(); break;

}


?>
  
  </ul>
</div>
<!-- leftpanel --> 


  
