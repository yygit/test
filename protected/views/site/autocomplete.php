<?php
/* @var $this CController */
?>
<?php
$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
    'name' => 'title',
    'sourceUrl' => Yii::app()->createUrl('site/getPageTitlesAr'),
    'options' => array(
        'minLength' => '2',
        'type' => 'get',
        'select' => 'js:function(event, ui) {
            $("#selectedTitle").text(ui.item.value);
        }',
    ),
));
?>
<h2 id="selectedTitle"></h2>
