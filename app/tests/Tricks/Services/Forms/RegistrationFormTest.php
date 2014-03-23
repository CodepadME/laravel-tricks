<?php

namespace Tricks\Services\Forms;

use Mockery;
use TestCase;

class RegistrationFormTest
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
    $repositoryMock = Mockery::mock('Illuminate\Config\Repository');

    $registrationForm = new RegistrationForm($repositoryMock);

    $this->assertEquals(
      $repositoryMock,
      $this->getProtectedProperty($registrationForm, 'config')
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetPreparedRules()
  {
    $repositoryMock = Mockery::mock('Illuminate\Config\Repository');

    $repositoryMock
      ->shouldReceive('get')
      ->atLeast()->once()
      ->with('config.forbidden_usernames')
      ->andReturn([
        'first',
        'second'
      ]);

    $registrationFormMock = Mockery::mock('Tricks\Services\Forms\RegistrationForm', [
      $repositoryMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $before = $this->getProtectedProperty($registrationFormMock, 'rules');

    $after = $before;
    $after["username"] .= '|not_in:first,second';

    $this->assertEquals(
      $after,
      $registrationFormMock->getPreparedRules()
    );
  }
}
