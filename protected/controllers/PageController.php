<?php

class PageController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Page'),
		));
	}

	public function actionCreate() {
		$model = new Page;


		if (isset($_POST['Page'])) {
			$model->setAttributes($_POST['Page']);
			$relatedData = array(
				'files' => $_POST['Page']['files'] === '' ? null : $_POST['Page']['files'],
				);

			if ($model->saveWithRelated($relatedData)) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Page');


		if (isset($_POST['Page'])) {
			$model->setAttributes($_POST['Page']);
			$relatedData = array(
				'files' => $_POST['Page']['files'] === '' ? null : $_POST['Page']['files'],
				);

			if ($model->saveWithRelated($relatedData)) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Page')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Page');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Page('search');
		$model->unsetAttributes();

		if (isset($_GET['Page']))
			$model->setAttributes($_GET['Page']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}