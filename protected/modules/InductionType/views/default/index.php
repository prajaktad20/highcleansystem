<?php
/* @var $this InductionTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Licences Types',
);

$this->menu=array(
	array('label'=>'Create InductionType', 'url'=>array('create')),
	array('label'=>'Manage InductionType', 'url'=>array('admin')),
);
?>

<h1>Licences Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
