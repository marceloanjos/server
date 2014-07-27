<?php
/* @var $this PolicyController */
/* @var $model Policy */

$this->breadcrumbs=array(
	'Policies'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'Policies Home', 'url'=>array('index')),
	array('label'=>'Create Policies', 'url'=>array('create')),
	array('label'=>'Update Policy', 'url'=>array('update', 'id'=>$model->idPolicy)),
	array('label'=>'Delete Policy', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idPolicy),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Policies', 'url'=>array('admin')),
);
?>

<h1>View Policy: <?php echo $model->Name; ?></h1>

<?php 
$arr = array(
		'Name',
		'Description',
		array('label'=>'Trigger','type'=>'raw','value'=>CHtml::label($model->policyTrigger->Name,null)),
                array('label'=>$model->policyTrigger->Label1,'type'=>'raw','value'=>CHtml::label($model->TriggerValue1,null)),
                array('label'=>'Action','type'=>'raw','value'=>CHtml::label($model->policyAction->Name,null)),
                array('label'=>$model->policyAction->Label1,'type'=>'raw','value'=>CHtml::label($model->ActionValue1,null)),
                array('label'=>$model->policyAction->Label2,'type'=>'raw','value'=>CHtml::label($model->ActionValue2,null)),
    
	);
$arr = array('Name',
            array(
                'name' => 'Description',
                'value' => nl2br($model->Description),
                'type' => 'raw',
            ),
        );
//trigger is manditory
$arr[] = array('label'=>'Trigger','type'=>'raw','value'=>CHtml::label($model->policyTrigger->Name,null));

//Add in the TriggerValue1
if($model->policyTrigger->hasValue1) $arr[] = array('label'=>$model->policyTrigger->Label1,'type'=>'raw','value'=>CHtml::label($model->TriggerValue1,null));

//action is manditory
$arr[] = array('label'=>'Action','type'=>'raw','value'=>CHtml::label($model->policyAction->Name,null));

//Add in the Action Values
if($model->policyAction->hasValue1)
{
    if(strtoupper($model->policyAction->Label1)== 'PLUGIN')
    {
        
         //$arr[] = array('label'=>$model->policyAction->Label1,'type'=>'raw','value'=>CHtml::label(Plugin::model()->FindByPk($model->ActionValue1)->Name,null));
         $arr[] = array('label'=>$model->policyAction->Label1,'type'=>'raw','value'=>CHtml::Link(Plugin::model()->FindByPk($model->ActionValue1)->Name,array("plugin/view","id"=>$model->ActionValue1)));
    }
    else
    {
         $arr[] = array('label'=>$model->policyAction->Label1,'type'=>'raw','value'=>CHtml::label($model->ActionValue1,null));
    }
   
}

if($model->policyAction->hasValue2)
{
    if(strtoupper($model->policyAction->Label2)== 'PLUGIN')
    {
         //$arr[] = array('label'=>$model->policyAction->Label2,'type'=>'raw','value'=>CHtml::label(Plugin::model()->FindByPk($model->ActionValue2)->Name,null));
        $arr[] = array('label'=>$model->policyAction->Label2,'type'=>'raw','value'=>CHtml::Link(Plugin::model()->FindByPk($model->ActionValue2)->Name,array("plugin/view","id"=>$model->ActionValue2)));
    }
    else
    {
         $arr[] = array('label'=>$model->policyAction->Label2,'type'=>'raw','value'=>CHtml::label($model->ActionValue2,null));
    }
}
        
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>$arr,
)); ?>
