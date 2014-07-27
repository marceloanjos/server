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
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	'Update',
);\n";
?>

$this->menu=array(
	array('label'=>'<?php echo $label; ?> Home', 'url'=>array('index')),
	array('label'=>'Create <?php echo $label; ?>', 'url'=>array('create')),
	array('label'=>'View <?php echo $this->modelClass; ?>', 'url'=>array('view', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label'=>'Manage <?php echo $label; ?>', 'url'=>array('admin')),
);
?>

<h1>Update <?php
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

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>