<?php defined('SYSPATH') or die('No direct script access.');

class Prophet {
    
    public static function exception_handler(Exception $e)
    {
        if (Kohana::$environment === Kohana::DEVELOPMENT)
        {
            Kohana_Exception::handler($e);
        }
        
        // It's a nice time to log :)
        Kohana::$log->add(Kohana_Log::ERROR, Kohana_Exception::text($e));
        
        if ( ! defined('SUPPRESS_REQUEST'))
        {
            $request = array(
                // Get status from current request
                'action'  => Request::current()->status(),
                
                // If exception has a message this can be passed on
                'message' => rawurlencode($e->getMessage()),
            );
            
            // Override status if HTTP_Exception thrown
            if ($e instanceof HTTP_Exception)
            {
                $request['action'] = $e->getCode();
            }
            
            echo Request::factory(Route::get('prophet_error')->uri($request))
                ->execute()
                ->send_headers()
                ->response;
        }
    }
    
}