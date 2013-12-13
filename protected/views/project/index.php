<?php
/* @var $this ProjectController */
/* @var $dataProvider CActiveDataProvider */
/* @var $sysMessage string message attribute of SysMessage AR model */

$this->breadcrumbs = array(
    'Projects',
);

$menu = array(
//    array('label' => 'Manage Project', 'url' => array('admin')),
);
$menu[] = Yii::app()->authManager->checkAccessNoBizrule('reader') ? array('label' => 'Manage Project', 'url' => array('admin')) : null;
$menu[] = Yii::app()->authManager->checkAccessNoBizrule('owner') ? array('label' => 'Create Project', 'url' => array('create')) : null;
$this->menu = $menu;
?>

<?php if($sysMessage != null):?>
    <div class="sys-message">
        <?php echo $sysMessage; ?>
    </div>
    <?php
    Yii::app()->clientScript->registerScript(
        'fadeAndHideEffect',
        '$(".sys-message").animate({opacity: 1.0}, 5000).fadeOut("slow");'
    );
endif; ?>

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
