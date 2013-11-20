<?php
/* @var $this ProjectController */
/* @var $model Project */

$this->breadcrumbs=array(
	'Projects'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Project', 'url'=>array('index')),
	array('label'=>'Manage Project', 'url'=>array('admin')),
);
?>

<h1>Create Project (owned by user # <?php echo $this->_userId; ?>)</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
