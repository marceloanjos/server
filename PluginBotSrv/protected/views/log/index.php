<?php
/* @var $this LogController */
/* @var $model Log */

$this->breadcrumbs=array(
	'Logs'
);

$this->menu=array(
	array('label'=>'Logs Home', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$Title = 'Logs';
$Device = NULL;
if(isset($_REQUEST['id']))
{
    $Device = Device::model()->findByPk($_REQUEST['id'])->Name;
    $Title = 'Logs for ' . $Device;
}

?>
 <div class="cleartable">
    <div class="pagecell">
         <h1><?php echo $Title; ?></h1>
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
        
    </div>  
    <div class="cell sideimage">
        <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/log.jpg') ?>
    </div>
  </div>


<h1></h1>



<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'log-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		
                
                array(
		'name'=>'DeviceID',
		'value'=>'isset($data->device) ?  CHtml::Link($data->device->Name,array("device/view","id"=>"$data->DeviceID")):"Not Set"',
		'filter'=>isset($Device) ? '' : CHTML::listData(Device::model()->findAll(array('order'=>'Name')), 'idDevice', 'Name'),
		'type'=>'raw',
                    ),
                //'EventDate',
                array(
		'name'=>'EventDate',
		'value'=>'CHtml::Link($data->EventDate,array("log/view","id"=>"$data->idLog"))',
		'type'=>'raw',
		),
		'IPAddress',
                'Name',
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array
                        (
                            'view'=>array
                            (
                                'url'=>'Yii::app()->createUrl("log/view", array("id"=>$data->idLog))',
                            ),
                            
                        )
		),
	),
)); ?>
