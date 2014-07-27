<?php

/**
 * The Message class represents a client message
 * 
 * At a minimum a message should contain
 * Version - the client version
 * Code - this is the device code
 * Type - this is the request type {test|join|install|reinstall|uninstall|update}
 * Extra Elements are added based on the type <join email="" password ="">
 * 
 * Example message
 * <?xml version="1.0" ?>
 * <message version="1" code="1-2-CODE" request="join" >
 * <join email="me@home.com" password="password" />
 * </message>
 */
class Message
{

    //The error codes
    const ERROR_NONE = 0;
    const ERROR_UNKNOWN = 1;
    const ERROR_XML = 2;
    const ERROR_INVALID_VERSION = 3;
    const ERROR_LOGIN_EXISTS = 4;
    const ERROR_ACCOUNT_DISABLED = 5;
    const ERROR_MAX_DEVICE_LIMIT = 6;
    const ERROR_INVALID_EMAIL = 7;
    const ERROR_INVALID_PASSWORD = 8;
    const ERROR_INVALID_ACCOUNT = 9;
    const ERROR_INVALID_DEVICE = 10;
    const ERROR_NO_DATA = 11;
    const ERROR_NO_CLIENT = 12;
    
    //Version information
    const MESSAGE_VERSION = 1;
    
    /**
     * The devices code
     * @var type String
     */
    public $Code = '';
    
    /**
     * The message Request
     * @var string Type of request
     */
    public $Request = '';
    
    /**
     * The version information
     * @var int Message version
     */
    public $Version = 1;
    
    /**
     * The primary key of the device
     * @var BIGINT
     */
    public $Device = 0;
    
    /**
     * The primary key of the Account
     * @var BIGINT
     */
    public $Account = 0;
    
    /**
     * The error number
     * @var int
     */
    public $ErrorCode = self::ERROR_NONE;
    
    /**
     * The request xml string
     * @var type String
     */
    public $RequestXML = '';
    
    /**
     * The Request object
     * @var SimpleXMLElement 
     */
    public $RequestElement;
    
    
    /**
     * The response xml string
     * @var String
     */
    public $Response = '';
    
     /**
     * Device information
     * @var Array
     */
    public $DeviceInfo = array();
    
     /**
     * Client information
     * @var Array
     */
    public $ClientInfo = array();
    
    /**
     * Plugin information
     * @var Array
     */
    public $PluginInfo = array();
    
    /**
     * Policy information
     * @var Array
     */
    public $PolicyInfo = array();
    
    /**
     * Defualt Constructor
     * @param string $Request (Optional) The XML request
     */
    public function Message($Request ='')
    {
        if(isset($Request) && $Request != '')
        {
            $this->RequestXML = $Request;
            $this->FromXML($Request);
        }
    }
    
    /**
     * Determines if there is an error
     * @return boolean
     */
    public function hasError()
    {
        if($this->ErrorCode > 0) return true;
        
        return false;
    }
    
   /**
    * Read the varibles from the XML request
    * @param string $Request
    */
    public function FromXML($Request)
    {
        if(!isset($this->RequestXML) || $this->RequestXML == '')
        {
            $this->ErrorCode = self::ERROR_XML;
            $this->Response = 'XML not set!';
            return;
        }
        
            libxml_use_internal_errors(true);
            $this->RequestElement = simplexml_load_string($this->RequestXML);
            if (! $this->RequestElement)
            {
                $er = "Failed loading XML: ";
                foreach(libxml_get_errors() as $error)
                {
                    $er = $er .  trim($error->message) . " ";
                }
                //throw new Exception(trim($er));
                $this->ErrorCode = self::ERROR_XML;
                $this->Response = trim($er);
                return;
            }
            
            //load the XML attributes
            if($this->hasError()) return;

            $this->Version = (String) $this->RequestElement['version'];
            $this->Request = (String) $this->RequestElement['request'];
            $this->Code = (String) $this->RequestElement['code'];
     
            //validate the code
            if(strlen($this->Code) > 0)
            {
                $tmpcode = Security::getInstallCodeArray($this->Code);
                $this->Account = $tmpcode['account'];
                $this->Device = $tmpcode['device'];
            }
            
            //parse the code
            $codeitems = split('-', $this->Code);
            if(isset($codeitems[0])) $this->Account = $codeitems[0];
            if(isset($codeitems[1])) $this->Device = $codeitems[1];
            

    }
    
  
    
