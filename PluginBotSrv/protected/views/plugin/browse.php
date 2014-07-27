<?php
/* @var $this PluginFileController */
/* @var $model PluginFile */



$this->breadcrumbs=array(
    'Plugins'=>array('index'),
    'Browse',
);

$this->menu=array(
        array('label'=>'Plugins Home', 'url'=>array('index')),
        array('label'=>'Upload Plugin Files', 'url'=>array('submit')),
        array('label'=>'Manage Plugin Files', 'url'=>array('submitions')),
	array('label'=>'Create Plugin', 'url'=>array('create')),
	array('label'=>'Manage Plugins', 'url'=>array('admin')),

);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('plugin-file-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

 <div class="cleartable">
    <div class="pagecell">
         <h1>Browse Plugin Files</h1>

<p>
    Plugins extend the functionality of the system. We allow site members rank and comment on plugins that are submitted to the site. If you are interested in submitting a plugin, please register to become a plugin author.
    
</p>
        
    </div>  
    <div class="cell sideimage">
        <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/plugin.jpg') ?>
    </div>
  </div>



<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_browse',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'plugin-file-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
		'name'=>'OperatingSystemID',
		'value'=>'isset($data->operatingSystem) ? $data->operatingSystem->Name:"Not Set"',
		'filter'=>CHTML::listData(OperatingSystem::model()->findAll(), 'idOperatingSystem', 'Name'),
		),
		array(
		'name'=>'Name',
		'value'=>'CHtml::Link($data->Name,array("plugin/details","id"=>"$data->idPluginFile"))',
		'type'=>'raw',
		),

		array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array
                        (
                            'view'=>array
                            (
                                'url'=>'Yii::app()->createUrl("plugin/details", array("id"=>$data->idPluginFile))',
                            ),
                            
                        )
		),
                 
                 
	),
)); ?>
