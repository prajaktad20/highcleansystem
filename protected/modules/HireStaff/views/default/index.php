<?php
/* @var $this HireStaffController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Hire Staff',
);

$this->menu=array(
	array('label'=>'Create HireStaff', 'url'=>array('create')),
	array('label'=>'Manage HireStaff', 'url'=>array('admin')),
);
?>

<h1>Hire Staff</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
