<?php
/* @var $this ProjectController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Projects',
);

$menu = array(
//    array('label' => 'Manage Project', 'url' => array('admin')),
);
$menu[] = Yii::app()->authManager->checkAccessNoBizrule('reader', Yii::app()->user->id) ? array('label' => 'Manage Project', 'url' => array('admin')) : null;
$menu[] = Yii::app()->authManager->checkAccessNoBizrule('owner', Yii::app()->user->id) ? array('label' => 'Create Project', 'url' => array('create')) : null;
$this->menu = $menu;
?>

<h1>Projects</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>

<?php // comments
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => 'Recent Comments',
));
$this->widget('RecentCommentsWidget', array(
    'displayLimit' => 5,
));
$this->endWidget();
?>
