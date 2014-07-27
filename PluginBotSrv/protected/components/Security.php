<?php

/**
 * Class controls security of the site
 */
class Security
{
    /**
     * Hashes a password
     * @param string $Password
     * @return string
     */
    public static function HashPassword($Password)
    {
        return hash('sha256', $Password);
    }
    
    /**
     * Creates a salted password and returns a hash
     * @param string $Password
     * @return string
     */
    public static function CreatePassword($Password)
    {
        return crypt($Password, Security::blowfishSalt());
    }
    
    /**
     * Compares a password against the stored / salted passwords
     * @param string $Password
     * @param string $Stored
     * @return boolean
     */
    public static function ComparePassword($Password, $Stored)
    {
        $hash = crypt($Password, $Stored);
        if(strcmp($Stored, $hash) == 0) return true;
        return false;
    }
    
    
    /**
    * Generate a random salt in the crypt(3) standard Blowfish format.
    *
    * @param int $cost Cost parameter from 4 to 31.
    *
    * @throws Exception on invalid cost parameter.
    * @return string A Blowfish hash salt for use in PHP's crypt()
    */
   public static function blowfishSalt($cost = 4)
   {
       if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
           throw new Exception("cost parameter must be between 4 and 31");
       }
       $rand = array();
       for ($i = 0; $i < 8; $i += 1) {
           $rand[] = pack('S', mt_rand(0, 0xffff));
       }
       $rand[] = substr(microtime(), 2, 6);
       $rand = sha1(implode('', $rand), true);
       $salt = '$2a$' . sprintf('%02d', $cost) . '$';
       $salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));
       return $salt;
   }
   
       /**
     * Returns the Account ID
     * @return int
     */
     public static function getAccountID()
     {
        if(Yii::app()->user->isGuest) return 0;
        
        return Yii::app()->user->getState('accountid',0);
     }
     
     /**
     * Returns the Login ID
     * @return int
     */
     public static function getUserID()
     {
        if(Yii::app()->user->isGuest) return 0;
        
        return Yii::app()->user->getState('primaryKey',0);
     }
    
     /**
     * Returns the Login ID
     * @return int
     */
     public static function isAdmin()
     {
        if(Yii::app()->user->isGuest) return false;
        
        return Login::model()->findByPk(Security::getUserID())->isAdmin == 0 ? true : false;
     }
     
    /**
     * Hides the admin area from non admins
     * @param type $IPOnly
     * @throws CHttpException
     */
    public static function SiteAdminCheck($IPOnly = false)
    {
        //check to see if it is an valid IP
        $ip = $_SERVER['REMOTE_ADDR'];
        $cntCriteria = new CDbCriteria();
        $cntCriteria->condition = "IPAddress = :ip";
        $cntCriteria->params[':ip'] = $ip;
        $Count = SiteAdmin::model()->count($cntCriteria);
        
        if($Count < 1) throw new CHttpException(404,'The requested page does not exist.');
        
        if($IPOnly) return;
        
        if(Security::isSiteAdmin() == 0) throw new CHttpException('Access Denied','You are not allowed access to this area.');
    }
    
    /**
     *Determines if the user is a site admin
     * @return int
     */
     public static function isSiteAdmin()
     {
        if(Yii::app()->user->isGuest) return 0;
        
        return Yii::app()->user->getState('siteadmin',0);
     }
     
     /**
     * Generates a Install Code for devices
     * @param string $Account
     * @param string $Device
     * @return string
     */
    public static function getInstallCode($Account, $Device)
    {
        return $Account . '-' . $Device . '-' . strtoupper(substr(Security::HashPassword($Account . $Device), 1, 4));
    }
    
     /**
     * Generates a Install Code for devices
     * @param string $Device
     * @return string
     */
    public static function getAccountInstallCode($Device)
    {
        $Account = Security::getAccountID();
        return $Account . '-' . $Device . '-' . strtoupper(substr(Security::HashPassword($Account . $Device), 1, 4));
    }
    
    /**
     * Determines if an install code is valid
     * @param string $code
     * @return boolean
     */
    public static function isInstallCodeValid($code)
    {
        if(strpos($code, '-') > 0)
        {
            $arr = split('-', $code);
            if(isset($arr[2]))
            {
                $account = $arr[0];
                $device = $arr[1];
                $testcode = Security::getInstallCode($account, $device);
 
                if($code == $testcode)
                {
                    return true;
                }
                
            }
        }
        
        return false;  
    }
     
    /**
     * Returns an array with the install code parts
     * @param string $code
     * @return array
     * @throws Exception
     */
    public static function getInstallCodeArray($code)
    {
        $arr = split('-', $code);
        if(!Security::isInstallCodeValid($code)) throw new Exception ('Invalid security code');
        
        $ret  = array();
        $ret['account'] = $arr[0];
        $ret['device'] = $arr[1];
        $ret['hash'] = $arr[2];
        
        return $ret;
    }
    
     
   /**
     * Generates a password recovery link
     * @param Login $model
     */
    public static function PasswordRecoveryLink($model)
    {
        $date = new DateTime();
        $date->modify('+24 hour');
        $expire = $date->format('Y-m-d H:i:s');

        $user = $model->primaryKey;
        $account = $model->AccountID;
        $string  = base64_encode($account . '|' . $user . "|" . $expire);
            
        echo CHtml::link('recover password', Yii::app()->createAbsoluteUrl('site/password', array('key'=>$string)));
    }
}



?>
