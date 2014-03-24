<?php

use Illuminate\Foundation\Testing\TestCase as Base;
use PHPUnit_Framework_Assert as Assert;

class TestCase
extends Base
{
	public function createApplication()
	{
		$unitTesting     = true;
		$testEnvironment = 'testing';

		return require(__DIR__ . '/../../bootstrap/start.php');
	}

	public function setProtectedProperty($class, $property, $value)
	{
		$reflectionClass = new ReflectionClass($class);

		$reflectionProperty = $reflectionClass->getProperty($property);
		$reflectionProperty->setAccessible(true);
		$reflectionProperty->setValue($class, $value);
	}

	public function getProtectedProperty($class, $property)
	{
		return Assert::readAttribute($class, $property);
	}

	protected function incomplete($message = 'This test has not been implemented yet.')
	{
		$this->markTestIncomplete($message);
	}
}
