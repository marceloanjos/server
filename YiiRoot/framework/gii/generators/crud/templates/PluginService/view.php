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
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

$this->menu=array(
	array('label'=>'<?php echo $label; ?> Home', 'url'=>array('index')),
	array('label'=>'Create <?php echo $label; ?>', 'url'=>array('create')),
	array('label'=>'Update <?php echo $this->modelClass; ?>', 'url'=>array('update', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label'=>'Delete <?php echo $this->modelClass; ?>', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage <?php echo $label; ?>', 'url'=>array('admin')),
);
?>

<h1>View <?php
$Title = $this->tableSchema->primaryKey;
if(in_array('Name', $this->tableSchema->columnNames)) $Title = 'Name';

if(in_array('FirstName', $this->tableSchema->columnNames)) 
{
    $Title = 'FirstName';
    echo $this->modelClass.": <?php echo \$model->FirstName . ' ' . \$model->LastName; ?>"; 
}
else
{
    echo $this->modelClass.": <?php echo \$model->{$Title}; ?>"; 
}
?>
</h1>
<?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
{
     //Skip the primary key
     if($column->autoIncrement) continue;
    
    //Skip the account id
    if($column->name == 'AccountID') continue;
    
    //Skip the password
    if($column->name == 'Password') continue;
    
    //Handle boolean values
    if(stripos($column->dbType,'tinyint')!==false)
    {
        echo "\t\tarray('label'=>'" . $column->name . "','value'=>\$model->" . $column->name . "  ? 'Yes' : 'No',),\n";
        continue;
    }
    
    //Handle dates
    if($column->dbType == 'date')
    {
        echo "\t\tarray('label'=>'" . $column->name . "','value'=>\$model->" . $column->name . " == NULL ? NULL : date_format(new DateTime(\$model->" . $column->name . "), 'm-d-Y'),),\n";
        continue;
    }
    
    //Handle times
    if($column->dbType == 'time')
    {
        echo "\t\tarray('label'=>'" . $column->name . "','value'=>\$model->" . $column->name . " == NULL ? NULL : date_format(new DateTime(\$model->" . $column->name . "), H:m:s'),),\n";
        continue;
    }
    
    //Handle dates and times
    if(stripos($column->dbType,'date')!==false)
    {
        echo "\t\tarray('label'=>'" . $column->name . "','value'=>\$model->" . $column->name . " == NULL ? NULL : date_format(new DateTime(\$model->" . $column->name . "), 'm-d-Y H:m:s'),),\n";
        continue;
    }
    
    //Handle external references
    if (stripos($column->dbType, 'bigint') !== false && substr($column->name, strlen($column->name) - 2, 2) == 'ID')
    {
        $ModelName = substr($column->name, 0, strlen($column->name) - 2);
        echo "\t\tarray('label'=>'" . $ModelName . "','value'=>isset(\$model->" . strtolower($ModelName) . ") ? \$model->" . strtolower($ModelName) . "->Name : NULL,),\n";
        continue;
    }
     //Handle an email
    if($column->name == 'Web' || $column->name == 'Url')
    {
                
        echo "\t\tarray('label'=>'" . $column->name . "','type'=>'raw','value'=>CHtml::link(\$model->" . $column->name . ", \$model->" . $column->name . ")),\n";
        continue;
    }
    
    //Handle an email
    if($column->name == 'Email')
    {
                
        echo "\t\tarray('label'=>'" . $column->name . "','type'=>'raw','value'=>CHtml::link(\$model->" . $column->name . ", 'mailto:' .\$model->" . $column->name . ")),\n";
        continue;
    }

    //Just add it to the array as a normal item
    echo "\t\t'".$column->name."',\n";
        
}
	
?>
	),
)); ?>
