<?php
/* @var $this PluginController */
/* @var $model Plugin */

$this->breadcrumbs=array(
	'Plugins'=>array('index'),
	$model->Name=>array('view','id'=>$model->idPlugin),
	'Update',
);

$this->menu=array(
	array('label'=>'Plugins Home', 'url'=>array('index')),
        array('label'=>'Browse Plugin Files', 'url'=>array('browse')),
        array('label'=>'Upload Plugin Files', 'url'=>array('submit')),
        array('label'=>'Manage Plugin Files', 'url'=>array('submitions')),
	array('label'=>'Create Plugin', 'url'=>array('create')),
        array('label'=>'View Plugin', 'url'=>array('view', 'id'=>$model->idPlugin)),
        array('label'=>'Delete Plugin', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idPlugin),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Plugins', 'url'=>array('admin')),

);
?>

<h1>Update Plugin: <?php echo $model->Name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>