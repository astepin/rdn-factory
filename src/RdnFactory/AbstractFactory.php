<?php

namespace RdnFactory;

use Interop\Container\ContainerInterface;
use RdnFactory\Plugin\PluginInterface;
use RdnFactory\Plugin\PluginManager;
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
	 * @param ContainerInterface $services
	 *
	 * @return mixed
	 */
	public function createService(ContainerInterface $services)
	{
		$this->setServiceLocator($services);
		return $this->create();
	}

	public function setServiceLocator(ContainerInterface $services)
	{
		$this->setPlugins($services->get('RdnFactory\Plugin\PluginManager'));
	}

	public function setPlugins(PluginManager $plugins)
	{
		$this->plugins = $plugins;
	}

	public function getPlugins()
	{
		return $this->plugins;
	}

	public function __call($name, $args = [])
	{
		if (!$this->plugins instanceof ContainerInterface)
		{
			throw new \RuntimeException('No service locator set for factory. Set the service locator using the setServiceLocator() method first.');
		}

		/** @var PluginInterface|callable $plugin */
		$plugin = $this->plugins->get($name);
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
