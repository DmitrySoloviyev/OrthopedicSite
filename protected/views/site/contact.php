<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - Контакты';
?>

<?php if (Yii::app()->user->hasFlash('contact')): ?>
    <div class="flash-success">
        <?= Yii::app()->user->getFlash('contact'); ?>
    </div>
<?php else: ?>

    <p>
        Если у вас есть предложения или вопросы, пожалуйста, заполните следующую форму, чтобы связаться со мной.
        Спасибо.
    </p>

    <div class="form">
        <?php $form = $this->beginWidget('CActiveForm', [
            'id' => 'contact-form',
            'enableClientValidation' => true,
            'clientOptions' => [
                'validateOnSubmit' => true,
            ],
        ]); ?>

        <p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

        <?= $form->errorSummary($model); ?>

        <div class="row">
            <?= $form->labelEx($model, 'name'); ?><br/>
            <?= $form->textField($model, 'name'); ?>
            <?= $form->error($model, 'name'); ?>
        </div>

        <div class="row">
            <?= $form->labelEx($model, 'email'); ?><br/>
            <?= $form->textField($model, 'email'); ?>
            <?= $form->error($model, 'email'); ?>
        </div>

        <div class="row">
            <?= $form->labelEx($model, 'subject'); ?><br/>
            <?= $form->textField($model, 'subject', ['size' => 20, 'maxlength' => 128]); ?>
            <?= $form->error($model, 'subject'); ?>
        </div>

        <div class="row">
            <?= $form->labelEx($model, 'body'); ?><br/>
            <?= $form->textArea($model, 'body', ['rows' => 6, 'cols' => 50]); ?>
            <?= $form->error($model, 'body'); ?>
        </div>

        <?php if (CCaptcha::checkRequirements()): ?>
            <div class="row">
                <?= $form->labelEx($model, 'verifyCode'); ?>
                <div>
                    <?php $this->widget('CCaptcha'); ?>
                    <?= $form->textField($model, 'verifyCode'); ?>
                </div>
                <div class="hint">Пожалуйста, введите буквы, изображенные на картинке выше.
                    <br/>Буквы не чувствительны к регистру.
                </div>
                <?= $form->error($model, 'verifyCode'); ?>
            </div>
        <?php endif; ?>

        <div class="row buttons">
            <?= CHtml::submitButton('Отправить'); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>

<?php endif; ?>
