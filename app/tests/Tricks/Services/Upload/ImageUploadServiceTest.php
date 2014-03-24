<?php

namespace Tricks\Services\Upload;

use Intervention\Image\Image as Base;
use Image;
use Mockery;
use ReflectionMethod;
use TestCase;

$headers = [];

function header($value) {
  global $headers;
  $headers[] = $value;
}

function get_headers() {
  global $headers;
  return $headers;
}

class MockableImage
extends Base
{
  public function __construct($path)
  {
    // nothing to see here
  }
}

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
    $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem');

    $imageUploadService = new ImageUploadService($filesystemMock);

    $imageUploadService->enableCORS('foo');
    $headers = get_headers();

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
    $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem')
      ->makePartial();

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
    $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem')
      ->makePartial();

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

  /**
   * @group tricks/services
   */
  public function testsGetJsonBody()
  {
    $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem');

    $imageUploadServiceMock = Mockery::mock('Tricks\Services\Upload\ImageUploadService', [
      $filesystemMock
    ])
      ->shouldAllowMockingProtectedMethods()
      ->makePartial();

    $imageUploadServiceMock
      ->shouldReceive('getFileSize')
      ->atLeast()->once()
      ->with('foo')
      ->andReturn('mocked');

    $imageUploadServiceMock
      ->shouldReceive('getDataUrl')
      ->atLeast()->once()
      ->with('bar', 'foo')
      ->andReturn('mocked');

    $this->assertEquals(
      [
        'images' => [
          'filename' => 'baz',
          'mime'     => 'bar',
          'size'     => 'mocked',
          'dataURL'  => 'mocked'
        ]
      ],
      $imageUploadServiceMock->getJsonBody('baz', 'bar', 'foo')
    );
  }

  /**
   * @group tricks/services
   */
  public function testHandle()
  {
    $this->incomplete('Need to mock Image::make()');
  }
}
