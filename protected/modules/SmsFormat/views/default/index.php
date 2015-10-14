<?php
/* @var $this SmsFormatController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sms Formats',
);

$this->menu=array(
	array('label'=>'Create SmsFormat', 'url'=>array('create')),
	array('label'=>'Manage SmsFormat', 'url'=>array('admin')),
);
?>

<h1>Sms Formats</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
