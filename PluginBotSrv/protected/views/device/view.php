<?php
/* @var $this DeviceController */
/* @var $model Device */
/* @var $groups GroupDevice */
/* @var $policies GroupPolicy */
/* @var $plugins GroupPlugin */

$this->breadcrumbs=array(
	'Devices'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'Devices Home', 'url'=>array('index')),
	array('label'=>'Create Devices', 'url'=>array('create')),
	array('label'=>'Update Device', 'url'=>array('update', 'id'=>$model->idDevice)),
	array('label'=>'Delete Device', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idDevice),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Devices', 'url'=>array('admin')),
        array('label'=>'Logs', 'url'=>array('log/index', 'id'=>$model->idDevice)),
);
?>

<h1>View Device: <?php echo $model->Name; ?></h1>



<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
                array(
                    'name' => 'Install Code',
                    'value' =>Security::getInstallCode(0, $model->primaryKey),
                    'type' => 'raw',
                ),
		array('label'=>'Operating System','value'=>isset($model->operatingSystem) ? $model->operatingSystem->Name : NULL,),
		'Bits',
                'Name',
		'IPAddress',
		array('label'=>'Date Installed','value'=>$model->DateInstalled == NULL ? NULL : date_format(new DateTime($model->DateInstalled), 'm-d-Y H:m:s'),),
		array('label'=>'Date Updated','value'=>$model->DateUpdated == NULL ? NULL : date_format(new DateTime($model->DateUpdated), 'm-d-Y H:m:s'),),
		array('label'=>'Date Missing','value'=>$model->DateMissing == NULL ? NULL : date_format(new DateTime($model->DateMissing), 'm-d-Y H:m:s'),),
		'UpdateInterval',
		array('label'=>'Missing','value'=>$model->isMissing  ? 'Yes' : 'No',),
		array(
                    'name' => 'Description',
                    'value' => nl2br($model->Description),
                    'type' => 'raw',
                ),
	),
)); 



if(count($groups) > 0)
{
    $groupitems = array();
    foreach($groups as $group)
    {
        $groupitems[$group->primaryKey] = array('label'=>'Group','type'=>'raw','value'=>CHtml::link(CHtml::encode($group->group->Name),array('group/view','id'=>$group->GroupID)));
    }
    echo '<br><br><b>Groups</b>';
    $this->widget('zii.widgets.CDetailView', array('data'=>$model,'attributes'=>$groupitems));
}


if(count($policies) > 0)
{
    $policyitems = array();
    foreach($policies as $policy)
    {
        $policyitems[$policy->primaryKey] = array('label'=>'Group: ' . CHtml::link(CHtml::encode($policy->group->Name),array('group/view','id'=>$policy->GroupID)),'type'=>'raw','value'=>CHtml::link(CHtml::encode($policy->policy->Name),array('policy/view','id'=>$policy->PolicyID)));
    }
    echo '<br><br><b>Policies</b>';
    $this->widget('zii.widgets.CDetailView', array('data'=>$model,'attributes'=>$policyitems));
}

if(count($plugins) > 0)
{
    $pluginitems = array();
    foreach($plugins as $plugin)
    {
        //$pluginitems[$plugin->primaryKey] = array('label'=>'Name','type'=>'raw','value'=>CHtml::link(CHtml::encode($plugin->plugin->Name),array('plugin/view','id'=>$plugin->primaryKey)));
        $pluginitems[$plugin->primaryKey] = array('label'=>'Group: ' . CHtml::link(CHtml::encode($plugin->group->Name),array('group/view','id'=>$plugin->GroupID)),'type'=>'raw','value'=>CHtml::link(CHtml::encode($plugin->plugin->Name),array('plugin/view','id'=>$plugin->PluginID)));
    }
    echo '<br><br><b>Plugins</b>';
    $this->widget('zii.widgets.CDetailView', array('data'=>$model,'attributes'=>$pluginitems));
}

?>
