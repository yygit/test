<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('user_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->user)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('page_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->page)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('comment')); ?>:
	<?php echo GxHtml::encode($data->comment); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('date_entered')); ?>:
	<?php echo GxHtml::encode($data->date_entered); ?>
	<br />

</div>