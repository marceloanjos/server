<?php
/* @var $this LoginController */
/* @var $model Login */

$this->breadcrumbs=array(
	'Logins'=>array('index'),
	$model->Email=>array('view','id'=>$model->idLogin),
	'Update',
);

$this->menu=array(
	array('label'=>'Logins Home', 'url'=>array('index')),
	array('label'=>'Create Logins', 'url'=>array('create')),
	array('label'=>'View Login', 'url'=>array('view', 'id'=>$model->idLogin)),
	array('label'=>'Manage Logins', 'url'=>array('admin')),
);
?>

<h1>Update Login: <?php echo $model->FirstName . ' ' . $model->LastName; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>