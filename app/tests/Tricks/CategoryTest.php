<?php

namespace Tricks;

use Mockery;
use TestCase;

class CategoryTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks
   */
  public function testTricks()
  {
    $mock = Mockery::mock('Tricks\Category')
      ->makePartial();

    $mock
      ->shouldReceive('belongsToMany')
      ->atLeast()->once()
      ->with('Tricks\Trick')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->tricks());
  }
}
