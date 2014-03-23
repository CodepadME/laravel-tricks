<?php

namespace Tricks\Services\Forms;

use Mockery;
use TestCase;

class SettingsFormTest
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

    $authManagerMock = Mockery::mock('Illuminate\Auth\AuthManager');

    $settingsForm = new SettingsForm(
      $repositoryMock,
      $authManagerMock
    );

    $this->assertEquals(
      $repositoryMock,
      $this->getProtectedProperty($settingsForm, 'config')
    );

    $this->assertEquals(
      $authManagerMock,
      $this->getProtectedProperty($settingsForm, 'auth')
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

    $authManagerMock = Mockery::mock('Illuminate\Auth\AuthManager');

    $authManagerMock
      ->shouldReceive('user')
      ->atLeast()->once()
      ->andReturn($authManagerMock);

    $authManagerMock->id = 1;

    $settingsFormMock = Mockery::mock('Tricks\Services\Forms\SettingsForm', [
      $repositoryMock,
      $authManagerMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $before = $this->getProtectedProperty($settingsFormMock, 'rules');

    $after = $before;
    $after["username"] .= '|not_in:first,second|unique:users,username,1';

    $this->assertEquals(
      $after,
      $settingsFormMock->getPreparedRules()
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetInputData()
  {
    $before = [
      'username'              => 'foo',
      'password'              => 'bar',
      'password_confirmation' => '1,2,3',
      'invalid'               => 'YOU SHALL NOT PASS'
    ];

    $after = [
      'username'              => 'foo',
      'password'              => 'bar',
      'password_confirmation' => '1,2,3'
    ];

    $settingsForm = new SettingsForm(
      Mockery::mock('Illuminate\Config\Repository'),
      Mockery::mock('Illuminate\Auth\AuthManager')
    );

    $this->setProtectedProperty($settingsForm, 'inputData', $before);

    $this->assertEquals(
      array_keys($after),
      array_keys($settingsForm->getInputData())
    );
  }
}
