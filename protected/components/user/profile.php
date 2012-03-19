<?php $ajaxform = array('class'=>'ajaxform'); ?>
<div style='min-width:990px'>
	<div id='userleftbar' style='float:left;width:250px;padding:30px 0 0 30px;'>
		<h3 >Membership</h3>
		<div >
			<?php if (UserId::get('isVip')): ?>
				VIP
			<?php elseIf (UserId::get('isPremium')): ?>
				Premium Member
			<?php else: ?>
				Registered Member
			<?php endif ?>
			
			<div class='clear' style='height:20px'></div>
			<h3 >Status</h3>
			<?php if (UserId::get('isBanned')): ?>
				Ban
			<?php elseIf (UserId::get('isActivate')): ?>
				Activated
			<?php else: ?>
				Non Activate
			<?php endif ?>
			
			<?php if (UserId::get('canAccessAdmin')): ?>
				<div class='clear' style='height:20px'></div>
				<h3 >Admin Privilage</h3>
				<?php if (UserId::get('isDev')): ?>
					Developer
				<?php endif ?>
				<?php if (UserId::get('isSuper')): ?>
					Super Admin
				<?php endif ?>
				<?php if (UserId::get('isAdmin')): ?>
					Admin
				<?php endif ?>
				<?php if (UserId::get('isEditor')): ?>
					Editor
				<?php endif ?>
			<?php endif ?>
			
		</div>
	</div><!-- userleftbar -->
	<div style='float:left;width:600px;'>
		<div style='margin:20px;width:600px;'>
			<ul >
				<li >
					<div style='float:left;width:150px;margin:0px 0 16px 100px;'>
						<div style="float:left;border:1px solid #CCC;padding:4px;height:98px;"><img src="/resources/anonymous-big.png" style='border:1px solid #CCC;' /></div>
					</div>
					<div style='float:left;width:200px;'>
						<div >Login Email : <?php echo $profile['email'] ?></div>
						<div style='margin:10px 0;'>
							<div id='pwd-display' class='display' >
								<span class="edit" >[Change Password]</span>
							</div>
							<div id='pwd-edit' class='edit hide'>
								<span class="value">
									<input type="password" name="User[oldpwd]" class='ajaxform' value="" id="User[oldpwd]" placeholder="Current Password" />
									<input type="password" name="User[newpwd]" class='ajaxform' value="" id="User[oldpwd]" placeholder="New Password" />
								</span>
								<span class='edit'>Save</span> <span class='cancel'>&times;</span>
							</div>
						</div>
					</div>
					<div class='clear'></div>
				</li>
				<li class='field'>
					<div class="display holder">
						<span class='edit'>Edit</span>
						<label><?php echo CHtml::activeLabel($model,'name') ?></label>
						<span class="value"><?php echo $profile['name'] ?></span>
						<div class='clear'></div>
					</div><!-- display -->
					<div class="edit holder">
						<span class='cancel'>&times;</span><span class='edit'>Save</span>
						<label><?php echo CHtml::activeLabel($model,'name') ?></label>
						<span class="value"><?php echo CHtml::activeTextField($model,'name',$ajaxform); ?></span>
						<div class='clear'></div>
					</div><!-- edit -->
				</li>
				<li class='field'>
					<div class="display holder">
						<span class='edit'>Edit</span>
						<label><?php echo CHtml::activeLabel($model,'dob') ?></label>
						<span class="value"><?php echo $profile['dob'] ?></span>
						<div class='clear'></div>
					</div><!-- display -->
					<div class="edit holder">
						<span class='cancel'>&times;</span><span class='edit'>Save</span>
						<label><?php echo CHtml::activeLabel($model,'dob') ?></label>
						<span class="value">
						<?php echo 	CHtml::activeDropdownList($model,'dobmonth',Fish::select(Fish::date('month'),'Month'),array('class'=>'selectdate month')).
									CHtml::activeDropdownList($model,'dobday',Fish::select(Fish::date('day'),'Day'),array('class'=>'selectdate day')).
									CHtml::activeDropdownList($model,'dobyear',Fish::select(Fish::date('year'),'Year'),array('class'=>'selectdate year')); ?>
						<?php echo CHtml::activeHiddenField($model,'dob',$ajaxform); ?>
						</span>
						<div class='clear'></div>
					</div><!-- edit -->
				</li>
				<li class='field'>
					<div class="display holder">
						<span class='edit'>Edit</span>
						<label><?php echo CHtml::activeLabel($model,'gender') ?></label>
						<span class="value"><?php echo (!empty($profile['gender']))?Yii::app()->params['flag']['gender'][$profile['gender']]:'' ?></span>
						<div class='clear'></div>
					</div><!-- display -->
					<div class="edit holder">
						<span class='cancel'>&times;</span><span class='edit'>Save</span>
						<label><?php echo CHtml::activeLabel($model,'gender') ?></label>
						<span class="value"><?php echo CHtml::activeDropdownList($model,'gender',Yii::app()->params['flag']['gender'],$ajaxform); ?></span>
						<div class='clear'></div>
					</div><!-- edit -->
				</li>
				<li class='field'>
					<div class="display holder">
						<span class='edit'>Edit</span>
						<label><?php echo CHtml::activeLabel($model,'contact_mobile') ?></label>
						<span class="value"><?php echo $profile['contact_mobile'] ?></span>
						<div class='clear'></div>
					</div><!-- display -->
					<div class="edit holder">
						<span class='cancel'>&times;</span><span class='edit'>Save</span>
						<label><?php echo CHtml::activeLabel($model,'contact_mobile') ?></label>
						<span class="value"><?php echo CHtml::activeTextField($model,'contact_mobile',$ajaxform); ?></span>
						<div class='clear'></div>
					</div><!-- edit -->
				</li>
				<li class='field'>
					<div class="display holder">
						<span class='edit'>Edit</span>
						<label><?php echo CHtml::activeLabel($model,'contact_home') ?></label>
						<span class="value"><?php echo $profile['contact_home'] ?></span>
						<div class='clear'></div>
					</div><!-- display -->
					<div class="edit holder">
						<span class='cancel'>&times;</span><span class='edit'>Save</span>
						<label><?php echo CHtml::activeLabel($model,'contact_home') ?></label>
						<span class="value"><?php echo CHtml::activeTextField($model,'contact_home',$ajaxform); ?></span>
						<div class='clear'></div>
					</div><!-- edit -->
				</li>
				<li class='field'>
					<div class="display holder">
						<span class='edit'>Edit</span>
						<label><?php echo CHtml::activeLabel($model,'contact_work') ?></label>
						<span class="value"><?php echo $profile['contact_work'] ?></span>
						<div class='clear'></div>
					</div><!-- display -->
					<div class="edit holder">
						<span class='cancel'>&times;</span><span class='edit'>Save</span>
						<label><?php echo CHtml::activeLabel($model,'contact_work') ?></label>
						<span class="value"><?php echo CHtml::activeTextField($model,'contact_work',$ajaxform); ?></span>
						<div class='clear'></div>
					</div><!-- edit -->
				</li>
				<li class='field'>
					<div class="display holder">
						<span class='edit'>Edit</span>
						<label><?php echo CHtml::activeLabel($model,'contact_address') ?></label>
						<span class="value"><?php echo $profile['contact_address'] ?></span>
						<div class='clear'></div>
					</div><!-- display -->
					<div class="edit holder">
						<span class='cancel'>&times;</span><span class='edit'>Save</span>
						<label><?php echo CHtml::activeLabel($model,'contact_address') ?></label>
						<span class="value"><?php echo CHtml::activeTextField($model,'contact_address',$ajaxform); ?></span>
						<div class='clear'></div>
					</div><!-- edit -->
				</li>
				<li class='field'>
					<div class="display holder">
						<span class='edit'>Edit</span>
						<label><?php echo CHtml::activeLabel($model,'contact_postal') ?></label>
						<span class="value"><?php echo $profile['contact_postal'] ?></span>
						<div class='clear'></div>
					</div><!-- display -->
					<div class="edit holder">
						<span class='cancel'>&times;</span><span class='edit'>Save</span>
						<label><?php echo CHtml::activeLabel($model,'contact_postal') ?></label>
						<span class="value"><?php echo CHtml::activeTextField($model,'contact_postal',$ajaxform); ?></span>
						<div class='clear'></div>
					</div><!-- edit -->
				</li>
				<li class='field'>
					<div class="display holder">
						<span class='edit'>Edit</span>
						<label><?php echo CHtml::activeLabel($model,'contact_country') ?></label>
						<span class="value"><?php echo (!empty($profile['contact_country']))?Yii::app()->params['country'][$profile['contact_country']]:'' ?></span>
						<div class='clear'></div>
					</div><!-- display -->
					<div class="edit holder">
						<span class='cancel'>&times;</span><span class='edit'>Save</span>
						<label><?php echo CHtml::activeLabel($model,'contact_country') ?></label>
						<span class="value"><?php echo CHtml::activeDropdownList($model,'contact_country',Fish::select(Yii::app()->params['country']),$ajaxform); ?></span>
						<div class='clear'></div>
					</div><!-- edit -->
				</li>
			</ul>
		</div>
	</div><!--  -->
