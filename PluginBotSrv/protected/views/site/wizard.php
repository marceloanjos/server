<?php
/* @var $this LoginController */
/* @var $model Login */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Setup Wizard';
$this->breadcrumbs=array(
        'Setup Wizard'
);

?>

<h1>Setup Wizard</h1>

To begin, you will need to create a administrative login.<br><br>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>false,
)); ?>
            <div class="table">
                <div class="row">
                    <div class="cell">

                    


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'FirstName'); ?>
		<?php echo $form->textField($model,'FirstName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'FirstName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'LastName'); ?>
		<?php echo $form->textField($model,'LastName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'LastName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Email'); ?>
		<?php echo $form->emailField($model,'Email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Password'); ?>
		<?php echo $form->passwordField($model,'Password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Password'); ?>
	</div>

	
        <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
        
        </div>
                    <div class="cell sideimage">
                        <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/pluginbot-windows-256x256.png') ?>
                    </div>
                </div>
            </div>
<?php $this->endWidget(); ?>

</div><!-- form -->