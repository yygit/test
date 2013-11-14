<?php
echo CHtml::link(Yii::app()->request->getBaseUrl(true), array('/'))."<br>\n";
echo CHtml::link(Yii::app()->request->getBaseUrl(false), array('/'))."<br>\n";

//Yii::app()->clientScript->registerScriptFile('/path/to/file.js');
//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('testjs1','alert("test1");',CClientScript::POS_READY);
