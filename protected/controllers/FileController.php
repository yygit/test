<?php

class FileController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'File'),
		));
	}

	public function actionCreate() {
		$model = new File;


		if (isset($_POST['File'])) {
			$model->setAttributes($_POST['File']);
			$relatedData = array(
				'pages' => $_POST['File']['pages'] === '' ? null : $_POST['File']['pages'],
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
		$model = $this->loadModel($id, 'File');


		if (isset($_POST['File'])) {
			$model->setAttributes($_POST['File']);
			$relatedData = array(
				'pages' => $_POST['File']['pages'] === '' ? null : $_POST['File']['pages'],
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
			$this->loadModel($id, 'File')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('File');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new File('search');
		$model->unsetAttributes();

		if (isset($_GET['File']))
			$model->setAttributes($_GET['File']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}