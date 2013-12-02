<?php
/* @var $this Controller */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
          media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print"/>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo"><?php
            echo CHtml::encode(Yii::app()->name);
            /*var_dump($this->route);
            var_dump($this->id);*/
            ?>
        </div>
    </div>
    <!-- header -->

    <div id="mainmenu">
        <?php
        $items = array(
            array('label' => 'Home', 'url' => array('/'), 'itemOptions' => array('class' => $this->route == Yii::app()->defaultController . '/' . $this->defaultAction ? 'active' : null)),
            array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
            array('label' => 'Contact', 'url' => array('/site/contact')),
        );
        $items[] = Yii::app()->authManager->checkAccessNoBizrule('reader', Yii::app()->user->id) ? array('label' => 'Users', 'url' => array('/user'), 'itemOptions' => array('class' => $this->id == 'user' ? 'active' : null)) : null;
        $items[] = Yii::app()->authManager->checkAccessNoBizrule('readProject', Yii::app()->user->id) ? array('label' => 'Projects', 'url' => array('/project'), 'itemOptions' => array('class' => $this->id == 'project' ? 'active' : null)) : null;
        $items[] = Yii::app()->authManager->checkAccessNoBizrule('readIssue', Yii::app()->user->id) ? array('label' => 'Issues', 'url' => array('/issue'), 'itemOptions' => array('class' => $this->id == 'issue' ? 'active' : null)) : null;
        $items[] = Yii::app()->authManager->checkAccessNoBizrule('owner', Yii::app()->user->id) ? array('label' => 'Comments', 'url' => array('/comment'), 'itemOptions' => array('class' => $this->id == 'comment' ? 'active' : null)) : null;
        $items[] = array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest);
        $items[] = array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest);

        $this->widget('zii.widgets.CMenu', array(
            'items' => array_values($items),
        ));
        ?>
    </div>
    <!-- mainmenu -->
    <?php if (isset($this->breadcrumbs)): ?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
    <?php endif ?>

    <?php echo $content; ?>

    <div id="footer">
        YY <?php echo date('Y'); ?><br/>
    </div>
    <!-- footer -->

</div>
<!-- page -->

</body>
</html>
