<?php
/* @var $this LoginController */
/* @var $model Login */

$this->breadcrumbs=array(
	'Logins'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Logins Home', 'url'=>array('index')),
	array('label'=>'Manage Logins', 'url'=>array('admin')),
);
?>

<h1>Create Login</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>