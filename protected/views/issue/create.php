<?php
/* @var $this IssueController */
/* @var $model Issue */

$this->breadcrumbs=array(
	'Issues'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Issues', 'url'=>array('index')),
	array('label'=>'Manage Issues', 'url'=>array('admin')),
);
?>

<h1>Create Issue for project # <?php echo $this->_project->id.' ('.$this->_project->name.')' ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
