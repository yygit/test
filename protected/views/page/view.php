<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs=array(
	'Pages'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Page', 'url'=>array('index')),
	array('label'=>'Create Page', 'url'=>array('create')),
	array('label'=>'Update Page', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Add a File', 'url'=>array('addfile', 'id'=>$model->id)),
	array('label'=>'Delete Page', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Page', 'url'=>array('admin')),
);

if(Yii::app()->user->hasFlash('e_pageview')) {
    echo '<div class="flash-error">';
    echo Yii::app()->user->getFlash('e_pageview');
    echo '</div>';
}
if(Yii::app()->user->hasFlash('pageview')) {
    echo '<div class="flash-success">';
    echo Yii::app()->user->getFlash('pageview');
    echo '</div>';
}

?>

<h1>View Page #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'live',
		'title',
		'content',
        array(
            'label'=>'files',
            'type'=>'raw',
            'value'=>$this->printNames($model,'files','name'),
        ),
		'date_updated',
		'date_published',
	),
)); ?>
