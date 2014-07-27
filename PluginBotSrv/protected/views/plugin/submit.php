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
        array('label'=>'Manage Plugin Files', 'url'=>array('submitions')),
	array('label'=>'Create Plugin', 'url'=>array('create')),
	array('label'=>'Manage Plugins', 'url'=>array('admin')),
);


?>

<h1>Submit Plugin</h1>

Plugins can be downloaded from <a href="http://www.pluginbot.net">pluginbot.net</a><br><br>

Once you have downloaded the plugin, you can upload it to this server by using the form below.
<br><br>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'upload-plugin-form',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <br><br>
        <?php echo $form->labelEx($model,'UploadFile'); ?>
        (ZIP files under 5mb)<br>
        <?php echo $form->fileField($model,'UploadFile'); ?>
        <?php echo $form->error($model,'UploadFile'); ?>
    </div>
    
   <div class="row buttons">
       <br><br>
        <?php echo CHtml::submitButton('Upload'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

