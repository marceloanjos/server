<?php
/**
 * Description of FormHelper
 *
 * @author Bryan Cairns
 */
class FormHelper
{

    //Renders a field based on the value type
    public static function RenderField($name, $value, $valuetype, $controller, $model, $form, $default = '')
    {

        
        switch (strtoupper($valuetype))
        {
            case 'DATE':
                $default = date('Y-m-d');
                if(strlen($value) == 0) $value = $default;
                Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                $controller->widget('CJuiDateTimePicker', array(
                    'model' => $model, //Model object
                    'attribute' => $name, //attribute name
                    'name' => get_class($model) . '[' . $name . ']',
                    'id' => get_class($model) . '_' . $name,
                    'mode' => 'date', //use "time","date" or "datetime" (default)
                    'options' => array('dateFormat' => 'yy-mm-dd', 'timeFormat' => 'hh:mm:ss'), // jquery plugin options
                    'language' => '',
                    'value' => $value,
                    'htmlOptions'=>array('value'=>$value),
                ));
                break;

            case 'TIME':
                $default = date('H:i:s');
                if(strlen($value) == 0) $value = $default;
                Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                $controller->widget('CJuiDateTimePicker', array(
                    'model' => $model, //Model object
                    'attribute' => $name, //attribute name
                    'name' => get_class($model) . '[' . $name . ']',
                    'id' => get_class($model) . '_' . $name,
                    'mode' => 'time', //use "time","date" or "datetime" (default)
                    'options' => array('dateFormat' => 'yy-mm-dd', 'timeFormat' => 'hh:mm:ss'), // jquery plugin options
                    'language' => '',
                    'value' => $value,
                    'htmlOptions'=>array('value'=>$value),
                ));
                break;

            case 'DATETIME':
                $default = date('Y-m-d H:i:s');
                if(strlen($value) == 0) $value = $default;
                Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                $controller->widget('CJuiDateTimePicker', array(
                    'model' => $model, //Model object
                    'attribute' => $name, //attribute name
                    'name' => get_class($model) . '[' . $name . ']',
                    'id' => get_class($model) . '_' . $name,
                    'mode' => 'datetime', //use "time","date" or "datetime" (default)
                    'options' => array('dateFormat' => 'yy-mm-dd', 'timeFormat' => 'hh:mm:ss'), // jquery plugin options
                    'language' => '',
                    'value' => $value,
                    'htmlOptions'=>array('value'=>$value),
                ));

                break;

            case 'NUMBER':
                $default = 0;
                if(strlen($value) == 0) $value = $default;
                echo $form->numberField($model, $name, array('value' => $value));
                break;
            case 'IPMASK':
                $default = '192.168.1.*';
                if(strlen($value) == 0) $value = $default;
                echo $form->textField($model, $name, array('value' => $value));
                break;
                
            case 'FILE':
                if(strlen($value) == 0) $value = $default;
                echo $form->fileField($model, $name, array('value' => $value));
                break;

            case 'PLUGIN':
                if(strlen($value) == 0) $value = $default;

                echo CHtml::dropDownList(
                        get_class($model) . '[' . $name . ']', 
                        $name, 
                        //CHTML::listData(PluginFile::model()->findAll(array('order'=>'Name')), 'idPluginFile', 'Name'), 
                        CHTML::listData(Plugin::model()->findAll(array('order'=>'Name')), 'idPlugin', 'Name'), 
                        array('prompt' => 'Select a Plugin','options' => array($value=>array('selected'=>true)),
                      
                        ));
                
                break;

            default:
                if(strlen($value) == 0) $value = $default;
                echo $form->textField($model, $name, array('size' => 60, 'maxlength' => 255, 'value' => $value));
        }
         
    }
    
    public static function RenderBitsField($name, $form, $model)
    {
        $array = array('0' => 'Unknown','32' => '32 Bits', '64' => '64 Bits');
        echo $form->dropDownList($model,$name,$array,array('options' => array( $model[$name]=>array('selected'=>true))));
    }

}

?>
