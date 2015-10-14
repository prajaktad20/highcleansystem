<?php
/* @var $this StateManagerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'State Managers',
);

$this->menu=array(
	array('label'=>'Create StateManager', 'url'=>array('create')),
	array('label'=>'Manage StateManager', 'url'=>array('admin')),
);
?>

<h1>State Managers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
