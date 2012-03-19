<!DOCTYPE html>
<html lang="en-GB">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta name="language" content="en" />
	<base href="<?php echo '//'.Yii::app()->request->getServerName().Yii::app()->request->baseUrl; ?>/" >
	<title><?php echo Yii::app()->name ?></title>
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<script src="js/jquery.colorbox-min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery-ui-1.8.9.custom.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/zz.tools.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="css/colorbox.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="css/custom.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="css/jquery-ui-1.8.9.custom.css" type="text/css" media="screen" title="jqueryui" charset="utf-8">
	
</head>
<body style='background-color:#F8F8F8;'>
<div id="wrap-middle">
	
	<div style='position:fixed;top:0px;width:100%;z-index:2;' class='clicktohide'>
		<?php foreach(Yii::app()->user->getFlashes() as $key => $message) {
		    if ($key=='counters') {continue;} //no need next line since 1.1.7
		    echo "<div class='flash-{$key}'>{$message}</div>";
		} ?>
	</div>
	
	<div style='width:600px;margin:200px auto;text-align:center;'><?php echo $content ?></div>
	<div class='clear'></div>
	<div id="wrap-foot">&copy; Copyright <?php echo date('Y') ?> <?php echo Hook::get('org.name') ?>. All Rights Reserved</div>
</div>

<script src="js/libs/jquery.colorbox-min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/libs/zz.tools.js" type="text/javascript" charset="utf-8"></script>
<script src="js/custom.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>