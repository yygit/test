<?php
/**
 * @var array $fullErrorArray
 * @var int $code
 * @var string $message
 */
$this->pageTitle = Yii::app()->name . ' - Error';
$this->breadcrumbs = array(
    'Error',
);
?>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
    <?php echo CHtml::encode($type . ': ' . $message); ?>
</div>

<?php

if (isset($fullErrorArray) && (YII_DEBUG == true)) {
    echo '<br><br><hr>';
    var_dump($fullErrorArray);
}


?>
