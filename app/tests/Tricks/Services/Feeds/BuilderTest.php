<?php

namespace Tricks\Services\Feeds;

use Mockery;
use PHPUnit_Framework_Assert as Assert;
use ReflectionClass;
use TestCase;
use Tricks\Services\Feeds\Builder;

class BuilderTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks/services
   */
  public function testConstructor()
  {
    $trickRepositoryInterfaceMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface');

    $responseMock = Mockery::mock('Illuminate\Http\Response');

    $environmentMock = Mockery::mock('Illuminate\View\Environment');

    $builder = new Builder(
      $trickRepositoryInterfaceMock,
      $responseMock,
      $environmentMock
    );

    $this->assertSame(
      $trickRepositoryInterfaceMock,
      Assert::readAttribute($builder, 'tricks')
    );

    $this->assertSame(
      $responseMock,
      Assert::readAttribute($builder, 'response')
    );

    $this->assertSame(
      $environmentMock,
      Assert::readAttribute($builder, 'view')
    );
  }

  /**
   * @group tricks/services
   */
  public function testSetType()
  {
    $builder = new Builder(
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      Mockery::mock('Illuminate\Http\Response'),
      Mockery::mock('Illuminate\View\Environment')
    );

    $builder->setType('Foo');

    $this->assertSame(
      'foo',
      Assert::readAttribute($builder, 'type')
    );
  }

  /**
   * @group tricks/services
   */
  public function testSetCharset()
  {
    $builder = new Builder(
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      Mockery::mock('Illuminate\Http\Response'),
      Mockery::mock('Illuminate\View\Environment')
    );

    $builder->setCharset('foo');

    $this->assertSame(
      'foo',
      Assert::readAttribute($builder, 'charset')
    );
  }

  /**
   * @group tricks/services
   */
  public function testRender()
  {
    $environmentMock = Mockery::mock('Illuminate\View\Environment');

    $responseMock = Mockery::mock('Illuminate\Http\Response');

    $responseMock
      ->shouldReceive('setContent')
      ->atLeast()->once()
      ->with($environmentMock);

    $builderMock = Mockery::mock('Tricks\Services\Feeds\Builder[setType,getFeedData,prepareView,prepareHeaders]', [
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      $responseMock,
      $environmentMock
    ])->shouldAllowMockingProtectedMethods();

    $builderMock
      ->shouldReceive('setType')
      ->atLeast()->once()
      ->with('foo');

    $builderMock
      ->shouldReceive('getFeedData')
      ->atLeast()->once()
      ->andReturn([]);

    $builderMock
      ->shouldReceive('prepareView')
      ->atLeast()->once()
      ->with([])
      ->andReturn($environmentMock);


    $builderMock
      ->shouldReceive('prepareHeaders')
      ->atLeast()->once();

    $this->assertSame(
      $responseMock,
      $builderMock->render('foo')
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetFeedData()
  {
    $trickRepositoryInterfaceMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface');

    $trickRepositoryInterfaceMock
      ->shouldReceive('findForFeed')
      ->atLeast()->once()
      ->andReturn('mocked');

    $builderMock = Mockery::mock('Tricks\Services\Feeds\Builder[getFeedData]', [
      $trickRepositoryInterfaceMock,
      Mockery::mock('Illuminate\Http\Response'),
      Mockery::mock('Illuminate\View\Environment')
    ])->shouldAllowMockingProtectedMethods();

    $builderMock
      ->shouldReceive('getFeedData')
      ->atLeast()->once()
      ->passthru();

    $this->assertEquals(
      ['tricks' => 'mocked'],
      $builderMock->getFeedData()
    );
  }

  /**
   * @group tricks/services
   */
  public function testPrepareHeaders()
  {
    $responseMock = Mockery::mock('Illuminate\Http\Response');

    $responseMock
      ->shouldReceive('header')
      ->atLeast()->once()
      ->with('Content-Type', 'bar; charset=UTF-8');

    $builderMock = Mockery::mock('Tricks\Services\Feeds\Builder[getContentType,prepareHeaders]', [
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      $responseMock,
      Mockery::mock('Illuminate\View\Environment')
    ])->shouldAllowMockingProtectedMethods();

    $builderMock
      ->shouldReceive('getContentType')
      ->atLeast()->once()
      ->andReturn('bar');

    $builderMock
      ->shouldReceive('prepareHeaders')
      ->atLeast()->once()
      ->passthru();

    $builderMock->prepareHeaders();
  }

  /**
   * @group tricks/services
   */
  public function testGetContentType()
  {
    $builderMock = Mockery::mock('Tricks\Services\Feeds\Builder[getContentType]', [
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      Mockery::mock('Illuminate\Http\Response'),
      Mockery::mock('Illuminate\View\Environment')
    ])->shouldAllowMockingProtectedMethods();

    $builderMock
      ->shouldReceive('getContentType')
      ->atLeast()->once()
      ->passthru();

    $class = new ReflectionClass($builderMock);
    $property = $class->getProperty('type');
    $property->setAccessible(true);

    $property->setValue($builderMock, 'rss');

    $this->assertSame(
      'application/rss+xml',
      $builderMock->getContentType()
    );

    $property->setValue($builderMock, 'atom');

    $this->assertSame(
      'application/atom+xml',
      $builderMock->getContentType()
    );
  }

  /**
   * @group tricks/services
   */
  public function testPrepareView()
  {
    $data = ['foo' => 'bar'];

    $environmentMock = Mockery::mock('Illuminate\View\Environment');

    $environmentMock
      ->shouldReceive('make')
      ->atLeast()->once()
      ->with('mocked', $data)
      ->andReturn('mocked');

    $builderMock = Mockery::mock('Tricks\Services\Feeds\Builder[getViewName,prepareView]', [
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      Mockery::mock('Illuminate\Http\Response'),
      $environmentMock
    ])->shouldAllowMockingProtectedMethods();

    $builderMock
      ->shouldReceive('prepareView')
      ->atLeast()->once()
      ->passthru();

    $builderMock
      ->shouldReceive('getViewName')
      ->atLeast()->once()
      ->andReturn('mocked');

    $this->assertEquals(
      'mocked',
      $builderMock->prepareView($data)
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetViewName()
  {
    $builderMock = Mockery::mock('Tricks\Services\Feeds\Builder[getViewName]', [
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      Mockery::mock('Illuminate\Http\Response'),
      Mockery::mock('Illuminate\View\Environment')
    ])->shouldAllowMockingProtectedMethods();

    $builderMock
      ->shouldReceive('getViewName')
      ->atLeast()->once()
      ->passthru();

    $class = new ReflectionClass($builderMock);
    $property = $class->getProperty('type');
    $property->setAccessible(true);

    $property->setValue($builderMock, 'rss');

    $this->assertSame(
      'feeds.rss',
      $builderMock->getViewName()
    );

    $property->setValue($builderMock, 'atom');

    $this->assertSame(
      'feeds.atom',
      $builderMock->getViewName()
    );
  }
}
