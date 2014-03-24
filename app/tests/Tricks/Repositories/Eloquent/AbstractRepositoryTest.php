<?php

namespace Tricks\Repositories\Eloquent;

use Mockery;
use TestCase;

class ConcreteRepository
extends AbstractRepository
{

}

class AbstractRepositoryTest
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
    $modelMock = Mockery::mock('Illuminate\Database\Eloquent\Model')
      ->makePartial();

    $concreteRepository = new ConcreteRepository($modelMock);

    $this->assertSame(
      $modelMock,
      $this->getProtectedProperty($concreteRepository, 'model')
    );
  }

  /**
   * @group tricks/repositories
   */
  public function testGetNew()
  {
    $data = [
      'foo' => 1,
      'bar' => 2,
      'baz' => 3
    ];

    $modelMock = Mockery::mock('Illuminate\Database\Eloquent\Model')
      ->makePartial();

    $modelMock
      ->shouldReceive('newInstance')
      ->atLeast()->once()
      ->with($data)
      ->andReturn('mocked newInstance');

    $concreteRepository = new ConcreteRepository($modelMock);

    $this->assertSame(
      'mocked newInstance',
      $concreteRepository->getNew($data)
    );
  }
}
