<?php
/* @var $this LogController */
/* @var $model Log */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'DeviceID'); ?>
		<?php echo CHtml::dropDownList('Log[DeviceID]', $model->DeviceID, CHTML::listData(Device::model()->findAll(array('order'=>'Name')), 'idDevice', 'Name'), array('prompt' => 'Select a Device')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'EventDate'); ?>
		<?php echo $form->textField($model,'EventDate'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->label($model,'IPAddress'); ?>
		<?php echo $form->textField($model,'IPAddress'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Name'); ?>
		<?php echo $form->textField($model,'Name',array('size'=>60,'maxlength'=>255)); ?>
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