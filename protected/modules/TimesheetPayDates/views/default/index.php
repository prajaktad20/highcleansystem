<?php
/* @var $this TimesheetPayDatesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Timesheet Pay Dates',
);

$this->menu=array(
	array('label'=>'Create TimesheetPayDates', 'url'=>array('create')),
	array('label'=>'Manage TimesheetPayDates', 'url'=>array('admin')),
);
?>

<h1>Timesheet Pay Dates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
