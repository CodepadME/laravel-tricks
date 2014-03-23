<?php

namespace Tricks\Providers;

use App;
use Mockery;
use TestCase;

class NavigationServiceProviderTest
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
    $mock = Mockery::mock('Illuminate\Foundation\Application')
      ->makePartial();

    $mock
      ->shouldReceive('share')
      ->atLeast()->once()
      ->with(Mockery::on(function($callback) {
        $mock = Mockery::mock('Illuminate\Foundation\Application')
          ->makePartial();

        $mock
          ->shouldReceive('offsetGet')
          ->atLeast()->once()
          ->with('config')
          ->andReturn(
            Mockery::mock('Illuminate\Config\Repository')
          );

        $mock
          ->shouldReceive('offsetGet')
          ->atLeast()->once()
          ->with('auth')
          ->andReturn(
            Mockery::mock('Illuminate\Auth\AuthManager')
          );

        $this->assertInstanceOf('Tricks\Services\Navigation\Builder', $callback($mock));

        return true;
      }))
      ->andReturn('mocked');

    $mock
      ->shouldReceive('offsetSet')
      ->atLeast()->once()
      ->with('navigation.builder', 'mocked');

    $provider = new NavigationServiceProvider(
      $mock
    );

    App::register($provider, [], true);
  }
}
