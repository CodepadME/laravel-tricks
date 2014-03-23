<?php

namespace Tricks\Events;

use Mockery;
use TestCase;

class ViewTrickHandlerTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks/events
   */
  public function testConstructor()
  {
    $trickRepositoryMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface');

    $storeMock = Mockery::mock('Illuminate\Session\Store');

    $viewTrickHandler = new ViewTrickHandler(
      $trickRepositoryMock,
      $storeMock
    );

    $this->assertSame(
      $trickRepositoryMock,
      $this->getProtectedProperty($viewTrickHandler, 'tricks')
    );

    $this->assertSame(
      $storeMock,
      $this->getProtectedProperty($viewTrickHandler, 'session')
    );
  }

  /**
   * @group tricks/events
   */
  public function testHandle()
  {
    $trickMock = Mockery::mock('Tricks\Trick');

    $trickRepositoryMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface')
      ->makePartial();

    $trickRepositoryMock
      ->shouldReceive('incrementViews')
      ->atLeast()->once()
      ->with($trickMock)
      ->andReturn('mocked');

    $storeMock = Mockery::mock('Illuminate\Session\Store');

    $viewTrickHandlerMock = Mockery::mock('Tricks\Events\ViewTrickHandler', [
      $trickRepositoryMock,
      $storeMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $viewTrickHandlerMock
      ->shouldReceive('hasViewedTrick')
      ->atLeast()->once()
      ->andReturn(false);

    $viewTrickHandlerMock
      ->shouldReceive('storeViewedTrick')
      ->atLeast()->once()
      ->with('mocked');

    $viewTrickHandlerMock->handle($trickMock);
  }

  /**
   * @group tricks/events
   */
  public function testHasViewedTrick()
  {
    $viewTrickHandlerMock = Mockery::mock('Tricks\Events\ViewTrickHandler', [
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      Mockery::mock('Illuminate\Session\Store')
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $time = time();

    $tricks = [
      "1" => $time - 50,
      "2" => $time - 150,
      "3" => $time
    ];

    $viewTrickHandlerMock
      ->shouldReceive('getViewedTricks')
      ->atLeast()->once()
      ->andReturn($tricks);

    $trickMock = Mockery::mock('Tricks\Trick')
      ->makePartial();

    $trickMock->id = 2;

    $this->assertTrue($viewTrickHandlerMock->hasViewedTrick($trickMock));
  }

  /**
   * @group tricks/events
   */
  public function testGetViewedTricks()
  {
    $trickRepositoryMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface');

    $storeMock = Mockery::mock('Illuminate\Session\Store')
      ->makePartial();

    $storeMock
      ->shouldReceive('get')
      ->atLeast()->once()
      ->with('viewed_tricks', [])
      ->andReturn('mocked');

    $viewTrickHandlerMock = Mockery::mock('Tricks\Events\ViewTrickHandler', [
      $trickRepositoryMock,
      $storeMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->assertEquals('mocked', $viewTrickHandlerMock->getViewedTricks());
  }

  /**
   * @group tricks/events
   */
  public function testStoreViewedTrick()
  {
    $id = 2;

    $trickMock = Mockery::mock('Tricks\Trick')
      ->makePartial();

    $trickMock->id = $id;

    $trickRepositoryMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface');

    $storeMock = Mockery::mock('Illuminate\Session\Store')
      ->makePartial();

    $storeMock
      ->shouldReceive('put')
      ->atLeast()->once()
      ->with('viewed_tricks.' . $id, Mockery::type('int'))
      ->andReturn('mocked');

    $viewTrickHandlerMock = Mockery::mock('Tricks\Events\ViewTrickHandler', [
      $trickRepositoryMock,
      $storeMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $viewTrickHandlerMock->storeViewedTrick($trickMock);
  }
}
