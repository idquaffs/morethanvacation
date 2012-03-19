<div style='width:400px;margin:auto'>
	<h1>Login</h1>
	<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'focus'=>array($model,'email'),
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); 
?>

	<table class="form">
		<tr >
			<td ><?php echo $form->labelEx($model,'email'); ?></td>
		</tr>
		<tr >
			<td ><?php echo $form->textField($model,'email'); ?>
			<?php echo $form->error($model,'email'); ?></td>
		</tr>
		<tr ><td ></td></tr>
		<tr >
			<td ><?php echo $form->labelEx($model,'pwd'); ?></td>
		</tr>
		<tr >
			<td ><?php echo $form->passwordField($model,'pwd'); ?>
			<?php echo $form->error($model,'pwd'); ?></td>
		</tr>
		<tr ><td ></td></tr>
		<tr ><td >
			<?php echo $form->checkBox($model,'rememberMe'); ?>
			<?php echo $form->label($model,'rememberMe'); ?>
			<?php echo $form->error($model,'rememberMe'); ?>
		</td></tr>
		<tr ><td ><button class='button bt3'> Login </button></td></tr>
	</table>
		<div class="row rememberMe">

		</div>

		<div class="row buttons">

		</div>

	<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>
