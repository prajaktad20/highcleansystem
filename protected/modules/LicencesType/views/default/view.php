<?php
/* @var $this LicencesTypeController */
/* @var $model LicencesType */

$this->breadcrumbs=array(
	'Licences Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LicencesType', 'url'=>array('index')),
	array('label'=>'Create LicencesType', 'url'=>array('create')),
	array('label'=>'Update LicencesType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LicencesType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LicencesType', 'url'=>array('admin')),
);
?>

<h1>View LicencesType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
