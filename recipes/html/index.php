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

	$u->setParameter('foo', 1);
	$u->setParameter('bar', 2);
	$u->setParameter('string', 'Some string value');
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

		<?php $report = $u->run(); ?>

		<ul class="stats">
			<li></li>
		</ul>

		<?php
			foreach ($u->byStatus($report) as $status => $results) {
				echo '<h1>'.count($results).' '.$status.'</h1>';
				if (count($results)) {
					echo '<dl class="canvas '.$status.'">';
					foreach ($results as $pointer => $result) {
						echo '<dt>'.$pointer.'</dt>';
						if ($status === 'failed') {
							echo '<dd>'.(is_string($result) ? $result : dump($result)).'</dd>';
						}
					}
					echo '</dl>';
				}
			}
		?>

	</body>
</html>
