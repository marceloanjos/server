<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->Name=>array('view','id'=>$model->idGroup),
	'Update',
);

$this->menu=array(
	array('label'=>'Groups Home', 'url'=>array('index')),
	array('label'=>'Create Groups', 'url'=>array('create')),
	array('label'=>'View Group', 'url'=>array('view', 'id'=>$model->idGroup)),
	array('label'=>'Manage Groups', 'url'=>array('admin')),
);
?>

<h1>Update Group: <?php echo $model->Name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>