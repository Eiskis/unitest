<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('error_log', 'errors.log');
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');

// Lib
require_once '../../Unitest.php';

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

		<?php $report = $u->run(); $stats = $u->asNumbers($report); ?>

		<ul class="stats">
			<?php
				foreach ($stats as $key => $value) {
					echo '<li class="'.$key.'">'.$value.' '.$key.'</li>';
				}
			?>
		</ul>
		<div class="clear"></div>

		<?php
			foreach ($u->byStatus($report) as $group => $suites) {
				echo '<h1>'.count($suites).'/'.$stats['total'].' '.$group.'</h1>';
				if (count($suites)) {
					echo '<dl class="canvas '.$group.'">';
					foreach ($suites as $name => $suite) {
						echo '<dt>'.$name.'</dt>';
						foreach ($suite as $test => $testResult) {
							$status = $u->assess($testResult);
							echo '<dd class="'.$status.'">';
							if ($status === 'failed') {
								echo '<strong>'.$test.'</strong><em>'.(is_string($testResult) ? $testResult : var_export($testResult, true)).'</em>';
							} else {
								echo $test;
							}
							echo '</dd>';
						}
					}
					echo '</dl>';
				}
			}
		?>

	</body>
</html>
