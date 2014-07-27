<?php
/* @var $this PluginFileController */
/* @var $model PluginFile */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'OperatingSystemID'); ?>
		<?php echo CHtml::dropDownList('PluginFile[OperatingSystemID]', $model->OperatingSystemID, CHTML::listData(OperatingSystem::model()->findAll(array('order'=>'Name')), 'idOperatingSystem', 'Name'), array('prompt' => 'Select a OperatingSystem')); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'Name'); ?>
		<?php echo $form->textField($model,'Name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DateReleased'); ?>
		<?php echo $form->textField($model,'DateReleased'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Version'); ?>
		<?php echo $form->textField($model,'Version'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Size'); ?>
		<?php echo $form->textField($model,'Size'); ?>
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