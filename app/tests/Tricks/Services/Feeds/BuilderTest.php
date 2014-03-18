<?php

namespace Tricks\Services\Feeds;

use Mockery;
use TestCase;

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
      $this->getProtectedProperty($builder, 'tricks')
    );

    $this->assertSame(
      $responseMock,
      $this->getProtectedProperty($builder, 'response')
    );

    $this->assertSame(
      $environmentMock,
      $this->getProtectedProperty($builder, 'view')
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
      $this->getProtectedProperty($builder, 'type')
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
      $this->getProtectedProperty($builder, 'charset')
    );
  }

  /**
   * @group tricks/services
   */
  public function testRender()
  {
    $environmentMock = Mockery::mock('Illuminate\View\Environment');

    $responseMock = Mockery::mock('Illuminate\Http\Response')
      ->makePartial();

    $responseMock
      ->shouldReceive('setContent')
      ->atLeast()->once()
      ->with($environmentMock);

    $builderMock = Mockery::mock('Tricks\Services\Feeds\Builder', [
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      $responseMock,
      $environmentMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

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
    $trickRepositoryInterfaceMock = Mockery::mock('Tricks\Repositories\TrickRepositoryInterface')
      ->makePartial();

    $trickRepositoryInterfaceMock
      ->shouldReceive('findForFeed')
      ->atLeast()->once()
      ->andReturn('mocked');

    $builderMock = Mockery::mock('Tricks\Services\Feeds\Builder', [
      $trickRepositoryInterfaceMock,
      Mockery::mock('Illuminate\Http\Response'),
      Mockery::mock('Illuminate\View\Environment')
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

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
    $responseMock = Mockery::mock('Illuminate\Http\Response')
      ->makePartial();

    $responseMock
      ->shouldReceive('header')
      ->atLeast()->once()
      ->with('Content-Type', 'bar; charset=foo');

    $builderMock = Mockery::mock('Tricks\Services\Feeds\Builder', [
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      $responseMock,
      Mockery::mock('Illuminate\View\Environment')
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->setProtectedProperty($builderMock, 'charset', 'foo');

    $builderMock
      ->shouldReceive('getContentType')
      ->atLeast()->once()
      ->andReturn('bar');

    $builderMock->prepareHeaders();
  }

  /**
   * @group tricks/services
   */
  public function testGetContentType()
  {
    $builderMock = Mockery::mock('Tricks\Services\Feeds\Builder', [
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      Mockery::mock('Illuminate\Http\Response'),
      Mockery::mock('Illuminate\View\Environment')
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->setProtectedProperty($builderMock, 'type', 'rss');

    $this->assertSame(
      'application/rss+xml',
      $builderMock->getContentType()
    );

    $this->setProtectedProperty($builderMock, 'type', 'atom');

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

    $environmentMock = Mockery::mock('Illuminate\View\Environment')
      ->makePartial();

    $environmentMock
      ->shouldReceive('make')
      ->atLeast()->once()
      ->with('mocked', $data)
      ->andReturn('mocked');

    $builderMock = Mockery::mock('Tricks\Services\Feeds\Builder', [
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      Mockery::mock('Illuminate\Http\Response'),
      $environmentMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

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
    $builderMock = Mockery::mock('Tricks\Services\Feeds\Builder', [
      Mockery::mock('Tricks\Repositories\TrickRepositoryInterface'),
      Mockery::mock('Illuminate\Http\Response'),
      Mockery::mock('Illuminate\View\Environment')
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->setProtectedProperty($builderMock, 'type', 'rss');

    $this->assertSame(
      'feeds.rss',
      $builderMock->getViewName()
    );

    $this->setProtectedProperty($builderMock, 'type', 'atom');

    $this->assertSame(
      'feeds.atom',
      $builderMock->getViewName()
    );
  }
}