    /**
     * Create an XML response from the message
     * @return string Returns an XML string
     */
    public function ToXML()
    {
  
        $xml = new SimpleXMLElement('<message/>');
        $xml->addAttribute('version', $this->Version);
        $xml->addAttribute('request', $this->Request);
        $xml->addAttribute('code', $this->Code);
        
        if($this->hasError())
        {
            $e = $xml->addChild('error');
            $e->addAttribute('number', $this->ErrorCode);
            $e->addAttribute('response', $this->Response);
        }
        else
        {
            $e = $xml->addChild('result');
            $e->addAttribute('response', $this->Response);
            
            if(isset($this->DeviceInfo) && count($this->DeviceInfo) > 0)
            {
                $d = $xml->addChild('device');
                $d->addAttribute('id', $this->DeviceInfo['id']);
                $d->addAttribute('name', $this->DeviceInfo['name']);
                $d->addAttribute('ipaddress', $this->DeviceInfo['ipaddress']);
                $d->addAttribute('dateupdated', $this->DeviceInfo['dateupdated']);
                $d->addAttribute('ismissing', $this->DeviceInfo['ismissing']);
                $d->addAttribute('datemissing', $this->DeviceInfo['datemissing']);
                $d->addAttribute('updateinterval', $this->DeviceInfo['updateinterval']);
                $d->addAttribute('os', $this->DeviceInfo['os']);
                $d->addAttribute('bits', $this->DeviceInfo['bits']);
            }
            
           
            if(isset($this->ClientInfo) && count($this->ClientInfo) > 0)
            {
                 
                $c = $xml->addChild('client');
                $c->addAttribute('id', $this->ClientInfo['id']);
                $c->addAttribute('os', $this->ClientInfo['os']);
                $c->addAttribute('bits', $this->ClientInfo['bits']);
                $c->addAttribute('url', Yii::app()->request->baseUrl . '/downloads/clients/' .$this->ClientInfo['url']);
                $c->addAttribute('name', $this->ClientInfo['name']);
                $c->addAttribute('version', $this->ClientInfo['version']);
                $c->addAttribute('released', $this->ClientInfo['released']);
                  
            }
             
            //Convert the plugin information
            if(isset($this->PluginInfo) && count($this->PluginInfo) > 0)
            {
                $ps = $xml->addChild('plugins');
                
                foreach($this->PluginInfo as $plugin)
                {
                    $p = $ps->addChild('plugin');
                    $p->addAttribute('name', $plugin['name']);  
                    $p->addAttribute('id', $plugin['id']); 
                    $p->addAttribute('filename', $plugin['filename']);  
                    $p->addAttribute('fileurl', Yii::app()->request->baseUrl . '/index.php?r=plugin/download&id=' . $plugin['fileid']);  //Yii::app()->request->baseUrl . '/downloads/plugins/' . $plugin['fileurl']);
                    $p->addAttribute('fileid', $plugin['fileid']);  
                    $p->addAttribute('version', $plugin['version']); 
                    $p->addAttribute('os', $plugin['os']);
                    $p->addAttribute('bits', $plugin['bits']);
                    
                    foreach($plugin as $pluginitem)
                    {
                        if(count($pluginitem) >= 2)
                        {
                            $pe = $p->addChild('item');
                            $pe->addAttribute('id', $pluginitem['id']); 
                            $pe->addAttribute('name', $pluginitem['name']); 
                            $pe->addAttribute('type', $pluginitem['type']); 
                            $pe->addAttribute('default', $pluginitem['default']); 
                            $pe->addAttribute('value', $pluginitem['value']); 
                        }
                          
                    }
                }
                
            }
            
            //Convert the policy information
            if(isset($this->PolicyInfo) && count($this->PolicyInfo) > 0)
            {
                $pr = $xml->addChild('policies');
                foreach($this->PolicyInfo as $policy)
                {
                   
                    
                    $po = $pr->addChild('policy');
                    $po->addAttribute('id', $policy['id']); 
                    $po->addAttribute('name', $policy['name']); 
                   // $pt = $po->addChild('triggers');
                   // $pa = $po->addChild('actions');
                    
                    //add the trigger
                    if(isset($policy['trigger1']))
                    {
                        $pt1 = $po->addChild('trigger');
                        $pt1->addAttribute('id', $policy['trigger1']['id']); 
                        $pt1->addAttribute('name1', $policy['trigger1']['name']); 
                        $pt1->addAttribute('type1', $policy['trigger1']['type']); 
                        $pt1->addAttribute('label1', $policy['trigger1']['label']); 
                        $pt1->addAttribute('value1', $policy['trigger1']['value']); 
                    }
                    
                    //add the action1
                    if(isset($policy['action1']))
                    {
                        $pa = $po->addChild('action');
                        $pa->addAttribute('id', $policy['action1']['id']); 
                        $pa->addAttribute('name1', $policy['action1']['name']); 
                        $pa->addAttribute('type1', $policy['action1']['type']); 
                        $pa->addAttribute('label1', $policy['action1']['label']); 
                        $pa->addAttribute('value1', $policy['action1']['value']); 
                        
                        if(isset($policy['action2']))
                        {
                            $pa->addAttribute('name2', $policy['action2']['name']); 
                            $pa->addAttribute('type2', $policy['action2']['type']); 
                            $pa->addAttribute('label2', $policy['action2']['label']); 
                            $pa->addAttribute('value2', $policy['action2']['value']); 
                        }
                    }
                    
                }
            }
            
        }

        
        $dom = new DOMDocument("1.0");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        $var = $dom->saveXML();

        return $var;
    }
    
}
