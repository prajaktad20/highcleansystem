<?php
/* @var $this SwmsTaskController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Swms Tasks',
);

$this->menu=array(
	array('label'=>'Create SwmsTask', 'url'=>array('create')),
	array('label'=>'Manage SwmsTask', 'url'=>array('admin')),
);
?>

<h1>Swms Tasks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
