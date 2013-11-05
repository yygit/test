<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Users',
);

$this->menu = array(
    array('label' => 'Create User', 'url' => array('create')),
    array('label' => 'Manage User', 'url' => array('admin')),
);
?>

<h1>Users</h1>
<h2>
<?php
if (isset(Yii::app()->user->name)) {echo 'Your USERNAME is "'.Yii::app()->user->name.'"';}
echo '<br>';
if (isset(Yii::app()->user->id)) {echo 'Your ID is "'.Yii::app()->user->id.'"';}
echo '<br>';
if (isset(Yii::app()->user->email)) {echo 'Your EMAIL is "'.Yii::app()->user->email.'"';}


?>
</h2>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>
