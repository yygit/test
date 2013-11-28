<?php
/* @var $this ProjectController */
/* @var $model Project */

$this->breadcrumbs = array(
    'Projects' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List Project', 'url' => array('index')),
    array('label' => 'Create Project', 'url' => array('create')),
    array('label' => 'Update Project', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Project', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Project', 'url' => array('admin')),
    array('label' => 'Create Issue', 'url' => array('issue/create', 'pid' => $model->id)),
);
if (Yii::app()->user->checkAccess('createUser', array('project' => $model))) {
    $this->menu[] = array('label' => 'Add User To Project', 'url' => array('adduser', 'id' => $model->id));
}
if (Yii::app()->user->checkAccess('deleteUser', array('project' => $model))) {
    $this->menu[] = array('label' => 'Revoke User From Project', 'url' => array('deleteuser', 'id' => $model->id));
}
?>

<h1>View Project #<?php echo $model->id; ?></h1>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name',
        'description',
        'create_time',
//		'create_user_id',
        array(
            'name' => 'create_user_id',
            'value' => isset($model->createUser) ? CHtml::encode($model->createUser->username) : "unknown",
        ),
        'update_time',
//		'update_user_id',
        array(
            'name' => 'update_user_id',
            'value' => isset($model->updateUser) ? CHtml::encode($model->updateUser->username) : "unknown",
        ),
        array(
            'label' => 'Assigned users',
            'value' => Project::printNames($model, 'users', 'username'),
        ),
    ),
)); ?>

<br/>
<h2>Project Issues</h2>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $issueDataProvider,
    'itemView' => '/issue/_view',
    'sortableAttributes' => array(
        'id',
        'name' => 'Name',
    ),
)); ?>
