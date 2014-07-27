<?php
/* @var $this PluginController */
/* @var $model PluginFile */

$this->breadcrumbs=array(
	'Plugins'=>array('index'),
        'Browse'=>array('browse'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'Plugins Home', 'url'=>array('index')),
        array('label'=>'Browse Plugin Files', 'url'=>array('browse')),
	array('label'=>'Update Plugin File', 'url'=>array('updatesubmition','id'=>$model->primaryKey)),
        array('label'=>'Create Plugin', 'url'=>array('create','id'=>$model->primaryKey)),
	array('label'=>'Manage Plugins', 'url'=>array('admin')),
        
);



?>

<h1>Details for: <?php echo $model->Name; ?></h1>
<?php 

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('label'=>'Operating System','value'=>isset($model->operatingSystem) ? $model->operatingSystem->Name : NULL,),
                'Bits',
                'Name',
		array('label'=>'Date Released','value'=>$model->DateReleased == NULL ? NULL : date_format(new DateTime($model->DateReleased), 'm-d-Y H:m:s'),),
		'Version',
                array(
                'name' => 'Size',
                'value' => number_format($model->Size) . ' kb',
                'type' => 'raw',
                ),
                array(
		'name'=>'File',
		'value'=>CHtml::Link($model->URL,array("plugin/download","id"=>$model->primaryKey)),
		'type'=>'raw',
		),
                array(
                'name' => 'Description',
                'value' => nl2br($model->Description),
                'type' => 'raw',
                ),
	),
)); ?>

