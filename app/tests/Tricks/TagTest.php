<?php

namespace Tricks;

use Mockery;
use TestCase;

class TagTest
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
    $mock = Mockery::mock('Tricks\Tag')
      ->makePartial();

    $mock
      ->shouldReceive('belongsToMany')
      ->atLeast()->once()
      ->with('Tricks\Trick')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->tricks());
  }
}
