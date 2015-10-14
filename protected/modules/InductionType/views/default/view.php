<?php
/* @var $this InductionTypeController */
/* @var $model InductionType */

$this->breadcrumbs=array(
	'Licences Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List InductionType', 'url'=>array('index')),
	array('label'=>'Create InductionType', 'url'=>array('create')),
	array('label'=>'Update InductionType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete InductionType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InductionType', 'url'=>array('admin')),
);
?>

<h1>View InductionType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
