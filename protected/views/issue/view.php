<?php
/* @var $this IssueController */
/* @var $model Issue */

$this->breadcrumbs=array(
	'Issues'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Issue', 'url'=>array('index')),
	/*array('label'=>'Create Issue', 'url'=>array('create')),*/
	array('label'=>'Update Issue', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Issue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Issue', 'url'=>array('admin')),
);
?>

<h1>View Issue #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
//		'project_id',
        array(
            'name'=>'project_id',
            'value'=>'#'.$model->project_id.' ('.CHtml::link(CHtml::encode($model->project->name), array('project/view', 'id'=>$model->project_id)).')',
            'type'=>'html',
        ),
//		'type_id',
        array(
            'name'=>'type_id',
            'value'=>CHtml::encode($model->getTypeText()),
        ),
//		'status_id',
        array(
            'name'=>'status_id',
            'value'=>CHtml::encode($model->getStatusText()),
        ),
//		'owner_id',
        array(
            'name'=>'owner_id',
            'value'=>isset($model->owner)?CHtml::encode($model->owner->username):"unknown"
        ),
//        'requester_id',
        array(
            'name'=>'requester_id',
            'value'=>isset($model->requester)?CHtml::encode($model->requester->username):"unknown"
        ),
		'create_time',
//		'create_user_id',
        array(
            'name'=>'create_user_id',
            'value'=>isset($model->creator)?CHtml::encode($model->creator->username):"unknown"
        ),
		'update_time',
//		'update_user_id',
        array(
            'name'=>'update_user_id',
            'value'=>isset($model->updator)?CHtml::encode($model->updator->username):"unknown"
        ),
	),
)); ?>
