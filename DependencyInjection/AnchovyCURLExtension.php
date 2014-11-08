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
 */

namespace Anchovy\CURLBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AnchovyCURLExtension extends Extension
{

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        if (isset($config['return_transfer']))
            $container->setParameter('anchovy_curl.return_transfer', $config['return_transfer']);

        if (isset($config['follow_location']))
            $container->setParameter('anchovy_curl.follow_location', $config['follow_location']);

        if (isset($config['max_redirects']))
            $container->setParameter('anchovy_curl.max_redirects', $config['max_redirects']);

        if (isset($config['timeout']))
            $container->setParameter('anchovy_curl.timeout', $config['timeout']);

        if (isset($config['connect_timeout']))
            $container->setParameter('anchovy_curl.connect_timeout', $config['connect_timeout']);

        if (isset($config['http_header']))
            $container->setParameter('anchovy_curl.http_header', $config['http_header']);

        if (isset($config['crlf']))
            $container->setParameter('anchovy_curl.crlf', $config['crlf']);

        if (isset($config['ssl_version']))
            $container->setParameter('anchovy_curl.ssl_version', $config['ssl_version']);

        if (isset($config['ssl_verify']))
            $container->setParameter('anchovy_curl.ssl_verify', $config['ssl_verify']);

    }

    public function getAlias()
    {
        return 'anchovy_curl';
    }

}
