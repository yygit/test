<?php
/**
 * @var $this BasicStatWidget
 */
$data = $this->getData();
$keys = $data->getKeys();
foreach ($keys as $k) {
    echo $k.': '.$data->itemAt($k).'<br />';
}

?>
