<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	'Manage',
);\n";
?>

$this->menu=array(
	array('label'=>'<?php echo $label; ?> Home', 'url'=>array('index')),
	array('label'=>'Create <?php echo $this->modelClass; ?>', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage <?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo "<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>"; ?>

<div class="search-form" style="display:none">
<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
    
     //Skip the primary key
     if($column->autoIncrement) continue;
    
    //Skip the account id
    if($column->name == 'AccountID') continue;
    
    //Skip the password
    if($column->name == 'Password') continue;
    
	if(++$count==7)
		echo "\t\t/*\n";
        
    //Handle external references
    if (stripos($column->dbType, 'tinyint') !== false)
    {
       // echo "\t\t' LINK".$column->name."',\n";
       
        echo  "\t\tarray(\n";
        echo "\t\t'name'=>'" . $column->name . "',\n";
        //echo "\t\t'value'=>\$model->" . $column->name . ",\n";
        echo "\t\t'value'=>'\$data->" . $column->name . "?Yii::t(\'app\',\'Yes\'):Yii::t(\'app\', \'No\')',\n";
        echo "\t\t'filter'=>array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),\n";
        echo  "\t\t),\n";
        continue;
    }
    
    //Handle external references
    if (stripos($column->dbType, 'bigint') !== false && substr($column->name, strlen($column->name) - 2, 2) == 'ID')
    {
       // echo "\t\t' LINK".$column->name."',\n";
        $ModelName = substr($column->name, 0, strlen($column->name) - 2);
        echo  "\t\tarray(\n";
        echo "\t\t'name'=>'" . $column->name . "',\n";
        //echo "\t\t'value'=>\$model->" . $column->name . ",\n";
        echo "\t\t'value'=>'isset(\$data->" . strtolower($ModelName) . ") ? \$data->" . strtolower($ModelName) . "->Name:\"Not Set\"',\n";
        echo "\t\t'filter'=>CHTML::listData(" . $ModelName . "::model()->findAll(), 'id" . $ModelName . "', 'Name'),\n";
        echo  "\t\t),\n";
        continue;
    }
        
	echo "\t\t'".$column->name."',\n";
}
if($count>=7)
	echo "\t\t*/\n";
?>
       
        
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
