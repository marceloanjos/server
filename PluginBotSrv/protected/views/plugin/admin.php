<?php
/* @var $this PluginController */
/* @var $model Plugin */

$this->breadcrumbs=array(
	'Plugins'=>array('index'),
	'Manage',
);

$this->menu=array(
        array('label'=>'Plugins Home', 'url'=>array('index')),
        array('label'=>'Browse Plugin Files', 'url'=>array('browse')),
        array('label'=>'Upload Plugin Files', 'url'=>array('submit')),
        array('label'=>'Manage Plugin Files', 'url'=>array('submitions')),
	array('label'=>'Create Plugin', 'url'=>array('create')),

);

?>

<h1>Manage Plugins</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php 

$form=$this->beginWidget('CActiveForm', array('action'=>Yii::app()->createUrl($this->route, array()),'method'=>'post',)); 

echo CHtml::dropDownList('groupid', NULL, CHTML::listData(Group::model()->findAll(), 'idGroup', 'Name'), array('prompt' => 'Select a group'));
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
	'id'=>'plugin-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
	'columns'=>array(
                array(
                'id' => 'toadd',
		'class'=>'CCheckBoxColumn',
		),

         
		array(
		'name'=>'Name',
		'value'=>'CHtml::Link($data->Name,array("plugin/view","id"=>"$data->primaryKey"))',
		'type'=>'raw',
		),
		
       
        
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 

$this->endWidget();

?>
