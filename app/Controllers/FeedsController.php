<?php

namespace Controllers;

use Illuminate\Support\Facades\Response;
use Tricks\Repositories\TrickRepositoryInterface;

class FeedsController extends BaseController
{
    /**
     * Trick repository.
     *
     * @var \Tricks\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Create a new FeedsController instance.
     *
     * @param  \Tricks\Repositories\TrickRepositoryInterface  $tricks
     * @return void
     */
    public function __construct(TrickRepositoryInterface $tricks)
    {
        parent::__construct();

        $this->tricks = $tricks;
    }

    /**
     * Show the ATOM feed.
     *
     * @return void
     */
    public function getAtom()
    {
        return $this->buildFeed('atom');
    }

    /**
     * Show the RSS feed.
     *
     * @return \Response
     */
    public function getRss()
    {
        return $this->buildFeed('rss');
    }

    /**
     * Build the specified type of feed (ATOM or RSS).
     *
     * @param  string $type
     * @return \Response
     */
    private function buildFeed($type)
    {
        $data['tricks'] = $this->tricks->findForFeed();
        $contentType    = $this->getContentType($type);

        return Response::view("feeds.{$type}", $data, 200, [
            'Content-Type' => $contentType . '; charset=UTF-8'
        ]);
    }

    /**
     * Get the correct Content-Type for the specified type.
     *
     * @param  string $type
     * @return string
     */
    private function getContentType($type)
    {
        return ($type == 'atom') ? 'application/atom+xml' : 'application/rss+xml';
    }
}
