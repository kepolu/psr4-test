<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Psr4ClassLoader.php';

$autoload = Psr4ClassLoader::create();

if ($autoload instanceof \Psr4ClassLoader) {
	$autoload->addNamespace('Foo\\', 'lib');
	$autoload->addNamespace('Foo\\Contracts\\', 'lib/Contracts');

	$autoload->register();
}
