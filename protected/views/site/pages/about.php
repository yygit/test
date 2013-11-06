<?php
$this->pageTitle = Yii::app()->name . ' - About';
$this->breadcrumbs = array(
    'About',
);
?>
<h1>About</h1>
<?php
$this->widget('bootstrap.widgets.TbLabel', array(
    'type' => 'important',
    'label' => 'About',
));
?>

<p>This is a "static" page. You may change the content of this page by updating the file
    <tt><?php echo __FILE__; ?></tt>.</p>
