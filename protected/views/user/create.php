<?php
/* @var $this UserController */
/* @var $model User */
/* @var $flag string */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>Create User</h1>

<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
    'flag'=>$flag,
)); ?>
