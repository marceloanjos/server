<?php

class EmailMessages
{
    /**
     * Sends the registration email
     * @param Users $model
     */
    public static function SendRegistration($model)
    {
        //send the validation email
        $message = new YiiMailMessage;
        $message->view = 'emailvalidation';
        $message->setBody(array('model' => $model,), 'text/html');
        $message->addTo($model->Email);
        $message->from = Yii::app()->params['adminEmail'];
        $message->subject = Yii::app()->name . " registration";
        $numsent = Yii::app()->mail->send($message);
    }
    
     /**
     * Sends email from the contact page to the admin account
     * @param ContactForm $model
     */
    public static function SendContact($model)
    {
        //send the validation email
        $message = new YiiMailMessage;
        $message->setBody($model->body);
        $message->addTo(Yii::app()->params['adminEmail']);
        $message->from = $model->email;
        $message->subject = Yii::app()->name . ' - ' . $model->subject;
        $numsent = Yii::app()->mail->send($message);
    }
    
    
     /**
     * Sends the password recovery email
     * @param RecoverPassword $model
     */
    public static function SendPasswordRecovery($model)
    {
        //send the validation email
        $message = new YiiMailMessage;
        $message->view = 'passwordrecovery';
        $message->setBody(array('model' => $model,), 'text/html');
        $message->addTo($model->Email);
        
        $message->from = Yii::app()->params['adminEmail'];
        $message->subject = Yii::app()->name  . " password recovery";
        $numsent = Yii::app()->mail->send($message);
    }
    
    
    public static function SendTest()
    {
        //send the validation email
        $model = Login::model()->find('Email = :email', array(':email'=>'bcairns@voidrealms.com'));
        $message = new YiiMailMessage;
        $message->view = 'passwordrecovery';
        $message->setBody(array('model' => $model,), 'text/html');
        $message->addTo($model->Email);
        
        $message->from = Yii::app()->params['adminEmail'];
        $message->subject = Yii::app()->params['siteName'] . " password recovery";
        $numsent = Yii::app()->mail->send($message);
        
        
        echo 'Body - ' . var_dump($message->Body).'<br>';
        echo 'to - ' . var_dump($message->To) .'<br>';
        echo 'from - ' . var_dump($message->From).'<br>';
        echo 'subject - ' . $message->Subject . '<br>';
        
        Yii::app()->end();
    }
    
    
}

?>
