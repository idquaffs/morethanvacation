<?php 
//echo "<pre>"; print_r( $profile ); 
//echo "<pre>"; print_r( $user ); exit;
//exit; ?>
<?php if (!empty($user['pwd'])): ?>
	<h3 >You have previously register with us (<?php echo $user['email'] ?>) </h3>
<?php endif ?>

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
	<ul class='nolist form'>
		<li >
			<span class='label'><?php echo $form->labelEx($model,'name',$LabelHtmlOption); ?> :</span>
			<?php $model->name = (!empty($user['name']))?$user['name']:$profile['name']; ?>
			<?php echo $form->textField($model,'name',$TextFieldHtmlOption); ?>
			<?php echo $form->error($model,'name'); ?>
			<?php if (!empty( $profile['name']) && $user['name'] != $profile['name'] ): ?>
				<div class="usefb">
					Use <span class='field link'><?php echo $profile['name'] ?></span> instead?
				</div>
			<?php endif ?>
		</li>
		<?php if (empty($user['pwd'])): ?>
		<li >
			<span class='label'><?php echo $form->labelEx($model,'pwd',$LabelHtmlOption); ?> : </span>
			<?php echo $form->passwordField($model,'pwd',$TextFieldHtmlOption); ?>
			<?php echo $form->error($model,'pwd'); ?>
		</li>
		<?php endif ?>
		<li >
			<span class='label'><?php echo $form->labelEx($model,'dob',$LabelHtmlOption); ?> :</span>
			<?php if (!empty($user['dob'])){
				$model->dob = $user['dob'];
				$model->dobday = ltrim(Fish::xr(explode('-',$user['dob']),'2'),'0');
				$model->dobmonth = Fish::xr(explode('-',$user['dob']),'1');
				$model->dobyear = Fish::xr(explode('-',$user['dob']),'0');
			} ?>
			<?php $model->dob = (!empty($user['dob']))?$user['dob']:$profile['dob']; ?>
			<?php echo 	$form->dropdownList($model,'dobmonth',Fish::select(Fish::date('month'),'Month'),array('class'=>'selectdate month')).
						$form->dropdownList($model,'dobday',Fish::select(Fish::date('day'),'Day'),array('class'=>'selectdate day')).
						$form->dropdownList($model,'dobyear',Fish::select(Fish::date('year'),'Year'),array('class'=>'selectdate year')); ?>
			<?php echo $form->hiddenField($model,'dob'); ?>
			<?php echo $form->error($model,'dob'); ?>
			<?php if (!empty( $profile['dob']) && $user['dob'] != $profile['dob'] ): ?>
				<div class="usefb">
					Use <span class='field link' id='dob'><?php echo $profile['dob'] ?></span> instead?
				</div>
			<?php endif ?>
		</li>
		<li >
			<span class='label'><?php echo $form->labelEx($model,'gender',$LabelHtmlOption); ?> :</span>
			<?php $model->gender = (isset($profile['gender']))?$profile['gender']:''; ?>
			<?php $model->gender = (!empty($user['gender']))?$user['gender']:''; ?>
			<?php echo $form->dropdownList($model,'gender',Fish::select(Yii::app()->params['flag']['gender']),array('style'=>'width:90px')); ?>
			<?php echo $form->error($model,'gender'); ?>
		</li>
		<li >
			<span class='label'><?php echo $form->labelEx($model,'contact_country',$LabelHtmlOption); ?> :</span>
			<?php $model->contact_country = (!empty($user['contact_country']))?$user['contact_country']:''; ?>
			<?php echo $form->dropdownList($model,'contact_country',Fish::select(Yii::app()->params['country'],'')); ?>
			<?php echo $form->error($model,'contact_country'); ?>
		</li>
	</ul>
	
	<button class='button bt2'>Continue</button>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript" charset="utf-8">
$(function(){
	$('div.usefb span.field').click(function(e){
		var target = $( this );
		target.closest('li').children('input').val(target.html());
	});
	$('div.usefb span.field#dob').click(function(e){
		var target = $( this );
		$('select#User_dobday').val((target.html().split('-')[2]).replace(/^[0]+/g, ''));
		$('select#User_dobmonth').val(target.html().split('-')[1]);
		$('select#User_dobyear').val(target.html().split('-')[0]);
	});
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
	div.usefb {font-style:italic;font-size:9pt;}
	div.usefb span.field{cursor:pointer;}
</style>