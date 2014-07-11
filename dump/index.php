<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
// ini_set('error_log', 'errors.log');
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');

// Lib
require_once '../Unitest.php';

// Variables
$specPath = '';
$injections = array();
require_once 'conf.php';

// Init
$u = new Unitest();
$u->scrape($specPath);
foreach ($injections as $key => $value) {
	$u->inject($key, $value);
}

$report = $u->run();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">



		<title>Unitest</title>

		<meta name="application-name" content="Unitest">
		<meta property="og:site_name" content="Unitest">

		<meta name="description" content="A one-class miniature unit testing framework for PHP">
		<meta property="og:description" content="A one-class miniature unit testing framework for PHP">

		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">



		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui">
		<meta name="msapplication-tap-highlight" content="no">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<style type="text/css">
			@-ms-viewport{width: device-width;}
			@-o-viewport{width: device-width;}
			@viewport{width: device-width;}
			body{-webkit-tap-highlight-color: transparent;-webkit-text-size-adjust: none;-moz-text-size-adjust: none;-ms-text-size-adjust: none;}
		</style>

		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="prism.css">

	</head>

	<body class="language-php">

		<?php echo '<pre><code class="language-javascript">'.json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).'</code></pre>'; ?>

		<script type="application/javascript" src="prism.js"></script>

	</body>
</html>
