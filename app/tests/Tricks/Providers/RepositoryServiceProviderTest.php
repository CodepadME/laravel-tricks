<?php

namespace Tricks\Providers;

use App;
use Mockery;
use TestCase;

class RepositoryServiceProviderTest
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
      ->shouldReceive('bind')
      ->atLeast()->once()
      ->with(
        'Tricks\Repositories\UserRepositoryInterface',
        'Tricks\Repositories\Eloquent\UserRepository'
      );

    $mock
      ->shouldReceive('bind')
      ->atLeast()->once()
      ->with(
        'Tricks\Repositories\ProfileRepositoryInterface',
        'Tricks\Repositories\Eloquent\ProfileRepository'
      );

    $mock
      ->shouldReceive('bind')
      ->atLeast()->once()
      ->with(
        'Tricks\Repositories\TrickRepositoryInterface',
        'Tricks\Repositories\Eloquent\TrickRepository'
      );

    $mock
      ->shouldReceive('bind')
      ->atLeast()->once()
      ->with(
        'Tricks\Repositories\TagRepositoryInterface',
        'Tricks\Repositories\Eloquent\TagRepository'
      );

    $mock
      ->shouldReceive('bind')
      ->atLeast()->once()
      ->with(
        'Tricks\Repositories\CategoryRepositoryInterface',
        'Tricks\Repositories\Eloquent\CategoryRepository'
      );

    $provider = new RepositoryServiceProvider(
      $mock
    );

    App::register($provider, [], true);
  }
}
