<?php

namespace Foo;

use Foo\Contracts\PersonInterface;
use Foo\Dosen;

class DosenFactory implements PersonInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function create()
	{
		return new Dosen;
	}
}
