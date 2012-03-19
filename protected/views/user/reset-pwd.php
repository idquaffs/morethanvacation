<?php 
	CHtml::$afterRequiredLabel = '';
	CHtml::$beforeRequiredLabel = '* ';
	$LabelHtmlOption = array('style'=>'margin-top:0px;');
	$TextFieldHtmlOption = array('style'=>'font-size:16pt;');
	$SelectFieldHtmlOption = array('style'=>'font-size:14pt;width:277px');
?>
<?php
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'resetpassword-form',
	'enableClientValidation'=>true,
	//'htmlOptions'=>array('enctype' => 'multipart/form-data'),
	'clientOptions'=>array(
	//	'enctype'=>'multipart/form-data',
		'validateOnSubmit'=>true,
	),
));
?>
<div style='width:400px;margin:auto;'>
	<ul class='form'>
		<li >
			<span class="label">
				<span class='label'><?php echo $form->labelEx($model,'pwd',$LabelHtmlOption); ?> : </span>
				<?php echo $form->passwordField($model,'pwd',$TextFieldHtmlOption); ?>
				<?php echo $form->error($model,'pwd'); ?>
			</span>
		</li>
		<li >
			<span class="label">
				<span class='label'><?php echo $form->labelEx($model,'pwd2',$LabelHtmlOption); ?> : </span>
				<?php echo $form->passwordField($model,'pwd2',$TextFieldHtmlOption); ?>
				<?php echo $form->error($model,'pwd2'); ?>
			</span>
		</li>
	</ul>
	<button class='button bt3'> Reset Password </button>
</div><!--  -->
<?php $this->endWidget(); ?>

<script type="text/javascript" charset="utf-8">
$(function(){
	$('select.selectdate').change(function(){
		var y = $('select#User_dobyear').val();
		var m = $('select#User_dobmonth').val();
		var d = $('select#User_dobday').val();
		if ( y != '' && m != '' && d != '') {
			var fulldate = y+'-'+m+'-'+d;
			$('input#User_dob').val(fulldate);
		};
	});
});
</script>
<style type="text/css" media="screen">
	
</style>