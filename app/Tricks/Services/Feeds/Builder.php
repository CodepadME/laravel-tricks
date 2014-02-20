<?php

namespace Tricks\Services\Feeds;

use Illuminate\Http\Response;
use Illuminate\View\Environment;
use Tricks\Repositories\TrickRepositoryInterface;

class Builder
{
    /**
     * The feed type to build.
     *
     * @var string
     */
    protected $type;

    /**
     * Tricks repository used for persistance interaction.
     *
     * @var \Tricks\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Response instance.
     *
     * @var \Illuminate\Http\Response
     */
    protected $response;

    /**
     * View environment instance.
     *
     * @var \Illuminate\View\Environment
     */
    protected $view;

    /**
     * The charset to use for the feed.
     *
     * @var string
     */
    protected $charset = 'UTF-8';

    /**
     * Create a new feed builder instance.
     *
     * @param  \Tricks\Repositories\TrickRepositoryInterface  $tricks
     * @param  \Illuminate\Http\Response                      $response
     * @param  \Illuminate\View\Environment                   $view
     * @return void
     */
    public function __construct(
        TrickRepositoryInterface $tricks,
        Response $response,
        Environment $view
    ) {
        $this->tricks = $tricks;
        $this->response = $response;
        $this->view = $view;
    }

    /**
     * Set the feed type to build.
     *
     * @param  string  $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = strtolower($type);
    }

    /**
     * Set the charset to render the feed in.
     *
     * @param  string  $charset
     * @return void
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * Render the feed.
     *
     * @return \Illuminate\Http\Response
     */
    public function render($type)
    {
        $this->setType($type);

        $data = $this->getFeedData();
        $view = $this->prepareView($data);

        $this->prepareHeaders();

        $this->response->setContent($view);

        return $this->response;
    }

    /**
     * Gather the feed data to render.
     *
     * @return array
     */
    protected function getFeedData()
    {
        $data['tricks'] = $this->tricks->findForFeed();

        return $data;
    }

    /**
     * Prepare the headers for the response.
     *
     * @return void
     */
    protected function prepareHeaders()
    {
        $contentType = $this->getContentType();

        $header = $contentType . '; charset=' . $this->charset;

        $this->response->header('Content-Type', $header);
    }

    /**
     * Get the content type for the feed type.
     *
     * @return string
     */
    protected function getContentType()
    {
        return ($this->type === 'atom') ? 'application/atom+xml' : 'application/rss+xml';
    }

    /**
     * Prepare the feed view.
     *
     * @param  array  $data
     * @return \Illuminate\View\View
     */
    protected function prepareView(array $data)
    {
        $view = $this->getViewName();

        return $this->view->make($view, $data);
    }

    /**
     * Get the view name for the feed type.
     *
     * @return string
     */
    protected function getViewName()
    {
        return ($this->type === 'atom') ? 'feeds.atom' : 'feeds.rss';
    }
}
