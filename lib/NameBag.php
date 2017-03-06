<?php

namespace Foo;

use Foo\Contracts\NameBagInterface;

class NameBag implements NameBagInterface
{
	/**
	 * Name data stack.
	 */
	private $container = [];


	/**
	 * {@inheritdoc}
	 */
	public function store($data)
	{
		array_walk($data, function($value)
		{
			array_push($this->container, $value);
		});
	}

	/**
	 * {@inheritdoc}
	 */
	public function fetch()
	{
		return $this->container;
	}
}
