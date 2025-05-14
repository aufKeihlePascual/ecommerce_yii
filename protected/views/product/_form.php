<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>

<div class="product-form-card">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'product-form',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model, null, null, array('class'=>'form-errors')); ?>

    <div class="form-field">
        <?php echo $form->labelEx($model,'brand'); ?>
        <?php echo $form->textField($model,'brand', array('placeholder'=>'Brand name')); ?>
        <?php echo $form->error($model,'brand'); ?>
    </div>

    <div class="form-field">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name', array('placeholder'=>'Product name')); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="form-field">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description', array('class'=>'rich-text', 'rows'=>5, 'placeholder'=>'Product description')); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <div class="form-field">
        <?php echo $form->labelEx($model,'price'); ?>
        <?php echo $form->textField($model,'price', array('placeholder'=>'₱0.00')); ?>
        <?php echo $form->error($model,'price'); ?>
    </div>

    <div class="form-field">
        <?php echo $form->labelEx($model,'stock'); ?>
        <?php echo $form->textField($model,'stock', array('placeholder'=>'0')); ?>
        <?php echo $form->error($model,'stock'); ?>
    </div>

    <!-- <div class="form-field">
        <?php //echo $form->labelEx($model,'category_id'); ?>
        <?php //echo $form->textField($model,'category_id', array('placeholder'=>'Category ID')); ?>
        <?php //echo $form->error($model,'category_id'); ?>
    </div> -->

    <div class="form-field">
        <?php echo $form->labelEx($model,'category_id'); ?>
        <?php echo $form->dropDownList(
            $model,
            'category_id',
            $categoryList,
            ['prompt'=>'– Select Category –']
        ); ?>
        <?php echo $form->error($model,'category_id'); ?>
    </div>


    <div class="form-field media-upload-field">
        <label>Media</label>
        <div class="upload-zone">
            <!-- <i class="fa fa-upload"></i> -->
            <?php echo $form->fileField($model, 'image'); ?>
            <p class="upload-hint">Add file<br><small>or drop files to upload</small></p>
        </div>
        <?php echo $form->error($model,'image'); ?>
    </div>

    <div class="submit-wrapper">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'submit-btn')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
