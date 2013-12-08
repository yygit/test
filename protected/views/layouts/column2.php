<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
    <div class="span-18">
        <div id="content">
            <?php echo $content; ?>
        </div>
        <!-- content -->
    </div>
    <div class="span-6 last">
        <div id="sidebar">
            <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title' => 'Operations',
            ));
            $this->widget('zii.widgets.CMenu', array(
                'items' => $this->menu,
                'htmlOptions' => array('class' => 'operations'),
            ));
            $this->endWidget();
            ?>
        </div>
        <!-- sidebar -->
        <?php
        if (Yii::app()->authManager->checkAccessNoBizrule('reader', Yii::app()->user->id)) {
            ?>
            <div id="sidebar">
                <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title' => 'Date / Time',
                ));
                $this->widget('application.components.BasicStatWidget', array(
                    'option' => 'date',
                ));
                echo '<br/>';
                $this->widget('application.components.BasicStatWidget', array(
                    'option' => 'timestamp',
                ));
                $this->endWidget();
                ?>
            </div>
            <!-- sidebar -->
            <div id="sidebar">
                <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title' => 'Statistics',
                ));
                $this->widget('application.components.BasicStatWidget', array(
                    'option' => array('users', 'projects', 'myprojects', 'issues', 'myissues'),
                ));
                $this->endWidget();
                ?>
            </div>
            <!-- sidebar -->
        <?php
        }
        ?>
    </div>
</div>
<?php $this->endContent(); ?>
