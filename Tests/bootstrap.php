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
 * @credit        http://pooteeweet.org/blog/2046 And https://github.com/raulfraile/LadybugBundle And https://raw.github.com/wowo/WowoNewsletterBundle
 */


// Symfony dependencies
require_once $VENDOR_DIR.'/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';
use Symfony\Component\ClassLoader\UniversalClassLoader;
$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'          => array($VENDOR_DIR.'/symfony/src'),
    'Doctrine\\Common' => array($VENDOR_DIR.'/doctrine-common/lib'),
    'Doctrine\\DBAL'   => array($VENDOR_DIR.'/doctrine-dbal/lib'),
    'Doctrine'         => array($VENDOR_DIR.'/doctrine/lib'),
    'Anchovy' => array($VENDOR_DIR.'/bundles'),
));
$loader->register();

// Swiftmailer autoloader
require_once $VENDOR_DIR.'/swiftmailer/lib/classes/Swift.php';
Swift::registerAutoload($VENDOR_DIR.'/swiftmailer/lib/swift_init.php');


// Proxy object bootstrap
require_once $VENDOR_DIR . '/proxy-object/bootstrap.php';

// Mockery class loader
set_include_path(get_include_path() . PATH_SEPARATOR . $VENDOR_DIR . '/mockery/library/');
require_once('Mockery/Loader.php');
$loader = new \Mockery\Loader;
$loader->register();

// Some nifty namespaces taking care of (borrowed from FOSUserBundle)
spl_autoload_register(function($class) {
    if (0 === strpos($class, 'Anchovy\\CURLBundle')) {
        $path = __DIR__.'/../'.implode('/', array_slice(explode('\\', $class), 3)).'.php';
        if (!stream_resolve_include_path($path)) {
            return false;
        }
        require_once $path;
        return true;
    }
});

        ?>