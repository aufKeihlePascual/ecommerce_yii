<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/login.css">
	
	<script src="https://kit.fontawesome.com/4e3a20099e.js"></script>
</head>

<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
    'Login',
);
?>

<section class="login-section bg-dark text-light">
    <div class="login-container">
        <h1>Login</h1>
        <p>Please enter your login credentials to access your account.</p>

        <div class="form-container">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'login-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
            )); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <div class="input-group">
                <?php echo $form->labelEx($model,'username'); ?>
                <?php echo $form->textField($model,'username', array('class'=>'input-field', 'placeholder'=>'Enter username')); ?>
                <?php echo $form->error($model,'username'); ?>
            </div>

            <div class="input-group">
                <?php echo $form->labelEx($model,'password'); ?>
                <?php echo $form->passwordField($model,'password', array('class'=>'input-field', 'placeholder'=>'Enter password')); ?>
                <?php echo $form->error($model,'password'); ?>
                <p class="hint">
                    Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.
                </p>
            </div>

            <div class="input-group rememberMe">
                <?php echo $form->checkBox($model,'rememberMe'); ?>
                <?php echo $form->label($model,'rememberMe'); ?>
                <?php echo $form->error($model,'rememberMe'); ?>
            </div>

            <div class="button-group">
                <?php echo CHtml::submitButton('Login', array('class' => 'login-btn')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</section>
