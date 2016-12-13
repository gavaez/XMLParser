<?php
/**
 * Created by PhpStorm.
 * User: Anton Ermakov
 * Date: 07.12.2016
 */
namespace Swiftlet;

chdir(dirname(__FILE__) . '/..');

require 'vendor/autoload.php';

use \Swiftlet\Factories\App as AppFactory;
use \Swiftlet\Factories\View as ViewFactory;

try {
	$view = ViewFactory::build();

	$app = AppFactory::build($view, 'XmlParser');

    // Convert errors to ErrorException instances
    set_error_handler(array($app, 'error'), E_ALL | E_STRICT);

	date_default_timezone_set('UTC');

	$app->loadListeners();

	$app->dispatchController();

	ob_start();

	$view->render();

	ob_end_flush();

} catch ( \Exception $e ) {
	if ( !headers_sent() ) {
		header('HTTP/1.1 503 Service Temporarily Unavailable');
		header('Status: 503 Service Temporarily Unavailable');
	}

	$errorCode = substr(sha1(uniqid(mt_rand(), true)), 0, 5);

	$errorMessage = $errorCode . date(' r ') . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine();

	file_put_contents('log/exceptions.log', "\n" . $errorMessage . "\n" . $e->getTraceAsString() . "\n", FILE_APPEND);

	exit('Exception: ' . $errorCode . '<br><br><small>The issue has been logged. Please contact the website administrator.</small>');
}
