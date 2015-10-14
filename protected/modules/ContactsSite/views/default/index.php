<?php
/* @var $this ContactsSiteController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Contacts Sites',
);

$this->menu=array(
	array('label'=>'Create ContactsSite', 'url'=>array('create')),
	array('label'=>'Manage ContactsSite', 'url'=>array('admin')),
);
?>

<h1>Contacts Sites</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
