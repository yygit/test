<?php $this->pageTitle = Yii::app()->name; ?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<?php if (!Yii::app()->user->isGuest):?>
    <p>
        You last logged in on <b><?php echo Yii::app()->user->lastLogin; ?></b>.
    </p>
<?php endif; ?>

<ul>
    <li>View file: <tt><?php echo __FILE__; ?></tt></li>
    <li>Layout: <tt><?php echo $this->layout; ?></tt></li>
    <li>Layout file: <tt><?php echo $this->getLayoutFile($this->layout); ?></tt></li>
    <li>YiiBase::$_aliases <?php var_dump(YiiBase::$_aliases); ?></li>
</ul>

<?php var_dump(Yii::app()->request->getHostInfo()); ?>
<?php var_dump(Yii::app()->request->getIsSecureConnection()); ?>
