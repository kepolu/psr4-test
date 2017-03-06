<?php

namespace Foo;

use Foo\Contracts\PersonBehaviorInterface;
use Foo\NameBag;

class Person implements PersonBehaviorInterface
{
	/**
	 * @var $firstName
	 */
	private $firstName;

	/**
	 * @var $middleName
	 */
	private $middleName;

	/**
	 * @var $lastName
	 */
	private $lastName;


	/**
	 * {@inheritdoc}
	 */
	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setMiddleName($middleName)
	{
		$this->middleName = $middleName;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
	}

	/**
	 * Return name as json-able serialized array.
	 */
	public function __toString()
	{
		return (new NameBag)->store([$this->firstName, $this->middleName, $this->lastName])
			->fetch();
	}
}
