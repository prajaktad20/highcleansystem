<?php
/* @var $this AgentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Service Agents',
);

$this->menu=array(
	array('label'=>'Create Agent', 'url'=>array('create')),
	array('label'=>'Manage Agent', 'url'=>array('admin')),
);
?>

<h1>Service Agents</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
