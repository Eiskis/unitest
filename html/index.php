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

// Run tests
$report = $u->run();
$stats = array(
	'total' => $report['passed'] + $report['failed'] + $report['skipped'],
	'passed' => $report['passed'],
	'failed' => $report['failed'],
	'skipped' => $report['skipped'],
);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<title>Unitest report card</title>

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

	</head>

	<body>

		<ul class="stats">
			<?php
				foreach ($stats as $key => $value) {
					echo '<li class="'.$key.'">'.$value.' '.$key.'</li>';
				}
				unset($key, $value);
			?>
		</ul>
		<div class="clear"></div>

		<?php
			echo '<dl class="canvas">';

			// Each suite
			foreach ($report['children'] as $suite) {
				echo '<dt>'.implode(' / ', $suite['parents']).' / '.$suite['class'].'</dt>';
				foreach ($suite['tests'] as $test) {

					// Each test
					echo '<dd class="'.$test['status'].'">';

					// Fail
					if ($test['status'] === 'failed') {
						echo '<strong>'.$test['method'].'</strong><em>'.(is_string($test['message']) ? $test['message'] : var_export($test['message'], true)).'</em>';

					// Skip or pass
					} else {
						echo $test['method'];
					}
					echo '</dd>';

				}

			}
			unset($key, $value);
			echo '</dl>';
		?>

	</body>
</html>
