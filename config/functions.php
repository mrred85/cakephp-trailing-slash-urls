<?php

/**
 * PHP EXTRA FUNCTIONS
 *
 * @link https://github.com/mrred85/cakephp-trailing-slash-urls
 * @copyright 2016 - present Victor Rosu. All rights reserved.
 * @license Licensed under the MIT License.
 */

if (!function_exists('trailing_slash_url')) {
    /**
     * @param string $url URL to parse
     * @param bool $justBaseURL Base URL result
     * @return string
     */
    function trailing_slash_url(string $url, bool $justBaseURL = false): string
    {
        $parsedUrl = parse_url(htmlspecialchars_decode($url));
        $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
        $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        $port = isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '';
        $user = isset($parsedUrl['user']) ? $parsedUrl['user'] : '';
        $pass = isset($parsedUrl['pass']) ? ':' . $parsedUrl['pass'] : '';
        $pass = ($user || $pass) ? $pass . '@' : '';
        $path = isset($parsedUrl['path']) ? rtrim($parsedUrl['path'], '/') . '/' : '';
        $query = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';
        $fragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';
        $result = $scheme . $user . $pass . $host . $port . $path;
        if (!$justBaseURL) {
            $result .= $query . $fragment;
        }

        return $result;
    }
}
