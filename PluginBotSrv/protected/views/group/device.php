<?php
/* @var $this GroupController */
/* @var $model GroupDevice */
/* @var $group Group */

$this->breadcrumbs=array(
	'Groups'=>array('index'),
        $group->Name=>array('view','id'=>$group->primaryKey),
	'Devices',
);

$this->menu=array(
    array('label'=>'View Group', 'url'=>array('view', 'id'=>$group->primaryKey)),
    array('label'=>'Manage Devices', 'url'=>array('device/admin')),
);


?>

<h1>Manage Devices In: <?php echo $group->Name; ?></h1>

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
	'id'=>'group-device-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
	'columns'=>array(
		array(
                'id' => 'todelete',
		'class'=>'CCheckBoxColumn',
		),
                
		array(
		'name'=>'DeviceID',
		'value'=>'isset($data->device) ? $data->device->Name:"Not Set"',
		'filter'=>CHTML::listData(Device::model()->findAll(), 'idDevice', 'Name'),
                ),
       
        
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}{delete}',
                        'buttons'=>array
                        (
                            'view'=>array
                            (
                                'url'=>'Yii::app()->createUrl("device/view", array("id"=>$data->DeviceID))',
                            ),
                            'delete'=>array
                            (
                                'url'=>'Yii::app()->createUrl("group/deletedevice", array("id"=>$data->idGroupDevice,"group"=>$_REQUEST["group"]))',
                            ),
                        )
		),
	),
)); 
 


$this->endWidget();

?>