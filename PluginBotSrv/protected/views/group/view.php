<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'Groups Home', 'url'=>array('index')),
	array('label'=>'Create Groups', 'url'=>array('create')),
	array('label'=>'Update Group', 'url'=>array('update', 'id'=>$model->idGroup)),
	array('label'=>'Delete Group', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idGroup),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Groups', 'url'=>array('admin')),
        array('label'=>'Group Policies', 'url'=>array('policy', 'group'=>$model->idGroup)),
        array('label'=>'Group Plugins', 'url'=>array('plugin', 'group'=>$model->idGroup)),
        array('label'=>'Group Devices', 'url'=>array('device', 'group'=>$model->idGroup)),
);


?>

<h1>View Group: <?php echo $model->Name; ?></h1>

<b>Group Information</b>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Name',
		//'Description',
            array(
                'name' => 'Description',
                'value' => nl2br($model->Description),
                'type' => 'raw',
            ),
	),
));

//Show the group summery
$cntCriteria = new CDbCriteria();
$cntCriteria->condition = "GroupID = :group";
$cntCriteria->params[':group'] = $model->primaryKey;
$PolicyCount = GroupPolicy::model()->count($cntCriteria);
$PluginCount = GroupPlugin::model()->count($cntCriteria);
$DeviceCount = GroupDevice::model()->count($cntCriteria);

$items = array();
$items['GroupPolicy'] = array('label'=>'Policies','type'=>'raw','value'=>CHtml::link(CHtml::encode($PolicyCount),array('group/policy','group'=>$model->primaryKey)));
$items['GroupPlugin'] = array('label'=>'Plugins','type'=>'raw','value'=>CHtml::link(CHtml::encode($PluginCount),array('group/plugin','group'=>$model->primaryKey)));
$items['GroupDevice'] = array('label'=>'Devices','type'=>'raw','value'=>CHtml::link(CHtml::encode($DeviceCount),array('group/device','group'=>$model->primaryKey)));

echo '<br><b>Items in group</b>';
$this->widget('zii.widgets.CDetailView', array('data'=>$model,'attributes'=>$items));
?>
