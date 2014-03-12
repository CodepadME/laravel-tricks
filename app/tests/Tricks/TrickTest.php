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

  public function testVotes()
  {
    $mock = Mockery::mock('Tricks\Trick[belongsToMany]');

    $mock
      ->shouldReceive('belongsToMany')
      ->atLeast()->once()
      ->with('Tricks\User', 'votes')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->votes());
  }

  public function testUser()
  {
    $mock = Mockery::mock('Tricks\Trick[belongsTo]');

    $mock
      ->shouldReceive('belongsTo')
      ->atLeast()->once()
      ->with('Tricks\User')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->user());
  }

  public function testTags()
  {
    $mock = Mockery::mock('Tricks\Trick[belongsToMany]');

    $mock
      ->shouldReceive('belongsToMany')
      ->atLeast()->once()
      ->with('Tricks\Tag')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->tags());
  }

  public function testCategories()
  {
    $mock = Mockery::mock('Tricks\Trick[belongsToMany]');

    $mock
      ->shouldReceive('belongsToMany')
      ->atLeast()->once()
      ->with('Tricks\Category')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->categories());
  }
}
