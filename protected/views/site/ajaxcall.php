<?php
/* @var $this SiteController */
/* @var $data array */
?>
<!--<article>
    <h3><?php /*echo $data['title']; */?></h3>
    <div><?php /*echo $data['content']; */?></div>
</article>-->

<?php
echo CHtml::ajaxButton('show',
    Yii::app()->createUrl('site/ajaxresponse'),
    array(
        'dataType' => 'html',
        'type' => 'get',
        'update' => '#response'
    ) // ajax
); // script
echo CHtml::button('clear',array(
    'onclick'=>'js:$("#response").empty();',
));
?>

<div id='response'></div>
