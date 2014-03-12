<?php

namespace Tricks\Filters;

use Mockery;
use PHPUnit_Framework_Assert as Assert;
use TestCase;

class ViewThrottleFilterTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  public function testConstructor()
  {
    $repositoryMock = Mockery::mock('Illuminate\Config\Repository');

    $storeMock = Mockery::mock('Illuminate\Session\Store');

    $viewThrottleFilter = new ViewThrottleFilter(
      $repositoryMock,
      $storeMock
    );

    $this->assertEquals(
      $repositoryMock,
      Assert::readAttribute($viewThrottleFilter, 'config')
    );

    $this->assertEquals(
      $storeMock,
      Assert::readAttribute($viewThrottleFilter, 'session')
    );
  }

  public function testFilter()
  {
    $viewThrottleFilterMock = Mockery::mock('Tricks\Filters\ViewThrottleFilter[getViewedTricks,purgeExpiredTricks,storeViewedTricks]', [
      Mockery::mock('Illuminate\Config\Repository'),
      Mockery::mock('Illuminate\Session\Store')
    ])->shouldAllowMockingProtectedMethods();

    $time = time();

    $tricks = [
      "1" => $time - 50,
      "2" => $time - 150,
      "3" => $time
    ];

    $viewThrottleFilterMock
      ->shouldReceive('getViewedTricks')
      ->atLeast()->once()
      ->andReturn($tricks);

    $viewThrottleFilterMock
      ->shouldReceive('purgeExpiredTricks')
      ->atLeast()->once()
      ->with($tricks)
      ->andReturn($tricks);

    $viewThrottleFilterMock
      ->shouldReceive('storeViewedTricks')
      ->atLeast()->once()
      ->with($tricks);

    $viewThrottleFilterMock->filter();
  }

  public function testGetViewedTricks()
  {
    $repositoryMock = Mockery::mock('Illuminate\Config\Repository');

    $storeMock = Mockery::mock('Illuminate\Session\Store');

    $storeMock
      ->shouldReceive('get')
      ->atLeast()->once()
      ->with('viewed_tricks', null)
      ->andReturn('mocked');

    $viewThrottleFilterMock = Mockery::mock('Tricks\Filters\ViewThrottleFilter[getViewedTricks]', [
      $repositoryMock,
      $storeMock
    ])->shouldAllowMockingProtectedMethods();

    $viewThrottleFilterMock
      ->shouldReceive('getViewedTricks')
      ->atLeast()->once()
      ->passthru();

    $this->assertEquals('mocked', $viewThrottleFilterMock->getViewedTricks());
  }

  public function testGetThrottleTime()
  {
    $repositoryMock = Mockery::mock('Illuminate\Config\Repository');

    $repositoryMock
      ->shouldReceive('get')
      ->atLeast()->once()
      ->with('config.view_throttle_time')
      ->andReturn('mocked');

    $storeMock = Mockery::mock('Illuminate\Session\Store');

    $viewThrottleFilterMock = Mockery::mock('Tricks\Filters\ViewThrottleFilter[getThrottleTime]', [
      $repositoryMock,
      $storeMock
    ])->shouldAllowMockingProtectedMethods();

    $viewThrottleFilterMock
      ->shouldReceive('getThrottleTime')
      ->atLeast()->once()
      ->passthru();

    $this->assertEquals('mocked', $viewThrottleFilterMock->getThrottleTime());
  }

  public function testPurgeExpiredTricks()
  {
    $time = time();

    $tricks = [
      "1" => $time - 50,
      "2" => $time - 150,
      "3" => $time
    ];

    $purgedTricks = [
      "1" => $time - 50,
      "3" => $time
    ];

    $viewThrottleFilterMock = Mockery::mock('Tricks\Filters\ViewThrottleFilter[getThrottleTime,purgeExpiredTricks]', [
      Mockery::mock('Illuminate\Config\Repository'),
      Mockery::mock('Illuminate\Session\Store')
    ])->shouldAllowMockingProtectedMethods();

    $viewThrottleFilterMock
      ->shouldReceive('getThrottleTime')
      ->atLeast()->once()
      ->andReturn(100);

    $viewThrottleFilterMock
      ->shouldReceive('purgeExpiredTricks')
      ->atLeast()->once()
      ->with($tricks)
      ->passthru();

    $this->assertEquals($purgedTricks, $viewThrottleFilterMock->purgeExpiredTricks($tricks));
  }

  public function testStoreViewedTricks()
  {
    $repositoryMock = Mockery::mock('Illuminate\Config\Repository');

    $time = time();

    $tricks = [
      "1" => $time - 50,
      "2" => $time - 150,
      "3" => $time
    ];

    $storeMock = Mockery::mock('Illuminate\Session\Store');

    $storeMock
      ->shouldReceive('put')
      ->atLeast()->once()
      ->with('viewed_tricks', $tricks);

    $viewThrottleFilterMock = Mockery::mock('Tricks\Filters\ViewThrottleFilter[storeViewedTricks]', [
      $repositoryMock,
      $storeMock
    ])->shouldAllowMockingProtectedMethods();

    $viewThrottleFilterMock
      ->shouldReceive('storeViewedTricks')
      ->atLeast()->once()
      ->with($tricks)
      ->passthru();

    $viewThrottleFilterMock->storeViewedTricks($tricks);
  }
}
