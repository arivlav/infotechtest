<?php
/** @var AuthorController $this */
/** @var Author $model */
/** @var CActiveFormWidget $form */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', [
            'id' => 'author-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => [
                    'validateOnSubmit' => true
            ],
    ]); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'last_name'); ?>
        <?php echo $form->textField($model, 'last_name', ['size' => 60, 'maxlength' => 255]); ?>
        <?php echo $form->error($model, 'last_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'first_name'); ?>
        <?php echo $form->textField($model, 'first_name', ['size' => 60, 'maxlength' => 255]); ?>
        <?php echo $form->error($model, 'first_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'middle_name'); ?>
        <?php echo $form->textField($model, 'middle_name', ['size' => 60, 'maxlength' => 255]); ?>
        <?php echo $form->error($model, 'middle_name'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

