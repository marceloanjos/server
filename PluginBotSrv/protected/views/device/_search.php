<?php
/* @var $this DeviceController */
/* @var $model Device */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'OperatingSystemID'); ?>
		<?php echo CHtml::dropDownList('Device[OperatingSystemID]', $model->OperatingSystemID, CHTML::listData(OperatingSystem::model()->findAll(array('order'=>'Name')), 'idOperatingSystem', 'Name'), array('prompt' => 'Select a OperatingSystem')); ?>
	</div>
    
        <div class="row">
		<?php echo $form->label($model,'Bits'); ?>
		<?php echo $form->textField($model,'Bits'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->label($model,'Name'); ?>
		<?php echo $form->textField($model,'Name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IPAddress'); ?>
		<?php echo $form->textField($model,'IPAddress',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DateInstalled'); ?>
		<?php echo $form->textField($model,'DateInstalled'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DateUpdated'); ?>
		<?php echo $form->textField($model,'DateUpdated'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DateMissing'); ?>
		<?php echo $form->textField($model,'DateMissing'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'UpdateInterval'); ?>
		<?php echo $form->textField($model,'UpdateInterval'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'isMissing'); ?>
		<?php echo $form->checkBox($model,'isMissing'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Description'); ?>
		<?php echo $form->textArea($model,'Description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->