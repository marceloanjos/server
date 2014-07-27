<?php

class PolicyController extends Controller
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
				'actions'=>array('index','view','create','update','admin','delete', 'triggerchange', 'actionchange','groupadd'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

        /**
         * Toggles the trigger from a ajax call
         */
        public function actionTriggerChange()
        {
          
            //Make a blank model
            $model = new Policy;
            
            //Load the model
            if(isset($_POST['Policy'])) 
            {
                $model->attributes=$_POST['Policy']; 
                 if(isset($_POST['PolicyTriggerID'])) $model->PolicyTriggerID = $_POST['PolicyTriggerID'];
            }


            $this->renderPartial('_trigger', array('model'=>$model),false,true);

        }
        
        /**
         * Toggles the trigger from a ajax call
         */
        public function actionActionChange()
        {
          
            //Make a blank model
            $model = new Policy;
           
            //Load the model
            if(isset($_POST['Policy'])) 
            {
                $model->attributes=$_POST['Policy']; 
                if(isset($_POST['PolicyActionID'])) $model->PolicyActionID = $_POST['PolicyActionID'];
            }
            
            $this->renderPartial('_action', array('model'=>$model),false,true);

        }
        
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Policy;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
              
		if(isset($_POST['Policy']))
		{
			$model->attributes=$_POST['Policy'];
                        
                        
                                                
                        if($model->save())
				$this->redirect(array('view','id'=>$model->idPolicy));
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

		if(isset($_POST['Policy']))
		{
			$model->attributes=$_POST['Policy'];
			
                                                
                        if($model->save())
				$this->redirect(array('view','id'=>$model->idPolicy));
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
		$dataProvider=new CActiveDataProvider('Policy');
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
                            //if the items do not exist in the group policy, then add them
                            $existing = GroupPolicy::model()->find('GroupID = :group AND PolicyID = :policy', array(':group'=>$_POST['groupid'], ':policy'=>$id));
                            if(!isset($existing))
                            {
                                $gp = new GroupPolicy();
                                $gp->GroupID = $_POST['groupid'];
                                $gp->PolicyID = $id;
                                
                                if(!$gp->save()) $haderror = true;
                            }
                        }
                        
                        if($haderror)
                        {
                            $transaction->rollback();
                            //show the flash
                            Yii::app()->user->setFlash('error','The selected policies could not be added to the group!');
                            $this->refresh();
                        }
                        else
                        {
                            //commit the changes
                            $transaction->commit();
                        
                            //redirect to the group policy page
                            //$this->redirect($this->createUrl('group/policy', array('group'=>$_POST['groupid'])), true); 
                            Yii::app()->user->setFlash('success','The selected policies were added to ' . Group::model()->findByPk($_POST['groupid'])->Name . ' ' . CHtml::link('(Click here to view)', $this->createUrl('group/policy', array('group'=>$_POST['groupid']))));
                            $this->refresh();
                        }

                        
                    } 
                    catch (Exception $e)
                    {
                        $transaction->rollback();
                        //show the flash
                        Yii::app()->user->setFlash('error','The selected policies could not be added to the group');
                        $this->refresh(); 
                    }
               }
            
		$model=new Policy('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Policy']))
			$model->attributes=$_GET['Policy'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

        /**
	 * Adds the selected items to a group
	 */
	public function actionGroupAdd()
	{
		
            $this->actionAdmin();
	}
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Policy::model()->findByPk($id);
                
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='policy-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