</div><!--  -->
<style type="text/css" media="screen">
	li.field{margin:2px;padding:0px 20px;height:30px;background-color:#EEEEFA;}
	li.field div.edit{display:none;}
	
	li.field div.holder span.edit{float:right;display:none;cursor:pointer;}
	li.field div.holder span.cancel{float:right;display:none;cursor:pointer;}
	li.field div.holder span.edit:hover{text-decoration:underline;}
	li.field div.holder span.cancel:hover{text-decoration:underline;}
	li.field div.holder label{display:inline-block;width:150px;text-align:right;padding-right:20px;margin:4px;font-weight:bold;}
	li.field div.holder span.value{display:inline-block;}
	li.field div.holder:hover span.edit{display:inline;margin:6px 4px;}
	li.field div.holder:hover span.cancel{display:inline;margin:6px 4px;}

	li.field div.display span.value{margin-left:4px;}
	
	input[type="text"]{border:0;margin-top:0x;font-size:10pt;}
	
	#pwd-display{cursor:pointer;}
	#pwd-display:hover{text-decoration:underline;}
	#pwd-edit input[type="password"]{font-size:9pt;width:180px;}
	#pwd-edit span.edit{cursor:pointer;}
	#pwd-edit span.cancel{cursor:pointer;}
	#pwd-edit span.edit:hover{text-decoration:underline;}
	#pwd-edit span.cancel:hover{text-decoration:underline;}
</style>

<script type="text/javascript" charset="utf-8">
$(function(){
	init();
	initEvent();

});
function init () {
	$('select#User_dobday').val(($('#User_dob').val().split('-')[2]).replace(/^[0]+/g, ''));
	$('select#User_dobmonth').val($('#User_dob').val().split('-')[1]);
	$('select#User_dobyear').val($('#User_dob').val().split('-')[0]);
}
function initEvent () {
	
	$('select.selectdate').change(function(){
		var y = $('select#User_dobyear').val();
		var m = $('select#User_dobmonth').val();
		var d = $('select#User_dobday').val();
		if ( y != '' && m != '' && d != '') {
			var fulldate = y+'-'+m+'-'+d;
			$('input#User_dob').val(fulldate);
		};
	});
	$('div.display span.edit').click(function(e){
		$( this ).parent('div.display').hide().next('div.edit').show();
	});
	$('div.edit span.cancel').click(function(e){
		$( this ).parent('div.edit').hide().prev('div.display').show();
	});
	$('div.edit span.edit').click(function(e){
		var target = $( this );
		var form = target.siblings('span.value').children('.ajaxform');
		var data = {};
		form.each(function(e){
			var target = $( this );
			data[target.attr('name')]=target.val();
		});
		console.log(data);
		$.postJSON('/user/profile',data,function(e){
			for (i in e.data) break;
			target.parent('div.edit').hide().prev('div.display').show();
			target.closest('li.field').children('div.display').children('span.value').html(e.data[i]);
			flashMsg('success','profile update');
		});
	});
}
</script>