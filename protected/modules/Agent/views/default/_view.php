<?php
/* @var $this AgentController */
/* @var $data Agent */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agent_first_name')); ?>:</b>
	<?php echo CHtml::encode($data->agent_first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agent_last_name')); ?>:</b>
	<?php echo CHtml::encode($data->agent_last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('business_name')); ?>:</b>
	<?php echo CHtml::encode($data->business_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logo')); ?>:</b>
	<?php echo CHtml::encode($data->logo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('business_url_code')); ?>:</b>
	<?php echo CHtml::encode($data->business_url_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('auth_key')); ?>:</b>
	<?php echo CHtml::encode($data->auth_key); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('business_email_address')); ?>:</b>
	<?php echo CHtml::encode($data->business_email_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_address')); ?>:</b>
	<?php echo CHtml::encode($data->ip_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile')); ?>:</b>
	<?php echo CHtml::encode($data->mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_logined')); ?>:</b>
	<?php echo CHtml::encode($data->last_logined); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('street')); ?>:</b>
	<?php echo CHtml::encode($data->street); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state_province')); ?>:</b>
	<?php echo CHtml::encode($data->state_province); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('zip_code')); ?>:</b>
	<?php echo CHtml::encode($data->zip_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_date')); ?>:</b>
	<?php echo CHtml::encode($data->added_date); ?>
	<br />

	*/ ?>

</div>