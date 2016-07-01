<?php

namespace RdnFactory\Plugin;

use RdnFactory\FactoryInterface;

abstract class AbstractPlugin implements PluginInterface
{
	/**
	 * @var FactoryInterface
	 */
	protected $factory;

	public function setFactory(FactoryInterface $factory)
	{
		$this->factory = $factory;
	}

	public function getFactory()
	{
		return $this->factory;
	}
}
