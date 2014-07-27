<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{

           // $hash = Security::HashPassword($this->password);
            $login = Login::model()->find('Email = :email', array('email'=>$this->username));
        
            if (!isset($login)) 
            {
                $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
            }
            else
            {
                //make sure the login is enabled
                if($login->isEnabled == 0)
                {
                    $this->errorMessage = 'Your login is disabled!';
                    return !self::ERROR_UNKNOWN_IDENTITY;
                }
                
              
                
                //make sure the passwords match
                if(!Security::ComparePassword($this->password, $login->Password)) 
                {
                    $this->errorMessage = 'Incorrect password!';
                    return !self::ERROR_PASSWORD_INVALID;
                }
                        
                //no issues, load the information
                $this->setState('primaryKey', $login->primaryKey);
                $login->DateLogin = new CDbExpression('NOW()');
                $login->save();
                Yii::app()->user->returnUrl=array('login/index');
                $this->errorCode = self::ERROR_NONE;
            }
            
            return !$this->errorCode;
            
	}
}