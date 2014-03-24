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

    $categoryRepositoryMock = Mockery::mock('Tricks\Repositories\Eloquent\CategoryRepository', [
      $categoryMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $categoryRepositoryMock
      ->shouldReceive('getNew')
      ->atLeast()->once()
      ->andReturn($categoryMock);

    $categoryRepositoryMock
      ->shouldReceive('getMaxOrder')
      ->atLeast()->once()
      ->andReturn(1);

    $this->assertSame(
      $categoryMock,
      $categoryRepositoryMock->create($data)
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

  /**
   * @group tricks/repositories
   */
  public function testUpdate()
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

    $categoryRepositoryMock = Mockery::mock('Tricks\Repositories\Eloquent\CategoryRepository', [
      $categoryMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $categoryRepositoryMock
      ->shouldReceive('findById')
      ->atLeast()->once()
      ->with(1)
      ->andReturn($categoryMock);

    $this->assertSame(
      $categoryMock,
      $categoryRepositoryMock->update(1, $data)
    );

    $this->assertEquals(
      'bar',
      $categoryMock->description
    );

    $this->incomplete('Need to mock e() and Str::slug()');
  }

  /**
   * @group tricks/repositories
   */
  public function testGetMaxOrder()
  {
    $categoryMock = Mockery::mock('Tricks\Category')
      ->makePartial();

    $categoryMock
      ->shouldReceive('max')
      ->atLeast()->once()
      ->with('order')
      ->andReturn('mocked max');

    $categoryRepository = new CategoryRepository($categoryMock);

    $this->assertEquals(
      'mocked max',
      $categoryRepository->getMaxOrder()
    );
  }

  /**
   * @group tricks/repositories
   */
  public function testDelete()
  {
    $categoryMock = Mockery::mock('Tricks\Category')
      ->makePartial();

    $categoryMock
      ->shouldReceive('tricks')
      ->atLeast()->once()
      ->andReturn($categoryMock);

    $categoryMock
      ->shouldReceive('detach')
      ->atLeast()->once();

    $categoryMock
      ->shouldReceive('delete')
      ->atLeast()->once();

    $categoryRepositoryMock = Mockery::mock('Tricks\Repositories\Eloquent\CategoryRepository', [
      $categoryMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $categoryRepositoryMock
      ->shouldReceive('findById')
      ->atLeast()->once()
      ->with(1)
      ->andReturn($categoryMock);

    $categoryRepositoryMock->delete(1);
  }

  /**
   * @group tricks/repositories
   */
  public function testArrange()
  {
    $data = [
      11 => 1
    ];


    $collectionMock = Mockery::mock('stdClass');

    $categoryMock = Mockery::mock('Tricks\Category')
      ->makePartial();

    $categoryMock
      ->shouldReceive('whereIn')
      ->atLeast()->once()
      ->with('id', array_values($data))
      ->andReturn($categoryMock);

    $categoryMock
      ->shouldReceive('get')
      ->atLeast()->once()
      ->with(['id'])
      ->andReturn($collectionMock);

    $categoryMock
      ->shouldReceive('save')
      ->atLeast()->once();

    $collectionMock
      ->shouldReceive('find')
      ->atLeast()->once()
      ->with(1)
      ->andReturn($categoryMock);

    $categoryRepository = new CategoryRepository($categoryMock);

    $categoryRepository->arrange($data);

    $this->assertSame(
      11,
      $categoryMock->order
    );
  }

  /**
   * @group tricks/repositories
   */
  public function testGetForm()
  {
    $categoryRepository = new CategoryRepository(
      Mockery::mock('Tricks\Category')
    );

    $this->assertInstanceOf(
      'Tricks\Services\Forms\CategoryForm',
      $categoryRepository->getForm()
    );
  }
}
