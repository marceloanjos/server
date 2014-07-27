<?php
/* @var $this PluginFileController */
/* @var $model SubmitPluginForm */
/* @var $plugins PluginFile */

$this->breadcrumbs=array(
    'Plugins'=>array('index'),
   'Submit',
);

$this->menu=array(
	array('label'=>'Plugins Home', 'url'=>array('index')),
        array('label'=>'Browse Plugin Files', 'url'=>array('browse')),
        array('label'=>'Upload Plugin Files', 'url'=>array('submit')),
        array('label'=>'Manage Plugin Files', 'url'=>array('submitions')),
	array('label'=>'Create Plugin', 'url'=>array('create')),
	array('label'=>'Manage Plugins', 'url'=>array('admin')),
);


?>

<h1>Update Plugin Submition</h1>

<?php if(Yii::app()->user->hasFlash('saved')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('saved'); ?>
</div>
<?php endif; ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'plugin-file-form',
   'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

        
    <div class="form-area">
    <div class="row">
        <b>You can replace the file you uploaded</b><br>
         (This is optional, use only if you want to replace the existing plugin file - ZIP file under 5mb):<br><br>
         <?php echo $form->labelEx($model,'UploadFile'); ?>
         <?php echo $form->fileField($model,'UploadFile'); ?>
         <?php echo $form->error($model,'UploadFile'); ?>
     </div>
    </div>
    <br><br>
    
   
   <div class="row buttons">
       <br><br>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->