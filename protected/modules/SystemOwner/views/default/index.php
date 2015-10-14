<?php
/* @var $this SystemOwnerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'System Owners',
);

$this->menu=array(
	array('label'=>'Create SystemOwner', 'url'=>array('create')),
	array('label'=>'Manage SystemOwner', 'url'=>array('admin')),
);
?>

<h1>System Owners</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
