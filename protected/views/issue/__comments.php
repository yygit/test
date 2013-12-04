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
/*    $this->renderPartial('_comments', array(
        'comments' => $model->comments(array('limit' => 5, 'order' => 'comments.create_time DESC')),
    ));
    */?>
<?php else: ?>
    <b>no comments</b>
<?php endif; ?>
