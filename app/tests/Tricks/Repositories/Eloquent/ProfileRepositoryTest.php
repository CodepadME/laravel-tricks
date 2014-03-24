<?php

namespace Tricks\Repositories\Eloquent;

use Mockery;
use TestCase;

class ProfileRepositoryTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks/repositories
   */
  public function testConstructor()
  {
    $profileMock = Mockery::mock('Tricks\Profile')
      ->makePartial();

    $profileRepository = new ProfileRepository($profileMock);

    $this->assertSame(
      $profileMock,
      $this->getProtectedProperty($profileRepository, 'model')
    );
  }

  /**
   * @group tricks/repositories
   */
  public function testFindByUid()
  {
    $profileMock = Mockery::mock('Tricks\Profile')
      ->makePartial();

    $profileMock
      ->shouldReceive('whereUid')
      ->atLeast()->once()
      ->with(1)
      ->andReturn($profileMock);

    $profileMock
      ->shouldReceive('first')
      ->atLeast()->once()
      ->andReturn('mocked first');

    $profileRepository = new ProfileRepository($profileMock);

    $this->assertEquals(
      'mocked first',
      $profileRepository->findByUid(1)
    );
  }

  /**
   * @group tricks/repositories
   */
  public function testCreateFromGithubData()
  {
    $userMock = Mockery::mock('Tricks\User')
      ->makePartial();

    $userMock->id = 1;

    $profileMock = Mockery::mock('Tricks\Profile')
      ->makePartial();

    $profileMock
      ->shouldReceive('save')
      ->atLeast()->once();

    $detailsMock = Mockery::mock('League\OAuth2\Client\Provider\User')
      ->makePartial();

    $detailsMock->uid          = 1;
    $detailsMock->nickname     = 'foo';
    $detailsMock->name         = 'bar';
    $detailsMock->email        = 'foo@bar.com';
    $detailsMock->first_name   = 'foobert';
    $detailsMock->lastName     = 'barman';
    $detailsMock->location     = 'bazton';
    $detailsMock->description  = 'foo';
    $detailsMock->image_url    = 'bar';
    $detailsMock->access_token = 'baz';

    $profileRepositoryMock = Mockery::mock('Tricks\Repositories\Eloquent\ProfileRepository', [
      $profileMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $profileRepositoryMock
      ->shouldReceive('getNew')
      ->atLeast()->once()
      ->andReturn($profileMock);

    $this->assertSame(
      $profileMock,
      $profileRepositoryMock->createFromGithubData(
        $detailsMock,
        $userMock,
        'baz'
      )
    );

    $this->assertSame(
      $userMock->id,
      $profileMock->user_id
    );
  }

  /**
   * @group tricks/repositories
   */
  public function testUpdateToken()
  {
    $profileMock = Mockery::mock('Tricks\Profile')
      ->makePartial();

    $profileMock
      ->shouldReceive('save')
      ->atLeast()->once();

    $profileRepository = new ProfileRepository($profileMock);

    $this->assertSame(
      $profileMock,
      $profileRepository->updateToken($profileMock, 'foo')
    );

    $this->assertEquals(
      'foo',
      $profileMock->access_token
    );
  }
}
