<?php

namespace Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

class BaseController extends Controller
{
    /**
     * The layout used by the controller.
     *
     * @var \Illuminate\View\View
     */
    protected $layout = 'layouts.main';

    /**
     * Create a new BaseController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', [ 'on' => 'post' ]);
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * Set the specified view as content on the layout.
     *
     * @param  string  $path
     * @param  array  $data
     * @return void
     */
    protected function view($path, $data = [])
    {
        $this->layout->content = View::make($path, $data);
    }

    /**
     * Redirect to the specified named route.
     *
     * @param  string  $route
     * @param  array  $params
     * @param  array  $data
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectRoute($route, $params = [], $data = [])
    {
        return Redirect::route($route, $params)->with($data);
    }

    /**
     * Redirect back with old input and the specified data.
     *
     * @param  array $data
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBack($data = [])
    {
        return Redirect::back()->withInput()->with($data);
    }

    /**
     * Redirect a logged in user to the previously intended url.
     *
     * @param  mixed $default
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectIntended($default = null)
    {
        return Redirect::intended($default);
    }
}
