<?php
/* @var $this SiteController */
/* @var $data array */
?>

<?php echo CHtml::ajaxButton('show',
    Yii::app()->createUrl('site/jsonresponse'), array(
        'dataType' => 'json',
        'type' => 'get',
        'success' => 'function(result) {
            $("#updateTitle").html(result.title);
            $("#updateContent").html(result.content);
        }'
    ), // ajax options
    array(
        'confirm'=>'press "OK" to confirm',
     ) // html options
); // script
echo CHtml::button('clear', array(
    'onclick' => 'js:$("#updateContent").empty(); js:$("#updateTitle").empty();',
));
?>
<br style='margin-bottom: 20px;'/>
<h3 id="updateTitle"></h3>
<div id="updateContent"></div>
