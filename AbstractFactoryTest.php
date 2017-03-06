<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'autoload.php';

use Foo\MahasiswaFactory;
use Foo\DosenFactory;

class AbstractFactoryTest extends \PHPUnit_Framework_TestCase
{
	public function testCanCreateMahasiswa()
	{
		$factory = new MahasiswaFactory;
		$mahasiswa = $factory->create();

		$this->assertInstanceOf('Foo\Mahasiswa', $mahasiswa);
	}

	public function testCanCreateDosen()
	{
		$factory = new DosenFactory;
		$dosen = $factory->create();

		$this->assertInstanceOf('Foo\Dosen', $dosen);
	}
}
