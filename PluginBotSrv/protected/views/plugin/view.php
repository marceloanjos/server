<?php
/* @var $this PluginController */
/* @var $model Plugin */
/* @var $options PluginItem */

$this->breadcrumbs=array(
	'Plugins'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'Plugins Home', 'url'=>array('index')),
        array('label'=>'Browse Plugin Files', 'url'=>array('browse')),
        array('label'=>'Upload Plugin Files', 'url'=>array('submit')),
        array('label'=>'Manage Plugin Files', 'url'=>array('submitions')),
	array('label'=>'Update Plugin', 'url'=>array('update', 'id'=>$model->idPlugin)),
	array('label'=>'Delete Plugin', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idPlugin),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Plugins', 'url'=>array('admin')),
);

?>

<h1>View Plugin: <?php echo $model->Name; ?></h1>
<?php 

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            array(
		'name'=>'PluginFile',
		'value'=>CHtml::Link($model->pluginFile->Name,array("plugin/details","id"=>"$model->PluginFileID")),
		'type'=>'raw',
		),
		//array('label'=>'PluginFile','value'=>isset($model->pluginFile) ? $model->pluginFile->Name : NULL,),
		'Name',
            
		array(
                    'name' => 'Description',
                    'value' => nl2br($model->Description),
                    'type' => 'raw',
                ),
	),
)); 

//see if the plugin has options attached to it
$optionlist = array();
if(isset($options))
{
    
    foreach ($options as $option) 
    {
            $val = array(
            'label' => $option->pluginOption->Name,
            'value' => $option->Value,
            );

            array_push($optionlist, $val);
    }
    
   if(count($optionlist) > 0)  echo '<br><b>Options</b>';
    $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>$optionlist,
    )); 
}
?>


