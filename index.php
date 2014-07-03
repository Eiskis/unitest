<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('error_log', 'errors.log');
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');

include_once 'release/Unitest.php';
include_once 'baseline.php';

?>

<?php
	$u = new Unitest();
	$dump = array(
		'getters' => array(
			'children' => $u->children(),
			'parent' => $u->parent(),
			'ownTests' => $u->ownTests(),
			'scriptVariables' => $u->scriptVariables(),
		),
		'scrape' => $u->scrape('spec'),
		'available cases' => $u->availableCases(),
	);
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

		<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/prism/0.0.1/prism.min.css">

		<style type="text/css">
			body {
				font-family: sans-serif;
				padding: 2% 6%;
				max-width: 50em;
				margin-left: auto;
				margin-right: auto;
				background-color: #f0f0f0;
				line-height: 1.6;
				color: #444;
			}
			.canvas {
				margin-bottom: 6%;
				padding: 2% 6% 4% 6%;
				border-radius: 3px;
				border: 1px solid #ddd;
				background-color: #fcfcfc;
				box-shadow: 0 0.4em 2em #ddd;
			}
			h1 {
				text-transform: uppercase;
				font-weight: 900;
				color: #ddd;
			}
			h2, h3 {
				font-weight: 100;
				text-transform: uppercase;
				color: #bbb;
			}
			h4 {
				border-top: 1px dashed #ddd;
				padding-top: 2em;
			}
			pre {
				padding: 2em;
				border: 1px solid #eee;
				background-color: #fff;
				font-size: 0.8em;
			}
			a {
				transition: color 200ms;
				text-decoration: none;
				color: hsl(200, 100%, 45%);
			}
			a:hover {
				color: hsl(200, 100%, 30%);
			}
		</style>

	</head>

	<body class="language-php">

		<h1>Dump</h1>

		<div class="canvas">

			<h2>Test results</h2>
			<pre><code><?php echo dump($u->runOwnTests()); ?></code></pre>

			<h2>Properties</h2>
			<pre><code><?php echo dump($dump); ?></code></pre>
		</div>



		<h1>Unitest</h1>

		<div class="canvas">

			<h2>About</h2>

			<p><em>Unitest</em> is a one-class miniature unit testing framework for PHP.</p>

			<ul>
				<li><a href="https://bitbucket.org/Eiskis/unitest/">Bitbucket repo</a></li>
				<li><a href="https://bitbucket.org/Eiskis/unitest/src/master/Unitest.php">Download</a></li>
			</ul>



			<h2>Kickstart</h2>

			<pre><code>include_once 'Unitest.php';
$suite = new Unitest();
$suite->scrape('tests/');
$results = $suite->run();</code></pre>

		</div>



		<h1>API</h1>

		<div class="canvas">

			<h2>Construct</h2>

			<pre><code>$case = new Unitest($parent = null, $scriptVariables = array())</code></pre>
			<p>Parent case and script variables can be passed</p>

			<h2>Properties</h2>

			<h4>children</h4>
			<p>Child cases</p>
			<pre><code>$case->children()</code></pre>

			<h4>parent</h4>
			<p>Parent case</p>
			<pre><code>$case->parent()</code></pre>

			<h4>scriptVariables</h4>
			<p>Script variables</p>
			<pre><code>$case->scriptVariables()</code></pre>

			<h2>Dynamic getters</h2>

			<h4>ownTests</h4>
			<p>All test methods</p>
			<pre><code>$case->ownTests()</code></pre>



			<h2>Managing cases</h2>

			<h4>availableCases</h4>
			<p>Find declared classes that extend Unitest.</p>
			<pre><code>$case->availableCases()</code></pre>

			<h4>scrape</h4>
			<p>Find PHP files with classes under <code>$directory</code>. Multiple paths can be passed.</p>
			<pre><code>$case->scrape($directory)</code></pre>

			<h4>addChild</h4>
			<p>Add a valid child test case as a child</p>
			<pre><code>$case->addChild($case)</code></pre>

			<h4>nest</h4>
			<p>Generate a new child case. <code>$case</code> will be set as parent, and scriptVariables are passed on.</p>
			<pre><code>$case->nest()</code></pre>



			<h2>Running tests</h2>

			<h4>runTest</h4>
			<p>Run an individual test method</p>
			<pre><code>$case->runTest($method)</code></pre>

			<h4>runOwnTests</h4>
			<p>Run all own tests</p>
			<pre><code>$case->runOwnTests()</code></pre>

			<h4>runChildrensOwnTests</h4>
			<p>Run tests of all children</p>
			<pre><code>$case->runChildrensOwnTests()</code></pre>



			<h2>Assertions</h2>

			<h4>assert</h4>
			<p>Truey</p>
			<pre><code>$case->assert()</code></pre>

			<h4>assertEquals</h4>
			<p>Equality</p>
			<pre><code>$case->assertEquals()</code></pre>

		</div>



		<h1>Development</h1>

		<div class="canvas">

			<h2>To do</h2>

			<ul>
				<li><code>ReflectionClass</code>-based solution to detect test method's input variable names</li>
				<li>Fail if script variable is missing</li>
				<li>Actually construct test case objects
					<ol>
						<li>Scrape for files</li>
						<li>Find out which classes will be available</li>
						<li>Include file</li>
						<li>Instantiate custom case</li>
						<li>Add to a parent case</li>
					</ol>
				</li>
			</ul>

			<h2>Read up</h2>

			<ul>
				<li><a href="http://stackoverflow.com/questions/928928/determining-what-classes-are-defined-in-a-php-class-file">Find out which classes are defined in a file - without including the file</a></li>
			</ul>

		</div>

		<script type="application/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/prism/0.0.1/prism.min.js"></script>

	</body>
</html>
