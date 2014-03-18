<?php

namespace Tricks\Services\Upload;

use Mockery;
use TestCase;

class ImageUploadServiceTest
extends TestCase
{
  public function tearDown()
  {
      Mockery::close();
  }

  /**
   * @group tricks/services
   */
  public function testConstructor()
  {
    $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem');

    $imageUploadService = new ImageUploadService($filesystemMock);

    $this->assertEquals(
      $filesystemMock,
      $this->getProtectedProperty($imageUploadService, 'filesystem')
    );
  }

  /**
   * @group tricks/services
   */
  public function testEnableCORS()
  {
    if (!function_exists('xdebug_get_headers')) {
        $this->markTestSkipped(
          'The XDebug extension is missing.'
        );
    }

    $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem');

    $imageUploadService = new ImageUploadService($filesystemMock);

    $imageUploadService->enableCORS('foo');
    $headers = xdebug_get_headers();

    $this->assertContains(
      'Access-Control-Allow-Origin: foo',
      $headers
    );

    $this->assertContains(
      'Access-Control-Allow-Methods: POST, GET, OPTIONS',
      $headers
    );

    $this->assertContains(
      'Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Range, Content-Disposition, Content-Type',
      $headers
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetFullPath()
  {
    $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem');

    $imageUploadServiceMock = Mockery::mock('Tricks\Services\Upload\ImageUploadService', [
      $filesystemMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->assertEquals(
      realpath(__DIR__ . '/../../../../../public/favicon.ico'),
      $imageUploadServiceMock->getFullPath('favicon.ico')
    );
  }

  /**
   * @group tricks/services
   */
  public function testMakeFilename()
  {
    $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem');

    $imageUploadServiceMock = Mockery::mock('Tricks\Services\Upload\ImageUploadService', [
      $filesystemMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->setProtectedProperty($imageUploadServiceMock, 'extension', 'foo');

    $this->assertRegExp(
      '/[0-9a-f]{40}\.foo/',
      $imageUploadServiceMock->makeFilename()
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetFile()
  {
    $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem');

    $filesystemMock
      ->shouldReceive('get')
      ->atLeast()->once()
      ->with('foo')
      ->andReturn('mocked');

    $imageUploadServiceMock = Mockery::mock('Tricks\Services\Upload\ImageUploadService', [
      $filesystemMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->assertEquals(
      'mocked',
      $imageUploadServiceMock->getFile('foo')
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetFileSize()
  {
    $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem');

    $filesystemMock
      ->shouldReceive('size')
      ->atLeast()->once()
      ->with('foo')
      ->andReturn('mocked');

    $imageUploadServiceMock = Mockery::mock('Tricks\Services\Upload\ImageUploadService', [
      $filesystemMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $this->assertEquals(
      'mocked',
      $imageUploadServiceMock->getFileSize('foo')
    );
  }

  /**
   * @group tricks/services
   */
  public function testGetDataUrl()
  {
    $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem');

    $imageUploadServiceMock = Mockery::mock('Tricks\Services\Upload\ImageUploadService', [
      $filesystemMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $imageUploadServiceMock
      ->shouldReceive('getFile')
      ->atLeast()->once()
      ->andReturn('bar');

    $this->assertEquals(
      'data:foo;base64,' . base64_encode('bar'),
      $imageUploadServiceMock->getDataUrl('foo', 'bar')
    );
  }
}
