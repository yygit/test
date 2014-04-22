<?php
/**
 * @var BlogPost $data
 */
?>

<div class="post">
    <div class="title">
        <?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
    </div>
    <div class="author">
        posted by <?php echo $data->author->username . ' on ' . date('F j, Y', $data->create_time); ?>
    </div>
    <div class="content">
        <?php Yii::beginProfile('_view') ?>
        <?php
        // FRAGMENT CACHING; YY 20131216
        $key = "blog.postindex.post_view_." . $data->id;
        if ($this->beginCache($key, array(
            'dependency' => array(
                'connectionID' => 'db_blog',
                'class' => 'system.caching.dependencies.CDbCacheDependency',
                'sql' => 'SELECT `update_time` FROM blog_post WHERE `id` = ' . $data->id,
            ),
            'duration' => 180,
        ))
        ) {
            $this->beginWidget('CMarkdown', array('purifyOutput' => true));
            echo $data->content;
            $this->endWidget();
            $this->endCache();
        }
        ?>
        <?php Yii::endProfile('_view') ?>
    </div>
    <div class="nav">
        <b>Tags:</b>
        <?php echo implode(', ', $data->tagLinks); ?>
        <br/>
        <?php echo CHtml::link('Permalink', $data->url); ?> |
        <?php echo CHtml::link("Comments ({$data->commentCount})", $data->url . '#comments'); ?> |
        Last updated on <?php echo date('F j, Y', $data->update_time); ?>
    </div>
</div>
<hr/>
