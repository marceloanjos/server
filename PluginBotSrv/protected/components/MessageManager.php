<?php

/**
 * The MessageManager classes reads requests and generates responses
 */
class MessageManager
{
    /**
     * Reads the XML and processes the request
     * @param string $Request
     */
    public function ReadRequest($Request)
    {
        $message = new Message(NULL);
        try
        {
            //parse the request and get a message object
            $message = new Message($Request);

            //process the request
            $this->ProcessRequest($message);

            //get the response
            return $this->GetResponse($message);
        }
        catch(Exception $e)
        {
            $message->ErrorCode = Message::ERROR_UNKNOWN;
            $message->Response = $e->getMessage();
            return $this->GetResponse($message);
        }

    }
    

    /**
     * Process the Request and generate a response
     * @param Message $Message
     */
    public function ProcessRequest(&$Message)
    {
         switch(strtolower($Message->Request))
            {
                case '';
                     $this->ProcessNoData($Message);
                    break;
                case 'test': //test message
                    $this->ProcessTest($Message);
                    break;
                
                case 'code': //install a device or reinstall a device
                    $this->ProcessCode($Message);
                    break;
                
                case 'install': //install a device or reinstall a device
                    $this->ProcessInstall($Message);
                    break;
                
                case 'uninstall': //uninstall
                    $this->ProcessUninstall($Message);
                    break;
                
                case 'update': //update a device
                    $this->ProcessUpdate($Message);
                    break; 
                
               case 'client';
                     $this->ProcessClient($Message);
                    break; 
                
                default:
                    $this->ProcessUnknown($Message);
                    break;
            }
    }


    /**
     * Writes the Message as an XML string
     * @param Message $Message
     */
    public function GetResponse($Message)
    {
        return $Message->ToXML();
    }
    
    
    /**
     * Deletes any logs over the allowed amount
     * @param Message $Message 
     * @param string $Name
     * @param string $Description
     * @throws Exception
     */
    private function AddLog(&$Message, $Name, $Description)
    {

           //Add a device log
        $log = new Log();
        $log->DeviceID = $Message->Device;
        $log->IPAddress = $_SERVER['REMOTE_ADDR'];
        $log->EventDate = ModelHelper::getDate();
        $log->Name = $Name;
        $log->Description = $Description;
        if (!$log->save()) throw new Exception('Device log could not be saved!', Message::ERROR_UNKNOWN);

        //remove the logs that are over the limit
        $logs = Log::model()->findAll('DeviceID = :device',array(':device'=>$Message->Device),array('order'=>'idLog desc'));
        
        $limit = 1000;
        $count = count($logs);
    
        if($count > $limit) 
        {
            $rowid = $count - $limit;
            Log::model()->deleteAll('DeviceID = :device AND idLog < :loglimit',array(':device'=>$Message->Device,':loglimit'=>$logs[$rowid]->idLog),array('order'=>'idLog desc'));
        }

    }
    
     /**
     * Process the TEST request
     * @param Message $Message
     */
    private function ProcessNoData(&$Message)
    {
        $Message->ErrorCode = Message::ERROR_NO_DATA;
        $Message->Response = 'No request type or data in command, did you include a request=';
    }
    
     /**
     * Process the TEST request
     * @param Message $Message
     */
    private function ProcessUnknown(&$Message)
    {
        $Message->ErrorCode = Message::ERROR_UNKNOWN;
        $Message->Response = 'Unknown command';
    }
    
    /**
     * Process the TEST request
     * @param Message $Message
     */
    private function ProcessTest(&$Message)
    {
        $Message->Response = "This is a test!";
    }
    
