<?php
/* @var $this HazardController */
/* @var $model Hazard */

$this->breadcrumbs=array(
	'Hazards'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Hazard', 'url'=>array('index')),
	array('label'=>'Create Hazard', 'url'=>array('create')),
	array('label'=>'Update Hazard', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Hazard', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Hazard', 'url'=>array('admin')),
);
?>

<h1>View Hazard #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',
		'location',
		'note',
		'photo',
	),
)); ?>
