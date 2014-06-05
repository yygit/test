<?php
/**
 * @var RecentCommentsWidget $this
 * @var Comment $comment
 */
?>

<ul>
    <?php foreach ($this->getData() as $comment): ?>
        <div class="author">
            <?php echo $comment->author->username; ?> added a comment.
        </div>
        <div class="issue">
            <?php echo CHtml::link(CHtml::encode($comment->issue->name), array('issue/view', 'id' => $comment->issue->id)); ?>
        </div>
        <div class="comment">
            <?php echo CHtml::encode(mb_substr($comment->content, 0, 50, 'UTF-8')); ?>
        </div>
        <hr/>
    <?php endforeach; ?>
</ul>
