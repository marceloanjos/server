<?php
/* @var $this PolicyController */
/* @var $model Plugin */
/* @var $option PluginOption */
/* @var $pluginfile PluginFile */
/* @var $plugin PluginForm */
/* @var $form CActiveForm */

$form = new CActiveForm();
$pluginfile = null;
$optionlist = '';


if(isset($model->pluginFile))
{
    //Load from the model, typically when we open the page
    $pluginfile = PluginFile::model()->FindByPk($model->PluginFileID);
}
else
{
    //load from the post, typicaly when we change files
    if(isset($_POST['PluginFileID'])) $pluginfile = PluginFile::model()->FindByPk($_POST['PluginFileID']);
}

//Load the plugin file  -this is a new item
if(isset($pluginfile)) $options = PluginOption::model()->findall('PluginFileID=:id',array(':id'=>$pluginfile->primaryKey));


?>

<?php if(isset($pluginfile)): ?>
<div class="form-area">
    <h4><?php echo CHtml::link( $pluginfile->Name,array('plugin/details', 'id'=>$pluginfile->primaryKey)); ?> </h4>
        <?php echo 'Operating System: ' . $pluginfile->operatingSystem->Name . '<br>'; ?> 
        <?php echo 'Version: ' . $pluginfile->Version . '<br>'; ?> 
    <br>
    <?php echo $pluginfile->ShortDescription; ?>
    <br><br>
    
        <div class="row">
                <?php if(isset($options))
                {
                    if(count($options) > 0) echo '<hr><h5>Options</h5>';
                    foreach($options as $option)
                    {
                        echo '<br><div class="form-areapart">';
                        //get the value to display
                        $item = PluginItem::model()->find('PluginID=:id AND PluginOptionID=:option',array(':id'=>$model->primaryKey,':option'=>$option->primaryKey));
                        if(isset($item))
                        {
                            $value = $item->Value;
                        }
                        else
                        {
                            $value = $option->Default;
                        }
                        echo $form->labelEx($option, $option->Name);
                        echo $option->Description . '<br><br>';
                        FormHelper::RenderField('option' . $option->primaryKey, $value, $option->valueType->Name, $this, $option, $form);
                        $optionlist = $optionlist . $option->primaryKey . ',';
                        
                        echo '</div>';
                    }
                    
                    echo CHtml::hiddenField('options',$optionlist);
                }
                ?>
        </div>
</div>
<br>
<?php endif; ?>
