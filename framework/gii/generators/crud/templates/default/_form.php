<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?= "<?php\n"; ?>
/* @var $this <?= $this->getControllerClass(); ?> */
/* @var $model <?= $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>

<div class="form">

<?= "<?php \$form=\$this->beginWidget('CActiveForm', [
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
]); ?>\n"; ?>
    
	<?= "<?= \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
?>
		<?= "<?= ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
		<?= "<?= ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
		<?= "<?= \$form->error(\$model,'{$column->name}'); ?>\n"; ?>

<?php
}
?>
	<div class="buttons">
		<?= "<?= CHtml::submitButton(\$model->isNewRecord ? 'Создать' : 'Сохранить'); ?>\n"; ?>
	</div>

<?= "<?php \$this->endWidget(); ?>\n"; ?>

</div>
