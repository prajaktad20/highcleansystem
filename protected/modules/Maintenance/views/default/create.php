<?php
/* @var $this MaintenanceController */
/* @var $model Maintenance */

$this->breadcrumbs=array(
	'Maintenances'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Maintenance', 'url'=>array('index')),
	array('label'=>'Manage Maintenance', 'url'=>array('admin')),
);
?>

<h1>Create Maintenance</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>