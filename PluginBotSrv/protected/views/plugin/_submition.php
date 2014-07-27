<?php
/* @var $this PluginFileController */
/* @var $model SubmitPluginForm */
/* @var $plugins PluginFile */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'plugin-file-form',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'OperatingSystemID'); ?>
        <?php echo CHtml::dropDownList('SubmitPluginForm[OperatingSystemID]', $model->OperatingSystemID, CHTML::listData(OperatingSystem::model()->findAll(array('order'=>'Name')), 'idOperatingSystem', 'Name'), array('prompt' => 'Select a OperatingSystem')); ?>
        <?php echo $form->error($model,'OperatingSystemID'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'Name'); ?>
        <?php echo $form->textField($model,'Name',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'Name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'Version'); ?>
        <?php //echo $form->textField($model,'Version'); ?>
        <?php FormHelper::RenderField('Version', $model->Version, 'number', $this, $model, $form, 1) ?>
        <?php echo $form->error($model,'Version'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'ShortDescription'); ?>
        <?php echo $form->textField($model,'ShortDescription',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'ShortDescription'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'Description'); ?>
        <?php echo $form->textArea($model,'Description',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'Description'); ?>
    </div>


        <div class="row">
                <?php echo $form->labelEx($model, 'isPublic'); ?>
                <?php 
                $array = array('0' => 'Private', '1' => 'Public');
                echo $form->dropDownList($model,'isPublic',$array); 
                ?>
                <?php echo $form->error($model, 'isPublic'); ?> 
        </div>
  
    
    <div class="row">
        <br><br>
        <?php echo $form->labelEx($model,'UploadFile'); ?>
        <?php echo $form->fileField($model,'UploadFile',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'UploadFile'); ?>
    </div>
    
   <div class="row buttons">
       <br><br>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->