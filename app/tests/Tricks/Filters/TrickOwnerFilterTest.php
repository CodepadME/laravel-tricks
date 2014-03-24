<?php

namespace Tricks\Filters;

use Mockery;
use TestCase;

class TrickOwnerFilterTest
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
    $authManagerMock = Mockery::mock('Illuminate\Auth\AuthManager');

    $redirectorMock = Mockery::mock('Illuminate\Routing\Redirector');

    $trickRepositoryMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface');

    $trickOwnerFilter = new TrickOwnerFilter(
      $authManagerMock,
      $redirectorMock,
      $trickRepositoryMock
    );

    $this->assertSame(
      $authManagerMock,
      $this->getProtectedProperty($trickOwnerFilter, 'auth')
    );

    $this->assertSame(
      $redirectorMock,
      $this->getProtectedProperty($trickOwnerFilter, 'redirect')
    );

    $this->assertSame(
      $trickRepositoryMock,
      $this->getProtectedProperty($trickOwnerFilter, 'tricks')
    );
  }

  /**
   * @group tricks/filters
   */
  public function testFilter()
  {
    $routeMock1 = Mockery::mock('Illuminate\Routing\Route');

    $routeMock2 = Mockery::mock('Illuminate\Routing\Route');

    $authManagerMock = Mockery::mock('Illuminate\Auth\AuthManager');

    $redirectorMock = Mockery::mock('Illuminate\Routing\Redirector');

    $redirectorMock
      ->shouldReceive('route')
      ->atLeast()->once()
      ->with('browse.recent')
      ->andReturn('mocked route');

    $trickRepositoryMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface');

    $trickOwnerFilterMock = Mockery::mock('Tricks\Filters\TrickOwnerFilter', [
      $authManagerMock,
      $redirectorMock,
      $trickRepositoryMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $trickOwnerFilterMock
      ->shouldReceive('getSlug')
      ->atLeast()->once()
      ->with($routeMock1)
      ->andReturn('mocked route1 getSlug');

      $trickOwnerFilterMock
        ->shouldReceive('getSlug')
        ->atLeast()->once()
        ->with($routeMock2)
        ->andReturn('mocked route2 getSlug');

    $trickOwnerFilterMock
      ->shouldReceive('getUserId')
      ->atLeast()->once()
      ->andReturn(1);

    $trickOwnerFilterMock
      ->shouldReceive('isTrickOwnedByUser')
      ->atLeast()->once()
      ->with('mocked route1 getSlug', 1)
      ->andReturn(true);

    $trickOwnerFilterMock
      ->shouldReceive('isTrickOwnedByUser')
      ->atLeast()->once()
      ->with('mocked route2 getSlug', 1)
      ->andReturn(false);

    $this->assertNull(
      $trickOwnerFilterMock->filter($routeMock1)
    );

    $this->assertEquals(
      'mocked route',
      $trickOwnerFilterMock->filter($routeMock2)
    );
  }

  /**
   * @group tricks/filters
   */
  public function testGetUserId()
  {
    $authManagerMock = Mockery::mock('Illuminate\Auth\AuthManager');

    $authManagerMock
      ->shouldReceive('user')
      ->atLeast()->once()
      ->andReturn($authManagerMock);

    $authManagerMock->id = 1;

    $redirectorMock = Mockery::mock('Illuminate\Routing\Redirector');

    $trickRepositoryMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface');

    $trickOwnerFilterMock = Mockery::mock('Tricks\Filters\TrickOwnerFilter', [
      $authManagerMock,
      $redirectorMock,
      $trickRepositoryMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->assertEquals(
      1,
      $trickOwnerFilterMock->getUserId()
    );
  }

  /**
   * @group tricks/filters
   */
  public function testGetSlug()
  {
    $routeMock = Mockery::mock('Illuminate\Routing\Route');

    $routeMock
      ->shouldReceive('getParameter')
      ->atLeast()->once()
      ->with('trick_slug')
      ->andReturn('mocked getParameter');

    $trickOwnerFilterMock = Mockery::mock('Tricks\Filters\TrickOwnerFilter', [
      Mockery::mock('Illuminate\Auth\AuthManager'),
      Mockery::mock('Illuminate\Routing\Redirector'),
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface')
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->assertEquals(
      'mocked getParameter',
      $trickOwnerFilterMock->getSlug($routeMock)
    );
  }

  /**
   * @group tricks/filters
   */
  public function testIsTrickOwnedByUser()
  {
    $authManagerMock = Mockery::mock('Illuminate\Auth\AuthManager');

    $redirectorMock = Mockery::mock('Illuminate\Routing\Redirector');

    $trickRepositoryMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface');

    $trickRepositoryMock
      ->shouldReceive('isTrickOwnedByUser')
      ->atLeast()->once()
      ->with('foo', 1)
      ->andReturn('mocked isTrickOwnedByUser');

    $trickOwnerFilterMock = Mockery::mock('Tricks\Filters\TrickOwnerFilter', [
      $authManagerMock,
      $redirectorMock,
      $trickRepositoryMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->assertEquals(
      'mocked isTrickOwnedByUser',
      $trickOwnerFilterMock->isTrickOwnedByUser('foo', 1)
    );
  }
}
