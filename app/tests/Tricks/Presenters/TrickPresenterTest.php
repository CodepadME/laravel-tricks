<?php

namespace Tricks\Presenters;

use Carbon\Carbon;
use HTML;
use Mockery;
use TestCase;
use Tricks\Category;
use Tricks\Trick;
use URL;

class TrickPresenterTest
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
    $mock = Mockery::mock('Tricks\Trick');

    $trickPresenter = new TrickPresenter(
      $mock
    );

    $this->assertSame(
      $mock,
      $this->getProtectedProperty($trickPresenter, 'resource')
    );
  }

  /**
   * @group tricks/presenters
   */
  public function testEditLink()
  {
    $urlMock = Mockery::mock('stdClass');

    $urlMock
      ->shouldReceive('route')
      ->atLeast()->once()
      ->with('tricks.edit', ['mocked'])
      ->andReturn('mocked');

    URL::swap($urlMock);

    $trickPresenter = new TrickPresenter(
      $this->getTrickMockWithSlug()
    );

    $this->assertEquals('mocked', $trickPresenter->editLink());
  }

  /**
   * @group tricks/presenters
   */
  public function testDeleteLink()
  {
    $urlMock = Mockery::mock('stdClass');

    $urlMock
      ->shouldReceive('route')
      ->atLeast()->once()
      ->with('tricks.delete', ['mocked'])
      ->andReturn('mocked');

    URL::swap($urlMock);

    $trickPresenter = new TrickPresenter(
      $this->getTrickMockWithSlug()
    );

    $this->assertEquals('mocked', $trickPresenter->deleteLink());
  }

  /**
   * @group tricks/presenters
   */
  public function testTimeAgoLink()
  {
    $trickMock = Mockery::mock('Tricks\Trick')
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $trickMock
      ->shouldReceive('getDateFormat')
      ->atLeast()->once()
      ->andReturn('Y-m-d H:i:s');

    $trickMock->created_at = Carbon::now();

    $trickPresenter = new TrickPresenter(
      $trickMock
    );

    $this->assertEquals($trickMock->created_at->diffForHumans(), $trickPresenter->timeago());
  }

  /**
   * @group tricks/presenters
   */
  public function testLikedByUser()
  {
    $userMock = Mockery::mock('Tricks\User')
      ->makePartial();

    $userMock->id = 'mocked';

    $trickMock = Mockery::mock('Tricks\Trick');

    $trickMock
      ->shouldReceive('votes')
      ->atLeast()->once()
      ->andReturn($trickMock);

    $trickMock
      ->shouldReceive('where')
      ->atLeast()->once()
      ->with('users.id', 'mocked')
      ->andReturn($trickMock);

    $trickMock
      ->shouldReceive('exists')
      ->atLeast()->once()
      ->andReturn(true);

    $trickPresenter = new TrickPresenter(
      $trickMock
    );

    $this->assertFalse(
      $trickPresenter->likedByUser(null)
    );

    $this->assertTrue(
      $trickPresenter->likedByUser($userMock)
    );

    $this->assertTrue(
      $this->getProtectedProperty($trickPresenter, 'likedByUser')
    );
  }

  /**
   * @group tricks/presenters
   */
  public function testAllCategories()
  {
    $trickMock = Mockery::mock('Tricks\Trick')
      ->makePartial();

    $trickMock->categories = 'mocked';

    $trickPresenter = new TrickPresenter(
      $trickMock
    );

    $this->assertEquals(
      'mocked',
      $trickPresenter->allCategories()
    );
  }

  /**
   * @group tricks/presenters
   */
  public function testCategories()
  {
    $categoryMock = Mockery::mock('Tricks\Category');

    $trickMock = Mockery::mock('Tricks\Trick')
      ->makePartial();

    $trickMock->categories = [
      $categoryMock,
      $categoryMock,
      $categoryMock
    ];

    $trickPresenterMock = Mockery::mock('Tricks\Presenters\TrickPresenter', [
      $trickMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $trickPresenterMock
      ->shouldReceive('hasCategories')
      ->atLeast()->once()
      ->andReturn(true);

    $trickPresenterMock
      ->shouldReceive('getCategoryLink')
      ->atLeast()->once()
      ->with($categoryMock)
      ->andReturn('[category]');

    $this->assertEquals(
      'in [category], [category], [category]',
      $trickPresenterMock->categories()
    );
  }

  /**
   * @group tricks/presenters
   */
  public function testHasCategories()
  {
    $trick = new Trick();

    $trick->categories = [
      'foo',
      'bar',
      'baz'
    ];

    $trickPresenterMock = Mockery::mock('Tricks\Presenters\TrickPresenter', [
      $trick
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->assertTrue($trickPresenterMock->hasCategories());
  }

  /**
   * @group tricks/presenters
   */
  public function testGetCategoryLink()
  {
    $category = new Category();
    $category->name = 'foo';
    $category->slug = 'bar';

    $htmlMock = Mockery::mock('stdClass');

    $htmlMock
      ->shouldReceive('linkRoute')
      ->atLeast()->once()
      ->with('tricks.browse.category', 'foo', ['bar'])
      ->andReturn('mocked');

    HTML::swap($htmlMock);

    $trickMock = Mockery::mock('Tricks\Trick');

    $trickPresenterMock = Mockery::mock('Tricks\Presenters\TrickPresenter', [
      $trickMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->assertEquals(
      'mocked',
      $trickPresenterMock->getCategoryLink($category)
    );
  }

  /**
   * @group tricks/presenters
   */
  public function testPageDescription()
  {
    $trick = new Trick();

    $trick->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing
    elit. Donec porta nisi sed euismod ornare. Integer dapibus, tortor sed
    malesuada ullamcorper, ante neque bibendum nulla, eget vulputate turpis urna
    et velit. Nam egestas, magna vel hendrerit egestas, leo sem gravida dui, in
    facilisis massa erat eget nisl.';

    $trickPresenterMock = Mockery::mock('Tricks\Presenters\TrickPresenter', [
      $trick
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $trickPresenterMock
      ->shouldReceive('removeLastWord')
      ->atLeast()->once()
      ->andReturn('mocked');

    $this->assertEquals(
      'mocked...',
      $trickPresenterMock->pageDescription()
    );
  }

  /**
   * @group tricks/presenters
   */
  public function testPageTitle()
  {
    $trick = new Trick();

    $trick->title = 'Lorem ipsum dolor sit amet, consectetur adipiscing
    elit. Donec porta nisi sed euismod ornare. Integer dapibus, tortor sed
    malesuada ullamcorper, ante neque bibendum nulla, eget vulputate turpis urna
    et velit. Nam egestas, magna vel hendrerit egestas, leo sem gravida dui, in
    facilisis massa erat eget nisl.';

    $trickPresenterMock = Mockery::mock('Tricks\Presenters\TrickPresenter', [
      $trick
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $trickPresenterMock
      ->shouldReceive('removeLastWord')
      ->atLeast()->once()
      ->andReturn('mocked');

    $this->assertEquals(
      'mocked',
      $trickPresenterMock->pageTitle()
    );
  }

  /**
   * @group tricks/presenters
   */
  public function testRemoveLastWord()
  {
    $before = 'foo bar baz';

    $trickPresenterMock = Mockery::mock('Tricks\Presenters\TrickPresenter', [
      Mockery::mock('Tricks\Trick')
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->assertEquals(
      'foo bar',
      $trickPresenterMock->removeLastWord($before)
    );
  }

  /**
   * @group tricks/presenters
   */
  public function testTagUri()
  {
    $urlMock = Mockery::mock('stdClass');

    $urlMock
      ->shouldReceive('route')
      ->atLeast()->once()
      ->with('tricks.show', 'mocked')
      ->andReturn('http://foo.com/bar');

    URL::swap($urlMock);

    $trickMock = Mockery::mock('Tricks\Trick')
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $trickMock
      ->shouldReceive('getDateFormat')
      ->atLeast()->once()
      ->andReturn('Y-m-d H:i:s');

    $trickMock->slug       = 'mocked';
    $trickMock->created_at = Carbon::now();

    $trickPresenter = new TrickPresenter(
      $trickMock
    );

    $this->assertEquals(
      'tag:foo.com,' . $trickMock->created_at->format('Y-m-d') . ':/bar',
      $trickPresenter->tagUri()
    );
  }
}
