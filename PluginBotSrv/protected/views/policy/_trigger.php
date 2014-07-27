<?php
/* @var $this PolicyController */
/* @var $model Policy */
/* @var $policy PolicyForm */
/* @var $form CActiveForm */

$form = new CActiveForm();

?>
<?php if(isset($model) && isset($model->policyTrigger)): ?>
 
<div class="form-area">
    <b><?php echo $model->policyTrigger->Name; ?></b>
    <br>
    <?php echo $model->policyTrigger->Description; ?>
            <div class="row">
            
                <?php
                if($model->policyTrigger->hasValue1 == 1)
                {
                    echo '<br>';
                    echo $form->labelEx($model, $model->policyTrigger->Label1);

                    FormHelper::RenderField('TriggerValue1', $model->TriggerValue1, $model->policyTrigger->valueTypeID1->Name, $this, $model, $form);
                }
                else
                {
                    echo '<br>(There are no additional options available.)';
                }

                
                ?>
 
        </div> 
</div>
<br>
<?php endif; ?>
