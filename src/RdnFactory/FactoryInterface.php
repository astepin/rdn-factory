<?php

namespace RdnFactory;

use RdnFactory\Plugin\PluginManager;
use Zend\ServiceManager;

interface FactoryInterface extends ServiceManager\Factory\FactoryInterface
{
	public function setPlugins(PluginManager $plugins);

	/**
	 * @return PluginManager
	 */
	public function getPlugins();
}
