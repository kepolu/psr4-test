<?php

namespace Foo\Contracts;

interface NameBagInterface
{
	/**
	 * Store data into stack.
	 */
	public function store($data);

	/**
	 * Fetch data from stack.
	 */
	public function fetch();
}
