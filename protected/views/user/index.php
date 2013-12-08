<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Users',
);

$menu = array(
//    array('label' => 'List Project', 'url' => array('index')),
);
$menu[] = Yii::app()->authManager->checkAccessNoBizrule('reader', Yii::app()->user->id) ? array('label' => 'Manage User', 'url' => array('admin')) : null;
$menu[] = Yii::app()->authManager->checkAccessNoBizrule('owner', Yii::app()->user->id) ? array('label' => 'Create User', 'url' => array('create')) : null;
$this->menu = $menu;
?>

<h1>Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'sortableAttributes' => array(
        'id',
        'username',
    ),
)); ?>
