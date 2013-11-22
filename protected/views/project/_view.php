<?php
/* @var $this ProjectController */
/* @var $data Project */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::encode($data->id); ?>
	<br />

	<!--<b><?php /*echo CHtml::encode($data->getAttributeLabel('description')); */?>:</b>
	<?php /*echo CHtml::encode($data->description); */?>
	<br />-->

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_user_id')); ?>:</b>
	<?php /*echo CHtml::encode($data->create_user_id); */?>
	<?php echo '#'.$data->create_user_id.' ('.CHtml::encode($data->createUser->username).')'; ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_user_id')); ?>:</b>
	<?php /*echo CHtml::encode($data->update_user_id); */?>
    <?php echo '#'.$data->update_user_id.' ('.CHtml::encode($data->updateUser->username).')'; ?>
	<br />

    <b><?php echo 'Assigned users'; ?>:</b>
    <?php echo Project::printNames($data, 'users', 'username'); ?>
	<br />


</div>
