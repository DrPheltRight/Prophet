<?php defined('SYSPATH') or die('No direct script access.');

if (Kohana::$errors)
{
	// Override Kohana exception handler
	set_exception_handler(array('prophet', 'exception_handler'));
}

// Error Route for internal error requests
Route::set('prophet_error', 'prophet_error/<action>(/<message>)', array('action' => '[0-9]{3}', 'message' => '.*'))
	->defaults(array(
		'controller' => 'error',
	));

// Catch All Route (404 Response)
Route::set('prophet_catchall', '<catchall>', array('catchall' => '.*'))
	->defaults(array(
		'controller' => 'error',
		'action'	 => '404',
	));