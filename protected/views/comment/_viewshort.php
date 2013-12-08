<?php
/* @var $this IssueController */
/* @var $data Comment */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('comment/view', 'id'=>$data->id)); ?>
	by 	<b><?php echo CHtml::encode($data->author->username); ?></b>
    on 	<?php echo CHtml::encode($data->create_time); ?>
    <i><?php echo CHtml::encode($data->content); ?></i>
    <br />

</div>
