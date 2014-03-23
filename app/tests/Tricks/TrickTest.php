<?php

namespace Tricks;

use Mockery;
use TestCase;

class TrickTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks
   */
  public function testVotes()
  {
    $mock = Mockery::mock('Tricks\Trick')
      ->makePartial();

    $mock
      ->shouldReceive('belongsToMany')
      ->atLeast()->once()
      ->with('Tricks\User', 'votes')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->votes());
  }

  /**
   * @group tricks
   */
  public function testUser()
  {
    $mock = Mockery::mock('Tricks\Trick')
      ->makePartial();

    $mock
      ->shouldReceive('belongsTo')
      ->atLeast()->once()
      ->with('Tricks\User')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->user());
  }

  /**
   * @group tricks
   */
  public function testTags()
  {
    $mock = Mockery::mock('Tricks\Trick')
      ->makePartial();

    $mock
      ->shouldReceive('belongsToMany')
      ->atLeast()->once()
      ->with('Tricks\Tag')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->tags());
  }

  /**
   * @group tricks
   */
  public function testCategories()
  {
    $mock = Mockery::mock('Tricks\Trick')
      ->makePartial();

    $mock
      ->shouldReceive('belongsToMany')
      ->atLeast()->once()
      ->with('Tricks\Category')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->categories());
  }
}
