<?php

namespace Foo;

use Foo\Contracts\PersonInterface;
use Foo\Mahasiswa;

class MahasiswaFactory implements PersonInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function create()
	{
		return new Mahasiswa;
	}
}
