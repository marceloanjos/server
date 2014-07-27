<?php
/* @var $this LogController */
/* @var $model Log */

$this->breadcrumbs=array(
    'Logs'=>array('index'),
    $model->Name,
);

$this->menu=array(
    array('label'=>'Logs Home', 'url'=>array('index')),
);
?>

<h1>View Log: <?php echo $model->device->Name . ' on  ' .  $model->EventDate; ?></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        array('label'=>'Device','value'=>isset($model->device) ? $model->device->Name : NULL,),
        array('label'=>'EventDate','value'=>$model->EventDate == NULL ? NULL : date_format(new DateTime($model->EventDate), 'm-d-Y H:m:s'),),
        'IPAddress',
        'Name',
        array(
              'name' => 'Description',
              'value' => nl2br($model->Description),
               'type' => 'raw',
              ),
    ),
)); ?>