<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta name="language" content="en" />
	<base href="<?php echo '//'.Yii::app()->request->getServerName().Yii::app()->request->baseUrl; ?>/" >

	<title><?php echo Yii::app()->name ?>::<?php echo $this->pageTitle ?></title>
	<meta name="description" content="">
	<meta name="author" content="Quaffs">
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="stylesheet" href="css/colorbox.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="css/custom.css" type="text/css" media="screen" charset="utf-8">
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<script src="js/libs/modernizr-2.0.min.js"></script>
	<script src="js/libs/respond.min.js"></script>
	
</head>
<body >
	<div id="wrap-body">
		<?php echo $content ?>
		<div class='clear'></div>
		<div id="wrap-foot">&copy; Copyright <?php echo date('Y') ?>. All Rights Reserved</div>
	</div>

<script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>
<script src="js/libs/jquery.colorbox-min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/libs/zz.tools.js" type="text/javascript" charset="utf-8"></script>
<script src="js/custom.js" type="text/javascript" charset="utf-8"></script>
<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->
</body>
</html>