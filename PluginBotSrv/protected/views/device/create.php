<?php
/* @var $this DeviceController */
/* @var $model Device */

$this->breadcrumbs=array(
	'Devices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Devices Home', 'url'=>array('index')),
	array('label'=>'Manage Devices', 'url'=>array('admin')),
);
?>

<h1>Create Device</h1>

<?php if(Yii::app()->user->hasFlash('over')): ?>
<div class="flash-notice"><?php echo Yii::app()->user->getFlash('over'); ?>
</div> 
<?php else: ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php endif; ?>