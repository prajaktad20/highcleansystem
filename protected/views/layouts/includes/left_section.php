<div class="leftpanel" style="margin-top:8px;">
<h5 class="leftpanel-title"><?php echo date("l, F jS, Y", strtotime(date('Y-m-d'))); ?></h5>
  <ul class="nav nav-pills nav-stacked">
  
<?php 

$logined_user_role = Yii::app()->user->name;



switch($logined_user_role) {
	case 'system_owner' :
	$this->beginContent('//layouts/includes/system_owner_menus'); 
	$this->endContent(); break;

}


?>
  
  </ul>
</div>
<!-- leftpanel --> 


  
