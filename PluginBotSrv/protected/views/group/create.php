<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	'Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Groups Home', 'url'=>array('index')),
	array('label'=>'Manage Groups', 'url'=>array('admin')),
);
?>

<h1>Create Group</h1>

<?php if(Yii::app()->user->hasFlash('over')): ?>
<div class="flash-notice"><?php echo Yii::app()->user->getFlash('over'); ?>
</div> 
<?php else: ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php endif; ?>