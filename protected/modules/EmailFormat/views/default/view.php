<?php
/* @var $this EmailFormatController */
/* @var $model EmailFormat */


?>
<h1>
        <?php echo Yii::t("emailFormat.admin","E-mail Format details"); ?>
        <?php echo CHtml::link(
                Yii::t("emailFormat.admin", "Manage"),
                array("admin"),
                array("class"=>"btn btn-small pull-right")
        ); ?>
        <?php echo CHtml::link(
                Yii::t("emailFormat.admin", "Edit"),
                array("update", "id"=>$model->email_format_ID),
                array("class"=>"btn btn-small pull-right")
        ); ?>
</h1>




<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'email_format_ID',
		'email_format_name',
		'email_format',
	),
)); ?>
