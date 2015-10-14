<?php
/* @var $this InductionCompanyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Licences Types',
);

$this->menu=array(
	array('label'=>'Create InductionCompany', 'url'=>array('create')),
	array('label'=>'Manage InductionCompany', 'url'=>array('admin')),
);
?>

<h1>Licences Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
