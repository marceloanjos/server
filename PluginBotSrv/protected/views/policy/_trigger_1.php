<?php
/* @var $this PolicyController */
/* @var $model Policy */
/* @var $policy PolicyForm */
/* @var $form CActiveForm */

$form = new CActiveForm();
?>
<?php if(isset($policy) && isset($model)): ?>

<div class="form-area">
    <b><?php echo $policy->Title; ?></b>
    <br>
    <?php echo $policy->Description; ?>
            <div class="row">
            
                <?php
                if($policy->HasValue == 1)
                {
                    echo '<br>';
                    echo $form->labelEx($model, $policy->Name);
                        
                    switch(strtoupper($policy->ValueType))
                   {
                       case 'DATE':
                           //echo $form->dateField($model, $policy->FieldName, array('value'=>$policy->Value));
                            $Default = date('Y-m-d');
                           if($policy->Value == '') $policy->Value = $Default;
                           
                            Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                            $this->widget('CJuiDateTimePicker',array(
                                   'model'=>$policy, //Model object
                                   'attribute'=>'Value', //attribute name
                                   'name'=> get_class($model) . '[' . $policy->FieldName . ']',
                                   'id'=> get_class($model) . '_' . $policy->FieldName,
                                   'mode'=>'date', //use "time","date" or "datetime" (default)
                                   'options'=>array('dateFormat'=>'yy-mm-dd', 'timeFormat'=>'hh:mm:ss'), // jquery plugin options
                                   'language' => '',
                                   'value'=>$policy->Value,
                               ));
                           
                           break;

                       case 'TIME':
                          // echo $form->timeField($model, $policy->FieldName, array('value'=>$policy->Value));
                            $Default = date('H:i:s');
                           if($policy->Value == '') $policy->Value = $Default;
                           
                            Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                            $this->widget('CJuiDateTimePicker',array(
                                   'model'=>$policy, //Model object
                                   'attribute'=>'Value', //attribute name
                                   'name'=> get_class($model) . '[' . $policy->FieldName . ']',
                                   'id'=> get_class($model) . '_' . $policy->FieldName,
                                   'mode'=>'time', //use "time","date" or "datetime" (default)
                                   'options'=>array('dateFormat'=>'yy-mm-dd', 'timeFormat'=>'hh:mm:ss'), // jquery plugin options
                                   'language' => '',
                                   'value'=>$policy->Value,
                               ));
                           
                           break;
                       
                       case 'DATETIME':
                          // echo $form->timeField($model, $policy->FieldName, array('value'=>$policy->Value));
                            $Default = date('Y-m-d H:i:s');
                           if($policy->Value == '') $policy->Value = $Default;
                           
                            Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                            $this->widget('CJuiDateTimePicker',array(
                                   'model'=>$policy, //Model object
                                   'attribute'=>'Value', //attribute name
                                   'name'=> get_class($model) . '[' . $policy->FieldName . ']',
                                   'id'=> get_class($model) . '_' . $policy->FieldName,
                                   'mode'=>'datetime', //use "time","date" or "datetime" (default)
                                   'options'=>array('dateFormat'=>'yy-mm-dd', 'timeFormat'=>'hh:mm:ss'), // jquery plugin options
                                   'language' => '',
                                   'value'=>$policy->Value,
                               ));
                           
                           break;

                       case 'NUMBER':
                           echo $form->numberField($model, $policy->FieldName, array('value'=>$policy->Value));
                           break;

                       case 'FILE':
                           echo $form->fileField($model, $policy->FieldName, array('value'=>$policy->Value));
                           break;

                       case 'PLUGIN':
                           echo 'set plugin picker';
                           break;

                       default:
                           echo $form->textField($model, $policy->FieldName, array('size' => 60, 'maxlength' => 255,'value'=>$policy->Value));

                   }
                }
                else
                {
                    echo '<br>(There are no additional options available.)';
                }

                
                ?>
 
        </div> 
</div>
<br>
<?php endif; ?>
