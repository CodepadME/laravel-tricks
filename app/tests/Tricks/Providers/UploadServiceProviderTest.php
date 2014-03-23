<?php

namespace Tricks\Providers;

use App;
use Mockery;
use TestCase;

class UploadServiceProviderTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks/providers
   */
  public function testRegister()
  {
    $mock = Mockery::mock('Illuminate\Foundation\Application')
      ->makePartial();

    $mock
      ->shouldReceive('share')
      ->atLeast()->once()
      ->with(Mockery::on(function($callback) {
        $mock = Mockery::mock('Illuminate\Foundation\Application');

        $mock
          ->shouldReceive('offsetGet')
          ->atLeast()->once()
          ->with('files')
          ->andReturn(
            Mockery::mock('Illuminate\Filesystem\Filesystem')
          );

        $this->assertInstanceOf('Tricks\Services\Upload\ImageUploadService', $callback($mock));

        return true;
      }))
      ->andReturn('mocked');

    $mock
      ->shouldReceive('offsetSet')
      ->atLeast()->once()
      ->with('upload.image', 'mocked');

    $provider = new UploadServiceProvider(
      $mock
    );

    App::register($provider, [], true);
  }
}
