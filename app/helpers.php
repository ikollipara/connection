<?php

/*|==================================================================================|
  | helpers.php                                                                      |
  | Ian Kollipara <ikollipara2@huskers.unl.edu>                                      |
  |----------------------------------------------------------------------------------|
  | This file contains helper functions that can be used throughout the application. |
  |==================================================================================| */

/**
 * @codeCoverageIgnore
 */
if (!function_exists("str")) {
    /**
     * Helper to construct a
     * Stringable Object
     * @param string $value The value to stringify, defaults to an empty string
     * @return \Illuminate\Support\Stringable
     */
    function str($value = "")
    {
        return \Illuminate\Support\Str::of($value);
    }
}

/**
 * @codeCoverageIgnore
 */
if (!function_exists("literal")) {
    /**
     * Helper to construct a stdClass object
     * @return stdClass
     */
    function literal($args)
    {
        return (object) $args;
    }
}


if(!function_exists('session_back')) {
    /**
     * Redirects the user back to the previous page
     * using the cached session previous url.
     */
    function session_back($fallback = false, $status = 302, $headers = [], $secure = null)
    {
        $url = session()->previousUrl();
        return redirect($url ?? $fallback, $status, $headers, $secure);
    }
}
