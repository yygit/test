<?php
/* @var $this IssueController */
/* @var $model Issue */
/* @var $comment Comment */

$this->breadcrumbs = array(
    'Issues' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List Issue', 'url' => array('index')),
    /*array('label'=>'Create Issue', 'url'=>array('create')),*/
    array('label' => 'Update Issue', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Issue', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Issue', 'url' => array('admin')),
);
?>

<h1>View Issue #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name:html',
        'description:html',
//		'project_id',
        array(
            'name' => 'project_id',
            'value' => '#' . $model->project_id . ' (' . CHtml::link(CHtml::encode($model->project->name), array('project/view', 'id' => $model->project_id)) . ')',
            'type' => 'html',
        ),
        array(
            'name' => 'type_id',
            'value' => CHtml::encode($model->getTypeText()),
        ),
        array(
            'name' => 'status_id',
            'value' => CHtml::encode($model->getStatusText()),
        ),
        array(
            'name' => 'owner_id',
            'value' => isset($model->owner) ? CHtml::encode($model->owner->username) : "unknown"
        ),
        array(
            'name' => 'requester_id',
            'value' => isset($model->requester) ? CHtml::encode($model->requester->username) : "unknown"
        ),
        'create_time',
        array(
            'name' => 'create_user_id',
            'value' => isset($model->creator) ? CHtml::encode($model->creator->username) : "unknown"
        ),
        'update_time',
        array(
            'name' => 'update_user_id',
            'value' => isset($model->updator) ? CHtml::encode($model->updator->username) : "unknown"
        ),
    ),
)); ?>


<div id="comments">
    <div id='ajaxcomments'>

        <?php if ($model->commentCount >= 1): ?>
            <br>
            <h3>
                <?php echo ($model->commentCount > 1 ? $model->commentCount . ' comments' : '1 comment') . ' total'; ?>
            </h3>
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $commentDataProvider,
                'itemView' => '/comment/_view',
                'sortableAttributes' => array(
                    'id',
                    'create_time' => 'Created on',
                ),
            ));
            ?>
            <?php
            /*            $this->renderPartial('_comments', array(
                            'comments' => $model->comments(array('limit' => 5, 'order' => 'comments.create_time DESC')),
                        ));
                        */
            ?>
        <?php endif; ?>
    </div>
    <h3>Leave a Comment</h3>

    <?php if (Yii::app()->user->hasFlash('commentSubmitted')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
        </div>
    <?php endif; ?>
    <?php $this->renderPartial('/comment/_form', array(
        'model' => $comment,
        'issueId' => $model->id, // for ajax button
    )); ?>

</div>

<!--<div id='ajaxcomments'></div>-->
