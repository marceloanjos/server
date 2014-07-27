<?php
/* @var $this PluginFileController */
/* @var $model PluginFile */

$this->breadcrumbs=array(
    'Plugin Files'=>array('index'),
    'Manage',
);

$this->menu=array(
	array('label'=>'Plugins Home', 'url'=>array('index')),
        array('label'=>'Browse Plugin Files', 'url'=>array('browse')),
        array('label'=>'Upload Plugin Files', 'url'=>array('submit')),
	array('label'=>'Create Plugin', 'url'=>array('create')),
	array('label'=>'Manage Plugins', 'url'=>array('admin')),
);

?>

<h1>Manage Plugin Submitions</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'plugin-file-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        
        array(
		'name'=>'OperatingSystemID',
		'value'=>'isset($data->operatingSystem) ? $data->operatingSystem->Name:"Not Set"',
		'filter'=>CHTML::listData(OperatingSystem::model()->findAll(), 'idOperatingSystem', 'Name'),
		),
        array(
            'name' => 'Name',
            'value' => 'CHtml::Link($data->Name,array("plugin/details","id"=>"$data->idPluginFile"))',
            'type' => 'raw',
        ),

       array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => array
                (
                'view' => array
                    (
                    'url' => 'Yii::app()->createUrl("plugin/details", array("id"=>$data->idPluginFile))',
                ),
                'update' => array
                    (
                    'url' => 'Yii::app()->createUrl("plugin/updatesubmition", array("id"=>$data->idPluginFile))',
                ),
                'delete' => array
                    (
                    'url' => 'Yii::app()->createUrl("plugin/deletesubmition", array("id"=>$data->idPluginFile))',
                ),
            )
        ),
    ),
)); ?>
