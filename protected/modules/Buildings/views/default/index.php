<?php
/* @var $this BuildingsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Buildings',
);

$this->menu=array(
	array('label'=>'Create Buildings', 'url'=>array('create')),
	array('label'=>'Manage Buildings', 'url'=>array('admin')),
);
?>

<h1>Buildings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
