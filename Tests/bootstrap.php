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
 * @credit        http://pooteeweet.org/blog/2046 And https://github.com/raulfraile/LadybugBundle And https://raw.github.com/wowo/WowoNewsletterBundle/master/Tes
 */


//borrowed from FOSUserBundle

$vendorDirectory = realpath(__DIR__ . '/../vendor');

require_once $vendorDirectory . '/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespace('Symfony', array($vendorDirectory . '/symfony/src', $vendorDirectory . '/bundles'));
$loader->register();

spl_autoload_register(function($class) {
            if (strpos($class, 'Anchovy\\CURLBundle\\') === 0) {
                $file = __DIR__ . '/../' . implode('/', array_slice(explode('\\', $class), 3)) . '.php';
                if (file_exists($file) === false) {
                    return false;
                }
                require_once $file;
            }
        });
?>