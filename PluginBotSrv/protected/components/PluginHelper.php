<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Plugin Helper assits in working with plugins
 */
class PluginHelper
{
    /**
     * Determines if a plugin is valid
     * @param type $Filename The plugin filename
     */
    public static function isPluginValid($Filename)
    {
        try
        {
           $zip = new ZipArchive();

            if($zip->open($Filename) == true)
            {
                 for($i = 0; $i < $zip->numFiles; $i++)
                {
                    if(strtolower($zip->getNameIndex($i)) == "plugin.xml")
                    {
                        $zip->close();
                        return true;
                    }
                }

                //close the zip file
                $zip->close();
            }

            return false;
        } 
        catch (Exception $ex)
        {
         return false;
        }
    }
    
     /**
     * Get the raw data from the plugins.xml file
     * @param type $Filename The plugin filename
     */
    public static function getPluginXML($Filename)
    {
        try
        {
           $zip = new ZipArchive();
           $ret;
            if($zip->open($Filename) == true)
            {
                //Grab the contents
                $ret = $zip->getFromName("plugin.xml");

                //close the zip file
                $zip->close();
            }
            
            return $ret;
        } 
        catch (Exception $ex)
        {
         return false;
        }
    }
    
     /**
     * Gets a PluginFile object from the xml
     * @param type $AccountID The account id
     * @param type $Filename The plugin filename
     */
    public static function getPluginFile($AccountID,$Filename)
    {
        try
        {
            /*
             * At a minimum
             * OS, Name, Description, Bits, Released, Version 
             */
           $file = new PluginFile();
        } 
        catch (Exception $ex)
        {
         return null;
        }
    }
    
    /**
     * Returns an array from the zip file containing the XML 
     * @param type $Filename
     * @return null
     */
    public static function getXMLAttributes($Filename)
    {
        $arr = array();
        try
        {
          
            if(!PluginHelper::isPluginValid($Filename)) throw new Exception("Plugin is not valid!");
           
            //Load the XML
            $xml = PluginHelper::getPluginXML($Filename);
            libxml_use_internal_errors(true);
            $ele = simplexml_load_string($xml);

            if(!$ele)
            {
                $er = '';
                foreach(libxml_get_errors() as $error)
                {
                    $er = $er .  trim($error->message) . " ";
                }
                throw new Exception($er);
            }
            

            $arr['name'] = (string)$ele[0]['name'];
            $arr['os'] = (string)$ele[0]['os'];
            $arr['bits'] = (string)$ele[0]['bits'];
            $arr['version'] = (string)$ele[0]['version'];
            $arr['authorname'] = (string)$ele[0]['authorname'];
            $arr['authoremail'] = (string)$ele[0]['authoremail'];
            $arr['short'] = (string)$ele[0]->short;
            $arr['long'] = (string)$ele[0]->long;
            
            //parse the options
            $options = array();
            foreach($ele as $key=>$value)
            {
                if(strtolower($key) == "options")
                {
                    foreach($value as $option)
                    {
                        $optionitem = array();
                       
                        $optionitem['name'] = (string)$option['name'];
                        $optionitem['type'] = (string)$option['type'];
                        $optionitem['default'] = (string)$option['default'];
                        $optionitem['description'] = (string)$option['description'];
                        
                        $options[] = $optionitem;
                        
                    }
                }
            }
            
            //Add the options item
            $arr['options'] = $options;
            
            return $arr;
        } 
        catch (Exception $ex)
        {
            $arr['error'] = $ex->getMessage();
            return $arr;
        }
    }
    
}
