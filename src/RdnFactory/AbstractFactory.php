<?php

namespace RdnFactory;

use Interop\Container\ContainerInterface;
use RdnFactory\Plugin\PluginInterface;
use RdnFactory\Plugin\PluginManager;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\Stdlib\DispatchableInterface;

/**
 * Make it is easy to create factory classes. Contains helper methods for frequently used services.
 *
 * @method mixed config(\string $name = null)
 * @method DispatchableInterface controller(\string $name)
 * @method mixed params(\string $name, mixed $default = null)
 * @method mixed service(\string $name)
 * @method \string url(\string $name = null, $params = [], $options = [], $reuseMatchedParams = false)
 */
abstract class AbstractFactory implements FactoryInterface
{
	/**
	 * @var PluginManager
	 */
	protected $plugins;

	/**
	 * Create service
	 *
	 * @return mixed
	 */
	abstract protected function create();

    /**
     * Overwrite the FactoryInterface method to enable internal helpers.
     *
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL)
    {
        $this->setPlugins($container->get('RdnFactory\Plugin\PluginManager'));
        return $this->create();
    }

	public function setPlugins(PluginManager $plugins)
	{
		$this->plugins = $plugins;
	}

	public function getPlugins()
	{
		return $this->plugins;
	}

	public function __call($name, array $args = [])
	{
		if (!$this->getPlugins() instanceof AbstractPluginManager)
		{
			throw new \RuntimeException('No AbstractPluginManager set. '.get_class($this->getPlugins()));
		}

		/** @var PluginInterface|callable $plugin */
		$plugin = $this->getPlugins()->get($name);
		$plugin->setFactory($this);

		if (is_callable($plugin))
		{
			return call_user_func_array($plugin, $args);
		}

		return $plugin;
	}

	/**
	 * Prefix a service name with the current module name, if one is not already set.
	 *
	 * @param $name
	 *
	 * @return string
	 */
	protected function prefixModule($name)
	{
		if (strpos($name, ':') === false)
		{
			$name = $this->getModuleName() .':'. $name;
		}
		return $name;
	}

	/**
	 * Get name of module current class belongs to.
	 *
	 * @return string
	 */
	protected function getModuleName()
	{
		return strstr(get_class($this), '\\', true);
	}
}
