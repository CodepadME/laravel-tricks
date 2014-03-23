<?php

namespace Tricks;

use Mockery;
use TestCase;

class ProfileTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks
   */
  public function testUser()
  {
    $mock = Mockery::mock('Tricks\Profile')
      ->makePartial();

    $mock
      ->shouldReceive('belongsTo')
      ->atLeast()->once()
      ->with('Tricks\User')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->user());
  }
}
