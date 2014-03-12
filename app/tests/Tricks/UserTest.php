<?php

namespace Tricks;

use AspectMock\Test;
use Mockery;
use TestCase;

class UserTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
      Test::clean();
  }

  public function testProfile()
  {
    $mock = Mockery::mock('Tricks\User[hasOne]');

    $mock
      ->shouldReceive('hasOne')
      ->atLeast()->once()
      ->with('Tricks\Profile')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->profile());
  }

  public function testTricks()
  {
    $mock = Mockery::mock('Tricks\User[hasMany]');

    $mock
      ->shouldReceive('hasMany')
      ->atLeast()->once()
      ->with('Tricks\Trick')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->tricks());
  }

  public function testVotes()
  {
    $mock = Mockery::mock('Tricks\User[belongsToMany]');

    $mock
      ->shouldReceive('belongsToMany')
      ->atLeast()->once()
      ->with('Tricks\Trick', 'votes')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->votes());
  }

  public function testGetAuthIdentifier()
  {
    $mock = Mockery::mock('Tricks\User[getKey]');

    $mock
      ->shouldReceive('getKey')
      ->atLeast()->once()
      ->andReturn('mocked');

    $this->assertEquals('mocked', $mock->getAuthIdentifier());
  }

  public function testGetAuthPassword()
  {
    $password = 'foo';

    $user = new User();
    $user->password = $password;

    $this->assertEquals($password, $user->getAuthPassword());
  }

  public function testGetPhotoCssAttribute()
  {
    $photo = 'foo';

    $user = new User();
    $user->photo = $photo;

    $this->assertEquals(url('img/avatar/' . $user->photo), $user->getPhotocssAttribute());
  }

  public function testGetGravatarPhotoCssAttribute()
  {
    $email  = 'foo';
    $double = Test::double('Thomaswelton\LaravelGravatar\Gravatar');

    $user = new User();
    $user->email = $email;

    $user->getPhotocssAttribute();

    $double->verifyInvoked('src');
  }

  public function testGetReminderEmail()
  {
    $email = 'foo';

    $user = new User();
    $user->email = $email;

    $this->assertEquals($email, $user->getReminderEmail());
  }

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
