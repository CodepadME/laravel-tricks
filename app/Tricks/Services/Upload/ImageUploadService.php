<?php

namespace Tricks\Services\Upload;

use Intervention\Image\Image;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploadService
{
    /**
     * The directory to safe image uploads to.
     *
     * @var string
     */
    protected $directory = 'img/avatar/temp';

    /**
     * The extension to use for image files.
     *
     * @var string
     */
    protected $extension = 'jpg';

    /**
     * The dimensions to resize the image to.
     *
     * @var int
     */
    protected $size = 160;

    /**
     * The quality the image should be saved in.
     *
     * @var int
     */
    protected $quality = 65;

    /**
     * Filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Create a new ImageUploadService instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Enable CORS from the given origin.
     *
     * @param  string  $origin
     * @return void
     */
    public function enableCORS($origin)
    {
        $allowHeaders = [
            'Origin',
            'X-Requested-With',
            'Content-Range',
            'Content-Disposition',
            'Content-Type'
        ];

        header('Access-Control-Allow-Origin: ' . $origin);
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: ' . implode(', ', $allowHeaders));
    }

    /**
     * Get the full path from the given partial path.
     *
     * @param  string  $path
     * @return string
     */
    protected function getFullPath($path)
    {
        return public_path() . '/' . $path;
    }

    /**
     * Make a new unique filename
     *
     * @return string
     */
    protected function makeFilename()
    {
        return sha1(time() . time()) . ".{$this->extension}";
    }

    /**
     * Get the contents of the file located at the given path.
     *
     * @param  string  $path
     * @return mixed
     */
    protected function getFile($path)
    {
        return $this->filesystem->get($path);
    }

    /**
     * Get the size of the file located at the given path.
     *
     * @param  string  $path
     * @return mixed
     */
    protected function getFileSize($path)
    {
        return $this->filesystem->size($path);
    }

    /**
     * Construct the data URL for the JSON body
     *
     * @param  string  $mime
     * @param  string  $path
     * @return string
     */
    protected function getDataUrl($mime, $path)
    {
        $base = base64_encode($this->getFile($path));

        return 'data:' . $mime . ';base64,' . $base;
    }

    /**
     * Construct the body of the JSON response.
     *
     * @param  string  $filename
     * @param  string  $mime
     * @param  string  $path
     * @return array
     */
    protected function getJsonBody($filename, $mime, $path)
    {
        return [
            'images' => [
                'filename' => $filename,
                'mime'     => $mime,
                'size'     => $this->getFileSize($path),
                'dataURL'  => $this->getDataUrl($mime, $path)
            ]
        ];
    }

    /**
     * Handle the file upload. Returns the response body on success, or false
     * on failure.
     *
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile  $file
     * @return array|bool
     */
    public function handle(UploadedFile $file)
    {
        $mime     = $file->getMimeType();
        $filename = $this->makeFilename();
        $path     = $this->getFullPath($this->directory . '/' . $filename);

        $success = Image::make($file->getRealPath())
                        ->resize($this->size, $this->size, true, false)
                        ->save($path, $this->quality);

        if (! $success) {
            return false;
        }

        return $this->getJsonBody($filename, $mime, $path);
    }
}
