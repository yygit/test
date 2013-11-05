<?php
var_dump($model->errors);
$form = $this->beginWidget('CActiveForm',
	array(
		'enableAjaxValidation' => false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)
);
?>
<?php echo $form->fileField($model, 'avatar'); ?>
<?php echo CHtml::submitButton($model->isNewRecord ? 'submit' : 'update'); ?>
<?php $this->endWidget(); ?>


