<?php
/* @var $this CommentController */
/* @var $model Comment */
/* @var $form CActiveForm */
/* @var $issueId int id of the issue */
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'comment-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
        ),
    )); ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php echo $form->textArea($model, 'content', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>

    <?php echo CHtml::hiddenField('id', $issueId); // need this for ajax button ?>

    <div class="row buttons">
        <?php
        echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');
        echo CHtml::ajaxButton('Ajax',
            Yii::app()->createUrl('issue/ajaxcomment'),
            array(
                'dataType' => 'html',
                'type' => 'post',
//                'update' => '#ajaxcomments',
                'success' => 'js:function(result) {
                    $("#ajaxcomments").html(result);
                    $("#Comment_content").val("");
                }',
                'cache' => false,
                'data' => 'js:jQuery(this).parents("form").serialize()'
            ) // ajax
        ); // script
        ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
