<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('error_log', 'errors.log');
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');

include_once 'Unitest.php';
include_once 'baseline.php';

?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="utf-8">

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

		<style type="text/css">
			body {
				font-family: sans-serif;
				padding: 2% 6%;
				max-width: 40em;
				margin-left: auto;
				margin-right: auto;
				background-color: #fafafa;
				color: #444;
			}
			h1, h2, h3, h4 {
				font-weight: 100;
				text-transform: uppercase;
				color: #999;
			}
			h2 {
				padding-top: 1.34em;
				border-top: 1px dashed #ddd;
			}
			pre {
				padding: 2em;
				border: 1px solid #eee;
				background-color: #fff;
			}
			a {
				transition: color 200ms;
				display: inline-block;
				text-decoration: none;
				color: hsl(200, 100%, 45%);
			}
			a:hover {
				color: hsl(200, 100%, 30%);
			}
		</style>

	</head>

	<body>

		<h1>Unitest</h1>



		<h2>Test dump</h2>

		<?php
			$u = new Unitest();
			echo html_dump(array(
				'parent' => $u->parent(),
				'ownTests' => $u->ownTests(),
			));
		?>



		<h2>About</h2>

		<p><big>A one-class miniature unit testing framework for PHP.</big></p>

		<ul>
			<li><a href="https://bitbucket.org/Eiskis/unitest/">Bitbucket repo</a></li>
			<li><a href="https://bitbucket.org/Eiskis/unitest/src/master/Unitest.php">Download</a></li>
		</ul>



		<h2>Usage</h2>

		<pre><code>
			include_once 'Unitest.php';
			include_once 'testCases.php';

			

		</code></pre>

		<?php
			$u = new Unitest();
			echo html_dump(array(
				'parent' => $u->parent(),
				'ownTests' => $u->ownTests(),
			));
		?>



		<h2>To do</h2>

		<ul>
			<li>Public <code>rglob</code> helper to scrape for case files</li>
			<li><code>ReflectionClass</code>-based solution to detect test method's input variable names</li>
			<li>Fail if script variable is missing</li>
		</ul>

	</body>
</html>
