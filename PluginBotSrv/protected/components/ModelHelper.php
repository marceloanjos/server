<?php

/**
 * Has functions to help models
 */
class ModelHelper
{
    /**
     * Returns 30 days from now
     * @return Datetime
     */
    public static function getExpireDate()
    {
        //Expire Date is 30 days from now
        $date = new DateTime();
        $date->modify('+1 month');
        return $date->format('Y-m-d H:i:s');
    }
    
    /**
     * Returns the curret date and time
     * @return CDbExpression
     */
    public static function getDate()
    {
        return new CDbExpression('NOW()');
    }
    
    /**
     * Returns a formatted date and time
     * @param type $date
     * @return type
     */
    public static function getFormattedDate($date)
    {
        return date_format(new DateTime($date), 'm-d-Y H:m:s');
    }
    
    /**
     * Returns the current date
     */
    public static function getCurrentFormattedDate()
    {
        return date_format(new DateTime(), 'm-d-Y H:m:s');
    }
    
     /**
     * Get the rating
     * @param bigint $score
     * @param bigint $votes
     * @return type
     */
    public static function Rating($score, $votes)
    {
        if($score == 0 || $votes == 0) return 0;
        
        $ret = $score /  $votes;
        if($ret > 5) $ret = 5;
         return $ret;
    }
    
    /**
     * Round a number ot the nearest 0.5 
     * @param bigint $score
     * @param bigint $votes
     * @return type
     */
    public static function RoundRating($score, $votes)
    {
        if($score == 0 || $votes == 0) return 0;
        
        $rating = $score /  $votes;
        $ret = round($rating * 2) / 2;
        if($ret > 5) $ret = 5;
        
         return $ret;
    }
}

?>
