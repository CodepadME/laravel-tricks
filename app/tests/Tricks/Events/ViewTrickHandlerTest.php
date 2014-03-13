<?php

namespace Tricks\Events;

use Mockery;
use PHPUnit_Framework_Assert as Assert;
use TestCase;

class ViewTrickHandlerTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  public function testConstructor()
  {
    $trickRepositoryMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface');

    $storeMock = Mockery::mock('Illuminate\Session\Store');

    $viewTrickHandler = new ViewTrickHandler(
      $trickRepositoryMock,
      $storeMock
    );

    $this->assertEquals(
      $trickRepositoryMock,
      Assert::readAttribute($viewTrickHandler, 'tricks')
    );

    $this->assertEquals(
      $storeMock,
      Assert::readAttribute($viewTrickHandler, 'session')
    );
  }

  public function testHandle()
  {
    $trickMock = Mockery::mock('Tricks\Trick');

    $trickRepositoryMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface');

    $trickRepositoryMock
      ->shouldReceive('incrementViews')
      ->atLeast()->once()
      ->with($trickMock)
      ->andReturn('mocked');

    $storeMock = Mockery::mock('Illuminate\Session\Store');

    $viewTrickHandlerMock = Mockery::mock('Tricks\Events\ViewTrickHandler[hasViewedTrick,storeViewedTrick]', [
      $trickRepositoryMock,
      $storeMock
    ])->shouldAllowMockingProtectedMethods();

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

  public function testHasViewedTrick()
  {
    $viewTrickHandlerMock = Mockery::mock('Tricks\Events\ViewTrickHandler[getViewedTricks]', [
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      Mockery::mock('Illuminate\Session\Store')
    ])
      ->makePartial()
      ->shouldAllowMockingProtectedMethods();

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

    $trickMock = Mockery::mock('Tricks\Trick')->makePartial();

    $trickMock->id = 2;

    $this->assertTrue($viewTrickHandlerMock->hasViewedTrick($trickMock));
  }

  public function testGetViewedTricks()
  {
    $trickRepositoryMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface');

    $storeMock = Mockery::mock('Illuminate\Session\Store');

    $storeMock
      ->shouldReceive('get')
      ->atLeast()->once()
      ->with('viewed_tricks', [])
      ->andReturn('mocked');

    $viewTrickHandlerMock = Mockery::mock('Tricks\Events\ViewTrickHandler[getViewedTricks]', [
      $trickRepositoryMock,
      $storeMock
    ])->shouldAllowMockingProtectedMethods();

    $viewTrickHandlerMock
      ->shouldReceive('getViewedTricks')
      ->atLeast()->once()
      ->passthru();

    $this->assertEquals('mocked', $viewTrickHandlerMock->getViewedTricks());
  }

  public function testStoreViewedTrick()
  {
    $id = 2;

    $trickMock = Mockery::mock('Tricks\Trick')->makePartial();

    $trickMock->id = $id;

    $trickRepositoryMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface');

    $storeMock = Mockery::mock('Illuminate\Session\Store');

    $storeMock
      ->shouldReceive('put')
      ->atLeast()->once()
      ->with('viewed_tricks.' . $id, Mockery::type('int'))
      ->andReturn('mocked');

    $viewTrickHandlerMock = Mockery::mock('Tricks\Events\ViewTrickHandler[storeViewedTrick]', [
      $trickRepositoryMock,
      $storeMock
    ])->shouldAllowMockingProtectedMethods();

    $viewTrickHandlerMock
      ->shouldReceive('storeViewedTrick')
      ->atLeast()->once()
      ->with($trickMock)
      ->passthru();

    $viewTrickHandlerMock->storeViewedTrick($trickMock);
  }
}
