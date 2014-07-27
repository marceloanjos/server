<?php
/* @var $this PolicyController */
/* @var $model Policy */

$this->breadcrumbs=array(
	'Policies'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Policies Home', 'url'=>array('index')),
	array('label'=>'Create Policy', 'url'=>array('create')),
);


?>

<h1>Manage Policies</h1>

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
	'id'=>'policy-grid',
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
		'value'=>'CHtml::Link($data->Name,array("policy/view","id"=>"$data->primaryKey"))',
		'type'=>'raw',
		),
		//'Description',
	
       
        
		array(
			'class'=>'CButtonColumn',
		),
	),
));

$this->endWidget();
?>
