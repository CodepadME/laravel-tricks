<?php

namespace Tricks\Services\Social;

use Tricks\Trick;
use RuntimeException;
use Illuminate\Config\Repository;
use Guzzle\Service\Client as GuzzleClient;
use Illuminate\Database\Eloquent\Collection;
use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Message\Request as GuzzleRequest;
use Guzzle\Http\QueryAggregator\DuplicateAggregator;

class Disqus
{
    /**
     * The curl client used for Disqus API interaction
     *
     * @var \Guzzle\Service\Client
     */
    protected $client;

    /**
     * Config repository.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Create a new Disqus instance.
     *
     * @param  \Guzzle\Service\Client         $client
     * @param  \Illuminate\Config\Repository  $config
     * @return void
     */
    public function __construct(GuzzleClient $client, Repository $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * Get a config item.
     *
     * @param  mixed $key
     * @return mixed
     */
    protected function getConfig($key = null)
    {
        $key = is_null($key) ? '' : '.' . $key;

        return $this->config->get('social.disqus' . $key);
    }

    /**
     * Normalize the given trick(s) to an array of tricks.
     *
     * @param  mixed $tricks
     * @return array
     */
    protected function getValidTricks($tricks)
    {
        if ($this->areInvalidTricks($tricks)) {
            throw new RuntimeException('Invalid tricks');
        }

        if ($tricks instanceof Trick) {
            $tricks = [ $tricks ];
        }

        return $tricks;
    }

    /**
     * Determine whether the given tricks are invalid.
     *
     * @param  mixed  $tricks
     * @return bool
     */
    protected function areInvalidTricks($tricks)
    {
        return ! $tricks instanceof Trick &&
               ! ($tricks instanceof Collection && $tricks->count() > 0);
    }

    /**
     * Get a formatted list of the trick ids.
     *
     * @param  array $tricks
     * @return array
     */
    protected function getThreadsArray($tricks)
    {
        $threads = [];
        $format  = $this->getConfig('threadFormat');

        foreach ($tricks as $trick) {
            $threads[] = $format . $trick->id;
        }

        return $threads;
    }

    /**
     * Prepare the query string before the API request.
     *
     * @param  \Guzzle\Http\Message\Request $request
     * @param  array $tricks
     * @return \Guzzle\Http\Message\Request
     */
    protected function prepareQuery(GuzzleRequest $request, $tricks)
    {
        $threads = $this->getThreadsArray($tricks);
        $aggregator = $this->getQueryAggregator();

        $request->getQuery()
                ->set('forum', $this->getConfig('forum'))
                ->set('thread', $threads)
                ->set('api_key', $this->getConfig('publicKey'))
                ->setAggregator($aggregator);

        return $request;
    }

    /**
     * Get a new query aggregator instance.
     *
     * @return Guzzle\Http\QueryAggregator\DuplicateAggregator
     */
    protected function getQueryAggregator()
    {
        return new DuplicateAggregator;
    }

    /**
     * Get the response from the prepared request.
     *
     * @param  \Guzzle\Http\Message\Request $request
     * @return array
     */
    protected function getResponse($request)
    {
        try {
            $response = json_decode($request->send()->getBody(), true);

            return $response['response'];
        } catch (BadResponseException $bre) {
            return null;
        }
    }

    /**
     * Append the comment counts to the given tricks.
     * @param  mixed $tricks
     * @return mixed
     */
    public function appendCommentCounts($tricks)
    {
        $tricks = $this->getValidTricks($tricks);

        $request = $this->prepareQuery($this->client->get(), $tricks);
        $response = $this->getResponse($request);

        if (is_null($response)) {
            foreach ($tricks as $trick) {
                $trick->comment_count = 0;
            }
        } else {
            foreach ($response as $comment) {
                foreach ($tricks as $trick) {
                    if ($trick->id == $comment['identifiers'][0]) {
                        $trick->comment_count = $comment['posts'];
                        break;
                    }
                }
            }
        }

        return $tricks instanceof Collection ? $tricks : $tricks[0];
    }
}
