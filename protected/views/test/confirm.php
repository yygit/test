<?php
/* @var $this TestController */
/* @var $model Confirm */
/* @var $form CActiveForm */
/* @var $confirmed bool */
/* @var $confirmedMessage string */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'confirm-confirm-form',
        'enableAjaxValidation' => TRUE,
        'enableClientValidation' => FALSE,
        'clientOptions' => array(
            'validateOnSubmit' => TRUE,
        ),
    )); ?>


    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'url'); ?>
        <?php echo $form->textField($model, 'url'); ?>
        <?php echo $form->error($model, 'url'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'code'); ?>
        <?php echo $form->textField($model, 'code'); ?>
        <?php echo $form->error($model, 'code'); ?>
    </div>

    <div class="row" style="display:none;">
        <?php echo $form->labelEx($model, 'isconfirmed'); ?>
        <?php echo $form->textField($model, 'isconfirmed'); ?>
        <?php echo $form->error($model, 'isconfirmed'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

    <?php $this->endWidget();

    if ($confirmed) {
        echo $confirmedMessage;
    }

    ?>

</div><!-- form -->