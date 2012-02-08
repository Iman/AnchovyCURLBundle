<?php

/*
 * This file is part of the AnchovyCURLBundle package.
 *
 * (c)  Iman Samizadeh <http://github.com/Iman/AnchovyCURLBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package       Anchovy
 * @subpackage    CURLBundle
 * @author        Iman Samizadeh <iman@imanpage.com>  http://imanpage.com
 * @credit        http://pooteeweet.org/blog/2046 And https://github.com/raulfraile/LadybugBundle
 */

if (file_exists($file = __DIR__ . '/../vendor/.composer/autoload.php')) {
    $autoload = require_once $file;
} else {
    throw new RuntimeException('Install dependencies to run test suite.');
}

spl_autoload_register(function($class)
{
    if (0 === strpos($class, 'Anchovy\\CURLBundle\\')) {
        $path = __DIR__ . '/../' . implode('/', array_slice(explode('\\', $class), 3)) . '.php';

        if (!stream_resolve_include_path($path)) {
            return false;
        }
        require_once $path;
        return true;
    }
});
        ?>