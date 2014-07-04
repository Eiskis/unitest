<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('error_log', 'errors.log');
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');

include_once '../release/Unitest.php';
include_once 'baseline.php';
include_once 'helpers.php';

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">



		<title>Unitest</title>

		<meta name="application-name" content="'.htmlspecialchars($page->siteName()).'">
		<meta property="og:site_name" content="'.htmlspecialchars($page->siteName()).'">

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

		<?php
			$u = new Unitest();
			$u->scrape('spec');
			$u->setParameter('foo', 1);
			$u->setParameter('bar', 2);
			$u->setParameter('string', 'Some string value');
			$results = $u->run();
		?>



		<h1>Unitest demo</h1>

		<pre><code>$u = new Unitest();
$u->scrape('spec');
$u->setParameter('foo', 1);
$u->setParameter('bar', 2);
$u->setParameter('string', 'Some string value');
$results = $u->run();</code></pre>



		<div class="canvas hidden">

			<h2><code>$u->dump()</code></h2>

			<pre><code><?php echo dump($u->dump()); ?></code></pre>

		</div>



		<h2>Get results</h2>

		<div class="canvas">

			<p>This is what <code>$results</code>, returned by <code>$u->run()</code>, looks like:</p>

			<pre><code><?php echo dump($results); ?></code></pre>

		</div>



		<h2>Showing results as JSON</h2>

		<div class="canvas">

			<p>Convert into JSON with <code>$u->asJson($results)</code> (formatted for clarity here only):</p>

			<pre class="language-javascript"><code><?php echo prettyPrintJson($u->asJson($results)); ?></code></pre>

		</div>



		<h2>Sort results</h2>

		<div class="canvas">

			<p>Get all test results by status with <code>$u->byStatus($results)</code>:</p>

			<pre><code><?php echo dump($u->byStatus($results)); ?></code></pre>

		</div>



		<h2>Tally results</h2>

		<div class="canvas">

			<p>Get statistics (number of passed objects etc.) <code>$u->asNumbers($results)</code>:</p>

			<pre><code><?php echo dump($u->asNumbers($results)); ?></code></pre>

		</div>



		<script type="application/javascript" src="prism.js"></script>

	</body>
</html>
