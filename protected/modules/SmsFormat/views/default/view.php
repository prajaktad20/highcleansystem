<?php
/* @var $this SmsFormatController */
/* @var $model SmsFormat */

$this->breadcrumbs=array(
	'Sms Formats'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List SmsFormat', 'url'=>array('index')),
	array('label'=>'Create SmsFormat', 'url'=>array('create')),
	array('label'=>'Update SmsFormat', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SmsFormat', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SmsFormat', 'url'=>array('admin')),
);
?>

<h1>View SmsFormat #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'sms_text',
	),
)); ?>
