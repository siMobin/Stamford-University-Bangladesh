<?php
// Report all PHP errors
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 'On');  //On or Off

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\ErrorHandler;
use Monolog\Formatter\LineFormatter;

// Create your own formatter
$formatter = new LineFormatter(null, null, false, true);

// Create a handler and set the formatter to it
$handler = new StreamHandler($_SERVER['DOCUMENT_ROOT'] . "/storage/logs.log", Level::Debug);
$handler->setFormatter($formatter);

// Create a log channel and push the handler to it
$log = new Logger('name');
$log->pushHandler($handler);

// Register the logger as an error handler
ErrorHandler::register($log);
