<?php

namespace RdnFactory\Plugin;

class Service extends AbstractPlugin
{
	/**
	 * Get a service by the given name.
	 *
	 * @param string $name
	 *
	 * @return mixed
	 * @throws \RuntimeException if service locator not set
	 */
	public function __invoke($name)
	{
	    /** @var PluginManager $services */
		$services = $this->factory->getPlugins();
		return $services->getCreationContext()->get($name);
	}
}
