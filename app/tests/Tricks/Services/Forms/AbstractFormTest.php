<?php

namespace Tricks\Services\Forms;

use App;
use Mockery;
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
      $this->getProtectedProperty($concreteForm, 'inputData')
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetInputData()
  {
    $concreteForm = new ConcreteForm();

    $this->setProtectedProperty($concreteForm, 'inputData', 'mocked');

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
    $concreteFormMock = Mockery::mock('Tricks\Services\Forms\ConcreteForm')
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
      $this->getProtectedProperty($concreteFormMock, 'validator')
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

    $this->setProtectedProperty($concreteForm, 'validator', $mock);

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
    $concreteFormMock = Mockery::mock('Tricks\Services\Forms\ConcreteForm')
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->setProtectedProperty($concreteFormMock, 'rules', 'mocked');

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
    $concreteFormMock = Mockery::mock('Tricks\Services\Forms\ConcreteForm')
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->setProtectedProperty($concreteFormMock, 'messages', 'mocked');

    $this->assertEquals(
      'mocked',
      $concreteFormMock->getMessages()
    );
  }
}
