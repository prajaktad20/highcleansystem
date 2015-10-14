<?php
/* @var $this CompanyController */
/* @var $data Company */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('office_address')); ?>:</b>
	<?php echo CHtml::encode($data->office_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('office_suburb')); ?>:</b>
	<?php echo CHtml::encode($data->office_suburb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mailing_address')); ?>:</b>
	<?php echo CHtml::encode($data->mailing_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mailing_suburb')); ?>:</b>
	<?php echo CHtml::encode($data->mailing_suburb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('abn')); ?>:</b>
	<?php echo CHtml::encode($data->abn); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile')); ?>:</b>
	<?php echo CHtml::encode($data->mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fax')); ?>:</b>
	<?php echo CHtml::encode($data->fax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('website')); ?>:</b>
	<?php echo CHtml::encode($data->website); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number_of_site')); ?>:</b>
	<?php echo CHtml::encode($data->number_of_site); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('office_state')); ?>:</b>
	<?php echo CHtml::encode($data->office_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('office_postcode')); ?>:</b>
	<?php echo CHtml::encode($data->office_postcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mailing_state')); ?>:</b>
	<?php echo CHtml::encode($data->mailing_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mailing_postcode')); ?>:</b>
	<?php echo CHtml::encode($data->mailing_postcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>