<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs=array(
	'Pages'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Pages', 'url'=>array('index')),
	array('label'=>'Update Page', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Page', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Page', 'url'=>array('admin')),
);
?>

<h1>add File for Page #<?php echo $model->id; ?></h1>

<?php
var_dump($pagehasfiles->errors);
$form = $this->beginWidget('CActiveForm',
    array(
        'enableAjaxValidation' => false,
    )
);
echo CHtml::dropDownList('files', 'id', CHtml::listData($files, 'id', 'name'), array('size'=>5));
echo CHtml::submitButton();
$this->endWidget();
?>


