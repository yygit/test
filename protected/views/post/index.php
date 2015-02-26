<?php
/**
 * @var $posts Post[] post model
 * @var $count int
 */
var_dump($count);
if (!empty($posts)) {
    foreach ($posts as $k => $v) {
        var_dump($v->attributes);
    }
}
else
    echo 'no posts';

