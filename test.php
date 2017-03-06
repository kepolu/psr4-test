<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'autoload.php';

use Foo\MahasiswaFactory;
use Foo\DosenFactory;

$a = (new MahasiswaFactory)->create();
$b = (new DosenFactory)->create();

var_dump($a instanceof \Foo\Mahasiswa);
var_dump($b instanceof \Foo\Dosen);
