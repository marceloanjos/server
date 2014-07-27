<?php
/* @var $this PolicyController */
/* @var $model Policy */
/* @var $policy PolicyForm */
/* @var $form CActiveForm */

$form = new CActiveForm();

?>
<?php if(isset($model) && isset($model->policyAction)): ?>
 
<div class="form-area">
    <b><?php echo $model->policyAction->Name; ?></b>
    <br>
    <?php echo $model->policyAction->Description; ?>
            <div class="row">
            
                <?php
                if($model->policyAction->hasValue1 == 1)
                {
                    echo '<br>';
                    echo $form->labelEx($model, $model->policyAction->Label1);
                    FormHelper::RenderField('ActionValue1', $model->ActionValue1, $model->policyAction->valueTypeID1->Name, $this, $model, $form);
                }
                else
                {
                    echo '<br>(There are no additional options available.)';
                }

                if($model->policyAction->hasValue2 == 1)
                {
                    echo '<br>';
                    echo $form->labelEx($model, $model->policyAction->Label2);
                   
                    FormHelper::RenderField('ActionValue2', $model->ActionValue2, $model->policyAction->valueTypeID2->Name, $this, $model, $form);
                }
                
                ?>
 
        </div> 
</div>
<br>
<?php endif; ?>
