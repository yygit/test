<?php
/**
 * @var $this CController
 */
//$this->beginContent('/layouts/main');
$this->beginContent();
?>
<div class="container">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>
