<?php

declare(strict_types=1);

use Illuminate\Http\RedirectResponse;

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
     * @param array<string, string> $headers
     */
    function session_back(string|false $fallback = false, int $status = 302, array $headers = [], ?bool $secure = null): RedirectResponse
    {
        $url = session()->previousUrl();

        return redirect($url ?? $fallback, $status, $headers, $secure);
    }
}
