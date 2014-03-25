<?php
/**
 * @var Task $model
 * @var int $index
 * @var string $id
 */

//var_dump($model->getErrors());

?>

<li id="tasks_li">
    <div class="row">
        <?php echo CHtml::activeLabel($model, "[$index]title") ?>
        <?php echo CHtml::activeTextField($model, "[$index]title") ?>
        <?php echo CHtml::error($model, "[$index]title") ?>
    </div>
    <div class="row">
        <?php echo CHtml::activeLabel($model, "[$index]text") ?>
        <?php echo CHtml::activeTextArea($model, "[$index]text") ?>
        <?php echo CHtml::error($model, "[$index]text") ?>
    </div>
    <?php if (isset($index) && $index > 0): ?>
        <div class="row">
            <?php echo CHtml::button('Delete this task', array('class' => 'tasks-delete')) ?>
        </div>
    <?php endif; ?>
</li>

<script>
    $(".tasks-delete").click(function () {
        $(this).parents('#tasks_li').remove();
    });
</script>
