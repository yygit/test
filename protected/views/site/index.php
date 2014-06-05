<?php
/**
 * @var SiteController $this
 */

$this->pageTitle = Yii::app()->name; ?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<?php if (!Yii::app()->user->isGuest): ?>
    <p>
        You last logged in on <b><?php echo Yii::app()->user->lastLogin; ?></b>.
    </p>
<?php endif; ?>

<ul>
    <li>YII_DEBUG: <tt><?php echo YII_DEBUG; ?></tt></li>
    <li>View file: <tt><?php echo __FILE__; ?></tt></li>
    <li>Layout: <tt><?php echo $this->layout; ?></tt></li>
    <li>Layout file: <tt><?php echo $this->getLayoutFile($this->layout); ?></tt></li>
    <li>YiiBase::$_aliases <?php if (!empty(YiiBase::$_aliases)) var_dump(YiiBase::$_aliases); ?></li>
</ul>

<?php
$format = Yii::app()->format;
$logger = new CLogger;
var_dump(get_class(Yii::app()->session));
var_dump($format->formatDatetime(date('r')));
var_dump($logger->getExecutionTime());
var_dump($format->formatNumber($logger->getMemoryUsage()));

?>
