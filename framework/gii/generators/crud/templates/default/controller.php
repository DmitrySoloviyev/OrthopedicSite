<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?>
{
	public $layout = '//layouts/column2';

	public function filters()
	{
		return [
			'accessControl',
			'postOnly + delete',
		];
	}

	public function accessRules()
	{
		return [
			['allow',
				'actions' => ['index','view'],
				'users' => ['*'],
			],
			['allow',
				'actions' => ['create','update'],
				'users' => ['@'],
			],
			['allow',
				'actions' => ['admin', 'delete'],
				'users' => ['admin'],
			],
			['deny',
				'users' => ['*'],
			],
		];
	}

	public function actionView($id)
	{
		$this->render('view', [
			'model'=>$this->loadModel($id),
		]);
	}

	public function actionCreate()
	{
		$model = new <?php echo $this->modelClass; ?>;

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
			if($model->save())
				$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
		}

		$this->render('create', [
			'model' => $model,
		]);
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
			if($model->save())
				$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
		}

		$this->render('update', [
			'model'=>$model,
		]);
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('<?php echo $this->modelClass; ?>');
		$this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionAdmin()
	{
		$model = new <?php echo $this->modelClass; ?>('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['<?php echo $this->modelClass; ?>']))
			$model->attributes=$_GET['<?php echo $this->modelClass; ?>'];

		$this->render('admin', [
			'model' => $model,
		]);
	}

	public function loadModel($id)
	{
		$model=<?php echo $this->modelClass; ?>::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='<?php echo $this->class2id($this->modelClass); ?>-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
