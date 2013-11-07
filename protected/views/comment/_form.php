<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'comment-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->dropDownList($model, 'user_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'user_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'page_id'); ?>
		<?php echo $form->dropDownList($model, 'page_id', GxHtml::listDataEx(Page::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'page_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model, 'comment'); ?>
		<?php echo $form->error($model,'comment'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'date_entered'); ?>
		<?php echo $form->textField($model, 'date_entered'); ?>
		<?php echo $form->error($model,'date_entered'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->