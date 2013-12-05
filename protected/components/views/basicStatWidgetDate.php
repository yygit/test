<?php
$url = Yii::app()->createUrl('stat/index');
Yii::app()->clientScript->registerScript("refresh" . $this->option . "", "
    function updateData" . $this->option . "(){
        $.ajax({
            'url':'" . $url . "',
            'success':function(data){
                    $('#statdiv_" . $this->option . "').html(data);
                }
            });
    }

    updateData" . $this->option . "();

    var auto_refresh = setInterval(function(){
                updateData" . $this->option . "();
    }, 35000);
");
?>

<div id='statdiv_<?php echo $this->option; ?>'></div>
