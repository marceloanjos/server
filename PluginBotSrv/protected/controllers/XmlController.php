<?php

class XmlController extends Controller
{
	public function actionIndex()
	{
            header("Content-type: text/xml");
            $Manager = new MessageManager();
            $xml = "";
            
            if(!isset($_POST['request']))
            {
                //echo "Post Request not set";
                $xml = $Manager->ReadRequest('');
                
            }
            else
            {
                //echo "Sending to Message Manager";
                $xml = $Manager->ReadRequest($_POST['request']);

            }
  
             echo $xml;
             Yii::app()->end();
	}
}