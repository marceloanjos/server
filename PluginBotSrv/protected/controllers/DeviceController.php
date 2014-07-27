<?php

class DeviceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            //Load the device
            $model = $this->loadModel($id);
            
            //load the groups
            $groups = GroupDevice::model()->findAll('DeviceID = :device',array(':device'=>$model->primaryKey));

            //get an array of the group ids
            $grouparr = array();
            foreach($groups as $group)
            {
                $grouparr[] = $group->GroupID;
            }
            
            //make a critera
            $criteria = new CDbCriteria();
            $criteria->addInCondition("GroupID",$grouparr);
            
            //load the policies
            $policies = GroupPolicy::model()->findAll($criteria);
            
            
            //load the plugins
            $plugins = GroupPlugin::model()->findAll($criteria);
            
            $this->render('view',array('model'=>$model,'groups'=>$groups,'policies'=>$policies,'plugins'=>$plugins));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Device;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Device']))
		{
			$model->attributes=$_POST['Device'];

                        if($model->isMissing == 1) $model->DateMissing = ModelHelper::getDate();
                                                
                        if($model->save())
				$this->redirect(array('view','id'=>$model->idDevice));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Device']))
		{
			$model->attributes=$_POST['Device'];
			if($model->isMissing == 1) $model->DateMissing = ModelHelper::getDate();
                                                
                        if($model->save())
				$this->redirect(array('view','id'=>$model->idDevice));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Device');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            
            if(isset($_POST['toadd']) && isset($_POST['groupid']))
            {
               
                    //add the selected items to the group
                    $haderror = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try
                    {
                        foreach ($_POST['toadd'] as $id)
                        {
                            //if the items do not exist in the group device, then add them
                            $existing = GroupDevice::model()->find('GroupID = :group AND DeviceID = :device', array(':group'=>$_POST['groupid'], ':device'=>$id));
                            if(!isset($existing))
                            {
                                $gp = new GroupDevice();
                                $gp->GroupID = $_POST['groupid'];
                                $gp->DeviceID = $id;
                                
                                if(!$gp->save()) $haderror = true;
                            }
                        }
                        
                        if($haderror)
                        {
                            $transaction->rollback();
                            //show the flash
                            Yii::app()->user->setFlash('error','The selected devices could not be added to the group!');
                            $this->refresh();
                        }
                        else
                        {
                            //commit the changes
                            $transaction->commit();
                        
                            //redirect to the group policy page
                            Yii::app()->user->setFlash('success','The selected devices were added to ' . Group::model()->findByPk($_POST['groupid'])->Name . ' ' . CHtml::link('(Click here to view)', $this->createUrl('group/device', array('group'=>$_POST['groupid']))));
                            $this->refresh();
                        }

                        
                    } 
                    catch (Exception $e)
                    {
                        $transaction->rollback();
                        //show the flash
                        Yii::app()->user->setFlash('error','The selected devices could not be added to the group');
                        $this->refresh(); 
                    }
               }
            
		$model=new Device('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Device']))
			$model->attributes=$_GET['Device'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Device::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
               
                
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='device-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
