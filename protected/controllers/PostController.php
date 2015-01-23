<?php
class PostController extends CController{
    function actions() {
        return array(
            // http://localhost/test/post/delete/id/5
            'delete' => array(
                'class' => 'DeleteAction',
                'modelClass' => 'Post',
                'redirectTo' => array('post/index'),
            ),
        );
    }


    function actionIndex() {
        $posts = Post::model()->findAll();
        $this->render('index', array(
            'posts' => $posts,
        ));
    }
}
