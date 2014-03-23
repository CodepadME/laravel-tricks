<?php

namespace Tricks\Providers;

use Mockery;
use TestCase;

class SocialServiceProviderTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks/providers
   */
  public function testRegister()
  {
    $mock = Mockery::mock('Tricks\Providers\SocialServiceProvider', [
      Mockery::mock('Illuminate\Foundation\Application')
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $mock
      ->shouldReceive('registerGithub')
      ->atLeast()->once();

    $mock
      ->shouldReceive('registerDisqus')
      ->atLeast()->once();

    $mock->register();
  }

  /**
   * @group tricks/providers
   */
  public function testRegisterGithub()
  {
    $applicationMock = Mockery::mock('Illuminate\Foundation\Application')
      ->makePartial();

    $applicationMock
      ->shouldReceive('offsetSet')
      ->atLeast()->once()
      ->with('github.provider', 'mocked');

    $repositoryMock = Mockery::mock('Illuminate\Config\Repository')
      ->makePartial();

    $repositoryMock
      ->shouldReceive('get')
      ->atLeast()->once()
      ->with('social.github')
      ->andReturn([]);

    $applicationMock
      ->shouldReceive('offsetGet')
      ->atLeast()->once()
      ->with('config')
      ->andReturn(
        $repositoryMock
      );

    $applicationMock
      ->shouldReceive('share')
      ->atLeast()->once()
      ->with(
        Mockery::on(function($callback) use ($applicationMock) {
          $callback($applicationMock);

          return true;
        })
      )
      ->andReturn('mocked');

    $applicationMock
      ->shouldReceive('offsetSet')
      ->atLeast()->once()
      ->with('github', 'mocked');

    $applicationMock
      ->shouldReceive('offsetGet')
      ->atLeast()->once()
      ->with('github.provider')
      ->andReturn(
        Mockery::mock('League\OAuth2\Client\Provider\Github')
      );

    $applicationMock
      ->shouldReceive('offsetGet')
      ->atLeast()->once()
      ->with('Tricks\Repositories\UserRepositoryInterface')
      ->andReturn(
        Mockery::mock('Tricks\Repositories\UserRepositoryInterface')
      );

    $applicationMock
      ->shouldReceive('offsetGet')
      ->atLeast()->once()
      ->with('Tricks\Repositories\ProfileRepositoryInterface')
      ->andReturn(
        Mockery::mock('Tricks\Repositories\ProfileRepositoryInterface')
      );

    $socialServiceProviderMock = Mockery::mock('Tricks\Providers\SocialServiceProvider', [
      $applicationMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $socialServiceProviderMock->registerGithub();
  }

  /**
   * @group tricks/providers
   */
  public function testRegisterDisqus()
  {
    $applicationMock = Mockery::mock('Illuminate\Foundation\Application')
      ->makePartial();

    $applicationMock
      ->shouldReceive('offsetSet')
      ->atLeast()->once()
      ->with('disqus', 'mocked');

    $repositoryMock = Mockery::mock('Illuminate\Config\Repository')
      ->makePartial();

    $repositoryMock
      ->shouldReceive('get')
      ->atLeast()->once()
      ->with('social.disqus.requestUrl')
      ->andReturn('mocked');

    $applicationMock
      ->shouldReceive('offsetGet')
      ->atLeast()->once()
      ->with('config')
      ->andReturn(
        $repositoryMock
      );

    $applicationMock
      ->shouldReceive('share')
      ->atLeast()->once()
      ->with(
        Mockery::on(function($callback) use ($applicationMock) {
          $callback($applicationMock);

          return true;
        })
      )
      ->andReturn('mocked');

    $socialServiceProviderMock = Mockery::mock('Tricks\Providers\SocialServiceProvider', [
      $applicationMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $socialServiceProviderMock->registerDisqus();
  }
}
