<?php
$dotenv = new Dotenv\Dotenv('..\\');
$dotenv->load();

if (! function_exists('env')) {
    /**
     * Encapsulates the getenv function into a smaller one.
     *
     * @param  string  $key
     * @return array|false|string
     */
    function env(string $key)
    {
        return getenv($key);
    }
}
