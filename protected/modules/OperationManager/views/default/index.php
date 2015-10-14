<?php
/* @var $this OperationManagerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Operation Managers',
);

$this->menu=array(
	array('label'=>'Create OperationManager', 'url'=>array('create')),
	array('label'=>'Manage OperationManager', 'url'=>array('admin')),
);
?>

<h1>Operation Managers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
