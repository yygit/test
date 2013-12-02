<?php
if ($model->commentCount >= 1):
    if (Yii::app()->user->hasFlash('commentSubmitted')) {
?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
        </div>
<?php } ?>
    <h3>
        <?php echo $model->commentCount > 1 ? $model->commentCount . ' comments' : '1 comment'; ?>
    </h3>

    <?php $this->renderPartial('_comments', array(
    'comments' => $model->comments,
)); ?>
<?php else: ?>
    <b>no comments</b>
<?php endif; ?>