    /**
     * Returns the install code
     * @param Message $Message
     */
    private function ProcessCode(&$Message)
    {
        try
        {
            if(!isset($Message->RequestElement->code))  throw new Exception('No join element in xml!',Message::ERROR_XML);
            if(!isset($Message->RequestElement->code['email']))  throw new Exception('No email attribute in join element in xml!',Message::ERROR_XML);
            if(!isset($Message->RequestElement->code['password']))  throw new Exception('No password attribute in code element in xml!',Message::ERROR_XML);
           
            $Email = (string)$Message->RequestElement->code['email'];
            $Password = base64_decode((string)$Message->RequestElement->code['password']);

           
            //verify the values
            $login = Login::model()->find('Email = :email', array('email'=>$Email));
            if(!isset($login)) throw new Exception('Invalid email!!',Message::ERROR_INVALID_EMAIL);
            
            //get the password
            if(!Security::ComparePassword($Password, $login->Password)) throw new Exception('Passwords do not match!',Message::ERROR_INVALID_PASSWORD);
            
            //generate an install code
            $Message->Code = Security::getInstallCode(0, 0);
            
            //Set the response
            $Message->Response = "Code generated";
            
            
        }
        catch(Exception $e)
        {
            $Message->ErrorCode = $e->getCode();
            $Message->Response = $e->getMessage();
        }
    }
    
    
    /**
     * Installs a device
     * @param Message $Message
     */
    private function ProcessInstall(&$Message)
    {
        $transaction = Yii::app()->db->beginTransaction();
        try
        {

          
           //get the OS
           if(!isset($Message->RequestElement->install['os']))  throw new Exception('No OS attribute in install element in xml!',Message::ERROR_XML);
           $os = OperatingSystem::model()->find('Name = :name',array(':name'=>$Message->RequestElement->install['os']));
           if(!isset($os)) $os = OperatingSystem::model()->find('Name = :name',array(':name'=>'Unknown'));
           if(!isset($os)) throw new Exception ('Operating System Could not be determined!', Message::ERROR_UNKNOWN);
               
           if(!isset($Message->RequestElement->install['bits']))  throw new Exception('No bits attribute in install element in xml!',Message::ERROR_XML);
           $bits = $Message->RequestElement->install['bits'];

           $device = NULL;
           
           //install or resinstall
           if($Message->Device == 0)
           {
               //new device
               $device = new Device();

                $device->OperatingSystemID = $os->primaryKey;
                $device->Bits = (int)$bits;
                $device->Name = $os->Name . ' Device';
                $device->IPAddress = $_SERVER['REMOTE_ADDR'];
                $device->DateInstalled = ModelHelper::getDate();
                $device->DateUpdated = ModelHelper::getDate();
                $device->DateMissing = NULL;
                $device->UpdateInterval = 60;
                $device->isMissing = 0;
                $device->Description = 'A new device.';
                $Message->Response = "Device installed!";
                
                

           }
           else
           {
               //reinstall device
               $device = Device::model()->find('idDevice = :device', array(':device'=>$Message->Device));
               if(!isset($device))  throw new Exception ('Device not found!', Message::ERROR_INVALID_DEVICE);
               
               //update the device properties
                $device->OperatingSystemID = $os->primaryKey;
                $device->Bits = (int)$bits;
                $device->IPAddress = $_SERVER['REMOTE_ADDR'];
                $device->DateInstalled = ModelHelper::getDate();
                $device->DateUpdated = ModelHelper::getDate();
                $device->DateMissing = NULL;
                $device->UpdateInterval = 60;
                $device->isMissing = 0;
                $Message->Response = "Device reinstalled!";
           }
           
           if(!$device->validate()) throw new Exception ('Device could not be validated!', Message::ERROR_UNKNOWN);
           if(!$device->save()) throw new Exception ('Device could not be saved!', Message::ERROR_UNKNOWN);
            
            //generate an install code
            $Message->Account = 0;
            $Message->Device = $device->primaryKey;
            $Message->Code = Security::getInstallCode(0,$device->primaryKey);
            
            
            $this->AddLog($Message, 'Installed', 'Device was installed.');
            
            //Commit the transaction
            $transaction->commit();
            
        }
        catch(Exception $e)
        {
            $transaction->rollback();
            $Message->ErrorCode = $e->getCode();
            $Message->Response = $e->getMessage();
        }
    }
    
    
    /**
     * Uninstalls a device
     * @param Message $Message
     */
    private function ProcessUninstall(&$Message)
    {
        try
        {

           
           //get the device and make sure it is valid
           $device = Device::model()->find('idDevice = :device',array(':device'=>$Message->Device));
           if(!isset($device)) throw new Exception ('Device does not exist!', Message::ERROR_INVALID_DEVICE);
            
           //delete the device
           if(!$device->delete()) throw new Exception ('Device could not be deleted!', Message::ERROR_UNKNOWN);
           
            //Set the response
            $Message->Response = "Device uninstalled!";
            
            
        }
        catch(Exception $e)
        {
            $Message->ErrorCode = $e->getCode();
            $Message->Response = $e->getMessage();
        }
    }
    
