<?php
/* @var $this LicencesTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Licences Types',
);

$this->menu=array(
	array('label'=>'Create LicencesType', 'url'=>array('create')),
	array('label'=>'Manage LicencesType', 'url'=>array('admin')),
);
?>

<h1>Licences Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
