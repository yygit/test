<?php
/**
 * @var CActiveDataProvider $dataProvider
 * @var CController $this
 */

if (!empty($_GET['tag'])) {
    ?>
    <h1>Posts Tagged with <i>
            <?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php
} else {
    ?>
    <h1>All Posts </h1>
<?php
}
?>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'template' => "{items}\n{pager}",
)); ?>
