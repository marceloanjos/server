<?php
/* @var $this PolicyController */
/* @var $model Policy */

$this->breadcrumbs=array(
	'Policies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Policies Home', 'url'=>array('index')),
	array('label'=>'Manage Policies', 'url'=>array('admin')),
);

?>

<h1>Create Policy</h1>

<?php if(Yii::app()->user->hasFlash('over')): ?>
<div class="flash-notice"><?php echo Yii::app()->user->getFlash('over'); ?>
</div> 
<?php else: ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php endif; ?>