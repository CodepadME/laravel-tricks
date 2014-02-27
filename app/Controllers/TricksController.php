<?php

namespace Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Tricks\Repositories\TrickRepositoryInterface;

class TricksController extends BaseController
{
    /**
     * Trick repository.
     *
     * @var \Tricks\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Create a new TricksController instance.
     *
     * @param \Tricks\Repositories\TrickRepositoryInterface  $tricks
     * @return void
     */
    public function __construct(TrickRepositoryInterface $tricks)
    {
        parent::__construct();

        $this->tricks = $tricks;
    }

    /**
     * Show the single trick page.
     *
     * @param  string $slug
     * @return \Response
     */
    public function getShow($slug = null)
    {
        if (is_null($slug)) {
            return $this->redirectRoute('home');
        }

        $trick = $this->tricks->findBySlug($slug);

        if (is_null($trick)) {
            return $this->redirectRoute('home');
        }

        Event::fire('trick.view', $trick);

        $next = $this->tricks->findNextTrick($trick);
        $prev = $this->tricks->findPreviousTrick($trick);

        $this->view('tricks.single', compact('trick', 'next', 'prev'));
    }

    /**
     * Handle the liking of a trick.
     *
     * @param  string $slug
     * @return \Response
     */
    public function postLike($slug)
    {
        if (! Request::ajax() || ! Auth::check()) {
            $this->redirectRoute('browse.recent');
        }

        $trick = $this->tricks->findBySlug($slug);

        if (is_null($trick)) {
            return Response::make('error', 404);
        }

        $user = Auth::user();

        $voted = $trick->votes()->whereUserId($user->id)->first();

        if(!$voted) {

            $user = $trick->votes()->attach($user->id, [
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime
            ]);
            $trick->vote_cache = $trick->vote_cache + 1;

        } else {
            $trick->votes()->detach($voted->id);
            $trick->vote_cache = $trick->vote_cache - 1;
        }

        $trick->save();

        return Response::make($trick->vote_cache, 200);
    }
}