     /**
     * Uninstalls a device
     * @param Message $Message
     */
    private function ProcessUpdate(&$Message)
    {
        $transaction = Yii::app()->db->beginTransaction();
        
        try
        {

           
           //get the device and make sure it is valid
           $device = Device::model()->find('idDevice = :device',array(':device'=>$Message->Device));
           if(!isset($device)) throw new Exception ('Device does not exist!', Message::ERROR_INVALID_DEVICE);
            
           //Send any updates
            $device->IPAddress = $_SERVER['REMOTE_ADDR'];
            $device->DateUpdated = ModelHelper::getDate();
            if($device->DateInstalled == NULL) $device->DateInstalled = ModelHelper::getDate();
           
           //save the changes
           if(!$device->save()) throw new Exception ('Device could not be saved!', Message::ERROR_UNKNOWN);
            
           //Set the device information 
           $Message->DeviceInfo['id'] = $device->primaryKey;
           $Message->DeviceInfo['name'] = $device->Name;
           $Message->DeviceInfo['os'] = $device->operatingSystem->Name;
           $Message->DeviceInfo['bits'] = $device->Bits;
           $Message->DeviceInfo['ipaddress'] = $device->IPAddress;
           $Message->DeviceInfo['dateupdated'] = ModelHelper::getCurrentFormattedDate();
           $Message->DeviceInfo['ismissing'] = $device->isMissing;
           $Message->DeviceInfo['datemissing'] = $device->DateMissing;
           $Message->DeviceInfo['updateinterval'] = $device->UpdateInterval;
           
           //Add a log
           $this->AddLog($Message, 'Update', 'Device was updated.');
           
          //get the groups that the devices belong to
           $groups = GroupDevice::model()->findAll('DeviceID = :device',array(':device'=>$device->primaryKey));

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
            
            //build the plugin list
           foreach($plugins as $plugin)
           {
               $items = PluginItem::model()->findAll('PluginID = :plugin',array(':plugin'=>$plugin->plugin->primaryKey));
               $Message->PluginInfo['plugin-'.$plugin->primaryKey]['name'] = $plugin->plugin->Name;
               $Message->PluginInfo['plugin-'.$plugin->primaryKey]['id'] = $plugin->plugin->primaryKey;
               $Message->PluginInfo['plugin-'.$plugin->primaryKey]['filename'] = $plugin->plugin->pluginFile->Name;
               $Message->PluginInfo['plugin-'.$plugin->primaryKey]['fileurl'] =   $plugin->plugin->pluginFile->URL;
               $Message->PluginInfo['plugin-'.$plugin->primaryKey]['fileid'] = $plugin->plugin->pluginFile->primaryKey;
               $Message->PluginInfo['plugin-'.$plugin->primaryKey]['version'] = $plugin->plugin->pluginFile->Version;
               $Message->PluginInfo['plugin-'.$plugin->primaryKey]['os'] = $plugin->plugin->pluginFile->operatingSystem->Name;
               $Message->PluginInfo['plugin-'.$plugin->primaryKey]['bits'] = $plugin->plugin->pluginFile->Bits;
               
               foreach($items as $item)
               {
                   
                   $Message->PluginInfo['plugin-'.$plugin->primaryKey]['item-'.$item->primaryKey]['id'] = $item->primaryKey;
                   $Message->PluginInfo['plugin-'.$plugin->primaryKey]['item-'.$item->primaryKey]['name'] = $item->pluginOption->Name;
                   $Message->PluginInfo['plugin-'.$plugin->primaryKey]['item-'.$item->primaryKey]['type'] = $item->pluginOption->valueType->Name;
                   $Message->PluginInfo['plugin-'.$plugin->primaryKey]['item-'.$item->primaryKey]['default'] = $item->pluginOption->Default;
                   $Message->PluginInfo['plugin-'.$plugin->primaryKey]['item-'.$item->primaryKey]['value'] = $item->Value;
               }
               
           }
           
           //build the policy list
           foreach($policies as $policyrec)
           {
              
               $policy = $policyrec->policy;
               
               
               //load the policy information
               $Message->PolicyInfo['policy-'.$policy->primaryKey]['id'] = $policy->primaryKey;
               $Message->PolicyInfo['policy-'.$policy->primaryKey]['name'] = $policy->Name;
             
               //load the trigger1 information
               $Message->PolicyInfo['policy-'.$policy->primaryKey]['trigger1']['id'] = $policy->policyTrigger->primaryKey;
               $Message->PolicyInfo['policy-'.$policy->primaryKey]['trigger1']['name'] = $policy->policyTrigger->Name;
               $Message->PolicyInfo['policy-'.$policy->primaryKey]['trigger1']['type'] = $policy->policyTrigger->valueTypeID1->Name;
               $Message->PolicyInfo['policy-'.$policy->primaryKey]['trigger1']['value'] = $policy->TriggerValue1;
               $Message->PolicyInfo['policy-'.$policy->primaryKey]['trigger1']['label'] = $policy->policyTrigger->Label1;
               
               
               //load the action1 information
               if($policy->policyAction->hasValue1)
               {
                    $Message->PolicyInfo['policy-'.$policy->primaryKey]['action1']['id'] = $policy->policyAction->primaryKey;
                    $Message->PolicyInfo['policy-'.$policy->primaryKey]['action1']['name'] = $policy->policyAction->Name;
                    $Message->PolicyInfo['policy-'.$policy->primaryKey]['action1']['label'] = $policy->policyAction->Label1;     
                    $Message->PolicyInfo['policy-'.$policy->primaryKey]['action1']['type'] = $policy->policyAction->valueTypeID1->Name;
                    $Message->PolicyInfo['policy-'.$policy->primaryKey]['action1']['value'] = $policy->ActionValue1;
               }
               
               //load the action2 information
               if($policy->policyAction->hasValue2)
               {
                    $Message->PolicyInfo['policy-'.$policy->primaryKey]['action2']['id'] = $policy->policyAction->primaryKey;
                    $Message->PolicyInfo['policy-'.$policy->primaryKey]['action2']['name'] = $policy->policyAction->Name;
                    $Message->PolicyInfo['policy-'.$policy->primaryKey]['action2']['label'] = $policy->policyAction->Label2;                
                    $Message->PolicyInfo['policy-'.$policy->primaryKey]['action2']['type'] = $policy->policyAction->valueTypeID2->Name;
                    $Message->PolicyInfo['policy-'.$policy->primaryKey]['action2']['value'] = $policy->ActionValue2;
               }
           }
            
           
            //Set the response
            $Message->Response = "Device Updated!";
            
            //Commit the transaction
            $transaction->commit();
            
        }
        catch(Exception $e)
        {
            $transaction->rollback();
            $Message->ErrorCode = $e->getCode();
            if($Message->ErrorCode <= 0) $Message->ErrorCode = Message::ERROR_UNKNOWN;
            $Message->Response = $e->getMessage();
        }
    }
    
     /**
     * Process the client request
     * @param Message $Message
     */
    private function ProcessClient(&$Message)
    {
        try
        {
           
           $Message->ClientInfo['id'] = 0;
           $Message->ClientInfo['os'] = 'Unknown';
           $Message->ClientInfo['bits'] = 32;
           $Message->ClientInfo['url'] = 'None';
           $Message->ClientInfo['name'] = 'None';
           $Message->ClientInfo['version'] = '0';
           $Message->ClientInfo['released'] = 'None';
           
        }
        catch(Exception $e)
        {
            $Message->ErrorCode = $e->getCode();
            $Message->Response = $e->getMessage();
        }
    }
}
