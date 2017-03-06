<?php

namespace Foo\Contracts;

interface PersonBehaviorInterface
{
	/**
	 * Set first name.
	 */
	public function setFirstName($firstName);

	/**
	 * Set middle name.
	 */
	public function setMiddleName($middleName);

	/**
	 * Set last name.
	 */
	public function setLastName($lastName);
}
