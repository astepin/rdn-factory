<?php

namespace RdnFactory\Factory\Plugin;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use RdnFactory\Plugin;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class PluginManager implements FactoryInterface
{

    /**
     * Create service
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL)
    {
        $config = $container->get('Config');
        $config = new Config($config['rdn_factory_plugins']);

        $plugins = new Plugin\PluginManager($container, $config->toArray());

        return $plugins;
    }
}
