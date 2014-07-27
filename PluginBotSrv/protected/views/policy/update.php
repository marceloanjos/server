<?php
/* @var $this PolicyController */
/* @var $model Policy */

$this->breadcrumbs=array(
	'Policies'=>array('index'),
	$model->Name=>array('view','id'=>$model->idPolicy),
	'Update',
);

$this->menu=array(
	array('label'=>'Policies Home', 'url'=>array('index')),
	array('label'=>'Create Policies', 'url'=>array('create')),
	array('label'=>'View Policy', 'url'=>array('view', 'id'=>$model->idPolicy)),
	array('label'=>'Manage Policies', 'url'=>array('admin')),
);
?>

<h1>Update Policy: <?php echo $model->Name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>