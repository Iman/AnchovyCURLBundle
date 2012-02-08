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
$vendorDir = __DIR__ . '/../vendor';
require_once $vendorDir . '/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony' => array($vendorDir . '/symfony/src', $vendorDir . '/bundles'),
    'Doctrine\\Common' => $vendorDir . '/doctrine-common/lib',
    'Doctrine\\DBAL' => $vendorDir . '/doctrine-dbal/lib',
    'Doctrine\\ODM\\MongoDB' => $vendorDir . '/doctrine-mongodb-odm/lib',
    'Doctrine\\MongoDB' => $vendorDir . '/doctrine-mongodb/lib',
    'Doctrine\\ODM\\CouchDB' => $vendorDir . '/doctrine-couchdb/lib',
    'Doctrine\\CouchDB' => $vendorDir . '/doctrine-couchdb/lib',
    'Doctrine' => $vendorDir . '/doctrine/lib',
));
$loader->registerPrefixes(array(
    'Twig_' => $vendorDir . '/twig/lib',
));
$loader->register();

$swiftAutoloader = $vendorDir . '/swiftmailer/lib/classes/Swift.php';
if (file_exists($swiftAutoloader)) {
    require_once $swiftAutoloader;
    Swift::registerAutoload($vendorDir . '/swiftmailer/lib/swift_init.php');
}

set_include_path($vendorDir . '/phing/classes' . PATH_SEPARATOR . get_include_path());


spl_autoload_register(function($class) {
            if (0 === strpos($class, 'Anchovy\\CURLBundle\\')) {
                $path = __DIR__ . '/../' . implode('/', array_slice(explode('\\', $class), 2)) . '.php';
                if (!stream_resolve_include_path($path)) {
                    return false;
                }
                require_once $path;
                return true;
            }
        });
?>