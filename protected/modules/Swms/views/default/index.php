<?php
/* @var $this SwmsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Swms',
);

$this->menu=array(
	array('label'=>'Create Swms', 'url'=>array('create')),
	array('label'=>'Manage Swms', 'url'=>array('admin')),
);
?>

<h1>Swms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
