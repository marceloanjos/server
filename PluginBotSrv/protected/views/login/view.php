<?php
/* @var $this LoginController */
/* @var $model Login */

$this->breadcrumbs=array(
	'Logins'=>array('index'),
	$model->Email,
);

$this->menu=array(
	array('label'=>'Logins Home', 'url'=>array('index')),
	array('label'=>'Create Logins', 'url'=>array('create')),
	array('label'=>'Update Login', 'url'=>array('update', 'id'=>$model->idLogin)),
	array('label'=>'Delete Login', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idLogin),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Logins', 'url'=>array('admin')),
);
?>

<h1>View Login: <?php echo $model->FirstName . ' ' . $model->LastName; ?></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'FirstName',
		'LastName',
		array('label'=>'Email','type'=>'raw','value'=>CHtml::link($model->Email, 'mailto:' .$model->Email)),
		array('label'=>'DateLogin','value'=>$model->DateLogin == NULL ? NULL : date_format(new DateTime($model->DateLogin), 'm-d-Y H:m:s'),),
		array('label'=>'isEnabled','value'=>$model->isEnabled  ? 'Yes' : 'No',),
	),
)); ?>
