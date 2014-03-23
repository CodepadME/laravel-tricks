<?php

namespace Tricks\Providers;

use App;
use Mockery;
use TestCase;

class SitemapServiceProviderTest
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
      ->shouldReceive('alias')
      ->atLeast()->once()
      ->with('sitemap', 'Roumen\Sitemap\Sitemap');

    $provider = new SitemapServiceProvider(
      $mock
    );

    App::register($provider, [], true);
  }
}
