<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
            
            //See if there are any logons
            $numLogins = Login::model()->count();
            if($numLogins == 0)
            {
                $this->showWizard();
            }
            else
            {
                $this->showLogin();
            }
            
	}
        
        /**
         * The setup wizard
         */
        public function showWizard()
        {
            
                $model= new Login;
                $logonform = new LoginForm();
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Login']))
		{
                    
			$model->attributes=$_POST['Login'];
                        $logonform->username = $model->Email;
                        $logonform->rememberMe = false;
                        $logonform->password = $model->Password;
                        $model->Password = Security::CreatePassword($model->Password);
                        $model->DateLogin = ModelHelper::getDate();
                        $model->isEnabled=1;
                        
                        //Verify we can save the login
                        if($model->save() && $logonform->login())
                        {
                            $this->redirect(Yii::app()->user->returnUrl);
                        }
				
		}

		$this->render('wizard',array(
			'model'=>$model,
		));
             
             
             
        }
        
        public function showLogin()
        {
            
             
            	$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			
                        //check to see if the account is expired
                        if($model->validate() && $model->login())
                        {
                           $this->redirect(Yii::app()->user->returnUrl); 
                        }
				
		}
                
		// display the login form
		$this->render('index',array('model'=>$model));
             
             
        }
        
        /**
	 * The terms of service
	 */
	public function actionTos()
	{
		$this->render('tos');
	}
        
        /**
	 * The legal stuff
	 */
	public function actionLegal()
	{
		$this->render('legal');
	}
        
        /**
	 * The privacy stuff
	 */
	public function actionPrivacy()
	{
		$this->render('privacy');
	}
        
        /**
	 * The support
	 */
	public function actionSupport()
	{
		$this->render('support');
	}
        
        /**
	 * The eula stuff
	 */
	public function actionEula()
	{
		$this->render('eula');
	}
        
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}