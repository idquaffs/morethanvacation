<?php 
	$LabelHtmlOption = array('style'=>'margin-top:0px;');
	$TextFieldHtmlOption = array('style'=>'font-size:16pt;');
	$SelectFieldHtmlOption = array('style'=>'font-size:14pt;width:277px');
	CHtml::$afterRequiredLabel = '';
	CHtml::$beforeRequiredLabel = '* ';
?>

<?php
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'signup-form',
	'enableClientValidation'=>true,
	//'htmlOptions'=>array('enctype' => 'multipart/form-data'),
	'clientOptions'=>array(
	//	'enctype'=>'multipart/form-data',
		'validateOnSubmit'=>true,
	),
));
?>
<div style='margin:20px auto;width:500px' class='selectfalse'>
	<ul class='form'>
		<li >
			<span class='label'><?php echo $form->labelEx($model,'email',$LabelHtmlOption); ?> :</span>
			<?php echo $form->textField($model,'email',$TextFieldHtmlOption); ?>
			<?php echo $form->error($model,'email'); ?>
		</li>
		<li >
			<span class='label'><?php echo $form->labelEx($model,'pwd',$LabelHtmlOption); ?> :</span>
			<?php echo $form->passwordField($model,'pwd',$TextFieldHtmlOption); ?>
			<?php echo $form->error($model,'pwd'); ?>
		</li>
		<li >
			<span class='label'><?php echo $form->labelEx($model,'name',$LabelHtmlOption); ?> :</span>
			<?php echo $form->textField($model,'name',$TextFieldHtmlOption); ?>
			<?php echo $form->error($model,'name'); ?>
		</li>
		<li >
			<span class='label'><?php echo $form->labelEx($model,'dob',$LabelHtmlOption); ?> :</span>
			<?php echo 	$form->dropdownList($model,'dobmonth',Fish::select(Fish::date('month'),'Month'),array('class'=>'selectdate month')).
						$form->dropdownList($model,'dobday',Fish::select(Fish::date('day'),'Day'),array('class'=>'selectdate day')).
						$form->dropdownList($model,'dobyear',Fish::select(Fish::date('year'),'Year'),array('class'=>'selectdate year')); ?>
			<?php echo $form->hiddenField($model,'dob'); ?>
			<?php echo $form->error($model,'dob'); ?>		
		</li>
		<li >
			<span class='label'><?php echo $form->labelEx($model,'gender',$LabelHtmlOption); ?> :</span>
			<?php echo $form->dropdownList($model,'gender',Fish::select(Yii::app()->params['flag']['gender']),array('style'=>'width:90px')); ?>
			<?php echo $form->error($model,'gender'); ?>
		</li>
		<li >
			<span class='label'><?php echo $form->labelEx($model,'contact_country',$LabelHtmlOption); ?> :</span>
			<?php echo $form->dropdownList($model,'contact_country',Fish::select(Yii::app()->params['country'],'')); ?>
			<?php echo $form->error($model,'contact_country'); ?>		
		</li>
	</ul>
	<button class='button bt3'> Signup </button>
</div>
<?php $this->endWidget(); ?>


<style type="text/css" media="screen">
	.form tr span.label{display:block;padding-top:6px;text-align:right;}
</style>

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