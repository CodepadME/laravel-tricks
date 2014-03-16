<?php

namespace Tricks\Services\Forms;

use App;
use Mockery;
use PHPUnit_Framework_Assert as Assert;
use ReflectionClass;
use TestCase;
use Validator;

class ConcreteForm
extends AbstractForm
{

}

class AbstractFormTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks/services
   */
  public function testConstructor()
  {
    $mock = Mockery::mock('stdClass');

    $mock
      ->shouldReceive('make')
      ->atLeast()->once()
      ->with('request')
      ->andReturn($mock);

    $mock
      ->shouldReceive('all')
      ->atLeast()->once()
      ->andReturn('mocked');

    App::swap($mock);

    $concreteForm = new ConcreteForm();

    $this->assertEquals(
      'mocked',
      Assert::readAttribute($concreteForm, 'inputData')
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetInputData()
  {
    $concreteForm = new ConcreteForm();

    $class = new ReflectionClass($concreteForm);
    $property = $class->getProperty('inputData');
    $property->setAccessible(true);

    $property->setValue($concreteForm, 'mocked');

    $this->assertEquals(
      'mocked',
      $concreteForm->getInputData()
    );
  }

  /**
   * @group tricks/services
   */
  public function testIsValid()
  {
    $concreteFormMock = Mockery::mock('Tricks\Services\Forms\ConcreteForm[getInputData,getPreparedRules,getMessages]')
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $concreteFormMock
      ->shouldReceive('getInputData')
      ->atLeast()->once()
      ->andReturn(['mocked']);

    $concreteFormMock
      ->shouldReceive('getPreparedRules')
      ->atLeast()->once()
      ->andReturn(['mocked']);

    $concreteFormMock
      ->shouldReceive('getMessages')
      ->atLeast()->once()
      ->andReturn(['mocked']);

    $mock = Mockery::mock('stdClass');

    $mock
      ->shouldReceive('make')
      ->atLeast()->once()
      ->with(
        ['mocked'],
        ['mocked'],
        ['mocked']
      )
      ->andReturn($mock);

    $mock
      ->shouldReceive('passes')
      ->atLeast()->once()
      ->andReturn('mocked');

    Validator::swap($mock);

    $this->assertEquals(
      'mocked',
      $concreteFormMock->isValid()
    );

    $this->assertSame(
      $mock,
      Assert::readAttribute($concreteFormMock, 'validator')
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetErrors()
  {
    $mock = Mockery::mock('stdClass');

    $mock
      ->shouldReceive('errors')
      ->atLeast()->once()
      ->andReturn('mocked');

    $concreteForm = new ConcreteForm();

    $class = new ReflectionClass($concreteForm);
    $property = $class->getProperty('validator');
    $property->setAccessible(true);

    $property->setValue($concreteForm, $mock);

    $this->assertEquals(
      'mocked',
      $concreteForm->getErrors()
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetPreparedRules()
  {
    $concreteFormMock = Mockery::mock('Tricks\Services\Forms\ConcreteForm[getPreparedRules]')
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $class = new ReflectionClass($concreteFormMock);
    $property = $class->getProperty('rules');
    $property->setAccessible(true);

    $property->setValue($concreteFormMock, 'mocked');

    $concreteFormMock
      ->shouldReceive('getPreparedRules')
      ->atLeast()->once()
      ->passthru();

    $this->assertEquals(
      'mocked',
      $concreteFormMock->getPreparedRules()
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetMessages()
  {
    $concreteFormMock = Mockery::mock('Tricks\Services\Forms\ConcreteForm[getMessages]')
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $class = new ReflectionClass($concreteFormMock);
    $property = $class->getProperty('messages');
    $property->setAccessible(true);

    $property->setValue($concreteFormMock, 'mocked');

    $concreteFormMock
      ->shouldReceive('getMessages')
      ->atLeast()->once()
      ->passthru();

    $this->assertEquals(
      'mocked',
      $concreteFormMock->getMessages()
    );
  }
}
