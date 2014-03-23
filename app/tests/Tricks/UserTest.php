<?php

namespace Tricks;

use Gravatar;
use Mockery;
use TestCase;

class UserTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks
   */
  public function testProfile()
  {
    $mock = Mockery::mock('Tricks\User')
      ->makePartial();

    $mock
      ->shouldReceive('hasOne')
      ->atLeast()->once()
      ->with('Tricks\Profile')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->profile());
  }

  /**
   * @group tricks
   */
  public function testTricks()
  {
    $mock = Mockery::mock('Tricks\User')
      ->makePartial();

    $mock
      ->shouldReceive('hasMany')
      ->atLeast()->once()
      ->with('Tricks\Trick')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->tricks());
  }

  /**
   * @group tricks
   */
  public function testVotes()
  {
    $mock = Mockery::mock('Tricks\User')
      ->makePartial();

    $mock
      ->shouldReceive('belongsToMany')
      ->atLeast()->once()
      ->with('Tricks\Trick', 'votes')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->votes());
  }

  /**
   * @group tricks
   */
  public function testGetAuthIdentifier()
  {
    $mock = Mockery::mock('Tricks\User')
      ->makePartial();

    $mock
      ->shouldReceive('getKey')
      ->atLeast()->once()
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->getAuthIdentifier());
  }

  /**
   * @group tricks
   */
  public function testGetAuthPassword()
  {
    $password = 'foo';

    $user = new User();
    $user->password = $password;

    $this->assertEquals($password, $user->getAuthPassword());
  }

  /**
   * @group tricks
   */
  public function testGetPhotoCssAttribute()
  {
    $photo = 'foo';

    $user = new User();
    $user->photo = $photo;

    $this->assertEquals(url('img/avatar/' . $user->photo), $user->getPhotocssAttribute());
  }

  /**
   * @group tricks
   */
  public function testGetGravatarPhotoCssAttribute()
  {
    $email  = 'foo';

    $mock = Mockery::mock('stdClass');

    $mock
      ->shouldReceive('src')
      ->atLeast()->once()
      ->with($email, 100)
      ->andReturn('mocked');

    Gravatar::swap($mock);

    $user = new User();
    $user->email = $email;

    $this->assertEquals('mocked', $user->getPhotocssAttribute());
  }

  /**
   * @group tricks
   */
  public function testGetReminderEmail()
  {
    $email = 'foo';

    $user = new User();
    $user->email = $email;

    $this->assertEquals($email, $user->getReminderEmail());
  }

  /**
   * @group tricks
   */
  public function testIsAdmin()
  {
    $user = new User();

    $this->assertFalse($user->isAdmin());

    $user->is_admin = false;

    $this->assertFalse($user->isAdmin());

    $user->is_admin = true;

    $this->assertTrue($user->isAdmin());
  }
}
