<?php if (!UserId::get()): ?>
	<div id="wrap-banner">
		<div style='width:480px;margin:20px;'>
			<h2 ><?php echo Hook::get('label.introduction') ?></h2>
			<div style='width:400px;'>
				<form action="/user/subscribe" method="post" accept-charset="utf-8">
					<input type="text" id='email' name="email" value="" placeholder='Email Address' id="email" />
					<button id='subscribe' class='bt3 button'> Join Now ! </button>
					<div class='clear' style='height:4px;'></div>
				</form>
			</div><!--  -->
			<div style='margin:4px 110px'>
				Or
			</div>
			<div style='width:100px;margin:4px 40px'>
				<a href="<?php echo $fburl ?>">
					<img src="data:image/png;base64,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" alt="facebook login" title="facebook login" />
				</a>
			</div>
		</div>
		<div id="vid">

		</div><!-- vid -->
		<div class='clear'></div>	
	</div><!-- wrap-banner -->
	<div class='clear' style='height:40px;'></div>
<?php endif ?>

<div id="wrap-flag-category" >
	<ul class="nolist">
	<?php if ($flag) {
		foreach ($flag as $row) { 
			$this->renderPartial('/_partial/flag_head',array('row'=>$row));
		}
	} ?>
	</ul>
	<div class='clear'></div>

</div><!-- wrap-bottom -->


