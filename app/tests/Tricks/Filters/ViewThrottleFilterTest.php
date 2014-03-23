<?php

namespace Tricks\Filters;

use Mockery;
use TestCase;

class ViewThrottleFilterTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks/filters
   */
  public function testConstructor()
  {
    $repositoryMock = Mockery::mock('Illuminate\Config\Repository');

    $storeMock = Mockery::mock('Illuminate\Session\Store');

    $viewThrottleFilter = new ViewThrottleFilter(
      $repositoryMock,
      $storeMock
    );

    $this->assertSame(
      $repositoryMock,
      $this->getProtectedProperty($viewThrottleFilter, 'config')
    );

    $this->assertSame(
      $storeMock,
      $this->getProtectedProperty($viewThrottleFilter, 'session')
    );
  }

  /**
   * @group tricks/filters
   */
  public function testFilter()
  {
    $viewThrottleFilterMock = Mockery::mock('Tricks\Filters\ViewThrottleFilter', [
      Mockery::mock('Illuminate\Config\Repository'),
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

  /**
   * @group tricks/filters
   */
  public function testGetViewedTricks()
  {
    $repositoryMock = Mockery::mock('Illuminate\Config\Repository');

    $storeMock = Mockery::mock('Illuminate\Session\Store')
      ->makePartial();

    $storeMock
      ->shouldReceive('get')
      ->atLeast()->once()
      ->with('viewed_tricks', null)
      ->andReturn('mocked');

    $viewThrottleFilterMock = Mockery::mock('Tricks\Filters\ViewThrottleFilter', [
      $repositoryMock,
      $storeMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->assertEquals('mocked', $viewThrottleFilterMock->getViewedTricks());
  }

  /**
   * @group tricks/filters
   */
  public function testGetThrottleTime()
  {
    $repositoryMock = Mockery::mock('Illuminate\Config\Repository')
      ->makePartial();

    $repositoryMock
      ->shouldReceive('get')
      ->atLeast()->once()
      ->with('config.view_throttle_time')
      ->andReturn('mocked');

    $storeMock = Mockery::mock('Illuminate\Session\Store');

    $viewThrottleFilterMock = Mockery::mock('Tricks\Filters\ViewThrottleFilter', [
      $repositoryMock,
      $storeMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->assertEquals('mocked', $viewThrottleFilterMock->getThrottleTime());
  }

  /**
   * @group tricks/filters
   */
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

    $viewThrottleFilterMock = Mockery::mock('Tricks\Filters\ViewThrottleFilter', [
      Mockery::mock('Illuminate\Config\Repository'),
      Mockery::mock('Illuminate\Session\Store')
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $viewThrottleFilterMock
      ->shouldReceive('getThrottleTime')
      ->atLeast()->once()
      ->andReturn(100);

    $this->assertEquals($purgedTricks, $viewThrottleFilterMock->purgeExpiredTricks($tricks));
  }

  /**
   * @group tricks/filters
   */
  public function testStoreViewedTricks()
  {
    $repositoryMock = Mockery::mock('Illuminate\Config\Repository');

    $time = time();

    $tricks = [
      "1" => $time - 50,
      "2" => $time - 150,
      "3" => $time
    ];

    $storeMock = Mockery::mock('Illuminate\Session\Store')
      ->makePartial();

    $storeMock
      ->shouldReceive('put')
      ->atLeast()->once()
      ->with('viewed_tricks', $tricks);

    $viewThrottleFilterMock = Mockery::mock('Tricks\Filters\ViewThrottleFilter', [
      $repositoryMock,
      $storeMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $viewThrottleFilterMock->storeViewedTricks($tricks);
  }
}
