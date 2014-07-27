<?php
/* @var $this DeviceController */
/* @var $model Device */

$this->breadcrumbs=array(
	'Devices'=>array('index'),
	$model->Name=>array('view','id'=>$model->idDevice),
	'Update',
);

$this->menu=array(
	array('label'=>'Devices Home', 'url'=>array('index')),
	array('label'=>'Create Devices', 'url'=>array('create')),
	array('label'=>'View Device', 'url'=>array('view', 'id'=>$model->idDevice)),
	array('label'=>'Manage Devices', 'url'=>array('admin')),
);
?>

<h1>Update Device: <?php echo $model->Name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>