<?php
/* @var $this PluginFileController */
/* @var $model SubmitPluginForm */
/* @var $plugins PluginFile */

$account = Account::model()->findByPk(Security::getAccountID());

$this->breadcrumbs=array(
    'Plugins'=>array('index'),
   'Submit',
);

$this->menu=array(
	array('label'=>'Plugins Home', 'url'=>array('index')),
	array('label'=>'Create Plugin', 'url'=>array('create')),
	array('label'=>'Manage Plugins', 'url'=>array('admin')),
        array('label'=>'Browse Plugin Files', 'url'=>array('browse')),
);

//Check to see if the author tools are displayed
$this->AddAuthorTools($this->menu);

?>

<h1>Submit Plugin</h1>

<?php if($account->Name == ''): ?>
<div class="flash-notice"><b>Your author profile does not exist!</b><br><br>
    You can not submit a plugin until your author profile has been completed.<br><br>
    <?php  echo CHtml::link('Click here to create your author profile.', $this->createUrl('account/author')) ; ?>
</div> 
<?php else: ?>


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
	<?php echo $form->labelEx($model,'Bits'); ?>
	<?php //echo $form->textField($model,'Bits'); ?>
        <?php FormHelper::RenderBitsField('Bits', $form, $model); ?>
	<?php echo $form->error($model,'Bits'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'Name'); ?>
        <?php echo $form->textField($model,'Name',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'Name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'Version'); ?>
        <?php echo $form->textField($model,'Version'); ?>
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
        (ZIP files under 5mb)<br>
        <?php echo $form->fileField($model,'UploadFile'); ?>
        <?php echo $form->error($model,'UploadFile'); ?>
    </div>
    
   <div class="row buttons">
       <br><br>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>
