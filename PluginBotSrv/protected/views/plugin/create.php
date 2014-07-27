<?php
/* @var $this PluginController */
/* @var $model Plugin */

$this->breadcrumbs=array(
	'Plugins'=>array('index'),
	'Create',
);

$this->menu=array(
        array('label'=>'Plugins Home', 'url'=>array('index')),
        array('label'=>'Browse Plugin Files', 'url'=>array('browse')),
        array('label'=>'Upload Plugin Files', 'url'=>array('submit')),
        array('label'=>'Manage Plugin Files', 'url'=>array('submitions')),
	array('label'=>'Manage Plugins', 'url'=>array('admin')),
);



?>

<h1>Create Plugin</h1>

<?php if(Yii::app()->user->hasFlash('over')): ?>
<div class="flash-notice"><?php echo Yii::app()->user->getFlash('over'); ?>
</div> 
<?php else: ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php endif; ?>