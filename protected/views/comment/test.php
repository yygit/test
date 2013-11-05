<?php
if(!empty($data)){
    foreach($data as $v){
        var_dump($v->attributes);
        var_dump($v->user->attributes);
    }
}

if(!empty($cmd)){
    foreach($cmd as $row){
        var_dump($row);
    }
}
echo '<hr />';
if(!empty($xy)){
    var_dump($xy);
}
