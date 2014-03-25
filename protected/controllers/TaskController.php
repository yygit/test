<?php
class TaskController extends Controller{
    public function filters() {
        return array(
            'ajaxOnly + field'
        );
    }

    public function actionIndex() {
        $models = array();
        $isError = false;

        if (!empty($_POST['Task'])) {
            foreach ($_POST['Task'] as $taskData) {
                $model = new Task();
                $model->setAttributes($taskData);
                $model->validate();
                if (!$model->validate())
                    $isError = true;
                $models[] = $model;
            }
        }

        if (!empty($models)) {
            if (!$isError) {
                var_dump('ok');
                // We've received some models and validated them.
                // If you want to save the data you can do it here.
                /**
                 * @var Task $m
                 */
                foreach ($models as $m) {
                    var_dump($m->attributes);
                }

            }
        } else
            $models[] = new Task();

        $this->render('index', array(
            'models' => $models,
        ));
    }

    public function actionField($index) {
        $model = new Task();
        $this->renderPartial('_task', array(
            'model' => $model,
            'index' => $index,
        ));
    }
}
