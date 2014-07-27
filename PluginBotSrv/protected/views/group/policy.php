<?php
/* @var $this GroupController */
/* @var $model GroupPolicy */
/* @var $group Group */

$this->breadcrumbs=array(
	'Groups'=>array('index'),
        $group->Name=>array('view','id'=>$group->primaryKey),
	'Polices',
);

$this->menu=array(
    array('label'=>'View Group', 'url'=>array('view', 'id'=>$group->primaryKey)),
    array('label'=>'Manage Policies', 'url'=>array('policy/admin')),
);


?>

<h1>Manage Policies In: <?php echo $group->Name; ?></h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route, array('group'=>$_REQUEST['group'])),
	'method'=>'post',
)); 

echo CHtml::submitButton('Remove selected from group', array('name' => 'RemoveButton','confirm'=>'Remove selected from the group?'));

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
	'id'=>'group-policy-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
	'columns'=>array(
		array(
                'id' => 'todelete',
		'class'=>'CCheckBoxColumn',
		),
		array(
		'name'=>'PolicyID',
		'value'=>'isset($data->policy) ? $data->policy->Name:"Not Set"',
		'filter'=>CHTML::listData(Policy::model()->findAll(), 'idPolicy', 'Name'),
		),
       
        
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}{delete}',
                        'buttons'=>array
                        (
                            'view'=>array
                            (
                                'url'=>'Yii::app()->createUrl("policy/view", array("id"=>$data->PolicyID))',
                            ),
                            'delete'=>array
                            (
                                'url'=>'Yii::app()->createUrl("group/deletepolicy", array("id"=>$data->idGroupPolicy,"group"=>$_REQUEST["group"]))',
                            ),
                        )
		),
	),
)); 
 


$this->endWidget();

?>