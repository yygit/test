<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->getBaseUrl() . '/js/testfile.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScript('testjs1','alert("test1");',CClientScript::POS_READY);

echo CHtml::link(Yii::app()->request->getBaseUrl(true), array('/')) . "<br>\n";
echo CHtml::link(Yii::app()->request->getBaseUrl(false), array('/')) . "<br>\n";
?>

<div id="test"></div>
