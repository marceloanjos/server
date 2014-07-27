<?php
/* @var $this PluginController */
/* @var $model PluginFile */

//exiting options
$options = PluginOption::model()->findAll('PluginFileID = :plugin',array(':plugin'=>$model->primaryKey));
//echo var_dump($options);

foreach($options as $option)
{
    echo '<br><div class="form-areapart">';
 
    
    
    //Add the Name input
    echo '<b>Name<b><br><input size="60" maxlength="255" name="Option-' . $option->primaryKey . '[Name]" type="text" value="' . $option->Name . '" /><br>';
    
    //Add the Type input
    echo '<b>Type<b><br>';
    echo CHtml::dropDownList('Option-' . $option->primaryKey . '[ValueType]', $option->ValueTypeID, CHTML::listData(ValueType::model()->findAll(array('order'=>'Name')), 'idValueType', 'Name'));
    echo '<br>';
    
    //Add the Default input
    echo '<b>Default<b><br><input size="60" maxlength="255" name="Option-' . $option->primaryKey . '[Default]" type="text" value="' . $option->Default . '" /><br>';
    
     //Add the Description input
    echo '<b>Description<b><br><input size="60" maxlength="255" name="Option-' . $option->primaryKey . '[Description]" type="text" value="' . $option->Description . '" /><br>';
    
    
    //add the delete link
    //add 'confirm'=>'Are you sure you want to delete this item?'
    echo CHtml::ajaxButton ("Remove Option",
        CController::createUrl('plugin/removeoption',array('id'=>$model->primaryKey, 'optionid'=>$option->primaryKey, )), 
        array('update' => '#data',),array('id' => 'remove-link-'.uniqid(),'confirm'=>'Are you sure you want to delete this item? Any unsaved work will be lost!'));
    
    echo '</div>';
}

?>
 <br><br>
 <?php 
    echo CHtml::ajaxButton ("Add Option",
        CController::createUrl('plugin/addoption',array('id'=>$model->primaryKey)), 
        array('update' => '#data',),array('id' => 'add-link-'.uniqid()));
    ?>
