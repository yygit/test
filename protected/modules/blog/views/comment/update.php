<?php
$this->breadcrumbs=array(
	'Comments'=>array('index'),
	'Update BlogComment #'.$model->id,
);
?>

<h1>Update Comment #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
