<?php

namespace Tricks\Presenters;

use Carbon\Carbon;
use HTML;
use Mockery;
use PHPUnit_Framework_Assert as Assert;
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
    $mock = Mockery::mock('Tricks\Trick');

    $mock
      ->shouldReceive('getAttribute')
      ->atLeast()->once()
      ->with('slug')
      ->andReturn('mocked');

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
      Assert::readAttribute($trickPresenter, 'resource')
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
    $carbonMock = Mockery::mock('stdClass');

    $carbonMock
      ->shouldReceive('diffForHumans')
      ->atLeast()->once()
      ->andReturn('mocked');

    $trickMock = Mockery::mock('Tricks\Trick');

    $trickMock
      ->shouldReceive('getAttribute')
      ->atLeast()->once()
      ->with('created_at')
      ->andReturn(
        $carbonMock
      );

    $trickPresenter = new TrickPresenter(
      $trickMock
    );

    $this->assertEquals('mocked', $trickPresenter->timeago());
  }

  /**
   * @group tricks/presenters
   */
  public function testLikedByUser()
  {
    $userMock = Mockery::mock('Tricks\User');

    $userMock
     ->shouldReceive('getAttribute')
     ->atLeast()->once()
     ->with('id')
     ->andReturn('mocked');

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
      Assert::readAttribute($trickPresenter, 'likedByUser')
    );
  }

  /**
   * @group tricks/presenters
   */
  public function testAllCategories()
  {
    $trickMock = Mockery::mock('Tricks\Trick');

    $trickMock
      ->shouldReceive('getAttribute')
      ->atLeast()->once()
      ->with('categories')
      ->andReturn('mocked');

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

    $trickMock = Mockery::mock('Tricks\Trick');

    $trickMock
      ->shouldReceive('getAttribute')
      ->atLeast()->once()
      ->with('categories')
      ->andReturn([
        $categoryMock,
        $categoryMock,
        $categoryMock
      ]);

    $trickPresenterMock = Mockery::mock('Tricks\Presenters\TrickPresenter[hasCategories,getCategoryLink]', [
      $trickMock
    ])->shouldAllowMockingProtectedMethods();

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

    $trickPresenterMock = Mockery::mock('Tricks\Presenters\TrickPresenter[hasCategories]', [
      $trick
    ])->shouldAllowMockingProtectedMethods();

    $trickPresenterMock
      ->shouldReceive('hasCategories')
      ->atLeast()->once()
      ->passthru();

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

    $trickPresenterMock = Mockery::mock('Tricks\Presenters\TrickPresenter[getCategoryLink]', [
      $trickMock
    ])->shouldAllowMockingProtectedMethods();

    $trickPresenterMock
      ->shouldReceive('getCategoryLink')
      ->atLeast()->once()
      ->passthru();

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

    $trickPresenterMock = Mockery::mock('Tricks\Presenters\TrickPresenter[removeLastWord]', [
      $trick
    ])->shouldAllowMockingProtectedMethods();

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

    $trickPresenterMock = Mockery::mock('Tricks\Presenters\TrickPresenter[removeLastWord]', [
      $trick
    ])->shouldAllowMockingProtectedMethods();

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

    $trickPresenterMock = Mockery::mock('Tricks\Presenters\TrickPresenter[removeLastWord]', [
      Mockery::mock('Tricks\Trick')
    ])->shouldAllowMockingProtectedMethods();

    $trickPresenterMock
      ->shouldReceive('removeLastWord')
      ->atLeast()->once()
      ->passthru();

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

    $carbonMock = Mockery::mock('stdClass');

    $carbonMock
      ->shouldReceive('format')
      ->atLeast()->once()
      ->with('Y-m-d')
      ->andReturn('mocked');

    $trickMock = $this->getTrickMockWithSlug();

    $trickMock
      ->shouldReceive('getAttribute')
      ->atLeast()->once()
      ->with('created_at')
      ->andReturn($carbonMock);

    $trickPresenter = new TrickPresenter(
      $trickMock
    );

    $this->assertEquals(
      'tag:foo.com,mocked:/bar',
      $trickPresenter->tagUri()
    );
  }
}
