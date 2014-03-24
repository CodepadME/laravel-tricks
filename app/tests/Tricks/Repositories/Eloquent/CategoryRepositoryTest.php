<?php

namespace Tricks\Repositories\Eloquent;

use DB;
use Mockery;
use TestCase;

class CategoryRepositoryTest
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
    $categoryMock = Mockery::mock('Tricks\Category')
      ->makePartial();

    $categoryRepository = new CategoryRepository($categoryMock);

    $this->assertSame(
      $categoryMock,
      $this->getProtectedProperty($categoryRepository, 'model')
    );
  }

  /**
   * @group tricks/repositories
   */
  public function testListAll()
  {
    $categoryMock = Mockery::mock('Tricks\Category')
      ->makePartial();

    $categoryMock
      ->shouldReceive('lists')
      ->atLeast()->once()
      ->with('name', 'id')
      ->andReturn('mocked lists');

    $categoryRepository = new CategoryRepository($categoryMock);

    $this->assertEquals(
      'mocked lists',
      $categoryRepository->listAll()
    );
  }

  /**
   * @group tricks/repositories
   */
  public function testFindAll()
  {
    $categoryMock = Mockery::mock('Tricks\Category')
      ->makePartial();

    $categoryMock
      ->shouldReceive('orderBy')
      ->atLeast()->once()
      ->with('foo', 'bar')
      ->andReturn($categoryMock);

    $categoryMock
      ->shouldReceive('get')
      ->atLeast()->once()
      ->andReturn('mocked get');

    $categoryRepository = new CategoryRepository($categoryMock);

    $this->assertEquals(
      'mocked get',
      $categoryRepository->findAll('foo', 'bar')
    );
  }

  /**
   * @group tricks/repositories
   */
  public function testFindAllWithTrickCount()
  {
    $dbMock = Mockery::mock('stdClass');

    $dbMock
      ->shouldReceive('raw')
      ->atLeast()->once()
      ->with('COUNT(tricks.id) as trick_count')
      ->andReturn('COUNT(tricks.id) as trick_count');

    DB::swap($dbMock);

    $categoryMock = Mockery::mock('Tricks\Category')
      ->makePartial();

    $categoryMock
      ->shouldReceive('leftJoin')
      ->atLeast()->once()
      ->with('category_trick', 'categories.id', '=', 'category_trick.category_id')
      ->andReturn($categoryMock);

    $categoryMock
      ->shouldReceive('leftJoin')
      ->atLeast()->once()
      ->with('tricks', 'tricks.id', '=', 'category_trick.trick_id')
      ->andReturn($categoryMock);

    $categoryMock
      ->shouldReceive('groupBy')
      ->atLeast()->once()
      ->with('categories.slug')
      ->andReturn($categoryMock);

    $categoryMock
      ->shouldReceive('orderBy')
      ->atLeast()->once()
      ->with('trick_count', 'desc')
      ->andReturn($categoryMock);

    $categoryMock
      ->shouldReceive('get')
      ->atLeast()->once()
      ->with([
        'categories.name',
        'categories.slug',
        'COUNT(tricks.id) as trick_count'
      ])
      ->andReturn('mocked get');

    $categoryRepository = new CategoryRepository($categoryMock);

    $this->assertEquals(
      'mocked get',
      $categoryRepository->findAllWithTrickCount()
    );
  }

  /**
   * @group tricks/repositories
   */
  public function testFindById()
  {
    $categoryMock = Mockery::mock('Tricks\Category')
      ->makePartial();

    $categoryMock
      ->shouldReceive('find')
      ->atLeast()->once()
      ->with(1)
      ->andReturn('mocked find');

    $categoryRepository = new CategoryRepository($categoryMock);

    $this->assertEquals(
      'mocked find',
      $categoryRepository->findById(1)
    );
  }

  /**
   * @group tricks/repositories
   */
  public function testCreate()
  {
    $data = [
      'name'        => 'a new foo',
      'description' => 'bar'
    ];

    $categoryMock = Mockery::mock('Tricks\Category')
      ->makePartial();

    $categoryMock
      ->shouldReceive('save')
      ->atLeast()->once();

    $categoryRepository = Mockery::mock('Tricks\Repositories\Eloquent\CategoryRepository', [
      $categoryMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $categoryRepository
      ->shouldReceive('getNew')
      ->atLeast()->once()
      ->andReturn($categoryMock);

    $categoryRepository
      ->shouldReceive('getMaxOrder')
      ->atLeast()->once()
      ->andReturn(1);

    $this->assertSame(
      $categoryMock,
      $categoryRepository->create($data)
    );

    $this->assertEquals(
      'bar',
      $categoryMock->description
    );

    $this->assertEquals(
      2,
      $categoryMock->order
    );

    $this->incomplete('Need to mock e() and Str::slug()');
  }
}
