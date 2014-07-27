<?php
/* @var $this PluginController */
/* @var $model Plugin */
/* @var $form CActiveForm */
Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'plugin-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>



	<div class="row">
		<?php echo $form->labelEx($model,'Name'); ?>
		<?php echo $form->textField($model,'Name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'Name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Description'); ?>
		<?php echo $form->textArea($model,'Description',array('rows'=>12, 'cols'=>85)); ?>
		<?php echo $form->error($model,'Description'); ?>
	</div>

        <div class="row">
		<?php echo $form->labelEx($model,'PluginFileID'); ?>
		<?php echo CHtml::dropDownList('Plugin[PluginFileID]', $model->PluginFileID, CHTML::listData(PluginFile::model()->findAll(array('order'=>'Name')), 'idPluginFile', 'Name'), array(
                    'prompt' => 'Select a PluginFile',
                    'ajax' => array(
                            'type' => 'POST',
                            'url' => CController::createUrl('plugin/PluginChange'),
                            'update' => '#pluginarea',
                            'data' => array('PluginFileID' => 'js:this.value', 'Plugin' => CJSON::encode($model->attributes)),
                            'error' => 'function(err){alert(\'Ajax Error\');}',
                        ),
                    )); ?>
		<?php echo $form->error($model,'PluginFileID'); ?>
	</div>
        
        <div  id="pluginarea">
            <?php $this->renderPartial('_plugin', array('model' => $model), false, true); ?>
        </div>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->