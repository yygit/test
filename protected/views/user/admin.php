<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List User', 'url' => array('index')),
    array('label' => 'Create User', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
        &lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->

<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'afterAjaxUpdate' => 'reinstallDatePicker',
    'columns' => array(
        'id',
        'username',
        'email',
//		'pass',
        array(
            'header' => $model->getAttributeLabel('type'),
            'value' => 'ucfirst($data->type)',
            'filter' => CHtml::dropDownList('User[type]',
                $model->type, array('public' => 'Public', 'author' => 'Author', 'admin' => 'Admin'),
                array('empty' => '(Select)')),
        ),
        array(
            'header' => $model->getAttributeLabel('date_entered'),
            'value' => 'ucfirst($data->date_entered)',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'attribute' => 'date_entered',
                    'model' => $model,
                    'language' => $locale,
                    'htmlOptions' => array(
                        'id' => 'datepicker_for_due_date',
                    ),
                    'options' => array(
                        'dateFormat' => $dateFormat,
                    ),
                ),
                true),
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));

Yii::app()->clientScript->registerScript('reinstalldatepicker', "
    function reinstallDatePicker(id, data) {
        $.datepicker.setDefaults($.datepicker.regional['$locale']);
        $('#datepicker_for_due_date').datepicker({
            'dateFormat': '$dateFormat'
        });
    }
");
?>
