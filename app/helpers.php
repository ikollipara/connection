<?php

declare(strict_types=1);

/*|==================================================================================|
  | helpers.php                                                                      |
  | Ian Kollipara <ikollipara2@huskers.unl.edu>                                      |
  |----------------------------------------------------------------------------------|
  | This file contains helper functions that can be used throughout the application. |
  |==================================================================================| */
// @codeCoverageIgnoreStart
if (! function_exists('session_back')) {
    // @codeCoverageIgnoreEnd
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
