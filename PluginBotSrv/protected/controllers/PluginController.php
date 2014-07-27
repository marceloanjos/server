<?php

class PluginController extends Controller
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
				'actions'=>array('index','view','create','update','admin','delete','pluginchange','author','upload','submit','submitions','updatesubmition','deletesubmition','details','addoption', 'removeoption','rate','_rating','browse','download'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        

         /*
         * The function for the ajax call
         */
        public function actionAddOption($id)
        {
           
            //get the Plugin File
            $plugfile = PluginFile::model()->findByPk($id);
            $model = new SubmitPluginForm();
            $model->attributes = $plugfile->attributes;
            $model->primaryKey = $plugfile->primaryKey;
            
            //add a new option to the database
            $option = new PluginOption();
            $option->PluginFileID = $id;
            $option->ValueTypeID = ValueType::model()->find('Name = :name', array(':name'=>'String'))->primaryKey;
            $option->Name = 'Name Here';
            $option->Default = 'Default Value here';
            $option->Description = 'Description Here';
            $option->save();
               
            //render the div area
            $this->renderPartial('_options', array('model'=>$model),false,true);

        }
        
        
        public function actionRemoveOption($id, $optionid)
        {
            
            //get the Plugin File
            $model = PluginFile::model()->findByPk($id);
            $pluginoption = PluginOption::model()->findByPk($optionid);
            
            $pluginoption->delete();
               
            //render the div area
            $this->renderPartial('_options', array('model'=>$model),false,true);

        }
        
        
        /**
         * Plugin upload
         */
        public function actionSubmit()
        {
            $model = new UploadPluginForm();

            if(isset($_POST['UploadPluginForm']))
            {
                $transaction = Yii::app()->db->beginTransaction();
                //see if we have a valid upload
                try
                {
                    //get the upload instance
                    $model->UploadFile = CUploadedFile::getInstance($model,'UploadFile');
                    
                    if (!isset($model->UploadFile)) throw new Exception('No file uploaded!');
                    if (!isset($model->UploadFile->size)) throw new Exception('File size was not set.');
                    
                    //check to make sure this is a valid plugin zip file
                    $ret = PluginHelper::isPluginValid($model->UploadFile->tempName);
                    if(!$ret) throw new Exception('Not a valid plugin file! Missing plugin.xml, did you use the plugin generator application?');
                    
                    //get the xml from the zip file
                    $arrplugin = PluginHelper::getXMLAttributes($model->UploadFile->tempName);
                    
                    if(isset($arrplugin['error'])) throw new Exception($arrplugin['error']);
                    
                    //copy the plugin and create a new record
                    $pluginfile = new PluginFile();
                    
                    $os = OperatingSystem::model()->find('Name=:name',array(':name'=>$arrplugin['os']));
                    
                    
                    if(!isset($os)) throw new Exception('Not a valid operating system!');
                    
                    $name = '0_';

                    $pluginfile->OperatingSystemID = $os->primaryKey;
                    $pluginfile->Bits = $arrplugin['bits'];
                    $pluginfile->Name = $arrplugin['name'];
                    $pluginfile->URL = $name;
                    $pluginfile->DateReleased = ModelHelper::getDate();
                    $pluginfile->Version = $arrplugin['version'];
                    $pluginfile->Size = $model->UploadFile->size;
                    $pluginfile->ShortDescription = $arrplugin['short'];
                    $pluginfile->Description = $arrplugin['long'];
   

                    if($pluginfile->save())
                    {
                        
                        $pluginfile->URL = $pluginfile->primaryKey. '.zip';
                        
                       //save the plugin options
                        foreach($arrplugin['options'] as $option)
                        {
                            $optiontype = ValueType::model()->find('Name=:name',array(':name'=>$option['type']));
                            if(!isset($optiontype)) throw new Exception('Not a valid value type!');
 
                            $pluginoption = new PluginOption();
                            $pluginoption->PluginFileID = $pluginfile->primaryKey;
                            $pluginoption->ValueTypeID = $optiontype->primaryKey;
                            $pluginoption->Name = $option['name'];
                            $pluginoption->Default = $option['default'];
                            $pluginoption->Description = $option['description'];
                            
                            if(!$pluginoption->save()) throw new Exception('Option could not be saved!');
                        }
                        
                        if($pluginfile->save())
                        {
                             //copy the file and update the pluginfile url
                            $filepath = realpath(Yii::app()->basePath . '/../downloads/plugins/');
                            $filepath = $filepath . '/' . $pluginfile->URL;
                            
                            if($model->UploadFile->saveAs($filepath))
                            {
                                //send them to the editor
                                $transaction->commit();
                                //$this->redirect($this->createUrl('plugin/updatesubmition', array('id'=>$pluginfile->primaryKey)));
                                $this->redirect($this->createUrl('plugin/details', array('id'=>$pluginfile->primaryKey)));
                                
                                Yii::app()->end();
                            }
                            else
                            {
                                throw new Exception('Could not copy uploaded file');
                            }

                        }
                        else 
                        {
                            throw new Exception('Plugin url could not be updated!');
                        }
                    }
                    else   
                    {
                        throw new Exception('Plugin file could not be saved!');
                    }
                }
                catch(Exception $err)
                {
                    $transaction->rollback();
                    $model->addError('UploadFile', $err->getMessage());
                    $this->render('upload', array('model' => $model, 'errors' => $model->getErrors()));
                    Yii::app()->end();
                }
            }
            
            $this->render('submit', array('model'=>$model));
        }
        
         /**
	 * Lists all models.
	 */
	public function actionSubmitOLD()
	{
                 $model=new SubmitPluginForm();

                if(isset($_POST['SubmitPluginForm']))
                {
                    
                    
                    $model->attributes=$_POST['SubmitPluginForm'];
                    try
                    {
                        $model->uploadfile=CUploadedFile::getInstance($model,'UploadFile');
                        
                        if(!isset($model->uploadfile))
                        {
                            $model->addError('UploadFile', 'No file to upload');
                            throw new Exception('No file to upload');
                        }

                        if(!isset($model->uploadfile->size)) 
                        {
                            $model->addError('UploadFile', 'File size was not set.');
                            throw new Exception('File size was not set.');
                        }
                       
                        
                        $name = '0_';
                        $model->URL = $name;
                        $model->DateReleased = ModelHelper::getDate();
                        $model->Size = $model->uploadfile->size;

                    
                       if($model->save())
                        {
                           
                           $model->URL = $name . $model->primaryKey. '.zip';
                            if($model->save())
                            {
                                
                                $filepath = realpath(Yii::app()->basePath . '/../downloads/plugins/');
                                $filepath = $filepath . '/' . $model->URL;

                                if(!$model->uploadfile->saveAs($filepath))
                                {
                                     $model->addError('UploadFile', 'Could not upload file');
                                } 
                                else
                                {
                                    $this->redirect($this->createUrl('plugin/updatesubmition', array('id'=>$model->primaryKey)));
                                 
                                    Yii::app()->end();
                                }
                    
                                    
                            }
                            
                        }
                        else
                        {
                            $model->addError('Error', 'Model could not be saved!');
                            throw new Exception('Model could not be saved!');
                        }
                    }
                    catch(Exception $err)
                    {
                        $this->render('submit', array('model' => $model, 'errors' => $model->getErrors()));
                        Yii::app()->end();
                    }
                }
                $this->render('submit', array('model'=>$model));
	}
        
        
        /**
	 * Lists all models.
	 */
	public function actionSubmitions()
	{
 
		$model=new PluginFile('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PluginFile']))
			$model->attributes=$_GET['PluginFile'];
                        
		$this->render('submitions',array(
			'model'=>$model,
		));
	}
        
        /**
	 * Lists all models.
	 */
	public function actionBrowse()
	{
            
		$model=new PluginFile('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PluginFile']))
			$model->attributes=$_GET['PluginFile'];
                        
		$this->render('browse',array(
			'model'=>$model,
		));
	}
        
        /**
	 * Displays a particular plugin file.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionDetails($id)
	{
            if(Yii::app()->user->isGuest) $this->layout='//layouts/column1';
            
            $model = PluginFile::model()->findByPk($id);
            if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
            
            
           
		$this->render('details',array(
			'model'=>$model,
		));
	}
        
        /**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionAuthor($id)
	{

	}
        
        
        /**
         * Triggered when the plugin is changed
         */
        public function actionPluginChange()
        {
              //Make a blank model
            $model = new Plugin;
           
            //Load the model
            if(isset($_POST['Plugin'])) 
            {
                $model->attributes=$_POST['Plugin']; 
                
            }
         
            $this->renderPartial('_plugin', array('model'=>$model),false,true);
        }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            $model = $this->loadModel($id);
            $options = PluginItem::model()->findall('PluginID=:plugin',array(':plugin'=>$model->primaryKey));

		$this->render('view',array(
			'model'=>$model,
                        'options'=>$options,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Plugin;

                if(isset($_REQUEST['id']))
                {
                    $model->PluginFileID = $_REQUEST['id'];
                }
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                
		if(isset($_POST['Plugin']))
		{
                    
                    $transaction = Yii::app()->db->beginTransaction();
                    
                    try
                    {
                        $model->attributes=$_POST['Plugin'];
                       
                        if(!$model->save()) throw new Exception("Could not save the plugin.");

                        //save the options
                        $this->SaveOptions($model->primarykey);
                        
                        $transaction->commit(); 
                        $this->redirect(array('view','id'=>$model->idPlugin));
                        
                    }
                    catch(Exception $e)
                    {
                        //roll back the transaction
                        $transaction->rollback();
                        $model->addError('Error', $e->getMessage());
                        $this->render('create', array('model' => $model, 'errors' => $model->getErrors()));
                        Yii::app()->end();
                    }
                    
			
		}


		$this->render('create',array(
			'model'=>$model,
		));
	}

        public function SaveOptions($PluginID, $RemoveOld = false)
        {
            //add the new options
            if(isset($_POST["options"]))
            {
                //check to see if we are removing the old records
                if($RemoveOld ==  true)
                {
                    $rowsaffected = PluginItem::model()->deleteAll('PluginID=:id',array(':id'=>$PluginID));
                }
                
                $options = split(',', $_POST["options"]);
                foreach($options as $option)
                {
                    if(!is_numeric($option)) continue;
                    
                    $model = new PluginItem();
                    $model->PluginID = $PluginID;
                    $model->PluginOptionID = $option;

                    if(isset($_POST['PluginOption']['option' . $option]))
                    {
                        $model->Value =  $_POST['PluginOption']['option' . $option];
                    }
                    else
                    {
                        $model->Value = '';
                    }
                    
                    if(!$model->save()) throw new Exception("Could not save the plugin option.");
                    
                }
            }
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

		if(isset($_POST['Plugin']))
		{
			//$model->attributes=$_POST['Plugin'];
			
                                                
                        //if($model->save()) $this->redirect(array('view','id'=>$model->idPlugin));
                    
                    $transaction = Yii::app()->db->beginTransaction();
                    
                    try
                    {
                        $model->attributes=$_POST['Plugin'];
                        
                        if(!$model->save()) throw new Exception("Could not save the plugin.");

                        //save the options
                        $this->SaveOptions($model->primarykey, true);
                        
                        $transaction->commit(); 
                        $this->redirect(array('view','id'=>$model->idPlugin));
                        
                    }
                    catch(Exception $e)
                    {
                        //roll back the transaction
                        $transaction->rollback();
                        $model->addError('Error', $e->getMessage());
                        $this->render('update', array('model' => $model, 'errors' => $model->getErrors()));
                        Yii::app()->end();
                    }
                    
                    
                    
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
		$dataProvider=new CActiveDataProvider('Plugin');
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
                            //if the items do not exist in the group plugin, then add them
                            $existing = GroupPlugin::model()->find('GroupID = :group AND PluginID = :plugin', array(':group'=>$_POST['groupid'], ':plugin'=>$id));
                            if(!isset($existing))
                            {
                                $gp = new GroupPlugin();
                                $gp->GroupID = $_POST['groupid'];
                                $gp->PluginID = $id;
                                
                                if(!$gp->save()) $haderror = true;
                            }
                        }
                        
                        if($haderror)
                        {
                            $transaction->rollback();
                            //show the flash
                            Yii::app()->user->setFlash('error','The selected plugins could not be added to the group!');
                            $this->refresh();
                        }
                        else
                        {
                            //commit the changes
                            $transaction->commit();
                        
                            //redirect to the group policy page
                            Yii::app()->user->setFlash('success','The selected plugins were added to ' . Group::model()->findByPk($_POST['groupid'])->Name . ' ' . CHtml::link('(Click here to view)', $this->createUrl('group/plugin', array('group'=>$_POST['groupid']))));
                            $this->refresh();
                        }

                        
                    } 
                    catch (Exception $e)
                    {
                        $transaction->rollback();
                        //show the flash
                        Yii::app()->user->setFlash('error','The selected plugins could not be added to the group');
                        $this->refresh(); 
                    }
               }
            
		$model=new Plugin('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Plugin']))
			$model->attributes=$_GET['Plugin'];
                        
		$this->render('admin',array(
			'model'=>$model,
		));
	}

        
        /**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeleteSubmition($id)
	{
            $model = PluginFile::model()->findByPk($id);
            
            //delete the file
            $file = Yii::app()->basePath . '/../downloads/plugins/' . $model->URL;
            $filepath = realpath($file);

            if(file_exists($filepath))
            {
                unlink($filepath);
            }
                    
            
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
	/**
	 * Updates a particular model..
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionUpdateSubmition($id)
	{
            $plugfile = PluginFile::model()->findByPk($id);
            $model = new SubmitPluginForm;
            $model->attributes = $plugfile->attributes;
            $model->isNewRecord = false;
            $model->primaryKey = $plugfile->primaryKey;
            
            
            if(isset($_POST['SubmitPluginForm']))
            {
                
                
                 $transaction = Yii::app()->db->beginTransaction();
                    try 
                    {
                
                        $model->attributes=$_POST['SubmitPluginForm'];

                        $model->uploadfile=CUploadedFile::getInstance($model,'UploadFile');

                        if(isset($model->uploadfile))
                        {
                            $model->overwrite = 1;
                            
                            //make sure it is a valid plugin file
                            if (!isset($model->uploadfile->size)) throw new Exception('File size was not set.');
                            
                            //check to make sure this is a valid plugin zip file
                            $ret = PluginHelper::isPluginValid($model->uploadfile->tempName);
                            if(!$ret) throw new Exception('Not a valid plugin file! Missing plugin.xml, did you use the plugin generator application?');
                    
                               $filepath = realpath(Yii::app()->basePath . '/../downloads/plugins/');
                               $filepath = $filepath . '/' . $model->URL;

                                //remove the old file
                                if(file_exists($filepath)) unlink($filepath);

                                if(!$model->uploadfile->saveAs($filepath))
                                {
                                        $errnum = array( 
                                               0=>"There is no error, the file uploaded with success", 
                                               1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini", 
                                               2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form", 
                                               3=>"The uploaded file was only partially uploaded", 
                                               4=>"No file was uploaded", 
                                               6=>"Missing a temporary folder" 
                                       );
                                    
                                     $model->addError('UploadFile', 'Could not upload file: ' . $errnum[$model->uploadfile->getError()]);
                                     throw new Exception('Could not upload the new file!');
                                }
                                
                                //see if we are overwritting the information
                                if($model->overwrite)
                                {
                                    echo  'overwrite<br>';
                                    
                                    //get the xml from the zip file
                                    $arrplugin = PluginHelper::getXMLAttributes($filepath);
                                    if(isset($arrplugin['error'])) throw new Exception($arrplugin['error']);
                                    
                                    //replace the information
                                    $os = OperatingSystem::model()->find('Name=:name',array(':name'=>$arrplugin['os']));
                                    if(!isset($os)) throw new Exception('Not a valid operating system!');
                                    $model->OperatingSystemID = $os->primaryKey;
                                    $model->Bits = $arrplugin['bits'];
                                    $model->Name = $arrplugin['name'];
                                    $model->DateReleased = ModelHelper::getDate();
                                    $model->Version = $arrplugin['version'];
                                    $model->Size = $model->uploadfile->size;
                                    $model->ShortDescription = $arrplugin['short'];
                                    $model->Description = $arrplugin['long'];
                                    $model->save();
                                    
                                    //remove the options
                                    PluginOption::model()->deleteAll('PluginFileID = :plugin',array(':plugin'=>$model->primaryKey));
                                    
                                    //Add any new options
                                    foreach($arrplugin['options'] as $option)
                                    {
                                        echo 'option<br>';
                                        $optiontype = ValueType::model()->find('Name=:name',array(':name'=>$option['type']));
                                        if(!isset($optiontype)) throw new Exception('Not a valid value type!');

                                        $pluginoption = new PluginOption();
                                        $pluginoption->PluginFileID = $model->primaryKey;
                                        $pluginoption->ValueTypeID = $optiontype->primaryKey;
                                        $pluginoption->Name = $option['name'];
                                        $pluginoption->Default = $option['default'];
                                        $pluginoption->Description = $option['description'];

                                        if(!$pluginoption->save()) throw new Exception('Option could not be saved!');
                                    }
                                    
                                    //commit the transation
                                    $transaction->commit();
                                    Yii::app()->user->setFlash('saved','The plugin information has been saved.');
                                    $this->refresh();
                                    
                                    Yii::app()->end();
                                    return;
                                }
                        }

                        //attempt to save the model
                        if(!$model->save()) throw new Exception('Could not save!'); 

                        //save the options
                        $options = PluginOption::model()->findAll('PluginFileID = :plugin',array(':plugin'=>$model->primaryKey));
                        foreach($options as $option)
                        {
                            //save each option
                            $option->Name = $_POST['Option-' . $option->primaryKey]['Name'];
                            $option->ValueTypeID = $_POST['Option-' . $option->primaryKey]['ValueType'];
                            $option->Default = $_POST['Option-' . $option->primaryKey]['Default'];
                            $option->Description = $_POST['Option-' . $option->primaryKey]['Description'];
                            if(!$option->save())
                            {
                                $model->addErrors($option->errors);
                                throw new Exception('Errors saving options!');
                            }
                            
                        }
                        
                   
                        
                        //commit the transaction
                        $transaction->commit();

                        
                        
                        Yii::app()->user->setFlash('saved','The plugin information has been saved.');
                        $this->refresh();
                    } 
                    catch (Exception $e)
                    {
                        //roll back the transaction
                        $transaction->rollback();
                        $model->addError('Error', $e->getMessage());
                        $this->render('updatesubmition', array('model' => $model, 'errors' => $model->getErrors()));
                        Yii::app()->end();
                    }
                  
                  
                  
                  
                  
            }
                   
                    
            $this->render('updatesubmition',array(
			'model'=>$model,
		));
	}
        
        /**
	 * Downloads a plugin
	 */
	public function actionDownload()
	{
            //make sure we have a valid id
            if(!isset($_REQUEST['id'])) throw new CHttpException(404,'The requested page does not exist.');
            $id = $_REQUEST['id'];
            
            $model = PluginFile::model()->findByPk($id);
            if($model===null) throw new CHttpException(404,'The requested page does not exist.');
            
            
            
            //Redirect them to the file
            $url = Yii::app()->request->baseUrl . "/downloads/plugins/" . $model->URL;
            $this->redirect($url);
            
	}
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Plugin::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='plugin-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
