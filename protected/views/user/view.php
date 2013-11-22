<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>View User #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'email',
//		'password',
		'last_login_time',
		'create_time',
//		'create_user_id',
        array(
            'name'=>'create_user_id',
            'value'=>'#'.$model->create_user_id.' ('.CHtml::encode($this->loadModel($model->create_user_id)->username).')',
        ),
		'update_time',
//		'update_user_id',
        array(
            'name'=>'update_user_id',
            'value'=>'#'.$model->update_user_id.' ('.CHtml::encode($this->loadModel($model->update_user_id)->username).')',
        ),
	),
)); ?>
