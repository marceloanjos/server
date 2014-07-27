<?php
/* @var $this PolicyController */
/* @var $model Policy */
/* @var $form CActiveForm */
Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'policy-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Name'); ?>
		<?php echo $form->textField($model,'Name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Description'); ?>
		<?php echo $form->textArea($model,'Description',array('rows'=>12, 'cols'=>85)); ?>
		<?php echo $form->error($model,'Description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PolicyTriggerID'); ?>
		<?php 
                    echo CHtml::dropDownList('Policy[PolicyTriggerID]', $model->PolicyTriggerID, CHTML::listData(PolicyTrigger::model()->findAll(array('order'=>'Name')), 'idPolicyTrigger', 'Name'), array(
                        'prompt' => 'Select a Trigger',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => CController::createUrl('policy/TriggerChange'),
                            'update' => '#triggerarea',
                            'data' => array('PolicyTriggerID' => 'js:this.value', 'Policy' => CJSON::encode($model->attributes)),
                            'error' => 'function(err){alert(\'Ajax Error\');}',
                        ),
                        ));
                ?>
		<?php echo $form->error($model,'PolicyTriggerID'); ?>
	</div>

        
        <div  id="triggerarea">
            <?php $this->renderPartial('_trigger', array('model' => $model), false, true); ?>
        </div>
        

	<div class="row">
            <?php echo $form->labelEx($model,'PolicyActionID'); ?>
		<?php 
                    echo CHtml::dropDownList('Policy[PolicyActionID]', $model->PolicyActionID, CHTML::listData(PolicyAction::model()->findAll(array('order'=>'Name')), 'idPolicyAction', 'Name'), array(
                        'prompt' => 'Select a Action',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => CController::createUrl('policy/ActionChange'),
                            'update' => '#actionarea',
                            'data' => array('PolicyActionID' => 'js:this.value', 'Policy' => CJSON::encode($model->attributes)),
                            'error' => 'function(err){alert(\'Ajax Error\');}',
                        ),
                        ));
                ?>
		<?php echo $form->error($model,'PolicyActionID'); ?>
	</div>

	<div  id="actionarea">
            <?php $this->renderPartial('_action', array('model' => $model), false, true); ?>
        </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->