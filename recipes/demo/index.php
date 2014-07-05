<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('error_log', 'errors.log');
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');

include_once '../../Unitest.php';
include_once 'baseline.php';

?>

<?php
	$u = new Unitest();
	$u->scrape('../../spec/');
	$u->inject('foo', 1);
	$u->inject('bar', 2);
	$u->inject('string', 'Some string value');
	$results = $u->run();
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



		<h1>Unitest demo</h1>

		<pre><code>$u = new Unitest();
$u->scrape('spec');
$u->inject('foo', 1);
$u->inject('bar', 2);
$u->inject('string', 'Some string value');</code></pre>



		<h1>Dump</h1>

		<div class="canvas">

			<p><code>$u->dump()</code></p>

			<pre><code><?php echo dump($u->dump()); ?></code></pre>

		</div>



		<h1>Get results</h1>

		<div class="canvas">

			<p>This is what <code>$u->run()</code> returns:</p>

			<pre><code><?php echo dump($results); ?></code></pre>

		</div>



		<h1>Sort results</h1>

		<div class="canvas">

			<p>Get all test results by status with <code>$u->byStatus($results)</code>:</p>

			<pre><code><?php echo dump($u->byStatus($results)); ?></code></pre>

		</div>



		<h1>Tally results</h1>

		<div class="canvas">

			<p>Get statistics (number of passed objects etc.) <code>$u->asNumbers($results)</code>:</p>

			<pre><code><?php echo dump($u->asNumbers($results)); ?></code></pre>

		</div>



		<script type="application/javascript" src="prism.js"></script>

	</body>
</html>
