<?php
$url = Yii::app()->createUrl('stat/timestamp');
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
    }, 55000);
");
?>

Current timestamp is <div id='statdiv_<?php echo $this->option; ?>'></div>
