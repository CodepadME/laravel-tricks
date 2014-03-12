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

  public function testTricks()
  {
    $mock = Mockery::mock('Tricks\Tag[belongsToMany]');

    $mock
      ->shouldReceive('belongsToMany')
      ->atLeast()->once()
      ->with('Tricks\Trick')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->tricks());
  }
}
