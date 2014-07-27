<?php
/* @var $this PolicyController */
/* @var $model Policy */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Name'); ?>
		<?php echo $form->textField($model,'Name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Description'); ?>
		<?php echo $form->textArea($model,'Description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PolicyTriggerID'); ?>
		<?php echo CHtml::dropDownList('Policy[PolicyTriggerID]', $model->PolicyTriggerID, CHTML::listData(PolicyTrigger::model()->findAll(array('order'=>'Name')), 'idPolicyTrigger', 'Name'), array('prompt' => 'Select a PolicyTrigger')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PolicyActionID'); ?>
		<?php echo CHtml::dropDownList('Policy[PolicyActionID]', $model->PolicyActionID, CHTML::listData(PolicyAction::model()->findAll(array('order'=>'Name')), 'idPolicyAction', 'Name'), array('prompt' => 'Select a PolicyAction')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TriggerValue1'); ?>
		<?php echo $form->textField($model,'TriggerValue1',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ActionValue1'); ?>
		<?php echo $form->textField($model,'ActionValue1',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ActionValue2'); ?>
		<?php echo $form->textField($model,'ActionValue2',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->