<?php

class PostController extends Controller{
    public $layout = 'column2';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            !YII_DEBUG ? array(
                'CHttpCacheFilter + index',
                'lastModified' => Yii::app()->db_blog->createCommand("SELECT MAX(`update_time`) FROM blog_post")->queryScalar(),
            ) : null,
            !YII_DEBUG ? array(
                'CHttpCacheFilter + view',
                /*'lastModifiedExpression' => function () {
                    $postId = Yii::app()->request->getParam('id');
                    return Yii::app()->db_blog->createCommand("SELECT `update_time` FROM blog_post WHERE id=:id")->queryScalar(array(':id' => $postId));
                },*/
                'lastModified' => Yii::app()->db_blog->createCommand("SELECT `update_time` FROM blog_post WHERE id=:id")->queryScalar(array(":id" => Yii::app()->request->getParam('id'))),
            ) : null,
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to access 'index' and 'view' actions.
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated users to access all actions
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     */
    public function actionView() {
        $post = $this->loadModel();
        $comment = $this->newComment($post);

        $this->render('view', array(
            'model' => $post,
            'comment' => $comment,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new BlogPost;
        if (isset($_POST['Post'])) {
            $model->attributes = $_POST['Post'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate() {
        $model = $this->loadModel();
        if (isset($_POST['Post'])) {
            $model->attributes = $_POST['Post'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel()->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        Yii::beginProfile('preparing_data');
        $criteria = new CDbCriteria(array(
            'condition' => 'status=' . BlogPost::STATUS_PUBLISHED,
            'order' => 'update_time ASC',
            'with' => array(
                'author' => array('select' => 'id, username'),
                'commentCount',
            ),
        ));
        if (isset($_GET['tag']))
            $criteria->addSearchCondition('tags', $_GET['tag']);

        $dataProvider = new CActiveDataProvider('BlogPost', array(
            'pagination' => array(
                'pageSize' => Yii::app()->params['postsPerPage'],
            ),
            'criteria' => $criteria,
        ));
        Yii::endProfile('preparing_data');

        Yii::beginProfile('rendering_data');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
        Yii::endProfile('rendering_data');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new BlogPost('search');
        if (isset($_GET['Post']))
            $model->attributes = $_GET['Post'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Suggests tags based on the current user input.
     * This is called via AJAX when the user is entering the tags input.
     */
    public function actionSuggestTags() {
        if (isset($_GET['q']) && ($keyword = trim($_GET['q'])) !== '') {
            $tags = Tag::model()->suggestTags($keyword);
            if ($tags !== array())
                echo implode("\n", $tags);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id'])) {
                if (Yii::app()->user->isGuest)
                    $condition = 'status=' . BlogPost::STATUS_PUBLISHED . ' OR status=' . BlogPost::STATUS_ARCHIVED;
                else
                    $condition = '';
                $this->_model = BlogPost::model()->findByPk($_GET['id'], $condition);
            }
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

    /**
     * Creates a new comment.
     * This method attempts to create a new comment based on the user input.
     * If the comment is successfully created, the browser will be redirected
     * to show the created comment.
     * @param Post the post that the new comment belongs to
     * @return Comment the comment instance
     */
    protected function newComment($post) {
        $comment = new BlogComment;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
            echo CActiveForm::validate($comment);
            Yii::app()->end();
        }
        if (isset($_POST['BlogComment'])) {
            $comment->attributes = $_POST['BlogComment'];
            if ($post->addComment($comment)) {
                if ($comment->status == BlogComment::STATUS_PENDING)
                    Yii::app()->user->setFlash('commentSubmitted', 'Thank you for your comment. Your comment will be posted once it is approved.');
                $this->refresh();
            }
        }
        return $comment;
    }
}