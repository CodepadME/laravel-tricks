<?php

namespace Tricks\Presenters;

use Carbon\Carbon;
use HTML;
use Mockery;
use TestCase;
use Tricks\Category;
use Tricks\Trick;
use URL;

class UserPresenterTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  protected function getTrickMockWithSlug()
  {
    $mock = Mockery::mock('Tricks\Trick')
      ->makePartial();

    $mock->slug = 'mocked';

    return $mock;
  }

  /**
   * @group tricks/presenters
   */
  public function testConstructor()
  {
    $mock = Mockery::mock('Tricks\User');

    $userPresenter = new UserPresenter(
      $mock
    );

    $this->assertSame(
      $mock,
      $this->getProtectedProperty($userPresenter, 'resource')
    );
  }

  /**
   * @group tricks/presenters
   */
  public function testLastActivity()
  {
    $trickMock = Mockery::mock('stdClass');

    $trickMock
      ->shouldReceive('diffForHumans')
      ->atLeast()->once()
      ->andReturn('mocked');

    $trickMock->created_at = $trickMock;

    $trickMock
      ->shouldReceive('getCollection')
      ->atLeast()->once()
      ->andReturn($trickMock);

    $trickMock
      ->shouldReceive('sortBy')
      ->atLeast()->once()
      ->with(
        Mockery::on(function($callback) {
          $mock = Mockery::mock('stdClass');
          $mock->created_at = 'mocked';

          $this->assertEquals(
            'mocked',
            $callback($mock)
          );

          return true;
        })
      )
      ->andReturn($trickMock);

    $trickMock
      ->shouldReceive('reverse')
      ->atLeast()->once()
      ->andReturn($trickMock);

    $trickMock
      ->shouldReceive('first')
      ->atLeast()->once()
      ->andReturn($trickMock);

    $userMock = Mockery::mock('Tricks\User');

    $userPresenter = new UserPresenter(
      $userMock
    );

    $this->assertEquals(
      'No activity',
      $userPresenter->lastActivity([])
    );

    $this->assertEquals(
      'mocked',
      $userPresenter->lastActivity($trickMock)
    );
  }

  /**
   * @group tricks/presenters
   */
  public function testfullNameWithoutProfile()
  {
    $userMock = Mockery::mock('Tricks\User')
      ->makePartial();

    $userMock->username = 'foo';
    $userMock->profile  = null;

    $userPresenter = new UserPresenter(
      $userMock
    );

    $this->assertEquals(
      'foo',
      $userPresenter->fullName()
    );
  }

  /**
   * @group tricks/presenters
   */
  public function testfullNameWithProfile()
  {
    $profileMock = Mockery::mock('Tricks\Profile')
      ->makePartial();

    $profileMock->name = 'foo';

    $userMock = Mockery::mock('Tricks\User')
      ->makePartial();
      
    $userMock->profile = $profileMock;

    $userPresenter = new UserPresenter(
      $userMock
    );

    $this->assertEquals(
      'foo',
      $userPresenter->fullName()
    );
  }
}
