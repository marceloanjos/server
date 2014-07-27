<?php
/* @var $this DeviceController */
/* @var $model Device */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'device-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'OperatingSystemID'); ?>
		<?php echo CHtml::dropDownList('Device[OperatingSystemID]', $model->OperatingSystemID, CHTML::listData(OperatingSystem::model()->findAll(array('order'=>'Name')), 'idOperatingSystem', 'Name'), array('prompt' => 'Select a OperatingSystem')); ?>
		<?php echo $form->error($model,'OperatingSystemID'); ?>
	</div>

        <div class="row">
		<?php echo $form->labelEx($model,'Bits'); ?>
		<?php //echo $form->numberField($model,'Bits'); ?>
                <?php FormHelper::RenderBitsField('Bits', $form, $model);  ?>
		<?php echo $form->error($model,'Bits'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'Name'); ?>
		<?php echo $form->textField($model,'Name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'IPAddress'); ?>
		<?php echo $form->textField($model,'IPAddress',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'IPAddress'); ?>
	</div>

	

	<div class="row">
		<?php echo $form->labelEx($model,'UpdateInterval'); ?>
		<?php //echo $form->numberField($model,'UpdateInterval'); ?>
                <?php FormHelper::RenderField('UpdateInterval', $model->UpdateInterval, 'NUMBER', $this, $model, $form, 60);  ?>
		<?php echo $form->error($model,'UpdateInterval'); ?>
	</div>

            
       <div class="row">
		<?php echo $form->labelEx($model,'Description'); ?>
		<?php echo $form->textArea($model,'Description',array('rows'=>12, 'cols'=>85)); ?>
		<?php echo $form->error($model,'Description'); ?>
	</div>
        
        
        <div class="table">
                <div class="row">
                    <div class="cell checkbox">
                        <?php echo $form->checkBox($model,'isMissing'); ?>
                    </div>
                    <div class="cell text">
                        <?php echo $form->labelEx($model,'isMissing'); ?>
                        <?php echo $form->error($model,'isMissing'); ?>
                    </div>
                </div>
            </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->