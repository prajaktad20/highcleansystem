<?php
/* @var $this SwmsHzrdsConsqsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Swms Hzrds Consqs',
);

$this->menu=array(
	array('label'=>'Create SwmsHzrdsConsqs', 'url'=>array('create')),
	array('label'=>'Manage SwmsHzrdsConsqs', 'url'=>array('admin')),
);
?>

<h1>Swms Hzrds Consqs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
