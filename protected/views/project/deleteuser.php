<?php
$this->pageTitle = Yii::app()->name . ' - Revoke User From Project';
$this->breadcrumbs = array(
    $model->project->name => array('view', 'id' => $model->project->id),
    'Revoke User',
);
$this->menu = array(
    array('label' => 'Back To Project', 'url' => array('view', 'id' => $model->project->id)),
);
?>

<h1>Revoke User From "<?php echo $model->project->name; ?>"</h1>

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'deleteuser-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
        ),
        'focus' => array($model, 'username'),
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="row">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'model' => $model,
            'attribute' => 'username',
            'source' => $model->createUsernameList(),
            'options' => array(
                'minLength' => '2',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));
        ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <!--<div class="row">
		<?php /*echo $form->labelEx($model,'role'); */?>
		<?php /*echo $form->dropDownList($model,'role', Project::getUserRoleOptions()); */?>
		<?php /*echo $form->error($model,'role'); */?>
	</div>-->


    <div class="row buttons">
        <?php echo CHtml::submitButton('Revoke User'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
