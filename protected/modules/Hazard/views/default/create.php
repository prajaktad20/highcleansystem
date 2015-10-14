<?php
/* @var $this HazardController */
/* @var $model Hazard */

$this->breadcrumbs=array(
	'Hazards'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Hazard', 'url'=>array('index')),
	array('label'=>'Manage Hazard', 'url'=>array('admin')),
);
?>

<h1>Create Hazard</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>