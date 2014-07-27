<?php
/* @var $this DeviceController */
/* @var $model Device */

$this->breadcrumbs=array(
	'Devices'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Devices Home', 'url'=>array('index')),
	array('label'=>'Create Device', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('device-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Devices</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<br><br>


<?php 

$form=$this->beginWidget('CActiveForm', array('action'=>Yii::app()->createUrl($this->route, array()),'method'=>'post',)); 

echo CHtml::dropDownList('groupid', NULL, CHTML::listData(Group::model()->findAll(array('order'=>'Name')), 'idGroup', 'Name'), array('prompt' => 'Select a group'));
echo CHtml::submitButton('Add selected selected to group', array('name' => 'AddButton','confirm'=>'Add selected to the group?'));

?>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<br><br>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('success')): ?>
<br><br>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>

<?php 


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'device-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
	'columns'=>array(
                array(
                'id' => 'toadd',
		'class'=>'CCheckBoxColumn',
		),
		array(
		'name'=>'OperatingSystemID',
		'value'=>'isset($data->operatingSystem) ? $data->operatingSystem->Name:"Not Set"',
		'filter'=>CHTML::listData(OperatingSystem::model()->findAll(array('order'=>'Name')), 'idOperatingSystem', 'Name'),
		),
		array(
		'name'=>'Name',
		'value'=>'CHtml::Link($data->Name,array("device/view","id"=>"$data->primaryKey"))',
		'type'=>'raw',
		),
		'IPAddress',
		//'DateInstalled',
		//'DateUpdated',
		//'DateMissing',
		
		//'UpdateInterval',
		array(
		'name'=>'isMissing',
		'value'=>'$data->isMissing?Yii::t(\'app\',\'Yes\'):Yii::t(\'app\', \'No\')',
		'filter'=>array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
		),
		//'Description',
		
       
        
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 

$this->endWidget();

?>
