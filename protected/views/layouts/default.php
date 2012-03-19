<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<!-- <title>Travel Club, Great Deals, Great Savings - More Than Vacation</title> -->
<title><?php echo Yii::app()->name ?>::<?php echo $this->pageTitle ?></title>
<meta name="description" content="More than a vacation, it's a travel club with great deals and great savings" />
<meta name="viewport" content="width=device-width" />
<?php /*?><base href="<?php echo '//'.Yii::app()->request->getServerName().Yii::app()->request->baseUrl; ?>/" ><?php */?>
<link rel="stylesheet" href="css/style.css" />
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css' />
<script src="js/libs/modernizr-2.5.3.min.js"></script>
</head>
<body>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
<div id="pagebg"></div>
<div class="container clearfix">
    <header id="header" class="clearfix">
        <img src="img/logo-333.jpg" alt="More Than Vacation" />
        <h1>Enjoy Awesome Vacations at Incredible Prices <br />
            &amp; Earn Money While Vacationing!</h1>
    </header>
	<?php echo $content ?>
    <footer id="footer">
    	Travel Club, Great Deals, Great Savings - More Than Vacation <?php echo date('Y') ?>
    </footer>
</div>

<!-- JavaScript at the bottom for fast page loading --> 
<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline --> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> 
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script> 

<!-- scripts concatenated and minified via build script --> 
<script src="js/plugins.js"></script> 
<script src="js/script.js"></script>
<!-- end scripts --> 

<!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
mathiasbynens.be/notes/async-analytics-snippet --> 
<!-- <script>
var _gaq=[['_setAccount','UA-30053034-1'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
</script> -->
</body>
</html>