<?php

namespace Tricks\Providers;

use App;
use Mockery;
use TestCase;

class EventServiceProviderTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  public function testRegister()
  {
    $dispatcherMock = Mockery::mock('Illuminate\Events\Dispatcher');

    $dispatcherMock
      ->shouldReceive('listen')
      ->atLeast()->once()
      ->with('trick.view', 'Tricks\Events\ViewTrickHandler');

    $applicationMock = Mockery::mock('Illuminate\Foundation\Application');

    $applicationMock
      ->shouldReceive('offsetGet')
      ->atLeast()->once()
      ->with('events')
      ->andReturn($dispatcherMock);

    $provider = new EventServiceProvider(
      $applicationMock
    );

    App::register($provider, [], true);
  }
}
